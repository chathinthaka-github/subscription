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
Logger::info('MT worker started');

$db = Database::getInstance();
$apiConfig = Config::api();

/**
 * Process MT message
 */
function processMT($data, $msg)
{
    global $db, $apiConfig;

    try {
        Logger::info('Processing MT message', $data);

        if (empty($data['service_id']) || empty($data['msisdn']) || empty($data['message_type'])) {
            throw new Exception('Missing required fields');
        }

        // Generate mt_ref_id if not provided
        $mtRefId = !empty($data['mt_ref_id']) ? $data['mt_ref_id'] : generateMtRefId();

        // Get service message if not provided
        if (empty($data['message'])) {
            $serviceMessage = $db->queryOne(
                "SELECT message FROM service_messages 
                 WHERE service_id = ? AND message_type = ? AND status = 'active' 
                 LIMIT 1",
                [$data['service_id'], $data['message_type']]
            );

            if (!$serviceMessage) {
                throw new Exception('Service message not found');
            }
            $message = $serviceMessage['message'];
        } else {
            $message = $data['message'];
        }

        // Insert MT record with status 'queued'
        $result = $db->execute(
            "INSERT INTO mt (service_id, subscription_id, msisdn, message_type, status, dn_status, mt_ref_id, message, price_code, created_at, updated_at) 
             VALUES (?, ?, ?, ?, 'queued', 'pending', ?, ?, ?, NOW(), NOW())",
            [
                $data['service_id'],
                $data['subscription_id'] ?? null,
                $data['msisdn'],
                $data['message_type'],
                $mtRefId,
                $message,
                $data['price_code'] ?? null
            ]
        );

        $mtId = $result['lastInsertId'];
        Logger::info('MT record created', ['mt_id' => $mtId, 'mt_ref_id' => $mtRefId]);

        // Update renewal_job status to 'processing' if subscription_id provided
        if (!empty($data['subscription_id']) && !empty($data['renewal_job_id'])) {
            $db->execute(
                "UPDATE renewal_jobs SET status = 'processing', updated_at = NOW() WHERE id = ?",
                [$data['renewal_job_id']]
            );
        }

        // Call external Telecom API
        $apiResult = callTelecomAPI([
            'mt_ref_id' => $mtRefId,
            'msisdn' => $data['msisdn'],
            'message' => $message,
            'message_type' => $data['message_type']
        ]);

        // Update MT status based on API result
        $status = $apiResult['success'] ? 'success' : 'fail';
        $db->execute(
            "UPDATE mt SET status = ?, updated_at = NOW() WHERE id = ?",
            [$status, $mtId]
        );

        // If API call succeeded and there's a renewal_job, update it
        if ($apiResult['success'] && !empty($data['subscription_id']) && !empty($data['renewal_job_id'])) {
            $db->execute(
                "UPDATE renewal_jobs SET status = 'done', processed_at = NOW(), updated_at = NOW() WHERE id = ?",
                [$data['renewal_job_id']]
            );
        }

        Logger::info('MT processed', [
            'mt_id' => $mtId,
            'mt_ref_id' => $mtRefId,
            'status' => $status
        ]);

        return true;
    } catch (Exception $e) {
        Logger::error('Error processing MT', [
            'error' => $e->getMessage(),
            'data' => $data
        ]);
        return false;
    }
}

/**
 * Call external Telecom API
 */
function callTelecomAPI($data)
{
    global $apiConfig;

    try {
        $ch = curl_init($apiConfig['url']);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiConfig['key']
            ],
            CURLOPT_TIMEOUT => $apiConfig['timeout'],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            Logger::error('Telecom API curl error', ['error' => $error]);
            return ['success' => false, 'error' => $error];
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            Logger::info('Telecom API call successful', ['http_code' => $httpCode, 'response' => $response]);
            return ['success' => true, 'response' => $response];
        } else {
            Logger::warning('Telecom API call failed', ['http_code' => $httpCode, 'response' => $response]);
            return ['success' => false, 'error' => "HTTP {$httpCode}: {$response}"];
        }
    } catch (Exception $e) {
        Logger::error('Telecom API exception', ['error' => $e->getMessage()]);
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

/**
 * Generate unique MT reference ID
 */
function generateMtRefId()
{
    return 'MT' . date('YmdHis') . rand(1000, 9999);
}

// Start consuming
$queues = Config::queues();
try {
    RabbitMQ::consume($queues['mt'], 'processMT', false);
} catch (Exception $e) {
    Logger::error('MT worker error', ['error' => $e->getMessage()]);
    exit(1);
} finally {
    RabbitMQ::close();
}

