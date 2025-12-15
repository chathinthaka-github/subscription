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
    if (empty($input['msisdn'])) {
        throw new Exception('MSISDN is required');
    }

    // Validate MSISDN format (basic validation)
    $msisdn = preg_replace('/[^0-9+]/', '', $input['msisdn']);
    if (empty($msisdn) || strlen($msisdn) < 10) {
        throw new Exception('Invalid MSISDN format');
    }

    $db = Database::getInstance();

    // Determine service_id
    $serviceId = null;
    
    if (!empty($input['service_id'])) {
        $serviceId = (int)$input['service_id'];
    } elseif (!empty($input['shortcode']) && !empty($input['keyword'])) {
        // Look up service by shortcode and keyword
        $service = $db->queryOne(
            "SELECT s.id FROM services s 
             INNER JOIN shortcodes sc ON s.shortcode_id = sc.id 
             WHERE sc.shortcode = ? AND s.keyword = ? AND s.status = 'active' 
             LIMIT 1",
            [$input['shortcode'], $input['keyword']]
        );
        
        if (!$service) {
            throw new Exception('Service not found for given shortcode and keyword');
        }
        $serviceId = (int)$service['id'];
    } else {
        throw new Exception('Either service_id or shortcode+keyword is required');
    }

    // Check if service exists and is active
    $service = $db->queryOne(
        "SELECT id, fpmt_enabled FROM services WHERE id = ? AND status = 'active' LIMIT 1",
        [$serviceId]
    );

    if (!$service) {
        throw new Exception('Service not found or inactive');
    }

    // Check for existing active subscription
    $existing = $db->queryOne(
        "SELECT id FROM subscriptions WHERE msisdn = ? AND service_id = ? AND status = 'active' LIMIT 1",
        [$msisdn, $serviceId]
    );

    if ($existing) {
        throw new Exception('Active subscription already exists for this MSISDN and service');
    }

    // Get renewal_plan_id if provided
    $renewalPlanId = !empty($input['renewal_plan_id']) ? (int)$input['renewal_plan_id'] : null;

    if ($renewalPlanId) {
        $renewalPlan = $db->queryOne(
            "SELECT id FROM renewal_plans WHERE id = ? LIMIT 1",
            [$renewalPlanId]
        );
        if (!$renewalPlan) {
            throw new Exception('Invalid renewal_plan_id');
        }
    }

    // Prepare subscription data
    $subscriptionData = [
        'msisdn' => $msisdn,
        'service_id' => $serviceId,
        'renewal_plan_id' => $renewalPlanId,
        'subscribed_at' => date('Y-m-d H:i:s'),
    ];

    // Enqueue to RabbitMQ
    $queues = Config::queues();
    RabbitMQ::publish($queues['subscription'], $subscriptionData);

    Logger::info('Subscription request enqueued', $subscriptionData);

    echo json_encode([
        'success' => true,
        'message' => 'Subscription request received and queued',
        'data' => $subscriptionData
    ]);

} catch (Exception $e) {
    Logger::error('Subscription API error', ['error' => $e->getMessage()]);
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

