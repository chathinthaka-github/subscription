<?php

namespace App\Workers;

use App\Config;
use App\Database;
use App\Logger;
use App\RabbitMQ;
use PhpAmqpLib\Message\AMQPMessage;

class DnWorker
{
    private string $queue;

    public function __construct()
    {
        $this->queue = Config::get('QUEUE_DN', 'dn_queue');
    }

    public function start(): void
    {
        Logger::info("DN worker started");

        $channel = RabbitMQ::getChannel();
        $channel->queue_declare($this->queue, false, true, false, false);
        $channel->basic_qos(null, 1, null);

        $callback = function (AMQPMessage $msg) {
            try {
                $data = json_decode($msg->getBody(), true);
                
                if (!$data) {
                    throw new \InvalidArgumentException('Invalid message data');
                }

                Logger::info("Processing DN", $data);
                
                $this->processDn($data);
                
                $msg->ack();
                Logger::info("DN processed successfully", $data);
            } catch (\Exception $e) {
                Logger::error("DN processing failed", [
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

    private function processDn(array $data): void
    {
        $db = Database::getConnection();

        $mtRefId = $data['mt_ref_id'] ?? null;
        $status = $data['status'] ?? null;
        $details = $data['details'] ?? null;

        if (!$mtRefId || !$status) {
            throw new \InvalidArgumentException('Missing required fields: mt_ref_id and status');
        }

        // Map status to enum values
        $dnStatus = match(strtolower($status)) {
            'success', 'delivered', 'sent' => 'delivered',
            'failed', 'error', 'rejected' => 'failed',
            default => 'pending'
        };

        // Update MT record
        $stmt = $db->prepare("
            UPDATE mt 
            SET dn_status = ?, dn_details = ?, updated_at = NOW()
            WHERE mt_ref_id = ?
        ");
        $stmt->execute([$dnStatus, $details, $mtRefId]);

        if ($stmt->rowCount() === 0) {
            throw new \RuntimeException("MT record not found: {$mtRefId}");
        }

        Logger::info("DN updated", ['mt_ref_id' => $mtRefId, 'status' => $dnStatus]);
    }
}

