<?php

namespace App\Workers;

use App\Config;
use App\Database;
use App\Logger;
use App\RabbitMQ;

class RenewalWorker
{
    private int $checkInterval;

    public function __construct()
    {
        $this->checkInterval = (int)Config::get('RENEWAL_CHECK_INTERVAL', '60');
    }

    public function start(): void
    {
        Logger::info("Renewal worker started", ['interval' => $this->checkInterval]);

        while (true) {
            try {
                $this->checkRenewals();
            } catch (\Exception $e) {
                Logger::error("Renewal check failed", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }

            sleep($this->checkInterval);
        }
    }

    private function checkRenewals(): void
    {
        $db = Database::getConnection();

        // Find subscriptions due for renewal
        $stmt = $db->prepare("
            SELECT s.id, s.msisdn, s.service_id, s.renewal_plan_id, rp.plan_type, rp.schedule_rules
            FROM subscriptions s
            INNER JOIN renewal_plans rp ON s.renewal_plan_id = rp.id
            WHERE s.status = 'active'
            AND s.next_renewal_at <= NOW()
        ");
        $stmt->execute();
        $subscriptions = $stmt->fetchAll();

        Logger::info("Found subscriptions due for renewal", ['count' => count($subscriptions)]);

        foreach ($subscriptions as $subscription) {
            try {
                $this->processRenewal($subscription);
            } catch (\Exception $e) {
                Logger::error("Renewal processing failed for subscription", [
                    'subscription_id' => $subscription['id'],
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    private function processRenewal(array $subscription): void
    {
        $db = Database::getConnection();

        $db->beginTransaction();

        try {
            // Create renewal job
            $stmt = $db->prepare("
                INSERT INTO renewal_jobs (service_id, renewal_plan_id, subscription_id, msisdn, status, queued_at)
                VALUES (?, ?, ?, ?, 'pending', NOW())
            ");
            $stmt->execute([
                $subscription['service_id'],
                $subscription['renewal_plan_id'],
                $subscription['id'],
                $subscription['msisdn']
            ]);

            $jobId = $db->lastInsertId();

            // Queue renewal message
            $stmt = $db->prepare("
                SELECT sm.message, sm.price_code
                FROM service_messages sm
                WHERE sm.service_id = ? 
                AND sm.message_type = 'RENEWAL' 
                AND sm.status = 'active'
            ");
            $stmt->execute([$subscription['service_id']]);
            $message = $stmt->fetch();

            if ($message) {
                $mtData = [
                    'service_id' => $subscription['service_id'],
                    'subscription_id' => $subscription['id'],
                    'msisdn' => $subscription['msisdn'],
                    'message_type' => 'RENEWAL',
                    'message' => $message['message'],
                    'price_code' => $message['price_code'] ?? '',
                ];

                RabbitMQ::publish(Config::get('QUEUE_MT', 'mt_queue'), $mtData);
            }

            // Calculate next renewal date
            $nextRenewal = $this->calculateNextRenewal($subscription);

            // Update subscription
            $stmt = $db->prepare("
                UPDATE subscriptions 
                SET last_renewal_at = NOW(), 
                    next_renewal_at = ?,
                    updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$nextRenewal, $subscription['id']]);

            // Update renewal job
            $stmt = $db->prepare("
                UPDATE renewal_jobs 
                SET status = 'processed', processed_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$jobId]);

            $db->commit();

            Logger::info("Renewal processed", [
                'subscription_id' => $subscription['id'],
                'next_renewal_at' => $nextRenewal
            ]);
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    private function calculateNextRenewal(array $subscription): string
    {
        $planType = $subscription['plan_type'];
        $scheduleRules = json_decode($subscription['schedule_rules'] ?? '{}', true);

        return match($planType) {
            'daily' => date('Y-m-d H:i:s', strtotime('+1 day')),
            'weekly' => date('Y-m-d H:i:s', strtotime('+1 week')),
            'monthly' => date('Y-m-d H:i:s', strtotime('+1 month')),
            default => date('Y-m-d H:i:s', strtotime('+1 day'))
        };
    }
}

