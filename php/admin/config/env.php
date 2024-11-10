<?php

class Environment {
    private static $variables = [];

    public static function load($path = null) {
        if ($path === null) {
            $path = dirname(__DIR__) . '/.env';
        }

        if (!file_exists($path)) {
            throw new Exception('.env file not found');
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) continue;
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Remove quotes if present
            if (preg_match('/^"(.+)"$/', $value, $matches)) {
                $value = $matches[1];
            }
            
            // Replace ${VAR} with actual environment variables
            $value = preg_replace_callback('/\${([^}]+)}/', function($matches) {
                return self::get($matches[1], '');
            }, $value);

            self::$variables[$name] = $value;
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }

    public static function get($key, $default = null) {
        return self::$variables[$key] ?? $default;
    }

    public static function all() {
        return self::$variables;
    }
}

// Load environment variables
try {
    Environment::load();
} catch (Exception $e) {
    error_log('Error loading environment variables: ' . $e->getMessage());
}
