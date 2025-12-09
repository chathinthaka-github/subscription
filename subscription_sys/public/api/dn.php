<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config;
use App\Logger;
use App\RabbitMQ;

// Load configuration
Config::load();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new \InvalidArgumentException('Invalid JSON input');
    }

    $mtRefId = $input['mt_ref_id'] ?? null;
    $status = $input['status'] ?? null;
    $details = $input['details'] ?? null;

    if (!$mtRefId || !$status) {
        throw new \InvalidArgumentException('mt_ref_id and status are required');
    }

    // Queue DN
    $queueData = [
        'mt_ref_id' => $mtRefId,
        'status' => $status,
        'details' => $details,
    ];

    RabbitMQ::publish(Config::get('QUEUE_DN', 'dn_queue'), $queueData);

    Logger::info("DN queued", $queueData);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'DN queued successfully',
        'data' => $queueData
    ]);
} catch (\Exception $e) {
    Logger::error("DN API error", ['error' => $e->getMessage()]);
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

