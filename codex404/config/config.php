<?php

date_default_timezone_set('Asia/Kolkata');
// Prevent direct access
if (!defined('APP_START')) {
    die('Direct access not allowed');
}

// Database config
$db_config = [
    'host'     => 'localhost',
    'username' => 'u274161808_codex404_user',
    'password' => 'Kolkata@@@786',
    'database' => 'u274161808_codex404_db'
];

// Connect DB
$conn = mysqli_connect(
    $db_config['host'],
    $db_config['username'],
    $db_config['password'],
    $db_config['database']
);

// Check connection
if (!$conn) {
    error_log("DB Error: " . mysqli_connect_error());
    die("Database connection failed.");
}

// Charset
mysqli_set_charset($conn, "utf8mb4");
