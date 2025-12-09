<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config;
use App\Database;

// Load configuration
Config::load();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    $serviceId = $_GET['service_id'] ?? null;

    if (!$serviceId) {
        throw new \InvalidArgumentException('service_id is required');
    }

    $db = Database::getConnection();

    // Get all renewal plans for the selected service
    $stmt = $db->prepare("
        SELECT
            id as renewal_plan_id,
            name as plan_name,
            price_code,
            plan_type
        FROM renewal_plans
        WHERE service_id = ?
        ORDER BY name
    ");
    $stmt->execute([$serviceId]);
    $plans = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'plans' => $plans
    ]);
} catch (\Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
