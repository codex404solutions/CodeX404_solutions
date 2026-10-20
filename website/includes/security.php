<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Security & Protection Module
 * Hardened HTTP headers, CSRF validation, sanitization, and rate-limiting.
 */

// 0. Client IP Helper
function get_client_ip(): string {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    // Validate that it's a valid IPv4 or IPv6
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
    }
    return '127.0.0.1';
}

// 1. Emit hardened security headers
function send_security_headers(): void {
    if (headers_sent()) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");

    // HSTS in production with HTTPS / secure connection
    $isSecure = (defined('IS_SECURE_CONN') && IS_SECURE_CONN) || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    if (ENVIRONMENT === 'production' && $isSecure) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
}

// 2. CSRF Protection
function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function csrf_input_field(): string {
    $token = htmlspecialchars(generate_csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

// 3. Sanitization
function sanitize_text(mixed $val, int $maxLength = 5000): string {
    if (!is_string($val)) {
        return '';
    }
    // Remove null bytes and normalise newlines
    $cleaned = str_replace("\0", '', $val);
    $cleaned = trim(htmlspecialchars(strip_tags($cleaned), ENT_QUOTES, 'UTF-8'));
    return mb_substr($cleaned, 0, $maxLength);
}

function sanitize_email(mixed $val, int $maxLength = 254): string {
    if (!is_string($val)) {
        return '';
    }
    $cleaned = str_replace("\0", '', trim($val));
    $clean = filter_var($cleaned, FILTER_SANITIZE_EMAIL);
    if (!is_string($clean)) {
        return '';
    }
    return mb_substr($clean, 0, $maxLength);
}

function sanitize_phone(mixed $val, int $maxLength = 30): string {
    if (!is_string($val)) {
        return '';
    }
    $cleaned = str_replace("\0", '', trim($val));
    $clean = preg_replace('/[^0-9+\s\-().]/', '', $cleaned) ?? '';
    return mb_substr($clean, 0, $maxLength);
}

// 4. Rate Limiting (Session & Persistent IP-based)
function check_ip_rate_limit(string $action, int $maxAttempts = 5, int $decaySeconds = 60, ?string $ip = null): bool {
    $ip = $ip ?? get_client_ip();
    $storageFile = (defined('STORAGE_PATH') ? STORAGE_PATH : dirname(__DIR__) . '/storage') . '/logs/rate_limits.json';
    @mkdir(dirname($storageFile), 0755, true);

    $fp = @fopen($storageFile, 'c+');
    if (!$fp) {
        // Fallback to allowing request if file is inaccessible
        return true;
    }

    $allowed = true;
    if (flock($fp, LOCK_EX)) {
        $filesize = filesize($storageFile);
        $contents = $filesize > 0 ? (string)fread($fp, $filesize) : '';
        $data = json_decode($contents, true);
        if (!is_array($data)) {
            $data = [];
        }

        $now = time();
        $key = "{$action}:{$ip}";

        // Prune expired records across the table (lazy cleanup)
        foreach ($data as $k => $entry) {
            if (isset($entry['expires_at']) && $entry['expires_at'] < $now) {
                unset($data[$k]);
            }
        }

        if (isset($data[$key])) {
            $entry = $data[$key];
            if (($now - $entry['first_attempt']) > $decaySeconds) {
                // Window expired, reset
                $data[$key] = [
                    'count' => 1,
                    'first_attempt' => $now,
                    'expires_at' => $now + $decaySeconds
                ];
            } else {
                if ($entry['count'] >= $maxAttempts) {
                    $allowed = false;
                } else {
                    $data[$key]['count']++;
                    $data[$key]['expires_at'] = $entry['first_attempt'] + $decaySeconds;
                }
            }
        } else {
            $data[$key] = [
                'count' => 1,
                'first_attempt' => $now,
                'expires_at' => $now + $decaySeconds
            ];
        }

        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, (string)json_encode($data, JSON_UNESCAPED_SLASHES));
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    fclose($fp);

    return $allowed;
}

function check_rate_limit(string $action = 'submit', int $maxAttempts = 5, int $decaySeconds = 60, bool $enforceIp = true): bool {
    // 1. Persistent IP check prevents clearing cookies to bypass
    if ($enforceIp && !check_ip_rate_limit($action, $maxAttempts, $decaySeconds)) {
        return false;
    }

    // 2. In-session check
    $currentTime = time();
    $sessionKey = "rate_limit_{$action}";

    if (!isset($_SESSION[$sessionKey]) || !is_array($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = [
            'count' => 1,
            'first_attempt' => $currentTime
        ];
        return true;
    }

    $data = &$_SESSION[$sessionKey];

    // If window expired, reset
    if (($currentTime - (int)($data['first_attempt'] ?? 0)) > $decaySeconds) {
        $data['count'] = 1;
        $data['first_attempt'] = $currentTime;
        return true;
    }

    // Still within window
    if ((int)($data['count'] ?? 0) >= $maxAttempts) {
        return false;
    }

    $data['count'] = (int)($data['count'] ?? 0) + 1;
    return true;
}

// 5. Session Management Helpers
function rotate_session_id(bool $deleteOld = true): bool {
    if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
        return session_regenerate_id($deleteOld);
    }
    return false;
}

function enforce_session_timeout(int $idleTimeout = 1800, int $maxLifetime = 28800): bool {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return false;
    }

    $now = time();
    $created = (int)($_SESSION['session_created_at'] ?? 0);
    $lastActivity = (int)($_SESSION['session_last_activity'] ?? 0);

    // Initialise on first check
    if ($created === 0) {
        $_SESSION['session_created_at'] = $now;
        $_SESSION['session_last_activity'] = $now;
        return true;
    }

    // Check absolute lifetime
    if (($now - $created) > $maxLifetime) {
        return false;
    }

    // Check idle inactivity
    if (($now - $lastActivity) > $idleTimeout) {
        return false;
    }

    $_SESSION['session_last_activity'] = $now;
    return true;
}

// Auto-run security headers
send_security_headers();
