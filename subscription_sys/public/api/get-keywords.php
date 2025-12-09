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
    $shortcodeId = $_GET['shortcode_id'] ?? null;

    if (!$shortcodeId) {
        throw new \InvalidArgumentException('shortcode_id is required');
    }

    $db = Database::getConnection();

    // Get all active services with their renewal plans for the selected shortcode
    $stmt = $db->prepare("
        SELECT
            s.id as service_id,
            s.keyword,
            COUNT(rp.id) as plan_count
        FROM services s
        LEFT JOIN renewal_plans rp ON s.id = rp.service_id
        WHERE s.shortcode_id = ? AND s.status = 'active'
        GROUP BY s.id, s.keyword
        HAVING plan_count > 0
        ORDER BY s.keyword
    ");
    $stmt->execute([$shortcodeId]);
    $keywords = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'keywords' => $keywords
    ]);
} catch (\Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
