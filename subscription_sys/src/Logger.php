<?php

require_once __DIR__ . '/Config.php';

// Set timezone to Colombo, Sri Lanka
date_default_timezone_set('Asia/Colombo');

class Logger
{
    private static $logPath = null;

    /**
     * Get log directory path
     */
    private static function getLogPath()
    {
        if (self::$logPath === null) {
            self::$logPath = Config::logPath();
            if (!is_dir(self::$logPath)) {
                mkdir(self::$logPath, 0755, true);
            }
        }
        return self::$logPath;
    }

    /**
     * Write log entry
     */
    private static function write($level, $message, $context = [])
    {
        $logPath = self::getLogPath();
        $logFile = $logPath . '/' . date('Y-m-d') . '.log';
        
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
        $logEntry = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Log info message
     */
    public static function info($message, $context = [])
    {
        self::write('INFO', $message, $context);
    }

    /**
     * Log error message
     */
    public static function error($message, $context = [])
    {
        self::write('ERROR', $message, $context);
    }

    /**
     * Log warning message
     */
    public static function warning($message, $context = [])
    {
        self::write('WARNING', $message, $context);
    }

    /**
     * Log debug message
     */
    public static function debug($message, $context = [])
    {
        if (Config::get('APP_DEBUG', 'false') === 'true') {
            self::write('DEBUG', $message, $context);
        }
    }
}

