<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        :root {
            --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
            --color-neo-base: #E0E0E0;
            --color-neo-light: #F0F0F0;
            --color-neo-text: #2D2D2D;
            --color-neo-text-light: #5A5A5A;
            --color-neo-accent: #4F46E5;
            --color-neo-accent-hover: #4338CA;
            --color-neo-success: #059669;
            --color-neo-error: #DC2626;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: var(--font-sans);
            background: var(--color-neo-base);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: var(--color-neo-light);
            padding: 40px;
            border-radius: 1.25rem;
            box-shadow: 6px 6px 12px rgba(163, 163, 163, 0.3), -6px -6px 12px rgba(255, 255, 255, 0.9);
            border: 2px solid #C0C0C0;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            margin-bottom: 30px;
            color: var(--color-neo-text);
            text-align: center;
            font-size: 2rem;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--color-neo-text-light);
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 0.75rem;
            font-size: 16px;
            background: var(--color-neo-light);
            color: var(--color-neo-text);
            box-shadow: inset 4px 4px 8px rgba(163, 163, 163, 0.2), inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 2px solid #A0A0A0;
            transition: all 0.2s ease;
        }
        input:focus, select:focus {
            background: var(--color-neo-base);
            border-color: #4A4A4A;
            box-shadow: inset 2px 2px 4px rgba(163, 163, 163, 0.2), inset -2px -2px 4px rgba(255, 255, 255, 0.9), 0 0 0 3px rgba(79, 70, 229, 0.15);
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background: var(--color-neo-accent);
            color: white;
            border: 2px solid #312E81;
            border-radius: 0.75rem;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 4px 4px 12px rgba(79, 70, 229, 0.4), -2px -2px 6px rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }
        button:hover {
            background: var(--color-neo-accent-hover);
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
            box-shadow: none;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            display: none;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Subscribe</h1>
        
        <div id="message" class="message"></div>
        
        <form id="subscribeForm">
            <div class="form-group">
                <label for="msisdn">Phone Number (MSISDN)</label>
                <input type="tel" id="msisdn" name="msisdn" placeholder="+1234567890" required>
            </div>
            
            <div class="form-group">
                <label for="service_type">Service Selection Method</label>
                <select id="service_type" name="service_type" required>
                    <option value="service_id">By Service ID</option>
                    <option value="shortcode">By Shortcode & Keyword</option>
                </select>
            </div>
            
            <div class="form-group" id="service_id_group">
                <label for="service_id">Service ID</label>
                <input type="text" id="service_id" name="service_id" placeholder="e.g., 1">
            </div>
            
            <div class="form-group hidden" id="shortcode_group">
                <label for="shortcode">Shortcode</label>
                <input type="text" id="shortcode" name="shortcode" placeholder="e.g., 1234">
            </div>
            
            <div class="form-group hidden" id="keyword_group">
                <label for="keyword">Keyword</label>
                <input type="text" id="keyword" name="keyword" placeholder="e.g., SUB">
            </div>
            
            <button type="submit" id="submitBtn">Subscribe</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('subscribeForm');
        const serviceType = document.getElementById('service_type');
        const serviceIdGroup = document.getElementById('service_id_group');
        const shortcodeGroup = document.getElementById('shortcode_group');
        const keywordGroup = document.getElementById('keyword_group');
        const messageDiv = document.getElementById('message');
        const submitBtn = document.getElementById('submitBtn');

        serviceType.addEventListener('change', function() {
            const isServiceId = this.value === 'service_id';
            serviceIdGroup.classList.toggle('hidden', !isServiceId);
            shortcodeGroup.classList.toggle('hidden', isServiceId);
            keywordGroup.classList.toggle('hidden', isServiceId);
        });

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const data = {
                msisdn: formData.get('msisdn')
            };

            if (serviceType.value === 'service_id') {
                const serviceId = formData.get('service_id');
                if (serviceId) data.service_id = parseInt(serviceId);
            } else {
                data.shortcode = formData.get('shortcode');
                data.keyword = formData.get('keyword');
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Subscribing...';

            try {
                const response = await fetch('/subscription_manager/subscription_sys/public/api/subscribe.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('success', result.message || 'Subscription successful!');
                    form.classList.add('hidden');
                } else {
                    showMessage('error', result.error || 'Subscription failed');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Subscribe';
                }
            } catch (error) {
                showMessage('error', 'An error occurred: ' + error.message);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Subscribe';
            }
        });

        function showMessage(type, text) {
            messageDiv.className = 'message ' + type;
            messageDiv.textContent = text;
            messageDiv.style.display = 'block';
        }
    </script>
</body>
</html>

