# Pure PHP Backend Processing System

## Setup

### 1. Install Dependencies

```bash
cd subscription_sys
composer install
```

### 2. Configure Environment

Copy `.env.example` to `.env` and update with your database and RabbitMQ credentials:

```bash
cp .env.example .env
```

Edit `.env` with your settings:
- Database connection details
- RabbitMQ connection details
- External API URL (if applicable)

### 3. Install RabbitMQ

Ensure RabbitMQ is installed and running:

```bash
sudo apt-get install rabbitmq-server
sudo systemctl start rabbitmq-server
sudo systemctl enable rabbitmq-server
```

### 4. Setup Supervisor

Copy Supervisor configuration files:

```bash
sudo cp supervisor/*.conf /etc/supervisor/conf.d/
```

Update Supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```

### 5. Make Workers Executable

```bash
chmod +x workers/*.php
```

## API Endpoints

### Subscribe

**POST** `/api/subscribe`

Request body:
```json
{
  "msisdn": "+1234567890",
  "service_id": 1,
  "renewal_plan_id": 1
}
```

Or using shortcode/keyword:
```json
{
  "msisdn": "+1234567890",
  "shortcode": "1234",
  "keyword": "SUB"
}
```

### Delivery Notification

**POST** `/api/dn`

Request body:
```json
{
  "mt_ref_id": "MT123456",
  "status": "success",
  "details": "Message delivered successfully"
}
```

## Worker Management

### Start Workers

```bash
sudo supervisorctl start all
```

### Stop Workers

```bash
sudo supervisorctl stop all
```

### Restart Workers

```bash
sudo supervisorctl restart all
```

### Check Status

```bash
sudo supervisorctl status
```

### View Logs

```bash
tail -f logs/subscription_worker.log
tail -f logs/mt_worker.log
tail -f logs/dn_worker.log
tail -f logs/renewal_worker.log
```

## Notes

- **No Cron Required**: The renewal worker runs continuously and checks for due renewals every 60 seconds
- **Database**: Uses the same database as Laravel UI (`telecom_project`)
- **Logging**: All logs are stored in `logs/` directory
- **Error Handling**: Workers automatically retry failed messages

## Troubleshooting

### Workers Not Starting

1. Check Supervisor logs: `sudo tail -f /var/log/supervisor/supervisord.log`
2. Check worker logs: `tail -f logs/*.log`
3. Verify RabbitMQ is running: `sudo systemctl status rabbitmq-server`
4. Verify database connection in `.env`

### Messages Not Processing

1. Check RabbitMQ management: `sudo rabbitmqctl list_queues`
2. Check worker status: `sudo supervisorctl status`
3. Verify queue names match in `.env` and code

