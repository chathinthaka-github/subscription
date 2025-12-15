<?php

class Config
{
    private static $config = null;

    /**
     * Load configuration from .env file
     */
    public static function load($envPath = null)
    {
        if (self::$config !== null) {
            return self::$config;
        }

        $envPath = $envPath ?? __DIR__ . '/../.env';
        self::$config = [];

        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) {
                    continue; // Skip comments
                }

                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    
                    // Remove quotes if present
                    if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                        (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
                        $value = substr($value, 1, -1);
                    }
                    
                    self::$config[$key] = $value;
                }
            }
        }

        return self::$config;
    }

    /**
     * Get configuration value with optional default
     */
    public static function get($key, $default = null)
    {
        if (self::$config === null) {
            self::load();
        }

        return self::$config[$key] ?? $default;
    }

    /**
     * Get database configuration
     */
    public static function db()
    {
        return [
            'host' => self::get('DB_HOST', '127.0.0.1'),
            'port' => self::get('DB_PORT', '3306'),
            'database' => self::get('DB_DATABASE', 'subscription_db'),
            'username' => self::get('DB_USERNAME', 'root'),
            'password' => self::get('DB_PASSWORD', ''),
            'charset' => self::get('DB_CHARSET', 'utf8mb4'),
        ];
    }

    /**
     * Get RabbitMQ configuration
     */
    public static function rabbitmq()
    {
        return [
            'host' => self::get('RABBITMQ_HOST', 'localhost'),
            'port' => self::get('RABBITMQ_PORT', '5672'),
            'user' => self::get('RABBITMQ_USER', 'guest'),
            'password' => self::get('RABBITMQ_PASSWORD', 'guest'),
            'vhost' => self::get('RABBITMQ_VHOST', '/'),
        ];
    }

    /**
     * Get external API configuration
     */
    public static function api()
    {
        return [
            'url' => self::get('EXTERNAL_API_URL', 'https://api.telecom.example.com/send'),
            'key' => self::get('EXTERNAL_API_KEY', ''),
            'timeout' => (int)self::get('EXTERNAL_API_TIMEOUT', '30'),
        ];
    }

    /**
     * Get queue names
     */
    public static function queues()
    {
        return [
            'subscription' => self::get('QUEUE_SUBSCRIPTION', 'subscription_queue'),
            'mt' => self::get('QUEUE_MT', 'mt_queue'),
            'dn' => self::get('QUEUE_DN', 'dn_queue'),
            'renewal' => self::get('QUEUE_RENEWAL', 'renewal_queue'),
        ];
    }

    /**
     * Get log path
     */
    public static function logPath()
    {
        return self::get('LOG_PATH', __DIR__ . '/../logs');
    }
}

