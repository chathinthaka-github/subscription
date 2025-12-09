<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\Database;

Config::load();

$message = '';
$messageType = '';
$mts = [];

// Fetch all MT records
try {
    $db = Database::getConnection();
    $stmt = $db->query("
        SELECT
            mt.id,
            mt.mt_ref_id,
            mt.msisdn,
            mt.message_type,
            mt.status,
            mt.dn_status,
            mt.message,
            mt.price_code,
            mt.created_at,
            s.keyword,
            sc.shortcode
        FROM mt
        LEFT JOIN services s ON mt.service_id = s.id
        LEFT JOIN shortcodes sc ON s.shortcode_id = sc.id
        ORDER BY mt.created_at DESC
        LIMIT 100
    ");
    $mts = $stmt->fetchAll();
} catch (\Exception $e) {
    $message = 'Error loading MT records: ' . $e->getMessage();
    $messageType = 'error';
}

// Handle DN trigger
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mt_ref_id'])) {
    $mtRefId = $_POST['mt_ref_id'];
    $dnStatus = $_POST['dn_status'] ?? 'success';
    $details = $_POST['details'] ?? 'Delivery confirmed from emulator';

    // Call the DN API
    $apiUrl = 'http://localhost/subscription_sys/public/api/dn.php';

    $data = [
        'mt_ref_id' => $mtRefId,
        'status' => $dnStatus,
        'details' => $details
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $result = json_decode($response, true);
        $message = 'DN triggered successfully for ' . htmlspecialchars($mtRefId);
        $messageType = 'success';
    } else {
        $result = json_decode($response, true);
        $message = $result['error'] ?? 'Failed to trigger DN';
        $messageType = 'error';
    }

    // Refresh MT list
    header('Location: emulator.php?msg=' . urlencode($message) . '&type=' . $messageType);
    exit;
}

// Handle URL parameters for messages
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
    $messageType = $_GET['type'] ?? 'success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DN Emulator - Subscription Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .nav-links {
            text-align: center;
            margin-bottom: 20px;
        }

        .nav-links a {
            color: #f5576c;
            text-decoration: none;
            font-weight: 600;
            margin: 0 10px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f9f9f9;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-queued {
            background: #fff3cd;
            color: #856404;
        }

        .status-sent {
            background: #cfe2ff;
            color: #084298;
        }

        .status-delivered {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-failed {
            background: #f8d7da;
            color: #842029;
        }

        .dn-btn {
            padding: 6px 16px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .dn-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.3);
        }

        .dn-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .dn-form {
            display: inline-block;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 16px;
        }

        .info-box {
            background: #e7f3ff;
            border: 2px solid #b3d7ff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            color: #004085;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .info-box p {
            color: #004085;
            font-size: 14px;
            margin: 5px 0;
        }

        .message-preview {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 13px;
            color: #666;
        }

        .refresh-btn {
            float: right;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
        }

        .refresh-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="subscribe-page.php">Subscribe</a>
            <a href="emulator.php">Emulator</a>
        </div>

        <h1>🎮 DN Emulator</h1>

        <div class="info-box">
            <h3>ℹ️ How to Use</h3>
            <p>This emulator allows you to manually trigger Delivery Notifications (DN) for MT messages.</p>
            <p>Click the "Trigger DN" button next to any MT record to simulate a delivery notification.</p>
        </div>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <a href="emulator.php" class="refresh-btn">🔄 Refresh</a>
        <div style="clear: both;"></div>

        <?php if (empty($mts)): ?>
            <div class="no-data">
                <p>📭 No MT records found</p>
                <p style="margin-top: 10px;">Subscribe to a service first to see MT records here.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>MT Ref ID</th>
                        <th>MSISDN</th>
                        <th>Service</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Price Code</th>
                        <th>Status</th>
                        <th>DN Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mts as $mt): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($mt['mt_ref_id']); ?></strong></td>
                            <td><?php echo htmlspecialchars($mt['msisdn']); ?></td>
                            <td><?php echo htmlspecialchars(($mt['shortcode'] ?? '') . ' - ' . ($mt['keyword'] ?? 'N/A')); ?></td>
                            <td><?php echo htmlspecialchars($mt['message_type']); ?></td>
                            <td>
                                <div class="message-preview" title="<?php echo htmlspecialchars($mt['message']); ?>">
                                    <?php echo htmlspecialchars($mt['message']); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($mt['price_code'] ?? 'N/A'); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($mt['status']); ?>">
                                    <?php echo strtoupper($mt['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($mt['dn_status']): ?>
                                    <span class="status-badge status-<?php echo strtolower($mt['dn_status']); ?>">
                                        <?php echo strtoupper($mt['dn_status']); ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #999;">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($mt['created_at'])); ?></td>
                            <td>
                                <?php if ($mt['status'] === 'sent' && empty($mt['dn_status'])): ?>
                                    <form method="POST" class="dn-form" onsubmit="return confirm('Trigger DN for <?php echo htmlspecialchars($mt['mt_ref_id']); ?>?');">
                                        <input type="hidden" name="mt_ref_id" value="<?php echo htmlspecialchars($mt['mt_ref_id']); ?>">
                                        <input type="hidden" name="dn_status" value="success">
                                        <input type="hidden" name="details" value="Delivery confirmed from emulator">
                                        <button type="submit" class="dn-btn">Trigger DN</button>
                                    </form>
                                <?php else: ?>
                                    <button class="dn-btn" disabled>
                                        <?php echo $mt['dn_status'] ? 'DN Sent' : 'Not Ready'; ?>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
