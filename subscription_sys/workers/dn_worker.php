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
Logger::info('DN worker started');

$db = Database::getInstance();

/**
 * Process delivery notification
 */
function processDN($data, $msg)
{
    global $db;

    try {
        Logger::info('Processing delivery notification', $data);

        if (empty($data['mt_ref_id'])) {
            throw new Exception('mt_ref_id is required');
        }

        $mtRefId = $data['mt_ref_id'];
        $status = !empty($data['status']) ? $data['status'] : 'success';
        $details = !empty($data['details']) ? $data['details'] : '';

        // Validate status
        $validStatuses = ['pending', 'success', 'fail'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception('Invalid status: ' . $status);
        }

        // Update MT record
        $result = $db->execute(
            "UPDATE mt SET dn_status = ?, dn_details = ?, updated_at = NOW() WHERE mt_ref_id = ?",
            [$status, $details, $mtRefId]
        );

        if ($result['rowCount'] === 0) {
            throw new Exception('MT record not found: ' . $mtRefId);
        }

        Logger::info('DN processed', [
            'mt_ref_id' => $mtRefId,
            'dn_status' => $status
        ]);

        return true;
    } catch (Exception $e) {
        Logger::error('Error processing DN', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return false;
    }
}

// Start consuming
$queues = Config::queues();
try {
    RabbitMQ::consume($queues['dn'], 'processDN', false);
} catch (Exception $e) {
    Logger::error('DN worker error', ['error' => $e->getMessage()]);
    exit(1);
} finally {
    RabbitMQ::close();
}

