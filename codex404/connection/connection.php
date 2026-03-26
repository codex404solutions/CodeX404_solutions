<?php
require_once __DIR__ . '/../config/config.php';

/*
|--------------------------------------------------
| DATABASE CONFIG (AUTO SWITCH)
|--------------------------------------------------
*/

if (ENVIRONMENT === 'local') {

    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "codex404_db";
} elseif (ENVIRONMENT === 'dev') {

    $db_host = "localhost"; // change if hosting requires
    $db_user = "u274161808_codex404_dev_u";
    $db_pass = "Kolkata@@@786";
    $db_name = "u274161808_codex404_dev";
} else { // production

    $db_host = "localhost"; // change if hosting requires
    $db_user = "u274161808_codex404_user";
    $db_pass = "Kolkata@@@786";
    $db_name = "u274161808_codex404_db";
}

// ---------------- CONNECT ----------------

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// ---------------- ERROR ----------------

if (!$conn) {

    if (ENVIRONMENT === 'local') {
        die("DB Error: " . mysqli_connect_error());
    } else {
        die("Database connection failed.");
    }
}
