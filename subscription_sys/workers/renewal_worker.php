#!/usr/bin/env php
<?php

require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/RabbitMQ.php';
require_once __DIR__ . '/../src/Logger.php';

// Load configuration
Config::load();
Logger::info('Renewal worker started');

$db = Database::getInstance();
$queues = Config::queues();

/**
 * Process renewals
 */
function processRenewals()
{
    global $db, $queues;

    try {
        $now = date('Y-m-d H:i:s');

        // Find subscriptions that are due for renewal
        $subscriptions = $db->query(
            "SELECT s.*, rp.plan_type, rp.schedule_rules, rp.is_fixed_time, rp.fixed_time 
             FROM subscriptions s
             INNER JOIN renewal_plans rp ON s.renewal_plan_id = rp.id
             WHERE s.status = 'active' 
             AND s.renewal_plan_id IS NOT NULL
             AND s.next_renewal_at IS NOT NULL
             AND s.next_renewal_at <= ?
             ORDER BY s.next_renewal_at ASC",
            [$now]
        );

        if (empty($subscriptions)) {
            Logger::debug('No renewals due');
            return;
        }

        Logger::info('Found renewals due', ['count' => count($subscriptions)]);

        foreach ($subscriptions as $subscription) {
            try {
                $db->beginTransaction();

                // Get service message for renewal
                $serviceMessage = $db->queryOne(
                    "SELECT sm.* FROM service_messages sm
                     WHERE sm.service_id = ? AND sm.message_type = 'RENEWAL' AND sm.status = 'active'
                     LIMIT 1",
                    [$subscription['service_id']]
                );

                if (!$serviceMessage) {
                    Logger::warning('No RENEWAL message found for service', ['service_id' => $subscription['service_id']]);
                    $db->rollback();
                    continue;
                }

                // Create renewal_job
                $jobResult = $db->execute(
                    "INSERT INTO renewal_jobs (service_id, renewal_plan_id, subscription_id, msisdn, status, queued_at, created_at, updated_at)
                     VALUES (?, ?, ?, ?, 'queued', NOW(), NOW(), NOW())",
                    [
                        $subscription['service_id'],
                        $subscription['renewal_plan_id'],
                        $subscription['id'],
                        $subscription['msisdn']
                    ]
                );

                $renewalJobId = $jobResult['lastInsertId'];

                // Generate MT data
                $mtRefId = generateMtRefId();
                $mtData = [
                    'service_id' => $subscription['service_id'],
                    'subscription_id' => $subscription['id'],
                    'renewal_job_id' => $renewalJobId,
                    'msisdn' => $subscription['msisdn'],
                    'message_type' => 'RENEWAL',
                    'message' => $serviceMessage['message'],
                    'mt_ref_id' => $mtRefId,
                ];

                // Enqueue MT message
                RabbitMQ::publish($queues['mt'], $mtData);

                // Calculate next renewal date
                $scheduleRules = json_decode($subscription['schedule_rules'], true);
                $nextRenewalAt = calculateNextRenewal($subscription['plan_type'], $subscription['schedule_rules'], $subscription['is_fixed_time'], $subscription['fixed_time']);

                // Update subscription
                $db->execute(
                    "UPDATE subscriptions 
                     SET last_renewal_at = ?, next_renewal_at = ?, updated_at = NOW() 
                     WHERE id = ?",
                    [$now, $nextRenewalAt, $subscription['id']]
                );

                $db->commit();

                Logger::info('Renewal processed', [
                    'subscription_id' => $subscription['id'],
                    'renewal_job_id' => $renewalJobId,
                    'mt_ref_id' => $mtRefId
                ]);
            } catch (Exception $e) {
                $db->rollback();
                Logger::error('Error processing renewal', [
                    'subscription_id' => $subscription['id'],
                    'error' => $e->getMessage()
                ]);
            }
        }
    } catch (Exception $e) {
        Logger::error('Error in processRenewals', ['error' => $e->getMessage()]);
    }
}

require_once __DIR__ . '/../src/helpers.php';

// Main loop - check every 60 seconds
try {
    while (true) {
        processRenewals();
        sleep(60); // Wait 60 seconds before next check
    }
} catch (Exception $e) {
    Logger::error('Renewal worker error', ['error' => $e->getMessage()]);
    exit(1);
} finally {
    RabbitMQ::close();
}

