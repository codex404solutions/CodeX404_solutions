<?php
declare(strict_types=1);

namespace CRM\Services;

/** Small security helpers for session-protected CRM pages. */
class CrmSecurity
{
    public static function csrfToken(): string
    {
        if (empty($_SESSION['crm_csrf'])) {
            $_SESSION['crm_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['crm_csrf'];
    }

    public static function verifyCsrf(?string $token): bool
    {
        return is_string($token)
            && isset($_SESSION['crm_csrf'])
            && hash_equals($_SESSION['crm_csrf'], $token);
    }

    public static function escape(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
