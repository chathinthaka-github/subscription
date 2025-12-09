<?php

namespace App\Workers;

use App\Config;
use App\Database;
use App\Logger;
use App\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;

class MtWorker
{
    private string $queue;

    public function __construct()
    {
        $this->queue = Config::get('QUEUE_MT', 'mt_queue');
    }

    public function start(): void
    {
        Logger::info("MT worker started");

        $channel = RabbitMQ::getChannel();
        $channel->queue_declare($this->queue, false, true, false, false);
        $channel->basic_qos(null, 1, null);

        $callback = function (AMQPMessage $msg) {
            try {
                $data = json_decode($msg->getBody(), true);
                
                if (!$data) {
                    throw new \InvalidArgumentException('Invalid message data');
                }

                Logger::info("Processing MT", $data);
                
                $this->processMt($data);
                
                $msg->ack();
                Logger::info("MT processed successfully", $data);
            } catch (\Exception $e) {
                Logger::error("MT processing failed", [
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

    private function processMt(array $data): void
    {
        $db = Database::getConnection();

        $serviceId = $data['service_id'] ?? null;
        $subscriptionId = $data['subscription_id'] ?? null;
        $msisdn = $data['msisdn'] ?? null;
        $messageType = $data['message_type'] ?? null;
        $message = $data['message'] ?? null;
        $priceCode = $data['price_code'] ?? '';

        if (!$serviceId || !$msisdn || !$messageType || !$message) {
            throw new \InvalidArgumentException('Missing required fields');
        }

        // Generate unique MT reference ID
        $mtRefId = 'MT' . time() . rand(1000, 9999);

        // Insert MT record
        $stmt = $db->prepare("
            INSERT INTO mt (service_id, subscription_id, msisdn, message_type, status, dn_status, message, price_code, mt_ref_id)
            VALUES (?, ?, ?, ?, 'pending', 'pending', ?, ?, ?)
        ");
        $stmt->execute([
            $serviceId,
            $subscriptionId,
            $msisdn,
            $messageType,
            $message,
            $priceCode,
            $mtRefId
        ]);

        $mtId = $db->lastInsertId();

        // Call external API
        $apiUrl = Config::get('EXTERNAL_MT_API_URL');
        $apiKey = Config::get('EXTERNAL_MT_API_KEY');

        if ($apiUrl) {
            $this->callExternalApi($apiUrl, $apiKey, [
                'mt_ref_id' => $mtRefId,
                'msisdn' => $msisdn,
                'message' => $message,
                'price_code' => $priceCode,
            ]);

            // Update status to queued
            $stmt = $db->prepare("UPDATE mt SET status = 'queued' WHERE id = ?");
            $stmt->execute([$mtId]);
        } else {
            // If no API URL, mark as sent (for testing)
            $stmt = $db->prepare("UPDATE mt SET status = 'sent' WHERE id = ?");
            $stmt->execute([$mtId]);
        }
    }

    private function callExternalApi(string $url, ?string $apiKey, array $data): void
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                $apiKey ? "Authorization: Bearer {$apiKey}" : '',
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \RuntimeException("External API call failed with HTTP {$httpCode}: {$response}");
        }

        Logger::info("External API called successfully", ['response' => $response]);
    }
}

