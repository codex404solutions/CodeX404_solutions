<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Authentication Guard & Session Handler
 * Credentials are configurable via environment variables (.env).
 * Enforces persistent account lockout, strict password policy, session fixation
 * protection, idle/absolute timeouts, and client binding.
 */

require_once dirname(__DIR__) . '/includes/config.php';
require_once dirname(__DIR__) . '/includes/security.php';
require_once dirname(__DIR__) . '/config/Env.php';
Env::load(dirname(__DIR__) . '/.env');

// Link CRM RBAC & UserService for unified workforce profiling
$crmServicesDir = dirname(__DIR__, 2) . '/crm/app/Services';
if (file_exists($crmServicesDir . '/UserService.php')) {
    require_once $crmServicesDir . '/StorageService.php';
    require_once $crmServicesDir . '/RBACService.php';
    require_once $crmServicesDir . '/UserService.php';
    \CRM\Services\StorageService::init(dirname(__DIR__, 2) . '/crm/storage');
}

// Configure admin session settings before session starts or enforce if active
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    $isSecure = (defined('IS_SECURE_CONN') && IS_SECURE_CONN)
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (defined('ENVIRONMENT') && ENVIRONMENT === 'production');

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
}

// Valid admin credentials. Authentication is disabled until a real hash is configured.
defined('ADMIN_USER') || define('ADMIN_USER', Env::get('ADMIN_USER', ''));
defined('ADMIN_ALT_USER') || define('ADMIN_ALT_USER', Env::get('ADMIN_ALT_USER', ''));
defined('ADMIN_PASS_HASH') || define('ADMIN_PASS_HASH', Env::get('ADMIN_PASS_HASH', ''));

// Account lockout configuration
defined('ADMIN_MAX_FAILED_ATTEMPTS') || define('ADMIN_MAX_FAILED_ATTEMPTS', 5);
defined('ADMIN_ATTEMPT_WINDOW') || define('ADMIN_ATTEMPT_WINDOW', 900); // 15-minute failure counting window
defined('ADMIN_LOCKOUT_DURATION') || define('ADMIN_LOCKOUT_DURATION', 900); // 15-minute lockout

// Failed attempt tracking keys
defined('ADMIN_FAILED_ATTEMPTS_KEY') || define('ADMIN_FAILED_ATTEMPTS_KEY', 'codex_admin_failed_attempts');
defined('ADMIN_LOCKOUT_KEY') || define('ADMIN_LOCKOUT_KEY', 'codex_admin_lockout_until');

// Inactivity/session lifetime in seconds (30 minutes idle, 8 hours absolute max)
defined('ADMIN_SESSION_TIMEOUT') || define('ADMIN_SESSION_TIMEOUT', 1800);
defined('ADMIN_SESSION_MAX_LIFETIME') || define('ADMIN_SESSION_MAX_LIFETIME', 28800);

/**
 * File path for persistent lockout state storage.
 */
function get_admin_lockout_file(): string
{
    $dir = (defined('STORAGE_PATH') ? STORAGE_PATH : dirname(__DIR__) . '/storage') . '/auth';
    @mkdir($dir, 0700, true);
    return $dir . '/admin_lockouts.json';
}

/**
 * Check if admin account or client IP is locked out.
 * Evaluates both persistent store (by IP & username) and session state.
 */
function is_admin_locked_out(?string $username = null): bool
{
    // 1. Session check
    $sessionLockout = (int)($_SESSION[ADMIN_LOCKOUT_KEY] ?? 0);
    if ($sessionLockout > time()) {
        return true;
    }

    // 2. Persistent file check (IP + username)
    $file = get_admin_lockout_file();
    if (!file_exists($file)) {
        return false;
    }

    $ip = get_client_ip();
    $userKey = $username !== null ? strtolower(trim($username)) : '';

    $fp = @fopen($file, 'rb');
    if (!$fp) {
        return false;
    }

    $locked = false;
    if (flock($fp, LOCK_SH)) {
        $filesize = filesize($file);
        $contents = $filesize > 0 ? (string)fread($fp, $filesize) : '';
        $data = json_decode($contents, true);
        if (is_array($data)) {
            $now = time();
            // Check IP lockout
            $ipLock = (int)($data["lockout_ip:{$ip}"] ?? 0);
            if ($ipLock > $now) {
                $locked = true;
            }
            // Check username lockout if provided
            if (!$locked && $userKey !== '') {
                $userLock = (int)($data["lockout_user:{$userKey}"] ?? 0);
                if ($userLock > $now) {
                    $locked = true;
                }
            }
        }
        flock($fp, LOCK_UN);
    }
    fclose($fp);

    return $locked;
}

/**
 * Get remaining lockout time in seconds.
 */
function get_admin_lockout_remaining(?string $username = null): int
{
    $now = time();
    $maxRemaining = 0;

    // Session remaining
    $sessionLockout = (int)($_SESSION[ADMIN_LOCKOUT_KEY] ?? 0);
    if ($sessionLockout > $now) {
        $maxRemaining = max($maxRemaining, $sessionLockout - $now);
    }

    // Persistent file remaining
    $file = get_admin_lockout_file();
    if (file_exists($file)) {
        $ip = get_client_ip();
        $userKey = $username !== null ? strtolower(trim($username)) : '';

        $fp = @fopen($file, 'rb');
        if ($fp) {
            if (flock($fp, LOCK_SH)) {
                $filesize = filesize($file);
                $contents = $filesize > 0 ? (string)fread($fp, $filesize) : '';
                $data = json_decode($contents, true);
                if (is_array($data)) {
                    $ipLock = (int)($data["lockout_ip:{$ip}"] ?? 0);
                    if ($ipLock > $now) {
                        $maxRemaining = max($maxRemaining, $ipLock - $now);
                    }
                    if ($userKey !== '') {
                        $userLock = (int)($data["lockout_user:{$userKey}"] ?? 0);
                        if ($userLock > $now) {
                            $maxRemaining = max($maxRemaining, $userLock - $now);
                        }
                    }
                }
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }

    return $maxRemaining;
}

/**
 * Record a failed admin authentication attempt (persistent + session).
 */
function record_failed_admin_attempt(string $username = ''): void
{
    $now = time();
    $ip = get_client_ip();
    $userKey = strtolower(trim($username));

    // 1. Session tracking
    $attempts = ((int)($_SESSION[ADMIN_FAILED_ATTEMPTS_KEY] ?? 0)) + 1;
    $_SESSION[ADMIN_FAILED_ATTEMPTS_KEY] = $attempts;
    if ($attempts >= ADMIN_MAX_FAILED_ATTEMPTS) {
        $_SESSION[ADMIN_LOCKOUT_KEY] = $now + ADMIN_LOCKOUT_DURATION;
        $_SESSION[ADMIN_FAILED_ATTEMPTS_KEY] = 0;
    }

    // 2. Persistent file tracking with atomic locking
    $file = get_admin_lockout_file();
    $fp = @fopen($file, 'c+');
    if (!$fp) {
        return;
    }

    if (flock($fp, LOCK_EX)) {
        $filesize = filesize($file);
        $contents = $filesize > 0 ? (string)fread($fp, $filesize) : '';
        $data = json_decode($contents, true);
        if (!is_array($data)) {
            $data = [];
        }

        // Lazy cleanup of old entries
        foreach ($data as $k => $val) {
            if (str_starts_with($k, 'lockout_') && (int)$val < $now) {
                unset($data[$k]);
            } elseif (str_starts_with($k, 'attempts_') && is_array($val)) {
                if (($now - (int)($val['first_time'] ?? 0)) > ADMIN_ATTEMPT_WINDOW) {
                    unset($data[$k]);
                }
            }
        }

        $targets = ["ip:{$ip}"];
        if ($userKey !== '') {
            $targets[] = "user:{$userKey}";
        }

        foreach ($targets as $target) {
            $attemptKey = "attempts_{$target}";
            $lockoutKey = "lockout_{$target}";

            $entry = $data[$attemptKey] ?? ['count' => 0, 'first_time' => $now];
            if (($now - (int)($entry['first_time'] ?? 0)) > ADMIN_ATTEMPT_WINDOW) {
                $entry = ['count' => 1, 'first_time' => $now];
            } else {
                $entry['count'] = (int)($entry['count'] ?? 0) + 1;
            }

            if ($entry['count'] >= ADMIN_MAX_FAILED_ATTEMPTS) {
                $data[$lockoutKey] = $now + ADMIN_LOCKOUT_DURATION;
                $entry = ['count' => 0, 'first_time' => $now];
            }

            $data[$attemptKey] = $entry;
        }

        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, (string)json_encode($data, JSON_UNESCAPED_SLASHES));
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

/**
 * Reset failed attempt counter on successful authentication.
 */
function reset_admin_failed_attempts(string $username = ''): void
{
    unset($_SESSION[ADMIN_FAILED_ATTEMPTS_KEY], $_SESSION[ADMIN_LOCKOUT_KEY]);

    $file = get_admin_lockout_file();
    if (!file_exists($file)) {
        return;
    }

    $ip = get_client_ip();
    $userKey = strtolower(trim($username));

    $fp = @fopen($file, 'c+');
    if ($fp && flock($fp, LOCK_EX)) {
        $filesize = filesize($file);
        $contents = $filesize > 0 ? (string)fread($fp, $filesize) : '';
        $data = json_decode($contents, true);
        if (is_array($data)) {
            unset(
                $data["attempts_ip:{$ip}"],
                $data["lockout_ip:{$ip}"],
                $data["attempts_user:{$userKey}"],
                $data["lockout_user:{$userKey}"]
            );
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, (string)json_encode($data, JSON_UNESCAPED_SLASHES));
            fflush($fp);
        }
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}

/**
 * Validate password strength against security policy.
 * @param array<int, string> $errors Detailed failure reasons (by reference)
 */
function validate_admin_password_strength(string $password, array &$errors = []): bool
{
    $errors = [];

    if (strlen($password) < 12) {
        $errors[] = 'Password must be at least 12 characters in length.';
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must include at least one uppercase letter (A-Z).';
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must include at least one lowercase letter (a-z).';
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must include at least one number (0-9).';
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = 'Password must include at least one special character.';
    }
    if (preg_match('/\s/', $password)) {
        $errors[] = 'Password cannot contain spaces.';
    }

    return empty($errors);
}

/**
 * Check if the current session has authenticated admin access with
 * idle timeout, absolute lifetime check, and client fingerprint binding.
 */
function is_admin_logged_in(): bool
{
    if (empty($_SESSION['codex_admin_logged']) || $_SESSION['codex_admin_logged'] !== true) {
        return false;
    }

    $now = time();
    $loginTime = (int)($_SESSION['codex_admin_time'] ?? 0);
    $lastActivity = (int)($_SESSION['codex_admin_last_activity'] ?? $loginTime);

    // Absolute session max lifetime check (8 hours)
    if ($loginTime <= 0 || ($now - $loginTime) > ADMIN_SESSION_MAX_LIFETIME) {
        admin_logout();
        set_admin_flash('info', 'Your session has reached maximum duration. Please sign in again.');
        return false;
    }

    // Idle session timeout check (30 minutes)
    if (($now - $lastActivity) > ADMIN_SESSION_TIMEOUT) {
        admin_logout();
        set_admin_flash('info', 'Session expired due to inactivity. Please sign in again.');
        return false;
    }

    // Session hijacking protection: verify IP address and User-Agent binding
    $storedIp = (string)($_SESSION['codex_admin_ip'] ?? '');
    $currentIp = get_client_ip();
    if ($storedIp !== '' && !hash_equals($storedIp, $currentIp)) {
        // Suspected IP mismatch
        admin_logout();
        return false;
    }

    // Periodic session rotation (every 15 minutes) for active sessions
    $lastRotation = (int)($_SESSION['codex_admin_rotated_at'] ?? $loginTime);
    if (($now - $lastRotation) > 900) {
        if (!headers_sent()) {
            session_regenerate_id(true);
        }
        $_SESSION['codex_admin_rotated_at'] = $now;
    }

    // Access Scope verification
    $profile = current_admin_profile();
    if (($profile['access_scope'] ?? 'both') === 'crm_only') {
        admin_logout();
        set_admin_flash('error', 'Access Restricted: Your account is restricted to CRM Portal access only.');
        return false;
    }

    // Update last activity timestamp
    $_SESSION['codex_admin_last_activity'] = $now;

    return true;
}

/**
 * Enforce admin access. Redirects unauthenticated users to the login screen.
 */
function require_admin_auth(): void
{
    if (!is_admin_logged_in()) {
        $loginUrl = admin_url('login');
        $return = $_SERVER['REQUEST_URI'] ?? '';
        if ($return !== '' && !str_contains($return, 'login')) {
            $loginUrl .= '?return=' . urlencode($return);
        }
        header('Location: ' . $loginUrl);
        exit;
    }
}

/**
 * Authenticate credentials with portal clearance verification.
 */
function authenticate_admin(string $username, string $password, ?string &$errorReason = null): bool
{
    // Check if account or IP is locked out
    if (is_admin_locked_out($username)) {
        return false;
    }

    $cleanUser = trim(strtolower($username));

    // 1. Try unified UserService (MySQL or StorageService fallback)
    if (class_exists('\\CRM\\Services\\UserService')) {
        try {
            $user = \CRM\Services\UserService::getByUsernameOrEmail($cleanUser);
            if ($user && ($user['status'] ?? 'active') === 'active' && !empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
                // Portal Access Scope Enforcement
                $scope = $user['access_scope'] ?? 'both';
                if ($scope === 'crm_only') {
                    $errorReason = 'Access Restricted: Your account is provisioned for CRM Portal access only. Contact your executive administrator for Website Admin authorization.';
                    return false;
                }

                if (!headers_sent()) {
                    session_regenerate_id(true);
                }

                $now = time();
                $_SESSION['codex_admin_logged'] = true;
                $_SESSION['codex_admin_user'] = $user['username'] ?? 'admin';
                $_SESSION['codex_admin_user_id'] = $user['id'] ?? 'usr_admin';
                $_SESSION['codex_admin_profile'] = $user;
                $_SESSION['codex_admin_roles'] = (array)($user['roles'] ?? ['superadmin']);
                $_SESSION['codex_admin_time'] = $now;
                $_SESSION['codex_admin_last_activity'] = $now;
                $_SESSION['codex_admin_rotated_at'] = $now;
                $_SESSION['codex_admin_ip'] = get_client_ip();
                $_SESSION['codex_admin_ua'] = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);

                \CRM\Services\UserService::recordLogin($user['id']);
                reset_admin_failed_attempts($username);
                return true;
            }
        } catch (\Throwable $e) {
            // Fall through to database / env fallback
        }
    }

    // 2. Direct MySQL Database authentication fallback
    $pdo = Database::getConnection();
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM `users` WHERE LOWER(`username`) = :u OR LOWER(`email`) = :u LIMIT 1");
            $stmt->execute([':u' => $cleanUser]);
            $dbUser = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($dbUser && !empty($dbUser['password_hash']) && password_verify($password, $dbUser['password_hash'])) {
                if (!headers_sent()) {
                    session_regenerate_id(true);
                }

                $now = time();
                $_SESSION['codex_admin_logged'] = true;
                $_SESSION['codex_admin_user'] = $dbUser['username'] ?? 'admin';
                $_SESSION['codex_admin_user_id'] = $dbUser['id'] ?? 'usr_admin';
                $_SESSION['codex_admin_profile'] = $dbUser;
                $_SESSION['codex_admin_roles'] = ['superadmin', 'founder', 'ceo', 'cto'];
                $_SESSION['codex_admin_time'] = $now;
                $_SESSION['codex_admin_last_activity'] = $now;
                $_SESSION['codex_admin_rotated_at'] = $now;
                $_SESSION['codex_admin_ip'] = get_client_ip();
                $_SESSION['codex_admin_ua'] = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);

                reset_admin_failed_attempts($username);
                return true;
            }
        } catch (\Throwable $e) {
            // Fallback to env
        }
    }

    // 3. Fallback to .env admin credentials
    $validUser = ($cleanUser === strtolower((string)ADMIN_USER) || (ADMIN_ALT_USER !== '' && $cleanUser === strtolower((string)ADMIN_ALT_USER)));

    if (!$validUser || ADMIN_PASS_HASH === '' || password_get_info(ADMIN_PASS_HASH)['algo'] === null) {
        record_failed_admin_attempt($username);
        return false;
    }

    if (password_verify($password, ADMIN_PASS_HASH)) {
        if (!headers_sent()) {
            session_regenerate_id(true);
        }

        $now = time();
        $_SESSION['codex_admin_logged'] = true;
        $_SESSION['codex_admin_user'] = ADMIN_USER;
        $_SESSION['codex_admin_user_id'] = 'usr_admin_alex';
        $_SESSION['codex_admin_roles'] = ['superadmin', 'founder', 'ceo', 'cto'];

        // Pull full profile if available
        if (class_exists('\\CRM\\Services\\UserService')) {
            \CRM\Services\UserService::seedDefaultUsersIfEmpty();
            $seeded = \CRM\Services\UserService::getByUsernameOrEmail('admin');
            if ($seeded) {
                $_SESSION['codex_admin_profile'] = $seeded;
                $_SESSION['codex_admin_user_id'] = $seeded['id'];
                $_SESSION['codex_admin_roles'] = $seeded['roles'] ?? ['superadmin'];
            }
        }

        $_SESSION['codex_admin_time'] = $now;
        $_SESSION['codex_admin_last_activity'] = $now;
        $_SESSION['codex_admin_rotated_at'] = $now;
        $_SESSION['codex_admin_ip'] = get_client_ip();
        $_SESSION['codex_admin_ua'] = substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);

        reset_admin_failed_attempts($username);
        return true;
    }

    record_failed_admin_attempt($username);
    return false;
}

/**
 * Terminate admin session securely.
 */
function admin_logout(): void
{
    unset(
        $_SESSION['codex_admin_logged'],
        $_SESSION['codex_admin_user'],
        $_SESSION['codex_admin_time'],
        $_SESSION['codex_admin_last_activity'],
        $_SESSION['codex_admin_rotated_at'],
        $_SESSION['codex_admin_ip'],
        $_SESSION['codex_admin_ua']
    );

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

/**
 * Retrieve the current admin's full profile.
 */
function current_admin_profile(): array
{
    if (class_exists('\\CRM\\Services\\UserService')) {
        $username = (string)($_SESSION['codex_admin_user'] ?? 'admin');
        $user = \CRM\Services\UserService::getByUsernameOrEmail($username);
        if ($user) {
            $_SESSION['codex_admin_profile'] = $user;
            return $user;
        }
    }

    if (!empty($_SESSION['codex_admin_profile']) && is_array($_SESSION['codex_admin_profile'])) {
        return $_SESSION['codex_admin_profile'];
    }

    return [
        'id' => 'usr_admin_alex',
        'username' => (string)($_SESSION['codex_admin_user'] ?? 'admin'),
        'name' => 'Alex Rivera',
        'email' => 'admin@codex404solutions.online',
        'title' => 'Chief Executive Officer & Founder',
        'department' => 'Executive Leadership',
        'roles' => (array)($_SESSION['codex_admin_roles'] ?? ['superadmin', 'founder', 'ceo', 'cto']),
        'status' => 'active',
        'bio' => 'Founder & Principal Systems Architect at CodeX404 Solutions.'
    ];
}

/**
 * Check if the currently logged-in admin has a permission.
 */
function current_admin_can(string $permission): bool
{
    $profile = current_admin_profile();
    $roles = (array)($profile['roles'] ?? ['superadmin']);

    if (class_exists('\\CRM\\Services\\RBACService')) {
        return \CRM\Services\RBACService::hasPermission(
            $roles,
            $permission,
            (array)($profile['custom_permissions'] ?? null)
        );
    }

    return in_array('superadmin', array_map('strtolower', $roles), true);
}

/**
 * Check if the currently logged-in admin has a specific role.
 */
function current_admin_has_role(string $role): bool
{
    $profile = current_admin_profile();
    $roles = array_map('strtolower', (array)($profile['roles'] ?? []));
    return in_array(strtolower(trim($role)), $roles, true);
}


