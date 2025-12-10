<?php

declare(strict_types=1);

/**
 * Database Connection Factory
 * Creates and returns a PDO instance with proper error handling
 */

/**
 * Get database PDO connection
 */
function getDatabase(array $config): PDO
{
    static $pdo = null;
    
    if ($pdo === null) {
        $dbConfig = $config['database'];
        
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['database'],
            $dbConfig['charset']
        );
        
        try {
            $pdo = new PDO(
                $dsn,
                $dbConfig['username'],
                $dbConfig['password'],
                $dbConfig['options']
            );
        } catch (PDOException $e) {
            // Log error in production, show in development
            if ($config['app']['debug']) {
                die("Database connection failed: " . $e->getMessage());
            } else {
                error_log("Database connection error: " . $e->getMessage());
                die("Database connection failed. Please contact administrator.");
            }
        }
    }
    
    return $pdo;
}

// Don't auto-execute, just define the function
// Models will call this function with the config they received
