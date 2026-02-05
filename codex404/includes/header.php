<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once __DIR__ . '/../config/config.php'; ?>
    <?php require_once __DIR__ . '/../connection/connection.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeX404 | Where Bugs Meet Their Match</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS (AUTO CACHE FIX) -->
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime(__DIR__ . '/../css/style.css'); ?>">
</head>
<body>

<header class="navbar">
    <div class="container">

        <!-- LOGO -->
        <a href="<?= BASE_URL ?>index" class="logo-link">
            <div class="logo-box">
                <div class="logo">CodeX404</div>
                <div class="tagline">Where Bugs Meet Their Match</div>
            </div>
        </a>

        <!-- NAV -->
        <nav class="nav">
            <a href="<?= BASE_URL ?>index">Home</a>
            <a href="<?= BASE_URL ?>">Services</a>
            <a href="<?= BASE_URL ?>portfolio">Portfolio</a>
            <a href="<?= BASE_URL ?>">About</a>
            <a href="<?= BASE_URL ?>contact">Contact</a>
        </nav>

        <!-- MOBILE MENU -->
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

    </div>
</header>
