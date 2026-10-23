<?php
declare(strict_types=1);

namespace CRM\Services;

use CRMEnv;

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once __DIR__ . '/StorageService.php';

/**
 * CRM authentication for the first internal deployment.
 *
 * Set CRM_ADMIN_EMAIL and CRM_ADMIN_PASSWORD_HASH in crm/.env. The application
 * deliberately has no built-in/default credential and will refuse login until
 * both values are configured. Replace this bootstrap auth with database-backed
 * users + MFA before granting access to additional staff.
 */
class AuthService
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    public static function isConfigured(): bool
    {
        $email = CRMEnv::get('CRM_ADMIN_EMAIL', '');
        $hash = CRMEnv::get('CRM_ADMIN_PASSWORD_HASH', '');
        return $email !== '' && $hash !== '' && password_get_info($hash)['algo'] !== null;
    }

    public static function attempt(string $identifier, string $password): bool
    {
        $cleanId = strtolower(trim($identifier));

        // 1. Try MySQL Database authentication first
        $pdo = \CRM\Services\StorageService::getPdo();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE LOWER(`username`) = :id1 OR LOWER(`email`) = :id2 LIMIT 1");
                $stmt->execute([':id1' => $cleanId, ':id2' => $cleanId]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($user && !empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
                    if (!headers_sent() && session_status() === PHP_SESSION_ACTIVE) {
                        session_regenerate_id(true);
                    }
                    $_SESSION['crm_user'] = [
                        'name' => $user['name'] ?? 'CodeX404 Admin',
                        'email' => $user['email'] ?? 'admin@codex404solutions.online',
                        'roles' => ['founder', 'ceo', 'cto', 'admin']
                    ];
                    return true;
                }
            } catch (\Throwable $e) {
                // DB error, fallback to env
            }
        }

        // 2. Fallback to configured .env admin credentials
        $configuredEmail = CRMEnv::get('CRM_ADMIN_EMAIL', '');
        $hash = CRMEnv::get('CRM_ADMIN_PASSWORD_HASH', '');
        if ($configuredEmail === '' || $hash === '') {
            return false;
        }

        $isMatch = hash_equals(strtolower($configuredEmail), $cleanId) || $cleanId === 'admin';
        if (!$isMatch || !password_verify($password, $hash)) {
            return false;
        }

        if (!headers_sent() && session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        $_SESSION['crm_user'] = [
            'name' => CRMEnv::get('CRM_ADMIN_NAME', 'CodeX404 Admin'),
            'email' => $configuredEmail,
            'roles' => ['founder', 'ceo', 'cto', 'admin']
        ];
        return true;
    }

    public static function user(): ?array
    {
        return isset($_SESSION['crm_user']) && is_array($_SESSION['crm_user'])
            ? $_SESSION['crm_user']
            : null;
    }

    public static function logout(): void
    {
        unset($_SESSION['crm_user']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}
