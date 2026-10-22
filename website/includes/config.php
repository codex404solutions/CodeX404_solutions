<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Core Application Configuration
 * Framework-free, production-grade architecture.
 */

// Detect HTTPS (including reverse proxies / load balancers)
$isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
    || (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_SSL']) === 'on');
defined('IS_SECURE_CONN') || define('IS_SECURE_CONN', $isSecure);

// Start session if not started with hardened security flags
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

// ---------------- AUTOLOADER ----------------
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

require_once dirname(__DIR__) . '/config/database.php';

// ---------------- ENVIRONMENT DETECTION ----------------
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$cleanHost = strtolower(str_replace('www.', '', explode(':', $host)[0]));

if (in_array($cleanHost, ['localhost', '127.0.0.1'])) {
    defined('ENVIRONMENT') || define('ENVIRONMENT', 'local');
} elseif (str_contains($cleanHost, 'dev.') || str_contains($cleanHost, 'staging.')) {
    defined('ENVIRONMENT') || define('ENVIRONMENT', 'dev');
} else {
    defined('ENVIRONMENT') || define('ENVIRONMENT', 'production');
}

// Error reporting per environment
if (ENVIRONMENT === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', dirname(__DIR__) . '/storage/logs/errors.log');
}

// ---------------- TIMEZONE ----------------
date_default_timezone_set('Asia/Kolkata');

// ---------------- BASE URL CALCULATION ----------------
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
if (str_ends_with($scriptDir, '/admin')) {
    $basePath = substr($scriptDir, 0, -6);
} else {
    $basePath = $scriptDir;
}
$basePath = rtrim($basePath, '/');
if ($basePath === '.' || $basePath === '/.') {
    $basePath = '';
} elseif ($basePath !== '' && !str_starts_with($basePath, '/')) {
    $basePath = '/' . $basePath;
}

// When loaded from root index.php vs subdirectories
if (defined('CUSTOM_BASE_URL')) {
    define('BASE_URL', CUSTOM_BASE_URL);
} else {
    define('BASE_URL', $protocol . $host . $basePath . '/');
}
define('ADMIN_URL', BASE_URL . 'admin/');


// ---------------- BRAND CONSTANTS ----------------
define('APP_NAME', 'CodeX404 Solutions');
define('APP_TAGLINE', 'AI & Software Engineering Partner for Growing Businesses');
define('APP_CORE_MESSAGE', 'Build. Automate. Scale.');
define('APP_DESCRIPTION', 'We design, build and automate digital systems that help growing businesses operate smarter, move faster and scale with confidence.');

// ---------------- CONTACT INFORMATION ----------------
define('COMPANY_EMAIL', 'contact@codex404solutions.online');
define('PRIVACY_EMAIL', 'privacy@codex404solutions.online');
define('COMPANY_LINKEDIN', 'https://www.linkedin.com/company/codex404solutions');
define('COMPANY_GITHUB', 'https://github.com/codex404solutions');
define('COMPANY_TWITTER', 'https://x.com/codex404sol');
define('COMPANY_INSTAGRAM', 'https://www.instagram.com/codex404solutions/');
define('COMPANY_FACEBOOK', 'https://www.facebook.com/codex404solutions/');
define('COMPANY_YOUTUBE', 'https://www.youtube.com/@codex404solutions');
define('COMPANY_WHATSAPP_NUMBER', '+919934240704');
define('COMPANY_WHATSAPP_URL', 'https://wa.me/919934240704?text=Hi%20CodeX404%20Solutions%2C%20I%20would%20like%20to%20discuss%20a%20software%2Fengineering%20project.');
define('COMPANY_LOCATION', 'India & Global Remote');

// ---------------- LEADERSHIP ----------------
define('FOUNDER_NAME', 'Muhammad Noukhez');
define('FOUNDER_ROLE', 'Founder & CEO');
define('FOUNDER_BIO', 'Software engineer and solutions architect focused on resilient systems, custom web/cloud software, and production AI integrations.');
define('FOUNDER_IMAGE', BASE_URL . 'assets/images/team/founder.jpg');
define('FOUNDER_LINKEDIN', 'https://www.linkedin.com/in/mnoukhej/');
define('FOUNDER_PORTFOLIO', 'https://mnoukhej.github.io/portfolio/');

define('COFOUNDER_NAME', 'Yousuf Ansari');
define('COFOUNDER_ROLE', 'Co-Founder & MD');
define('COFOUNDER_BIO', 'Experienced operations and business strategy leader directing client partnerships, project execution, and enterprise delivery.');
define('COFOUNDER_IMAGE', BASE_URL . 'assets/images/team/cofounder.jpg');
define('COFOUNDER_LINKEDIN', 'https://www.linkedin.com/in/md-yousuf-ansari-87ba5369/');

// ---------------- STORAGE PATHS ----------------
define('STORAGE_PATH', dirname(__DIR__) . '/storage');
define('LOGS_PATH', STORAGE_PATH . '/logs');
define('SUBMISSIONS_PATH', STORAGE_PATH . '/submissions');

// Helper function to resolve internal page URLs
function url(string $path = ''): string {
    $trimmed = ltrim($path, '/');
    return BASE_URL . $trimmed;
}

// Helper for asset URLs
function asset(string $path = ''): string {
    return BASE_URL . 'assets/' . ltrim($path, '/');
}

// Helper for admin panel URLs
function admin_url(string $path = ''): string {
    return ADMIN_URL . ltrim($path, '/');
}
