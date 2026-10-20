<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Authentication Guard & Session Handler
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/security.php';

// Valid admin credentials
define('ADMIN_USER', 'admin');
define('ADMIN_ALT_USER', 'admin@codex404solutions.online');
// Password specified by user: admin@1234
define('ADMIN_PASS_HASH', '$2y$10$wK1yR95kK4W0sVn6E0fFTeFfH7YkP4H7QYy9NfZR1xQqyFkY3a5G2'); // password_hash('admin@1234', PASSWORD_DEFAULT)
define('ADMIN_PLAIN_PASS', 'admin@1234');

/**
 * Check if the current session has authenticated admin access.
 */
function is_admin_logged_in(): bool
{
    return !empty($_SESSION['codex_admin_logged']) && $_SESSION['codex_admin_logged'] === true;
}

/**
 * Enforce admin access. Redirects unauthenticated users to the login screen.
 */
function require_admin_auth(): void
{
    if (!is_admin_logged_in()) {
        $loginUrl = admin_url('login.php');
        $return = $_SERVER['REQUEST_URI'] ?? '';
        if ($return !== '' && !str_contains($return, 'login.php')) {
            $loginUrl .= '?return=' . urlencode($return);
        }
        header('Location: ' . $loginUrl);
        exit;
    }
}

/**
 * Authenticate credentials.
 */
function authenticate_admin(string $username, string $password): bool
{
    $cleanUser = trim(strtolower($username));
    $validUser = ($cleanUser === strtolower(ADMIN_USER) || $cleanUser === strtolower(ADMIN_ALT_USER));

    if (!$validUser) {
        return false;
    }

    // Verify against both hash and direct fallback
    if ($password === ADMIN_PLAIN_PASS || password_verify($password, ADMIN_PASS_HASH)) {
        if (!headers_sent()) {
            session_regenerate_id(true);
        }
        $_SESSION['codex_admin_logged'] = true;
        $_SESSION['codex_admin_user'] = ADMIN_USER;
        $_SESSION['codex_admin_time'] = time();
        return true;
    }

    return false;
}

/**
 * Terminate admin session.
 */
function admin_logout(): void
{
    unset($_SESSION['codex_admin_logged'], $_SESSION['codex_admin_user'], $_SESSION['codex_admin_time']);
    if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
        session_regenerate_id(true);
    }
}

/**
 * Set a flash notification for the admin dashboard.
 */
function set_admin_flash(string $type, string $message): void
{
    $_SESSION['codex_admin_flash'] = [
        'type' => $type, // 'success' | 'error' | 'info'
        'message' => $message,
    ];
}

/**
 * Retrieve and clear flash notification.
 */
function get_admin_flash(): ?array
{
    if (!empty($_SESSION['codex_admin_flash'])) {
        $flash = $_SESSION['codex_admin_flash'];
        unset($_SESSION['codex_admin_flash']);
        return $flash;
    }
    return null;
}
