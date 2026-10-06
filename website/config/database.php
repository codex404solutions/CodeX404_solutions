<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Database Configuration & Connection Provider
 * Uses PDO with resilient error handling and graceful fallbacks.
 */

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): ?PDO {
        if (self::$instance !== null) {
            return self::$instance;
        }

        // Credentials based on environment
        $host = getenv('DB_HOST') ?: 'localhost';
        $port = getenv('DB_PORT') ?: '3306';

        if (ENVIRONMENT === 'local') {
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';
            $name = getenv('DB_NAME') ?: 'codex404_db';
        } elseif (ENVIRONMENT === 'dev') {
            $user = getenv('DB_USER') ?: 'u274161808_codex404_dev_u';
            $pass = getenv('DB_PASS') ?: 'Kolkata@@@786';
            $name = getenv('DB_NAME') ?: 'u274161808_codex404_dev';
        } else {
            $user = getenv('DB_USER') ?: 'u274161808_codex404_user';
            $pass = getenv('DB_PASS') ?: 'Kolkata@@@786';
            $name = getenv('DB_NAME') ?: 'u274161808_codex404_db';
        }

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

        try {
            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 3
            ]);
            return self::$instance;
        } catch (PDOException $e) {
            // Log database connection error silently
            $logFile = LOGS_PATH . '/errors.log';
            $msg = "[" . date('Y-m-d H:i:s') . "] DB Connection Failed: " . $e->getMessage() . PHP_EOL;
            @file_put_contents($logFile, $msg, FILE_APPEND);
            return null;
        }
    }
}
