<?php

namespace App;

class Config
{
    private static array $config = [];

    public static function load(string $envFile = '.env'): void
    {
        $envPath = __DIR__ . '/../' . $envFile;
        
        if (!file_exists($envPath)) {
            throw new \RuntimeException("Environment file not found: {$envPath}");
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            self::$config[$key] = $value;
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return self::$config[$key] ?? $default;
    }

    public static function all(): array
    {
        return self::$config;
    }
}

