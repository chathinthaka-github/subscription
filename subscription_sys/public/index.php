<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\Database;

Config::load();

// Test database connection
$dbConnected = false;
$dbError = '';
try {
    $db = Database::getConnection();
    $dbConnected = true;
} catch (\Exception $e) {
    $dbError = $e->getMessage();
}

// Get system stats
$stats = [
    'total_subscriptions' => 0,
    'active_subscriptions' => 0,
    'total_mt' => 0,
    'pending_dn' => 0
];

if ($dbConnected) {
    try {
        $stmt = $db->query("SELECT COUNT(*) as count FROM subscriptions");
        $stats['total_subscriptions'] = $stmt->fetch()['count'];

        $stmt = $db->query("SELECT COUNT(*) as count FROM subscriptions WHERE status = 'active'");
        $stats['active_subscriptions'] = $stmt->fetch()['count'];

        $stmt = $db->query("SELECT COUNT(*) as count FROM mt");
        $stats['total_mt'] = $stmt->fetch()['count'];

        $stmt = $db->query("SELECT COUNT(*) as count FROM mt WHERE status = 'sent' AND dn_status IS NULL");
        $stats['pending_dn'] = $stmt->fetch()['count'];
    } catch (\Exception $e) {
        // Ignore stats errors
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Manager - PHP Backend</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 900px;
            width: 100%;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
            font-size: 32px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 40px;
            font-size: 16px;
        }

        .status-banner {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .status-success {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .status-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .nav-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .nav-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }

        .nav-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .nav-card .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .nav-card h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #667eea;
        }

        .nav-card p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #e0e0e0;
            color: #999;
            font-size: 14px;
        }

        .api-docs {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }

        .api-docs h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .api-endpoint {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-family: monospace;
            font-size: 13px;
            border-left: 4px solid #667eea;
        }

        .api-endpoint .method {
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Subscription Manager</h1>
        <p class="subtitle">Pure PHP Backend Processing System</p>

        <?php if ($dbConnected): ?>
            <div class="status-banner status-success">
                ✅ Database Connected Successfully
            </div>

            <div class="grid">
                <div class="stat-card">
                    <h3>Total Subscriptions</h3>
                    <div class="number"><?php echo number_format($stats['total_subscriptions']); ?></div>
                </div>
                <div class="stat-card">
                    <h3>Active</h3>
                    <div class="number"><?php echo number_format($stats['active_subscriptions']); ?></div>
                </div>
                <div class="stat-card">
                    <h3>Total MT</h3>
                    <div class="number"><?php echo number_format($stats['total_mt']); ?></div>
                </div>
                <div class="stat-card">
                    <h3>Pending DN</h3>
                    <div class="number"><?php echo number_format($stats['pending_dn']); ?></div>
                </div>
            </div>
        <?php else: ?>
            <div class="status-banner status-error">
                ❌ Database Connection Failed: <?php echo htmlspecialchars($dbError); ?>
            </div>
        <?php endif; ?>

        <div class="nav-cards">
            <a href="subscribe-page.php" class="nav-card">
                <div class="icon">📱</div>
                <h2>Subscribe</h2>
                <p>Subscribe mobile numbers to services and trigger FPMT messages</p>
            </a>

            <a href="emulator.php" class="nav-card">
                <div class="icon">🎮</div>
                <h2>DN Emulator</h2>
                <p>Test delivery notifications by manually triggering DN for MT messages</p>
            </a>
        </div>

        <div class="api-docs">
            <h3>📡 API Endpoints</h3>

            <div class="api-endpoint">
                <span class="method">POST</span>
                /api/subscribe.php
            </div>
            <p style="margin-bottom: 15px; font-size: 13px; color: #666;">
                Subscribe a mobile number to a service. Queues subscription for processing.
            </p>

            <div class="api-endpoint">
                <span class="method">POST</span>
                /api/dn.php
            </div>
            <p style="font-size: 13px; color: #666;">
                Receive delivery notifications from external MT API.
            </p>
        </div>

        <div class="footer">
            <p><strong>Subscription Manager</strong> - Pure PHP Backend</p>
            <p style="margin-top: 5px;">Powered by RabbitMQ & Supervisor</p>
        </div>
    </div>
</body>
</html>
