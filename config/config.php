<?php

declare(strict_types=1);

/**
 * Application Configuration
 * Loads environment variables from .env file and provides application settings
 */

// Load .env file if it exists
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            if (!array_key_exists($key, $_ENV)) {
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }
    }
}

/**
 * Get environment variable with fallback
 */
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? getenv($key) ?: $default;
    }
}

return [
    'app' => [
        'name' => env('APP_NAME', 'Palestine Science Olympiad Portal'),
        'env' => env('APP_ENV', 'production'),
        'debug' => env('APP_DEBUG', 'false') === 'true',
        'base_url' => rtrim(env('BASE_URL', 'http://localhost'), '/'),
    ],
    
    'database' => [
        'host' => env('DB_HOST', 'localhost'),
        'port' => (int)env('DB_PORT', '3306'),
        'database' => env('DB_NAME', 'psop_db'),
        'username' => env('DB_USER', 'root'),
        'password' => env('DB_PASS', ''),
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
    
    'session' => [
        'lifetime' => (int)env('SESSION_LIFETIME', '7200'),
        'name' => env('SESSION_NAME', 'PSOP_SESSION'),
        'path' => '/',
        'secure' => env('APP_ENV') === 'production',
        'httponly' => true,
        'samesite' => 'Strict',
    ],
    
    'security' => [
        'csrf_token_name' => env('CSRF_TOKEN_NAME', '_csrf_token'),
    ],
    
    'paths' => [
        'root' => dirname(__DIR__),
        'views' => dirname(__DIR__) . '/views',
        'public' => dirname(__DIR__) . '/public',
        'uploads' => dirname(__DIR__) . '/public/uploads',
    ],
];
