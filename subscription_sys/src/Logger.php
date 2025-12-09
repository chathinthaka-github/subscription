<?php

namespace App;

class Logger
{
    private static string $logDir = __DIR__ . '/../logs';

    public static function log(string $level, string $message, array $context = []): void
    {
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
        $logMessage = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;

        $logFile = self::$logDir . '/' . date('Y-m-d') . '.log';
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('ERROR', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('WARNING', $message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::log('DEBUG', $message, $context);
    }
}

