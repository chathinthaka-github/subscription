<?php
// Simplified subscription API that doesn't require RabbitMQ (for testing)

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config;
use App\Database;

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

    $msisdn = $input['msisdn'] ?? null;
    $serviceId = $input['service_id'] ?? null;
    $renewalPlanId = $input['renewal_plan_id'] ?? null;
    $shortcode = $input['shortcode'] ?? null;
    $keyword = $input['keyword'] ?? null;

    // Validate required fields
    if (!$msisdn) {
        throw new \InvalidArgumentException('msisdn is required');
    }

    $db = Database::getConnection();

    // If shortcode and keyword provided, find service
    if ($shortcode && $keyword && !$serviceId) {
        $stmt = $db->prepare("
            SELECT s.id
            FROM services s
            INNER JOIN shortcodes sc ON s.shortcode_id = sc.id
            WHERE sc.shortcode = ? AND s.keyword = ? AND s.status = 'active'
        ");
        $stmt->execute([$shortcode, $keyword]);
        $service = $stmt->fetch();

        if (!$service) {
            throw new \RuntimeException('Service not found for shortcode: ' . $shortcode . ' and keyword: ' . $keyword);
        }

        $serviceId = $service['id'];

        // If renewal_plan_id not provided, get the first active plan for this service
        if (!$renewalPlanId) {
            $stmt = $db->prepare("
                SELECT id FROM renewal_plans WHERE service_id = ? ORDER BY id ASC LIMIT 1
            ");
            $stmt->execute([$serviceId]);
            $plan = $stmt->fetch();

            if (!$plan) {
                throw new \RuntimeException('No renewal plan found for this service');
            }

            $renewalPlanId = $plan['id'];
        }
    }

    if (!$serviceId) {
        throw new \InvalidArgumentException('service_id is required (or provide shortcode and keyword)');
    }

    if (!$renewalPlanId) {
        throw new \InvalidArgumentException('renewal_plan_id is required');
    }

    // Validate service and renewal plan exist and are linked
    $stmt = $db->prepare("
        SELECT s.id, s.status, rp.id as plan_id, rp.name as plan_name
        FROM services s
        INNER JOIN renewal_plans rp ON rp.service_id = s.id
        WHERE s.id = ? AND rp.id = ? AND s.status = 'active'
    ");
    $stmt->execute([$serviceId, $renewalPlanId]);
    $validation = $stmt->fetch();

    if (!$validation) {
        throw new \RuntimeException('Invalid service or renewal plan, or they are not linked');
    }

    // Check if already subscribed
    $stmt = $db->prepare("
        SELECT id FROM subscriptions WHERE msisdn = ? AND service_id = ? AND status = 'active'
    ");
    $stmt->execute([$msisdn, $serviceId]);
    $existing = $stmt->fetch();

    if ($existing) {
        throw new \RuntimeException('Already subscribed to this service');
    }

    // Create subscription directly (without RabbitMQ)
    $stmt = $db->prepare("
        INSERT INTO subscriptions (msisdn, service_id, renewal_plan_id, status, subscribed_at, created_at, updated_at)
        VALUES (?, ?, ?, 'active', NOW(), NOW(), NOW())
    ");
    $stmt->execute([$msisdn, $serviceId, $renewalPlanId]);
    $subscriptionId = $db->lastInsertId();

    // Create FPMT message
    $stmt = $db->prepare("
        SELECT message, price_code FROM service_messages
        WHERE service_id = ? AND message_type = 'FPMT' AND status = 'active'
        LIMIT 1
    ");
    $stmt->execute([$serviceId]);
    $fpmt = $stmt->fetch();

    if ($fpmt) {
        $mtRefId = 'MT' . time() . rand(1000, 9999);

        $stmt = $db->prepare("
            INSERT INTO mt (service_id, subscription_id, msisdn, message_type, status, message, price_code, mt_ref_id, created_at, updated_at)
            VALUES (?, ?, ?, 'FPMT', 'queued', ?, ?, ?, NOW(), NOW())
        ");
        $stmt->execute([$serviceId, $subscriptionId, $msisdn, $fpmt['message'], $fpmt['price_code'], $mtRefId]);
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Subscription created successfully! (Direct mode - no RabbitMQ)',
        'data' => [
            'subscription_id' => $subscriptionId,
            'msisdn' => $msisdn,
            'service_id' => $serviceId,
            'renewal_plan_id' => $renewalPlanId
        ]
    ]);
} catch (\Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
