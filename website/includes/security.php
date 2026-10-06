<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Security & Protection Module
 * Hardened HTTP headers, CSRF validation, sanitization, and rate-limiting.
 */

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

    // HSTS only in production with HTTPS
    if (ENVIRONMENT === 'production' && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
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
function sanitize_text(mixed $val): string {
    if (!is_string($val)) {
        return '';
    }
    return trim(htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8'));
}

function sanitize_email(mixed $val): string {
    if (!is_string($val)) {
        return '';
    }
    $clean = filter_var(trim($val), FILTER_SANITIZE_EMAIL);
    return is_string($clean) ? $clean : '';
}

// 4. Rate Limiting (Session & IP based)
function check_rate_limit(string $action = 'submit', int $maxAttempts = 5, int $decaySeconds = 60): bool {
    $currentTime = time();
    $sessionKey = "rate_limit_{$action}";

    if (!isset($_SESSION[$sessionKey])) {
        $_SESSION[$sessionKey] = [
            'count' => 1,
            'first_attempt' => $currentTime
        ];
        return true;
    }

    $data = &$_SESSION[$sessionKey];

    // If window expired, reset
    if (($currentTime - $data['first_attempt']) > $decaySeconds) {
        $data['count'] = 1;
        $data['first_attempt'] = $currentTime;
        return true;
    }

    // Still within window
    if ($data['count'] >= $maxAttempts) {
        return false;
    }

    $data['count']++;
    return true;
}

// Auto-run security headers
send_security_headers();
