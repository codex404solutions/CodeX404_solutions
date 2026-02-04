<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../connection/connection.php';

// ensure IST
date_default_timezone_set('Asia/Kolkata');

// 1. get executed migrations
$executed = [];
$result = mysqli_query($conn, "SELECT migration FROM migrations");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $executed[] = $row['migration'];
    }
}

// 2. read migration files
$migrationFiles = glob(__DIR__ . '/migrations/*.php');
sort($migrationFiles);

// 3. run pending migrations
foreach ($migrationFiles as $file) {
    $migrationName = basename($file);

    if (!in_array($migrationName, $executed)) {

        echo "Running: $migrationName <br>";

        $sql = require $file;

        if (mysqli_query($conn, $sql)) {

            $time = date('Y-m-d H:i:s');
            mysqli_query(
                $conn,
                "INSERT INTO migrations (migration, created_at)
                 VALUES ('$migrationName', '$time')"
            );

            echo "✔ Done<br><br>";
        } else {
            die("❌ Failed: " . mysqli_error($conn));
        }
    }
}

echo "<strong>All migrations completed.</strong>";
