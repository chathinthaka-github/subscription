<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../src/Config.php';
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/RabbitMQ.php';
require_once __DIR__ . '/../../src/Logger.php';

// Load configuration
Config::load();

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if ($input === null) {
        throw new Exception('Invalid JSON input');
    }

    // Validate required fields
    if (empty($input['mt_ref_id'])) {
        throw new Exception('mt_ref_id is required');
    }

    $mtRefId = $input['mt_ref_id'];
    $status = !empty($input['status']) ? $input['status'] : 'success';
    $details = !empty($input['details']) ? $input['details'] : '';

    // Validate status
    $validStatuses = ['pending', 'success', 'fail'];
    if (!in_array($status, $validStatuses)) {
        throw new Exception('Invalid status. Must be one of: ' . implode(', ', $validStatuses));
    }

    // Verify MT exists
    $db = Database::getInstance();
    $mt = $db->queryOne(
        "SELECT id FROM mt WHERE mt_ref_id = ? LIMIT 1",
        [$mtRefId]
    );

    if (!$mt) {
        throw new Exception('MT record not found for mt_ref_id: ' . $mtRefId);
    }

    // Prepare DN data
    $dnData = [
        'mt_ref_id' => $mtRefId,
        'status' => $status,
        'details' => $details,
    ];

    // Enqueue to RabbitMQ
    $queues = Config::queues();
    RabbitMQ::publish($queues['dn'], $dnData);

    Logger::info('Delivery notification enqueued', $dnData);

    echo json_encode([
        'success' => true,
        'message' => 'Delivery notification received and queued',
        'data' => $dnData
    ]);

} catch (Exception $e) {
    Logger::error('DN API error', ['error' => $e->getMessage()]);
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

