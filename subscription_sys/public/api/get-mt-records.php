<?php

header('Content-Type: application/json');

require_once __DIR__ . '/../../src/Config.php';
require_once __DIR__ . '/../../src/Database.php';

// Load configuration
Config::load();

try {
    $db = Database::getInstance();
    
    $records = $db->query(
        "SELECT id, mt_ref_id, msisdn, message_type, status, dn_status 
         FROM mt 
         ORDER BY created_at DESC 
         LIMIT 100"
    );

    echo json_encode([
        'success' => true,
        'data' => $records
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

