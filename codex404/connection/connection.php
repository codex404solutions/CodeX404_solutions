<?php
require_once __DIR__ . '/../config/config.php';

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
| Automatically switches between LOCAL and LIVE
*/

if (ENVIRONMENT === 'local') {

    // 🔹 LOCAL DATABASE
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "codex404_db";

} else {

    // 🔹 LIVE SERVER DATABASE (Hostinger)
    $host = "localhost";
    $user = "u274161808_codex404_user";
    $password = "Kolkata@@@786";
    $database = "u274161808_codex404_db";
}

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    if (ENVIRONMENT === 'local') {
        die("DB Error: " . mysqli_connect_error());
    } else {
        die("Database connection failed.");
    }
}
