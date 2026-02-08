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


// Founder Details
define('FOUNDER_NAME', 'Muhammad Noukhez');
define('FOUNDER_ROLE', 'Founder & CEO');
define('FOUNDER_BIO', 'Founder of CodeX404, a software engineer focused on building clean, secure, and scalable web applications.');
define('FOUNDER_IMAGE', BASE_URL . 'images/founder.jpg');
define('FOUNDER_LINKEDIN', 'https://www.linkedin.com/in/mnoukhej/');


// Co-Founder Details
define('COFOUNDER_NAME', 'Md Yousuf Ansari');
define('COFOUNDER_ROLE', 'Co-Founder & MD');
define('COFOUNDER_BIO', 'Co-founder of CodeX404, contributing to business strategy, operations, and project coordination with a strong focus on client success.');
define('COFOUNDER_IMAGE', BASE_URL . 'images/cofounder.jpg');
define('COFOUNDER_LINKEDIN', 'https://www.linkedin.com/in/md-yousuf-ansari-87ba5369/');
    
