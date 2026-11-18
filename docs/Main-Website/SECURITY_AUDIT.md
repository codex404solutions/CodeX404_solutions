# CodeX404 Solutions — Application Security Audit (Corrected)

**Document:** SECURITY_AUDIT.md  
**Project:** CodeX404 Solutions Main Website Redesign  
**Audit Date:** 2026-11-18  
**Verification Method:** Direct inspection of source files (`website/includes/security.php`, `website/app/Controllers/ContactController.php`, `website/app/Helpers/Sanitizer.php`, `website/app/Validators/FormValidator.php`).  

**Implementation update (2026-11-19):** Public contact and discovery forms now require an explicit valid division and privacy consent. Local persistence failure produces an error state; notification logs omit email addresses and the email service no longer reports local or failed mail transport as sent. Production CRM, mail, database, and hosting controls remain unverified.

---

## 1. Verified Source Implementations in `website/includes/security.php`

Direct source code inspection confirms the following functions and mechanisms exist in `website/includes/security.php`:

### 1.1 CSRF Protection
- **Token Generation:** `generate_csrf_token(): string` generates a 32-byte cryptographically secure token via `random_bytes(32)`, stored in `$_SESSION['csrf_token']`.
- **Token Verification:** `verify_csrf_token(?string $token): bool` (line 46) uses `hash_equals($_SESSION['csrf_token'], $token)` for timing-attack-safe comparison.
- **Form Helper:** `csrf_input_field(): string` returns an escaped hidden `<input name="csrf_token">` element.
- *Correction Note:* An earlier draft referenced `csrf_validate()`; the actual declared function in code is `verify_csrf_token()`.

### 1.2 HTTP Security Headers
- `send_security_headers(): void` (line 20) emits the following headers if `!headers_sent()`:
  - `X-Content-Type-Options: nosniff`
  - `X-Frame-Options: SAMEORIGIN`
  - `X-XSS-Protection: 1; mode=block`
  - `Referrer-Policy: strict-origin-when-cross-origin`
  - `Permissions-Policy: geolocation=(), microphone=(), camera=()`
  - `Strict-Transport-Security` (only when `ENVIRONMENT === 'production'` and HTTPS is detected).
- **Scope Note:** `send_security_headers()` is invoked at line 232 of `security.php`. It applies to all PHP endpoints that include `website/includes/header.php` or `website/includes/security.php`. It does NOT apply to static files served directly by the web server (images, CSS, JS) unless configured in web server config / `.htaccess`.

### 1.3 Input Sanitization
- `sanitize_text(mixed $val, int $maxLength = 5000): string` — Strips null bytes, HTML tags via `strip_tags()`, escapes via `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`, and truncates via `mb_substr()`.
- `sanitize_email(mixed $val, int $maxLength = 254): string` — Strips null bytes and validates/sanitizes using `filter_var(..., FILTER_SANITIZE_EMAIL)`.
- `sanitize_phone(mixed $val, int $maxLength = 30): string` — Strips characters outside `0-9+\s\-().`.

### 1.4 Rate Limiting
- `check_ip_rate_limit(string $action, int $maxAttempts = 5, int $decaySeconds = 60, ?string $ip = null): bool` — Persistent file-locked JSON rate limiter in `storage/logs/rate_limits.json`. If file lock fails, it defaults to allowing the request.

---

## 2. Unverified Items (Not Checked / Unknown)

1. **Production Hosting Environment:**
   - Production web server (Apache, Nginx, or LiteSpeed) configuration is unknown and not verified in this repository.
   - SSL/TLS cipher suites and server-level WAF/DDoS protections are external and unverified.
2. **Database Server State:**
   - On the local machine, `httpd` is active, but the `mysqld` service is not running. Live MySQL injection hardening cannot be dynamically tested against a running database daemon at this time.
3. **Session Cookie Directives:**
   - `website/includes/config.php` sets session cookie parameters before `session_start()` (`secure` based on HTTPS detection, `httponly`, and `SameSite=Lax`). Production proxy/header behavior must still be verified in the hosting environment.
