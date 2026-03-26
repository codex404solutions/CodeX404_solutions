<?php
// config.php

// Detect protocol
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Detect host
$host = $_SERVER['HTTP_HOST'];

// Detect base path
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$basePath = rtrim($scriptName, '/');

// Base URL
define('BASE_URL', $protocol . $host . $basePath . '/');

// ---------------- ENVIRONMENT DETECTION ----------------

// Normalize host (remove www)
$cleanHost = str_replace('www.', '', $host);

if (in_array($cleanHost, ['localhost', '127.0.0.1'])) {
    define('ENVIRONMENT', 'local');
} elseif (strpos($cleanHost, 'dev') !== false) {
    // dev.codex404.com OR anything containing 'dev'
    define('ENVIRONMENT', 'dev');
} else {
    define('ENVIRONMENT', 'production');
}

// ---------------- ERROR HANDLING ----------------

if (ENVIRONMENT === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ---------------- FOUNDER ----------------

define('FOUNDER_NAME', 'Muhammad Noukhez');
define('FOUNDER_ROLE', 'Founder & CEO');
define('FOUNDER_BIO', 'Founder of CodeX404 Solutions, focused on clean, secure, scalable apps.');
define('FOUNDER_IMAGE', BASE_URL . 'images/founder.jpg');
define('FOUNDER_LINKEDIN', 'https://www.linkedin.com/in/mnoukhej/');

// ---------------- CO-FOUNDER ----------------

define('COFOUNDER_NAME', 'Yousuf Ansari');
define('COFOUNDER_ROLE', 'Co-Founder & MD');
define('COFOUNDER_BIO', 'Handles business strategy and operations.');
define('COFOUNDER_IMAGE', BASE_URL . 'images/cofounder.jpg');
define('COFOUNDER_LINKEDIN', 'https://www.linkedin.com/in/md-yousuf-ansari-87ba5369/');
