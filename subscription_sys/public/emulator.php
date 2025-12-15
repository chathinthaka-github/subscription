<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DN Emulator</title>
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font-sans);
            background: var(--color-neo-base);
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--color-neo-light);
            padding: 30px;
            border-radius: 1.25rem;
            box-shadow: 6px 6px 12px rgba(163, 163, 163, 0.3), -6px -6px 12px rgba(255, 255, 255, 0.9);
            border: 2px solid #C0C0C0;
        }
        h1 {
            margin-bottom: 30px;
            color: var(--color-neo-text);
            font-size: 2rem;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: var(--color-neo-base);
        }
        .btn {
            padding: 8px 16px;
            border-radius: 0.75rem;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            border: 2px solid #8B8B8B;
            background: var(--color-neo-light);
            color: var(--color-neo-text);
            box-shadow: 4px 4px 8px rgba(163, 163, 163, 0.3), -4px -4px 8px rgba(255, 255, 255, 0.8);
        }
        .btn:hover {
            background: var(--color-neo-base);
        }
        .btn-success {
            background: var(--color-neo-success);
            color: white;
            border-color: #065F46;
        }
        .btn-success:hover {
            background: #047857;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: var(--color-neo-light);
            padding: 30px;
            border-radius: 1.25rem;
            box-shadow: 6px 6px 12px rgba(163, 163, 163, 0.3), -6px -6px 12px rgba(255, 255, 255, 0.9);
            border: 2px solid #C0C0C0;
            max-width: 500px;
            width: 90%;
        }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--color-neo-text-light); }
        select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 0.75rem;
            font-size: 14px;
            background: var(--color-neo-light);
            color: var(--color-neo-text);
            box-shadow: inset 4px 4px 8px rgba(163, 163, 163, 0.2), inset -4px -4px 8px rgba(255, 255, 255, 0.9);
            border: 2px solid #A0A0A0;
        }
        textarea { min-height: 100px; resize: vertical; }
        .modal-buttons { display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px; }
        .status-badge { padding: 4px 8px; border-radius: 9999px; font-size: 12px; font-weight: bold; }
        .status-queued, .status-pending { background: #ffc107; color: #000; }
        .status-success { background: #28a745; color: white; }
        .status-fail { background: #dc3545; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>DN Emulator - MT Records</h1>
        <table id="mtTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>MT Ref ID</th>
                    <th>MSISDN</th>
                    <th>Message Type</th>
                    <th>Status</th>
                    <th>DN Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="mtTableBody"></tbody>
        </table>
    </div>

    <div id="dnModal" class="modal">
        <div class="modal-content">
            <h2>Send Delivery Notification</h2>
            <div id="modalMessage" style="display: none; padding: 10px; margin-bottom: 15px; border-radius: 5px;"></div>
            <form id="dnForm">
                <input type="hidden" id="modalMtRefId">
                <div class="form-group">
                    <label for="dnStatus">DN Status</label>
                    <select id="dnStatus" required>
                        <option value="success">Success</option>
                        <option value="fail">Fail</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dnDetails">DN Details</label>
                    <textarea id="dnDetails" placeholder="Enter delivery notification details"></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-success">Send DN</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let mtRecords = [];

        async function loadMTRecords() {
            try {
                const response = await fetch('/subscription_manager/subscription_sys/public/api/get-mt-records.php');
                const result = await response.json();
                if (result.success) {
                    mtRecords = result.data;
                    renderTable();
                } else {
                    document.getElementById('mtTableBody').innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 40px;">Error: ${result.error}</td></tr>`;
                }
            } catch (error) {
                document.getElementById('mtTableBody').innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 40px;">Error: ${error.message}</td></tr>`;
            }
        }

        function renderTable() {
            const tbody = document.getElementById('mtTableBody');
            if (mtRecords.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 40px;">No MT records found</td></tr>';
                return;
            }
            tbody.innerHTML = mtRecords.map(mt => `
                <tr>
                    <td>${mt.id}</td>
                    <td>${mt.mt_ref_id}</td>
                    <td>${mt.msisdn}</td>
                    <td>${mt.message_type}</td>
                    <td><span class="status-badge status-${mt.status.toLowerCase()}">${mt.status}</span></td>
                    <td><span class="status-badge status-${mt.dn_status.toLowerCase()}">${mt.dn_status}</span></td>
                    <td><button class="btn" onclick="openModal('${mt.mt_ref_id}')">Send DN</button></td>
                </tr>
            `).join('');
        }

        function openModal(mtRefId) {
            document.getElementById('modalMtRefId').value = mtRefId;
            document.getElementById('dnModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('dnModal').style.display = 'none';
            document.getElementById('dnForm').reset();
        }

        document.getElementById('dnForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const mtRefId = document.getElementById('modalMtRefId').value;
            const status = document.getElementById('dnStatus').value;
            const details = document.getElementById('dnDetails').value;
            try {
                const response = await fetch('/subscription_manager/subscription_sys/public/api/dn.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ mt_ref_id: mtRefId, status, details })
                });
                const result = await response.json();
                const modalMsg = document.getElementById('modalMessage');
                modalMsg.style.display = 'block';
                modalMsg.style.background = result.success ? '#d4edda' : '#f8d7da';
                modalMsg.style.color = result.success ? '#155724' : '#721c24';
                modalMsg.textContent = result.message || (result.success ? 'DN sent successfully!' : 'Failed to send DN');
                if(result.success) setTimeout(() => { closeModal(); loadMTRecords(); }, 1500);
            } catch (error) {
                // ... (error handling)
            }
        });

        window.onclick = e => { if (e.target == document.getElementById('dnModal')) closeModal(); };

        loadMTRecords();
        setInterval(loadMTRecords, 10000);
    </script>
</body>
</html>

