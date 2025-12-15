#!/usr/bin/env php
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../src/Config.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/RabbitMQ.php';
require_once __DIR__ . '/../src/Logger.php';

// Load configuration
Config::load();
Logger::info('Subscription worker started');

$db = Database::getInstance();
$queues = Config::queues();

/**
 * Process subscription message
 */
function processSubscription($data, $msg)
{
    global $db, $queues;

    try {
        Logger::info('Processing subscription', $data);

        if (empty($data['msisdn']) || empty($data['service_id'])) {
            throw new Exception('Missing required fields: msisdn or service_id');
        }

        // Check for existing active subscription
        $existing = $db->queryOne(
            "SELECT id FROM subscriptions WHERE msisdn = ? AND service_id = ? AND status = 'active' LIMIT 1",
            [$data['msisdn'], $data['service_id']]
        );

        if ($existing) {
            Logger::warning('Subscription already exists for this MSISDN and service', ['msisdn' => $data['msisdn'], 'service_id' => $data['service_id']]);
            return true; // Acknowledge the message without processing
        }

        // Get service details
        $service = $db->queryOne(
            "SELECT id, fpmt_enabled FROM services WHERE id = ? AND status = 'active' LIMIT 1",
            [$data['service_id']]
        );

        if (!$service) {
            throw new Exception('Service not found or inactive: ' . $data['service_id']);
        }

        // Calculate next_renewal_at if renewal_plan_id is provided
        $nextRenewalAt = null;
        if (!empty($data['renewal_plan_id'])) {
            $renewalPlan = $db->queryOne(
                "SELECT plan_type, schedule_rules, is_fixed_time, fixed_time FROM renewal_plans WHERE id = ? LIMIT 1",
                [$data['renewal_plan_id']]
            );

            if ($renewalPlan) {
                $nextRenewalAt = calculateNextRenewal($renewalPlan['plan_type'], $renewalPlan['schedule_rules'], $renewalPlan['is_fixed_time'], $renewalPlan['fixed_time']);
            }
        }

        // Insert subscription
        $result = $db->execute(
            "INSERT INTO subscriptions (msisdn, service_id, renewal_plan_id, status, subscribed_at, next_renewal_at, created_at, updated_at) 
             VALUES (?, ?, ?, 'active', ?, ?, NOW(), NOW())",
            [
                $data['msisdn'],
                $data['service_id'],
                $data['renewal_plan_id'] ?? null,
                $data['subscribed_at'] ?? date('Y-m-d H:i:s'),
                $nextRenewalAt
            ]
        );

        $subscriptionId = $result['lastInsertId'];
        Logger::info('Subscription created', ['subscription_id' => $subscriptionId, 'msisdn' => $data['msisdn']]);

        // If FPMT is enabled, create and enqueue MT message
        if (!empty($service['fpmt_enabled']) && ($service['fpmt_enabled'] == 1 || $service['fpmt_enabled'] === true)) {
            $serviceMessage = $db->queryOne(
                "SELECT sm.*, s.keyword, sc.shortcode 
                 FROM service_messages sm
                 INNER JOIN services s ON sm.service_id = s.id
                 INNER JOIN shortcodes sc ON s.shortcode_id = sc.id
                 WHERE sm.service_id = ? AND sm.message_type = 'FPMT' AND sm.status = 'active'
                 LIMIT 1",
                [$data['service_id']]
            );

            if ($serviceMessage) {
                $mtRefId = generateMtRefId();
                $mtData = [
                    'service_id' => $data['service_id'],
                    'subscription_id' => $subscriptionId,
                    'msisdn' => $data['msisdn'],
                    'message_type' => 'FPMT',
                    'message' => $serviceMessage['message'],
                    'mt_ref_id' => $mtRefId,
                ];

                RabbitMQ::publish($queues['mt'], $mtData);
                Logger::info('FPMT MT message enqueued', $mtData);
            } else {
                Logger::warning('FPMT enabled but no active FPMT message found', ['service_id' => $data['service_id']]);
            }
        }

        return true;
    } catch (Exception $e) {
        Logger::error('Error processing subscription', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return false;
    }
}

require_once __DIR__ . '/../src/helpers.php';

// Start consuming
try {
    RabbitMQ::consume($queues['subscription'], 'processSubscription', false);
} catch (Exception $e) {
    Logger::error('Subscription worker error', ['error' => $e->getMessage()]);
    exit(1);
} finally {
    RabbitMQ::close();
}

