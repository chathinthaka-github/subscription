<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config;
use App\Database;

Config::load();

$message = '';
$messageType = '';
$submitted = false;
$shortcodes = [];

// Fetch shortcodes for the dropdown
try {
    $db = Database::getConnection();
    $stmt = $db->query("
        SELECT
            id,
            shortcode,
            description
        FROM shortcodes
        WHERE status = 'active'
        ORDER BY shortcode
    ");
    $shortcodes = $stmt->fetchAll();
} catch (\Exception $e) {
    $message = 'Error loading shortcodes: ' . $e->getMessage();
    $messageType = 'error';
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msisdn = $_POST['msisdn'] ?? '';
    $shortcode = $_POST['shortcode'] ?? '';
    $keyword = $_POST['keyword'] ?? '';

    if (empty($msisdn) || empty($shortcode) || empty($keyword)) {
        $message = 'Please fill in all required fields';
        $messageType = 'error';
    } else {
        // Call the subscription API using shortcode and keyword
        $apiUrl = 'http://localhost/subscription_manager/subscription_sys/public/api/subscribe.php';

        $data = [
            'msisdn' => $msisdn,
            'shortcode' => $shortcode,
            'keyword' => $keyword
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
            $message = $result['message'] ?? 'Subscription request submitted successfully!';
            $messageType = 'success';
            $submitted = true;
        } else {
            $result = json_decode($response, true);
            $message = $result['error'] ?? 'Failed to submit subscription request';
            $messageType = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe - Subscription Manager</title>
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
            max-width: 500px;
            width: 100%;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        select:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
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

        .hidden {
            display: none;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .nav-links {
            text-align: center;
            margin-bottom: 20px;
        }

        .nav-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin: 0 10px;
        }

        .nav-links a:hover {
            text-decoration: underline;
        }

        .info-text {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }

        .loading {
            color: #667eea;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="subscribe-page.php">Subscribe</a>
            <a href="emulator.php">Emulator</a>
        </div>

        <h1>📱 Subscribe to Service</h1>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="subscribeForm" <?php echo $submitted ? 'class="hidden"' : ''; ?>>
            <div class="form-group">
                <label for="msisdn">Mobile Number (MSISDN) *</label>
                <input
                    type="tel"
                    id="msisdn"
                    name="msisdn"
                    placeholder="+1234567890"
                    required
                    pattern="^\+?[0-9]{10,15}$"
                    value="<?php echo htmlspecialchars($_POST['msisdn'] ?? ''); ?>"
                >
                <div class="info-text">Enter with country code (e.g., +1234567890)</div>
            </div>

            <div class="form-group">
                <label for="shortcode">Shortcode *</label>
                <select id="shortcode" name="shortcode" required onchange="loadKeywords()">
                    <option value="">Select a shortcode</option>
                    <?php foreach ($shortcodes as $sc): ?>
                        <option
                            value="<?php echo htmlspecialchars($sc['shortcode']); ?>"
                            data-id="<?php echo $sc['id']; ?>"
                            <?php echo (isset($_POST['shortcode']) && $_POST['shortcode'] == $sc['shortcode']) ? 'selected' : ''; ?>
                        >
                            <?php echo htmlspecialchars($sc['shortcode']); ?>
                            <?php if ($sc['description']): ?>
                                - <?php echo htmlspecialchars($sc['description']); ?>
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="keyword">Keyword *</label>
                <select id="keyword" name="keyword" required disabled>
                    <option value="">Select a shortcode first</option>
                </select>
                <div class="info-text" id="keywordInfo"></div>
            </div>

            <button type="submit" id="submitBtn">Subscribe Now</button>
        </form>

        <?php if ($submitted): ?>
            <a href="subscribe-page.php" class="back-link">← Subscribe Another Number</a>
        <?php endif; ?>
    </div>

    <script>
        function loadKeywords() {
            const shortcodeSelect = document.getElementById('shortcode');
            const keywordSelect = document.getElementById('keyword');
            const keywordInfo = document.getElementById('keywordInfo');
            const submitBtn = document.getElementById('submitBtn');
            const selectedOption = shortcodeSelect.options[shortcodeSelect.selectedIndex];

            // Reset keyword dropdown
            keywordSelect.innerHTML = '<option value="">Loading...</option>';
            keywordSelect.disabled = true;
            keywordInfo.innerHTML = '';
            submitBtn.disabled = true;

            if (!selectedOption.value) {
                keywordSelect.innerHTML = '<option value="">Select a shortcode first</option>';
                submitBtn.disabled = false;
                return;
            }

            const shortcodeId = selectedOption.dataset.id;

            // Fetch keywords via AJAX
            fetch('api/get-keywords.php?shortcode_id=' + shortcodeId)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.keywords.length > 0) {
                        keywordSelect.innerHTML = '<option value="">Select a keyword</option>';

                        data.keywords.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.keyword;
                            option.textContent = item.keyword + ' (' + item.plan_count + ' plan' + (item.plan_count > 1 ? 's' : '') + ')';
                            option.dataset.serviceId = item.service_id;
                            keywordSelect.appendChild(option);
                        });

                        keywordSelect.disabled = false;
                        keywordInfo.innerHTML = '<span class="loading">' + data.keywords.length + ' keyword(s) available</span>';
                    } else {
                        keywordSelect.innerHTML = '<option value="">No keywords available</option>';
                        keywordInfo.innerHTML = '<span style="color: #dc2626;">No active services found for this shortcode</span>';
                    }
                    submitBtn.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading keywords:', error);
                    keywordSelect.innerHTML = '<option value="">Error loading keywords</option>';
                    keywordInfo.innerHTML = '<span style="color: #dc2626;">Failed to load keywords</span>';
                    submitBtn.disabled = false;
                });
        }

        // Initialize on page load if shortcode is pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            const shortcodeSelect = document.getElementById('shortcode');
            if (shortcodeSelect.value) {
                loadKeywords();
            }
        });
    </script>
</body>
</html>
