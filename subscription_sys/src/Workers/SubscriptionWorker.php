<?php

namespace App\Workers;

use App\Config;
use App\Database;
use App\Logger;
use App\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;

class SubscriptionWorker
{
    private string $queue;

    public function __construct()
    {
        $this->queue = Config::get('QUEUE_SUBSCRIPTION', 'subscription_queue');
    }

    public function start(): void
    {
        Logger::info("Subscription worker started");

        $channel = RabbitMQ::getChannel();
        $channel->queue_declare($this->queue, false, true, false, false);
        $channel->basic_qos(null, 1, null);

        $callback = function (AMQPMessage $msg) {
            try {
                $data = json_decode($msg->getBody(), true);
                
                if (!$data) {
                    throw new \InvalidArgumentException('Invalid message data');
                }

                Logger::info("Processing subscription", $data);
                
                $this->processSubscription($data);
                
                $msg->ack();
                Logger::info("Subscription processed successfully", $data);
            } catch (\Exception $e) {
                Logger::error("Subscription processing failed", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $msg->nack(false, true);
            }
        };

        $channel->basic_consume($this->queue, '', false, false, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    private function processSubscription(array $data): void
    {
        $db = Database::getConnection();

        $msisdn = $data['msisdn'] ?? null;
        $serviceId = $data['service_id'] ?? null;
        $renewalPlanId = $data['renewal_plan_id'] ?? null;

        if (!$msisdn || !$serviceId || !$renewalPlanId) {
            throw new \InvalidArgumentException('Missing required fields');
        }

        $db->beginTransaction();

        try {
            // Check if subscription already exists
            $stmt = $db->prepare("
                SELECT id, status FROM subscriptions 
                WHERE msisdn = ? AND service_id = ?
            ");
            $stmt->execute([$msisdn, $serviceId]);
            $existing = $stmt->fetch();

            if ($existing) {
                if ($existing['status'] === 'active') {
                    throw new \RuntimeException('Subscription already active');
                }
                // Update existing subscription
                $stmt = $db->prepare("
                    UPDATE subscriptions 
                    SET renewal_plan_id = ?, status = 'active', 
                        subscribed_at = NOW(), 
                        next_renewal_at = (
                            SELECT DATE_ADD(NOW(), INTERVAL 1 DAY)
                            FROM renewal_plans 
                            WHERE id = ?
                        )
                    WHERE id = ?
                ");
                $stmt->execute([$renewalPlanId, $renewalPlanId, $existing['id']]);
                $subscriptionId = $existing['id'];
            } else {
                // Create new subscription
                $stmt = $db->prepare("
                    INSERT INTO subscriptions (msisdn, service_id, renewal_plan_id, status, subscribed_at, next_renewal_at)
                    SELECT ?, ?, ?, 'active', NOW(), DATE_ADD(NOW(), INTERVAL 1 DAY)
                    FROM renewal_plans WHERE id = ?
                ");
                $stmt->execute([$msisdn, $serviceId, $renewalPlanId, $renewalPlanId]);
                $subscriptionId = $db->lastInsertId();
            }

            // Get service info for FPMT
            $stmt = $db->prepare("
                SELECT s.id, s.fpmt_enabled, sm.message, sm.price_code
                FROM services s
                LEFT JOIN service_messages sm ON s.id = sm.service_id AND sm.message_type = 'FPMT' AND sm.status = 'active'
                WHERE s.id = ?
            ");
            $stmt->execute([$serviceId]);
            $service = $stmt->fetch();

            // Trigger FPMT if enabled
            if ($service && $service['fpmt_enabled'] && $service['message']) {
                $mtData = [
                    'service_id' => $serviceId,
                    'subscription_id' => $subscriptionId,
                    'msisdn' => $msisdn,
                    'message_type' => 'FPMT',
                    'message' => $service['message'],
                    'price_code' => $service['price_code'] ?? '',
                ];

                RabbitMQ::publish(Config::get('QUEUE_MT', 'mt_queue'), $mtData);
                Logger::info("FPMT queued", $mtData);
            }

            $db->commit();
        } catch (\Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}

