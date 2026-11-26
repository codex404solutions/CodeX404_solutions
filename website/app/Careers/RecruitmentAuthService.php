<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Handles Admin RBAC permission evaluation (MySQL backed) and passwordless Applicant Portal OTP sessions.
 */
final class RecruitmentAuthService
{
    public const APPLICANT_COOKIE = 'codex_applicant_token';

    /**
     * Evaluate whether the given roles & custom overrides allow a permission slug.
     * Supports Super Admin (superadmin/founder/ceo), Recruiter (recruiter/hr), and Viewer (viewer).
     */
    public static function adminRolesHavePermission(array $roles, string $permission, ?array $customPermissions = null): bool
    {
        $normalizedRoles = array_values(array_unique(array_filter(array_map(
            fn($r) => strtolower(trim((string)$r)),
            $roles
        ))));

        if (is_array($customPermissions)) {
            $denied = array_map('strtolower', (array)($customPermissions['denied'] ?? []));
            if (in_array(strtolower($permission), $denied, true)) {
                return false;
            }
            $granted = array_map('strtolower', (array)($customPermissions['granted'] ?? []));
            if (in_array(strtolower($permission), $granted, true)) {
                return true;
            }
        }

        if (empty($normalizedRoles)) {
            return false;
        }

        // Top executive roles always retain superadmin access
        if (array_intersect($normalizedRoles, ['superadmin', 'founder', 'ceo'])) {
            return true;
        }

        try {
            $pdo = CareersDB::pdo();
            $placeholders = implode(',', array_fill(0, count($normalizedRoles), '?'));
            $sql = "
                SELECT COUNT(*)
                FROM `role_permissions` rp
                INNER JOIN `roles` r ON r.id = rp.role_id
                INNER JOIN `permissions` p ON p.id = rp.permission_id
                WHERE LOWER(r.slug) IN ({$placeholders})
                  AND LOWER(p.slug) = ?
            ";
            $stmt = $pdo->prepare($sql);
            $params = array_merge($normalizedRoles, [strtolower(trim($permission))]);
            $stmt->execute($params);
            return (int)$stmt->fetchColumn() > 0;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Strict guard for admin endpoints & POST actions.
     */
    public static function requirePermission(string $permission, bool $jsonResponse = false): void
    {
        if (!function_exists('current_admin_can') || !current_admin_can($permission)) {
            if ($jsonResponse) {
                http_response_code(403);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['ok' => false, 'error' => 'Insufficient permissions (' . $permission . ').']);
                exit;
            }
            if (function_exists('set_admin_flash')) {
                set_admin_flash('error', 'Access Denied: Your role does not include permission "' . $permission . '".');
            }
            http_response_code(403);
            header('Location: ' . admin_url('careers'));
            exit;
        }
    }

    /**
     * List admin / recruiter staff accounts for assignment & RBAC tab.
     * @return array<int, array<string, mixed>>
     */
    public static function listAdminUsers(): array
    {
        $pdo = CareersDB::pdo();
        $rows = $pdo->query("SELECT `id`, `username`, `name`, `email`, `title`, `department`, `role`, `roles`, `status`, `access_scope`, `last_login` FROM `users` ORDER BY `name` ASC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$r) {
            $decoded = !empty($r['roles']) ? json_decode((string)$r['roles'], true) : [];
            $r['roles_list'] = is_array($decoded) && !empty($decoded) ? $decoded : [$r['role']];
        }
        return $rows;
    }

    /**
     * Update a staff user's primary recruitment role (`superadmin`, `recruiter`, or `viewer`) while keeping access_scope valid.
     */
    public static function assignRecruitmentRole(string $userId, string $roleSlug, string $actorName): void
    {
        $allowed = ['superadmin', 'recruiter', 'viewer', 'hr'];
        $cleanRole = strtolower(trim($roleSlug));
        if (!in_array($cleanRole, $allowed, true)) {
            throw new \InvalidArgumentException('Unsupported recruitment role.');
        }

        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("SELECT `id`, `roles`, `access_scope` FROM `users` WHERE `id` = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new \RuntimeException('Staff user not found.');
        }

        $existingRoles = !empty($user['roles']) ? json_decode((string)$user['roles'], true) : [];
        if (!is_array($existingRoles)) {
            $existingRoles = [];
        }
        // Replace recruitment-tier roles so privilege downgrade works deterministically
        $filtered = array_values(array_filter(
            $existingRoles,
            fn($r) => !in_array(strtolower((string)$r), ['superadmin', 'recruiter', 'hr', 'viewer'], true)
        ));
        array_unshift($filtered, $cleanRole);
        $filtered = array_values(array_unique($filtered));

        $newScope = $user['access_scope'] === 'crm_only' ? 'both' : $user['access_scope'];
        $upd = $pdo->prepare("UPDATE `users` SET `role` = ?, `roles` = ?, `access_scope` = ? WHERE `id` = ?");
        $upd->execute([$cleanRole, json_encode($filtered), $newScope, $userId]);

        // Keep user_roles pivot synced when role exists
        $rStmt = $pdo->prepare("SELECT `id` FROM `roles` WHERE LOWER(`slug`) = ? LIMIT 1");
        $rStmt->execute([$cleanRole]);
        $roleId = $rStmt->fetchColumn();
        if ($roleId) {
            $pdo->prepare("DELETE FROM `user_roles` WHERE `user_id` = ? AND `role_id` IN ('role_superadmin','role_recruiter','role_hr','role_viewer')")->execute([$userId]);
            $pdo->prepare("INSERT IGNORE INTO `user_roles` (`user_id`, `role_id`) VALUES (?, ?)")->execute([$userId, $roleId]);
        }

        ActivityLogService::log('admin', $userId, $actorName, 'rbac.role_updated', 'user', $userId, "Assigned recruitment role '{$cleanRole}' to user {$userId}");
    }

    /**
     * Issue a single-use, time-limited 6-digit OTP for Applicant Portal email verification.
     * Plain OTP is sent by email (or returned only in explicit internal test harness) and NEVER stored in DB or logs.
     */
    public static function requestApplicantOtp(string $email, string $purpose = 'login'): array
    {
        $cleanEmail = strtolower(trim($email));
        if (!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Please enter a valid email address.');
        }

        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("SELECT `id`, `full_name`, `email`, `status_flag` FROM `candidate_profiles` WHERE LOWER(`email`) = ? LIMIT 1");
        $stmt->execute([$cleanEmail]);
        $candidate = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$candidate) {
            // Generic message avoids enumerating which candidate emails exist in database
            return [
                'dispatched' => false,
                'generic_message' => 'If an application matches this email address, a 6-digit verification code has been sent.',
            ];
        }

        $cooldown = max(15, RecruitmentSettingsService::getInt('otp_resend_cooldown_seconds', 60));
        $recentStmt = $pdo->prepare("
            SELECT `created_at` FROM `applicant_otp_verifications`
            WHERE LOWER(`email`) = ? AND `purpose` = ?
            ORDER BY `id` DESC LIMIT 1
        ");
        $recentStmt->execute([$cleanEmail, $purpose]);
        $lastSent = $recentStmt->fetchColumn();
        if ($lastSent) {
            $elapsed = time() - strtotime((string)$lastSent);
            if ($elapsed < $cooldown) {
                $wait = $cooldown - $elapsed;
                throw new \RuntimeException("Please wait {$wait} seconds before requesting another verification code.");
            }
        }

        // Invalidate previous unconsumed codes for this email
        $pdo->prepare("UPDATE `applicant_otp_verifications` SET `consumed_at` = NOW() WHERE LOWER(`email`) = ? AND `consumed_at` IS NULL")
            ->execute([$cleanEmail]);

        $otpCode = (string)random_int(100000, 999999);
        $otpHash = password_hash($otpCode, PASSWORD_DEFAULT);
        $ttlMin = max(5, RecruitmentSettingsService::getInt('otp_expiry_minutes', 10));

        $ins = $pdo->prepare("
            INSERT INTO `applicant_otp_verifications` (`email`, `otp_hash`, `purpose`, `attempt_count`, `max_attempts`, `expires_at`, `ip_hash`)
            VALUES (?, ?, ?, 0, 5, DATE_ADD(NOW(), INTERVAL ? MINUTE), ?)
        ");
        $ins->execute([$cleanEmail, $otpHash, $purpose, $ttlMin, CareersDB::hashIp()]);

        RecruitmentEmailService::sendTemplate(
            'applicant_portal_otp',
            $cleanEmail,
            (string)$candidate['full_name'],
            [
                'candidate_name' => (string)$candidate['full_name'],
                'otp_code'       => $otpCode,
                'portal_url'     => url('careers/candidate-portal'),
            ],
            null,
            (int)$candidate['id'],
            'system'
        );

        ActivityLogService::log('applicant', (string)$candidate['id'], (string)$candidate['full_name'], 'portal.otp_requested', 'candidate', (string)$candidate['id'], 'Issued OTP verification for applicant portal access');

        return [
            'dispatched' => true,
            'candidate_id' => (int)$candidate['id'],
            'expires_minutes' => $ttlMin,
            'generic_message' => 'If an application matches this email address, a 6-digit verification code has been sent.',
            'dev_otp' => (defined('ENVIRONMENT') && ENVIRONMENT === 'local' && defined('CODEX_TEST_RETURN_OTP') && CODEX_TEST_RETURN_OTP === true) ? $otpCode : null,
        ];
    }

    /**
     * Verify OTP, enforce attempt lock, consume OTP, and establish signed Applicant Portal session.
     * @return array<string, mixed> Authenticated candidate + account row
     */
    public static function verifyApplicantOtp(string $email, string $otpCode): array
    {
        $cleanEmail = strtolower(trim($email));
        $cleanOtp = preg_replace('/\D+/', '', trim($otpCode));
        if (!filter_var($cleanEmail, FILTER_VALIDATE_EMAIL) || strlen($cleanOtp) !== 6) {
            throw new \InvalidArgumentException('Please enter a valid email address and 6-digit verification code.');
        }

        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            SELECT * FROM `applicant_otp_verifications`
            WHERE LOWER(`email`) = ? AND `consumed_at` IS NULL AND `expires_at` >= NOW()
            ORDER BY `id` DESC LIMIT 1
        ");
        $stmt->execute([$cleanEmail]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            throw new \RuntimeException('Verification code is invalid or has expired. Please request a new code.');
        }

        if ((int)$row['attempt_count'] >= (int)$row['max_attempts']) {
            $pdo->prepare("UPDATE `applicant_otp_verifications` SET `consumed_at` = NOW() WHERE `id` = ?")->execute([$row['id']]);
            throw new \RuntimeException('Maximum verification attempts exceeded. Please request a new code.');
        }

        if (!password_verify($cleanOtp, (string)$row['otp_hash'])) {
            $pdo->prepare("UPDATE `applicant_otp_verifications` SET `attempt_count` = `attempt_count` + 1 WHERE `id` = ?")->execute([$row['id']]);
            throw new \RuntimeException('Incorrect verification code. Please check your inbox and try again.');
        }

        // Mark OTP consumed atomically
        $pdo->prepare("UPDATE `applicant_otp_verifications` SET `consumed_at` = NOW() WHERE `id` = ?")->execute([$row['id']]);

        // Load candidate profile & upsert applicant account
        $cStmt = $pdo->prepare("SELECT * FROM `candidate_profiles` WHERE LOWER(`email`) = ? LIMIT 1");
        $cStmt->execute([$cleanEmail]);
        $candidate = $cStmt->fetch(PDO::FETCH_ASSOC);
        if (!$candidate) {
            throw new \RuntimeException('No candidate profile found for this email.');
        }

        $accStmt = $pdo->prepare("SELECT * FROM `applicant_accounts` WHERE `candidate_id` = ? LIMIT 1");
        $accStmt->execute([$candidate['id']]);
        $account = $accStmt->fetch(PDO::FETCH_ASSOC);

        if (!$account) {
            $insAcc = $pdo->prepare("INSERT INTO `applicant_accounts` (`candidate_id`, `email`, `status`, `last_login_at`, `last_login_ip_hash`) VALUES (?, ?, 'active', NOW(), ?)");
            $insAcc->execute([$candidate['id'], $cleanEmail, CareersDB::hashIp()]);
            $accountId = (int)$pdo->lastInsertId();
        } else {
            if (($account['status'] ?? 'active') === 'locked') {
                throw new \RuntimeException('This applicant portal account is temporarily locked. Please contact recruitment support.');
            }
            $accountId = (int)$account['id'];
            $pdo->prepare("UPDATE `applicant_accounts` SET `last_login_at` = NOW(), `last_login_ip_hash` = ? WHERE `id` = ?")
                ->execute([CareersDB::hashIp(), $accountId]);
        }

        // Generate cryptographically random session token stored hashed in DB
        $rawToken = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $rawToken);
        $sessionHours = max(1, RecruitmentSettingsService::getInt('applicant_session_hours', 12));

        $pdo->prepare("
            INSERT INTO `applicant_sessions` (`applicant_account_id`, `token_hash`, `ip_hash`, `user_agent_hash`, `expires_at`)
            VALUES (?, ?, ?, ?, DATE_ADD(NOW(), INTERVAL ? HOUR))
        ")->execute([
            $accountId,
            $tokenHash,
            CareersDB::hashIp(),
            hash('sha256', substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255)),
            $sessionHours,
        ]);

        if (session_status() === PHP_SESSION_ACTIVE) {
            if (!headers_sent()) {
                session_regenerate_id(true);
            }
            $_SESSION['codex_applicant_token'] = $rawToken;
            $_SESSION['codex_applicant_candidate_id'] = (int)$candidate['id'];
        }

        if (!headers_sent()) {
            $isSecure = (defined('IS_SECURE_CONN') && IS_SECURE_CONN)
                || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            setcookie(self::APPLICANT_COOKIE, $rawToken, [
                'expires'  => time() + ($sessionHours * 3600),
                'path'     => '/',
                'secure'   => $isSecure,
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }

        ActivityLogService::log('applicant', (string)$candidate['id'], (string)$candidate['full_name'], 'portal.login', 'candidate', (string)$candidate['id'], 'Authenticated to Applicant Portal via Email OTP');

        return [
            'candidate' => $candidate,
            'account_id' => $accountId,
            'token' => $rawToken,
        ];
    }

    /**
     * Resolve currently authenticated Applicant Portal candidate or return null.
     * @return array<string, mixed>|null
     */
    public static function currentApplicant(?string $overrideToken = null): ?array
    {
        $rawToken = $overrideToken
            ?? ($_SESSION['codex_applicant_token'] ?? null)
            ?? ($_COOKIE[self::APPLICANT_COOKIE] ?? null);

        if (!is_string($rawToken) || strlen($rawToken) < 32) {
            return null;
        }

        $tokenHash = hash('sha256', $rawToken);
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            SELECT cp.*, aa.id AS account_id, aa.status AS account_status, s.id AS session_id
            FROM `applicant_sessions` s
            INNER JOIN `applicant_accounts` aa ON aa.id = s.applicant_account_id
            INNER JOIN `candidate_profiles` cp ON cp.id = aa.candidate_id
            WHERE s.token_hash = ? AND s.revoked_at IS NULL AND s.expires_at >= NOW() AND aa.status != 'locked'
            LIMIT 1
        ");
        $stmt->execute([$tokenHash]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $pdo->prepare("UPDATE `applicant_sessions` SET `last_seen_at` = NOW() WHERE `id` = ?")->execute([$row['session_id']]);
        return $row;
    }

    public static function requireApplicantAuth(): array
    {
        $applicant = self::currentApplicant();
        if (!$applicant) {
            header('Location: ' . url('careers/application-status'));
            exit;
        }
        return $applicant;
    }

    public static function logoutApplicant(): void
    {
        $rawToken = ($_SESSION['codex_applicant_token'] ?? null)
            ?? ($_COOKIE[self::APPLICANT_COOKIE] ?? null);

        if (is_string($rawToken) && strlen($rawToken) >= 32) {
            $pdo = CareersDB::pdo();
            $pdo->prepare("UPDATE `applicant_sessions` SET `revoked_at` = NOW() WHERE `token_hash` = ?")
                ->execute([hash('sha256', $rawToken)]);
        }

        unset($_SESSION['codex_applicant_token'], $_SESSION['codex_applicant_candidate_id']);
        if (!headers_sent()) {
            setcookie(self::APPLICANT_COOKIE, '', [
                'expires'  => time() - 3600,
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }
    }
}
