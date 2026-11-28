<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Database Configuration & Connection Provider
 * Uses PDO with resilient error handling and graceful fallbacks.
 * Credentials are read dynamically from environment variables or .env.
 */

require_once __DIR__ . '/Env.php';
Env::load(dirname(__DIR__) . '/.env');

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): ?PDO {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host = Env::get('DB_HOST', 'localhost');
        $port = Env::get('DB_PORT', '3306');
        $user = Env::get('DB_USER', 'root');
        $pass = Env::get('DB_PASS', '');
        $name = Env::get('DB_NAME', 'codex404_db');

        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

        try {
            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 3,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
            ]);
            return self::$instance;
        } catch (PDOException $e) {
            $logFile = (defined('LOGS_PATH') ? LOGS_PATH : dirname(__DIR__) . '/storage/logs') . '/errors.log';
            @mkdir(dirname($logFile), 0755, true);
            // Strip any sensitive credentials or host topology before logging
            $sanitizedMsg = preg_replace(
                ['/password[=:][^\s;,\)]+/i', '/user[=:][^\s;,\)]+/i', "/user '[^']+'/i"],
                ['password=***', 'user=***', "user '***'"],
                $e->getMessage()
            ) ?? 'Connection error';
            $msg = "[" . date('Y-m-d H:i:s') . "] DB Connection Failed [Code: " . $e->getCode() . "]: " . $sanitizedMsg . PHP_EOL;
            @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);
            return null;
        }
    }
}
