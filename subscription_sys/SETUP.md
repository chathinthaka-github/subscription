# Setup Guide - Subscription System

## Step-by-Step Setup Instructions

### 1. ✅ Environment Configuration (DONE)
Your `.env` file has been configured with:
- Database: `telecom_project` (same as Laravel)
- RabbitMQ: Default guest/guest credentials

### 2. Start RabbitMQ Server

Check if RabbitMQ is running:
```bash
sudo systemctl status rabbitmq-server
```

If not running, start it:
```bash
sudo systemctl start rabbitmq-server
sudo systemctl enable rabbitmq-server  # Auto-start on boot
```

Verify RabbitMQ is working:
```bash
sudo rabbitmqctl status
```

### 3. Test Database Connection

Test the database connection:
```bash
cd /var/www/html/subscription_manager/subscription_sys
php -r "require 'src/Config.php'; require 'src/Database.php'; Config::load(); \$db = Database::getInstance(); echo 'Database connection: OK\n';"
```

### 4. Test RabbitMQ Connection

Test RabbitMQ:
```bash
php -r "require 'vendor/autoload.php'; require 'src/Config.php'; require 'src/RabbitMQ.php'; Config::load(); RabbitMQ::publish('test_queue', ['test' => 'message']); echo 'RabbitMQ: OK\n';"
```

### 5. Setup Supervisor Configuration

Copy supervisor configs:
```bash
sudo cp supervisor/*.conf /etc/supervisor/conf.d/
```

Update supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
```

### 6. Start All Workers

```bash
sudo supervisorctl start all
```

### 7. Check Worker Status

```bash
sudo supervisorctl status
```

You should see all 4 workers running:
- subscription_worker: RUNNING
- mt_worker: RUNNING
- dn_worker: RUNNING
- renewal_worker: RUNNING

### 8. Monitor Logs

View worker logs:
```bash
# Subscription worker
tail -f logs/subscription_worker.log

# MT worker
tail -f logs/mt_worker.log

# DN worker
tail -f logs/dn_worker.log

# Renewal worker
tail -f logs/renewal_worker.log
```

### 9. Test the System

#### Test Subscription API:
```bash
curl -X POST http://localhost/subscription_sys/public/api/subscribe.php \
  -H "Content-Type: application/json" \
  -d '{"msisdn":"+1234567890","service_id":1}'
```

#### Access Public Pages:
- Subscription Page: http://localhost/subscription_sys/public/subscribe-page.php
- DN Emulator: http://localhost/subscription_sys/public/emulator.php

### 10. Troubleshooting

#### Workers Not Starting:
```bash
# Check supervisor logs
sudo tail -f /var/log/supervisor/supervisord.log

# Check worker error logs
tail -f logs/*_error.log

# Restart specific worker
sudo supervisorctl restart subscription_worker
```

#### RabbitMQ Issues:
```bash
# Check RabbitMQ status
sudo rabbitmqctl status

# List queues
sudo rabbitmqctl list_queues

# Check connections
sudo rabbitmqctl list_connections
```

#### Database Issues:
- Verify database credentials in `.env`
- Ensure database `telecom_project` exists
- Check MySQL is running: `sudo systemctl status mysql`

### Useful Commands

```bash
# Restart all workers
sudo supervisorctl restart all

# Stop all workers
sudo supervisorctl stop all

# Start all workers
sudo supervisorctl start all

# View real-time logs
tail -f logs/*.log

# Check worker status
sudo supervisorctl status

# Reload supervisor config after changes
sudo supervisorctl reread
sudo supervisorctl update
```

