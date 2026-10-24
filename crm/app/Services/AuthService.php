<?php
declare(strict_types=1);

namespace CRM\Services;

use CRMEnv;

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once __DIR__ . '/StorageService.php';
require_once __DIR__ . '/UserService.php';
require_once __DIR__ . '/RBACService.php';

/**
 * AuthService
 * Secure session authentication, multi-role profiling resolution,
 * and granular permission enforcement.
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
        $users = UserService::getAll();
        if (!empty($users)) {
            return true;
        }

        $email = CRMEnv::get('CRM_ADMIN_EMAIL', '');
        $hash = CRMEnv::get('CRM_ADMIN_PASSWORD_HASH', '');
        return $email !== '' && $hash !== '' && password_get_info($hash)['algo'] !== null;
    }

    /**
     * Authenticate an inbound credential against UserService and fallback to .env.
     */
    public static function attempt(string $identifier, string $password, ?string &$errorReason = null): bool
    {
        $cleanId = strtolower(trim($identifier));
        if ($cleanId === '') {
            return false;
        }

        // 1. Primary: Authenticate through UserService
        $user = UserService::getByUsernameOrEmail($cleanId);

        if ($user !== null) {
            // Check status
            if (($user['status'] ?? 'active') !== 'active') {
                $errorReason = 'Your workforce account is inactive or suspended. Please contact HR.';
                return false;
            }

            // Verify password
            if (!empty($user['password_hash']) && password_verify($password, $user['password_hash'])) {
                // Portal Access Scope Enforcement
                $scope = $user['access_scope'] ?? 'crm_only';
                if ($scope === 'admin_only') {
                    $errorReason = "Access Restricted: Your account is provisioned for Website Admin Portal access only. Contact your executive administrator for CRM clearance.";
                    return false;
                }

                if (!headers_sent() && session_status() === PHP_SESSION_ACTIVE) {
                    session_regenerate_id(true);
                }

                $_SESSION['crm_user'] = self::formatSessionUser($user);
                UserService::recordLogin($user['id']);
                return true;
            }
        }

        // 2. Fallback: Authenticate against .env admin credentials if matching
        $configuredEmail = CRMEnv::get('CRM_ADMIN_EMAIL', '');
        $hash = CRMEnv::get('CRM_ADMIN_PASSWORD_HASH', '');

        if ($configuredEmail !== '' && $hash !== '') {
            $isMatch = hash_equals(strtolower($configuredEmail), $cleanId) || $cleanId === 'admin';
            if ($isMatch && password_verify($password, $hash)) {
                // Ensure default user account exists
                UserService::seedDefaultUsersIfEmpty();
                $seededAdmin = UserService::getByUsernameOrEmail('admin');

                if (!headers_sent() && session_status() === PHP_SESSION_ACTIVE) {
                    session_regenerate_id(true);
                }

                if ($seededAdmin) {
                    $_SESSION['crm_user'] = self::formatSessionUser($seededAdmin);
                    UserService::recordLogin($seededAdmin['id']);
                } else {
                    $_SESSION['crm_user'] = [
                        'id' => 'usr_admin_alex',
                        'name' => CRMEnv::get('CRM_ADMIN_NAME', 'CodeX404 Admin'),
                        'username' => 'admin',
                        'email' => $configuredEmail,
                        'phone' => '+1 (415) 555-0140',
                        'title' => 'Chief Executive Officer & Founder',
                        'department' => 'Executive Leadership',
                        'bio' => 'Founder & Principal Systems Architect at CodeX404 Solutions.',
                        'avatar' => '',
                        'roles' => ['superadmin', 'founder', 'ceo', 'cto'],
                        'access_scope' => 'both',
                        'approval_status' => 'approved',
                        'authority_tier' => 1,
                        'custom_permissions' => ['granted' => [], 'denied' => []],
                        'status' => 'active',
                        'timezone' => 'America/New_York',
                        'currency' => 'USD',
                        'logged_in_at' => time()
                    ];
                }
                return true;
            }
        }

        return false;
    }

    /**
     * Format a complete user record into an authenticated session structure.
     */
    private static function formatSessionUser(array $user): array
    {
        $roles = (array)($user['roles'] ?? ['viewer']);
        return [
            'id' => $user['id'] ?? 'usr_' . bin2hex(random_bytes(6)),
            'name' => $user['name'] ?? 'Team Member',
            'username' => $user['username'] ?? 'user',
            'email' => $user['email'] ?? '',
            'phone' => $user['phone'] ?? '',
            'title' => $user['title'] ?? 'Staff',
            'department' => $user['department'] ?? 'Operations',
            'bio' => $user['bio'] ?? '',
            'avatar' => $user['avatar'] ?? '',
            'roles' => $roles,
            'access_scope' => $user['access_scope'] ?? 'crm_only',
            'approval_status' => $user['approval_status'] ?? 'approved',
            'authority_tier' => RBACService::getAuthorityTier($roles),
            'custom_permissions' => (array)($user['custom_permissions'] ?? ['granted' => [], 'denied' => []]),
            'status' => $user['status'] ?? 'active',
            'timezone' => $user['timezone'] ?? 'UTC',
            'currency' => $user['currency'] ?? 'USD',
            'logged_in_at' => time()
        ];
    }

    /**
     * Retrieve currently logged in user profile.
     */
    public static function user(): ?array
    {
        if (isset($_SESSION['crm_user']) && is_array($_SESSION['crm_user'])) {
            if (($_SESSION['crm_user']['access_scope'] ?? 'crm_only') === 'admin_only') {
                self::logout();
                return null;
            }
            return $_SESSION['crm_user'];
        }
        return null;
    }

    /**
     * Check if currently logged in user has a specific permission.
     */
    public static function can(string $permission): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        return RBACService::hasPermission(
            (array)($user['roles'] ?? []),
            $permission,
            (array)($user['custom_permissions'] ?? null)
        );
    }

    /**
     * Check if currently logged in user holds a specific role.
     */
    public static function hasRole(string $role): bool
    {
        $user = self::user();
        if (!$user) {
            return false;
        }

        $roles = array_map('strtolower', (array)($user['roles'] ?? []));
        return in_array(strtolower(trim($role)), $roles, true);
    }

    /**
     * Refresh the active session profile with latest database/storage values.
     */
    public static function refreshSessionUser(): void
    {
        $current = self::user();
        if (!$current || empty($current['id'])) {
            return;
        }

        $fresh = UserService::getById($current['id']);
        if ($fresh) {
            $_SESSION['crm_user'] = self::formatSessionUser($fresh);
        }
    }

    /**
     * Terminate user session.
     */
    public static function logout(): void
    {
        unset($_SESSION['crm_user']);
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}
