<?php
// Detect protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Detect host
$host = $_SERVER['HTTP_HOST'];

// Detect base path
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = rtrim($scriptName, '/');

// Base URL
define('BASE_URL', $protocol . $host . $basePath . '/');

// Environment
if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false) {
    define('ENVIRONMENT', 'local');
} else {
    define('ENVIRONMENT', 'production');
}

// Error handling
if (ENVIRONMENT === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
