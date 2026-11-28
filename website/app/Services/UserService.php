<?php
declare(strict_types=1);

namespace App\Services;

use Database;
use Env;
use PDO;

/**
 * MySQL-backed Workforce User & Profile Service.
 * Manages staff accounts, multi-role assignments, portal access scopes, and avatars.
 */
final class UserService
{
    private const ALLOWED_SCOPES = ['both', 'admin_only', 'crm_only'];
    private const ALLOWED_STATUSES = ['active', 'inactive', 'suspended'];

    /**
     * Return all workforce users ordered by authority tier then name.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getAll(): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return [];
        }

        $stmt = $pdo->query('SELECT * FROM `users` ORDER BY `authority_tier` ASC, `name` ASC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([self::class, 'hydrateUser'], $rows);
    }

    /**
     * Fetch a single user by primary ID.
     *
     * @return array<string, mixed>|null
     */
    public static function getById(string $id): ?array
    {
        $cleanId = trim($id);
        if ($cleanId === '') {
            return null;
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return null;
        }

        $stmt = $pdo->prepare('SELECT * FROM `users` WHERE `id` = ? LIMIT 1');
        $stmt->execute([$cleanId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? self::hydrateUser($row) : null;
    }

    /**
     * Fetch a single user by username or email (case-insensitive).
     *
     * @return array<string, mixed>|null
     */
    public static function getByUsernameOrEmail(string $identifier): ?array
    {
        $clean = strtolower(trim($identifier));
        if ($clean === '') {
            return null;
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return null;
        }

        $stmt = $pdo->prepare('SELECT * FROM `users` WHERE LOWER(`username`) = ? OR LOWER(`email`) = ? LIMIT 1');
        $stmt->execute([$clean, $clean]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? self::hydrateUser($row) : null;
    }

    /**
     * Provision a new workforce user with hashed password and synced roles.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed>|null $actor
     * @return array<string, mixed>
     */
    public static function create(array $data, ?array $actor = null): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            throw new \RuntimeException('Database connection unavailable.');
        }

        $name = trim((string) ($data['name'] ?? ''));
        $username = strtolower(trim((string) ($data['username'] ?? '')));
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $password = (string) ($data['password'] ?? '');

        if ($name === '' || $username === '' || $email === '') {
            throw new \InvalidArgumentException('Name, username, and email are required.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Please provide a valid email address.');
        }
        self::assertStrongPassword($password);

        $roles = self::normalizeRoles((array) ($data['roles'] ?? ['viewer']));
        $scope = self::normalizeScope((string) ($data['access_scope'] ?? 'crm_only'));
        $status = self::normalizeStatus((string) ($data['status'] ?? 'active'));
        $targetTier = RBACService::getAuthorityTier($roles);

        $requiresApproval = false;
        if ($actor !== null) {
            $actorTier = RBACService::getAuthorityTier((array) ($actor['roles'] ?? []));
            if ($actorTier >= 3) {
                throw new \RuntimeException('Insufficient authority tier to provision user accounts.');
            }
            if ($actorTier > 1 && ($targetTier === 1 || $scope === 'both')) {
                $requiresApproval = true;
            }
        }

        $dup = $pdo->prepare('SELECT `id` FROM `users` WHERE LOWER(`username`) = ? OR LOWER(`email`) = ? LIMIT 1');
        $dup->execute([$username, $email]);
        if ($dup->fetchColumn()) {
            throw new \InvalidArgumentException('A user with that username or email already exists.');
        }

        $id = 'usr_' . bin2hex(random_bytes(8));
        $primaryRole = $roles[0] ?? 'viewer';
        $customPerms = self::normalizeCustomPermissions($data['custom_permissions'] ?? null);
        $approvalStatus = $requiresApproval ? 'pending' : 'approved';

        $pdo->beginTransaction();
        try {
            $sql = '
                INSERT INTO `users` (
                    `id`, `username`, `email`, `password_hash`, `name`, `phone`, `title`, `department`,
                    `bio`, `role`, `roles`, `status`, `access_scope`, `authority_tier`,
                    `custom_permissions`, `approval_status`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $id,
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $name,
                trim((string) ($data['phone'] ?? '')) ?: null,
                trim((string) ($data['title'] ?? 'Staff Member')),
                trim((string) ($data['department'] ?? 'Operations')),
                trim((string) ($data['bio'] ?? '')) ?: null,
                $primaryRole,
                json_encode($roles),
                $status,
                $scope,
                $targetTier,
                json_encode($customPerms),
                $approvalStatus,
            ]);

            self::syncUserRolesPivot($pdo, $id, $roles);
            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }

        $created = self::getById($id) ?? [];
        if ($requiresApproval) {
            $created['approval_required'] = true;
        }
        return $created;
    }

    /**
     * Update an existing user's profile, roles, scope, or custom permissions.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed>|null $actor
     * @return array<string, mixed>|false
     */
    public static function update(string $id, array $data, ?array $actor = null): array|false
    {
        $existing = self::getById($id);
        if (!$existing) {
            return false;
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            throw new \RuntimeException('Database connection unavailable.');
        }

        $roles = isset($data['roles']) ? self::normalizeRoles((array) $data['roles']) : (array) $existing['roles'];
        $scope = isset($data['access_scope'])
            ? self::normalizeScope((string) $data['access_scope'])
            : (string) ($existing['access_scope'] ?? 'crm_only');
        $status = isset($data['status'])
            ? self::normalizeStatus((string) $data['status'])
            : (string) ($existing['status'] ?? 'active');

        $targetTier = RBACService::getAuthorityTier($roles);
        $existingTier = (int) ($existing['authority_tier'] ?? RBACService::getAuthorityTier((array) $existing['roles']));

        // Enforce actor authority boundaries when modifying roles or clearance
        $requiresApproval = false;
        if ($actor !== null) {
            $actorTier = RBACService::getAuthorityTier((array) ($actor['roles'] ?? []));
            $isPrivilegeChange = ($roles !== $existing['roles']) || ($scope !== ($existing['access_scope'] ?? 'crm_only'));
            if ($isPrivilegeChange && $actorTier >= 3) {
                throw new \RuntimeException('Insufficient authority tier to modify roles or portal clearance.');
            }
            if ($actorTier > 1 && $existingTier === 1) {
                throw new \RuntimeException('Only Tier 1 executives can modify Supreme Authority accounts.');
            }
            if ($actorTier > 1 && ($targetTier === 1 || $scope === 'both') && $isPrivilegeChange) {
                $requiresApproval = true;
            }
        }

        $username = isset($data['username']) ? strtolower(trim((string) $data['username'])) : (string) $existing['username'];
        $email = isset($data['email']) ? strtolower(trim((string) $data['email'])) : (string) $existing['email'];

        if ($username === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Valid username and email are required.');
        }

        $dup = $pdo->prepare('SELECT `id` FROM `users` WHERE (LOWER(`username`) = ? OR LOWER(`email`) = ?) AND `id` != ? LIMIT 1');
        $dup->execute([$username, $email, $id]);
        if ($dup->fetchColumn()) {
            throw new \InvalidArgumentException('Another account already uses that username or email.');
        }

        $customPerms = array_key_exists('custom_permissions', $data)
            ? self::normalizeCustomPermissions($data['custom_permissions'])
            : ($existing['custom_permissions'] ?? ['granted' => [], 'denied' => []]);

        // If non-Tier-1 triggers an approval-required elevation, store pending_payload without applying elevated roles yet
        if ($requiresApproval) {
            $pendingPayload = [
                'roles' => $roles,
                'access_scope' => $scope,
                'requested_by' => $actor['id'] ?? '',
                'requested_at' => date('c'),
            ];
            $stmt = $pdo->prepare('UPDATE `users` SET `approval_status` = ?, `pending_payload` = ? WHERE `id` = ?');
            $stmt->execute(['pending', json_encode($pendingPayload), $id]);
            return [
                'approval_required' => true,
                'user' => self::getById($id),
            ];
        }

        $pdo->beginTransaction();
        try {
            $sql = '
                UPDATE `users` SET
                    `name` = ?,
                    `username` = ?,
                    `email` = ?,
                    `phone` = ?,
                    `title` = ?,
                    `department` = ?,
                    `bio` = ?,
                    `timezone` = ?,
                    `currency` = ?,
                    `status` = ?,
                    `access_scope` = ?,
                    `role` = ?,
                    `roles` = ?,
                    `authority_tier` = ?,
                    `custom_permissions` = ?,
                    `avatar` = ?
                WHERE `id` = ?
            ';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                trim((string) ($data['name'] ?? $existing['name'])),
                $username,
                $email,
                array_key_exists('phone', $data) ? (trim((string) $data['phone']) ?: null) : ($existing['phone'] ?? null),
                trim((string) ($data['title'] ?? $existing['title'] ?? 'Staff Member')),
                trim((string) ($data['department'] ?? $existing['department'] ?? 'Operations')),
                array_key_exists('bio', $data) ? (trim((string) $data['bio']) ?: null) : ($existing['bio'] ?? null),
                trim((string) ($data['timezone'] ?? $existing['timezone'] ?? 'UTC')),
                trim((string) ($data['currency'] ?? $existing['currency'] ?? 'USD')),
                $status,
                $scope,
                $roles[0] ?? 'viewer',
                json_encode($roles),
                $targetTier,
                json_encode($customPerms),
                array_key_exists('avatar', $data) ? (trim((string) $data['avatar']) ?: null) : ($existing['avatar'] ?? null),
                $id,
            ]);

            self::syncUserRolesPivot($pdo, $id, $roles);
            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }

        return self::getById($id) ?? false;
    }

    /**
     * Update a user's password hash.
     */
    public static function updatePassword(string $id, string $newPassword): bool
    {
        self::assertStrongPassword($newPassword);

        $pdo = Database::getConnection();
        if (!$pdo) {
            return false;
        }

        $stmt = $pdo->prepare('UPDATE `users` SET `password_hash` = ? WHERE `id` = ?');
        $stmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Approve a pending privilege/scope elevation request (Tier 1 executive only).
     *
     * @param array<string, mixed> $actor
     * @return array<string, mixed>
     */
    public static function approvePendingElevation(string $id, array $actor): array
    {
        if (RBACService::getAuthorityTier((array) ($actor['roles'] ?? [])) !== 1) {
            throw new \RuntimeException('Only Tier 1 executives can approve elevation requests.');
        }

        $user = self::getById($id);
        if (!$user || ($user['approval_status'] ?? 'approved') !== 'pending') {
            throw new \RuntimeException('No pending approval request found for this user.');
        }

        $payload = !empty($user['pending_payload']) ? json_decode((string) $user['pending_payload'], true) : [];
        if (!is_array($payload)) {
            $payload = [];
        }

        $roles = isset($payload['roles']) ? self::normalizeRoles((array) $payload['roles']) : (array) $user['roles'];
        $scope = isset($payload['access_scope'])
            ? self::normalizeScope((string) $payload['access_scope'])
            : (string) ($user['access_scope'] ?? 'crm_only');
        $tier = RBACService::getAuthorityTier($roles);

        $pdo = Database::getConnection();
        if (!$pdo) {
            throw new \RuntimeException('Database connection unavailable.');
        }

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('
                UPDATE `users` SET
                    `role` = ?,
                    `roles` = ?,
                    `access_scope` = ?,
                    `authority_tier` = ?,
                    `approval_status` = ?,
                    `pending_payload` = NULL
                WHERE `id` = ?
            ');
            $stmt->execute([$roles[0] ?? 'viewer', json_encode($roles), $scope, $tier, 'approved', $id]);
            self::syncUserRolesPivot($pdo, $id, $roles);
            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }

        return self::getById($id) ?? $user;
    }

    /**
     * Reject a pending privilege/scope elevation request (Tier 1 executive only).
     *
     * @param array<string, mixed> $actor
     */
    public static function rejectPendingElevation(string $id, array $actor): bool
    {
        if (RBACService::getAuthorityTier((array) ($actor['roles'] ?? [])) !== 1) {
            throw new \RuntimeException('Only Tier 1 executives can reject elevation requests.');
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return false;
        }

        $stmt = $pdo->prepare('UPDATE `users` SET `approval_status` = ?, `pending_payload` = NULL WHERE `id` = ? AND `approval_status` = ?');
        $stmt->execute(['approved', $id, 'pending']);
        return $stmt->rowCount() > 0;
    }

    private static function assertStrongPassword(string $password): void
    {
        if (function_exists('validate_admin_password_strength')) {
            $errors = [];
            if (!validate_admin_password_strength($password, $errors)) {
                throw new \InvalidArgumentException(implode(' ', $errors));
            }
            return;
        }

        if (
            strlen($password) < 12
            || !preg_match('/[A-Z]/', $password)
            || !preg_match('/[a-z]/', $password)
            || !preg_match('/[0-9]/', $password)
            || !preg_match('/[^A-Za-z0-9]/', $password)
            || preg_match('/\s/', $password)
        ) {
            throw new \InvalidArgumentException('Password must be at least 12 characters with uppercase, lowercase, number, and symbol (no spaces).');
        }
    }

    /**
     * Permanently remove a user account (prevents self-deletion).
     */
    public static function delete(string $id, string $currentUserId = ''): bool
    {
        $cleanId = trim($id);
        if ($cleanId === '' || ($currentUserId !== '' && $cleanId === $currentUserId)) {
            throw new \RuntimeException('You cannot delete your own active account.');
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return false;
        }

        $pdo->beginTransaction();
        try {
            $pdo->prepare('DELETE FROM `user_roles` WHERE `user_id` = ?')->execute([$cleanId]);
            $stmt = $pdo->prepare('DELETE FROM `users` WHERE `id` = ?');
            $stmt->execute([$cleanId]);
            $deleted = $stmt->rowCount() > 0;
            $pdo->commit();
            return $deleted;
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return false;
        }
    }

    /**
     * Record last login timestamp and IP for a user.
     */
    public static function recordLogin(string $id): void
    {
        $pdo = Database::getConnection();
        if (!$pdo || trim($id) === '') {
            return;
        }

        try {
            $ip = function_exists('get_client_ip') ? get_client_ip() : ($_SERVER['REMOTE_ADDR'] ?? '');
            $stmt = $pdo->prepare('UPDATE `users` SET `last_login` = NOW(), `last_ip` = ? WHERE `id` = ?');
            $stmt->execute([substr((string) $ip, 0, 50), $id]);
        } catch (\Throwable $e) {
            // Non-critical telemetry
        }
    }

    /**
     * Seed default superadmin account from .env if users table is empty.
     */
    public static function seedDefaultUsersIfEmpty(): void
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return;
        }

        try {
            $count = (int) $pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();
            if ($count > 0) {
                return;
            }

            $adminUser = strtolower(trim((string) Env::get('ADMIN_USER', 'admin')));
            $adminPassHash = (string) Env::get('ADMIN_PASS_HASH', '');
            if ($adminUser === '' || $adminPassHash === '') {
                return;
            }

            $roles = ['superadmin', 'founder', 'ceo', 'cto'];
            $stmt = $pdo->prepare('
                INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `name`, `title`, `department`, `role`, `roles`, `status`, `access_scope`, `authority_tier`, `approval_status`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            $stmt->execute([
                'admin',
                $adminUser,
                'admin@codex404solutions.online',
                $adminPassHash,
                'Alex Rivera',
                'Chief Executive Officer & Founder',
                'Executive Leadership',
                'superadmin',
                json_encode($roles),
                'active',
                'both',
                1,
                'approved',
            ]);
            self::syncUserRolesPivot($pdo, 'admin', $roles);
        } catch (\Throwable $e) {
            // Safe no-op
        }
    }

    /**
     * Validate and store an uploaded avatar image, updating the user record.
     *
     * @param array<string, mixed> $file
     */
    public static function uploadAvatar(string $id, array $file): string
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('File upload failed.');
        }
        $tmpName = (string) ($file['tmp_name'] ?? '');
        if ($tmpName === '' || !is_uploaded_file($tmpName)) {
            throw new \InvalidArgumentException('Invalid uploaded file.');
        }
        if ((int) ($file['size'] ?? 0) > 2 * 1024 * 1024) {
            throw new \InvalidArgumentException('Avatar image must be 2 MB or smaller.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = (string) $finfo->file($tmpName);
        $extMap = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];
        if (!isset($extMap[$mime])) {
            throw new \InvalidArgumentException('Only JPG, PNG, and WEBP images are allowed.');
        }

        $uploadDir = dirname(__DIR__, 2) . '/assets/images/avatars';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $id) . '_' . bin2hex(random_bytes(4)) . '.' . $extMap[$mime];
        $destPath = $uploadDir . '/' . $filename;
        if (!move_uploaded_file($tmpName, $destPath)) {
            throw new \RuntimeException('Failed to save uploaded avatar.');
        }

        $relativePath = 'images/avatars/' . $filename;
        self::removeOldAvatarFile($id);

        $pdo = Database::getConnection();
        if ($pdo) {
            $stmt = $pdo->prepare('UPDATE `users` SET `avatar` = ? WHERE `id` = ?');
            $stmt->execute([$relativePath, $id]);
        }

        return $relativePath;
    }

    /**
     * Remove a user's avatar image reference and local file if present.
     */
    public static function removeAvatar(string $id): bool
    {
        self::removeOldAvatarFile($id);

        $pdo = Database::getConnection();
        if (!$pdo) {
            return false;
        }

        $stmt = $pdo->prepare('UPDATE `users` SET `avatar` = NULL WHERE `id` = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Return avatar display metadata (image path or initials + deterministic gradient).
     *
     * @param array<string, mixed> $user
     * @return array{image: ?string, initials: string, background: string, color: string}
     */
    public static function getAvatarInfo(array $user): array
    {
        $name = trim((string) ($user['name'] ?? $user['username'] ?? 'U'));
        $parts = preg_split('/\s+/', $name) ?: ['U'];
        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));

        $palettes = [
            'linear-gradient(135deg, #38BDF8 0%, #3B82F6 100%)',
            'linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%)',
            'linear-gradient(135deg, #10B981 0%, #059669 100%)',
            'linear-gradient(135deg, #F59E0B 0%, #D97706 100%)',
            'linear-gradient(135deg, #EC4899 0%, #BE185D 100%)',
        ];
        $idx = abs(crc32($name)) % count($palettes);

        $image = !empty($user['avatar']) ? (string) $user['avatar'] : null;

        return [
            'image' => $image,
            'initials' => $initials !== '' ? $initials : 'U',
            'background' => $palettes[$idx],
            'color' => '#ffffff',
        ];
    }

    /**
     * @param array<string, mixed> $row
     * @return array<string, mixed>
     */
    private static function hydrateUser(array $row): array
    {
        $decodedRoles = !empty($row['roles']) ? json_decode((string) $row['roles'], true) : [];
        if (!is_array($decodedRoles) || empty($decodedRoles)) {
            $decodedRoles = [!empty($row['role']) ? (string) $row['role'] : 'viewer'];
        }
        $row['roles'] = self::normalizeRoles($decodedRoles);

        $decodedCustom = !empty($row['custom_permissions']) ? json_decode((string) $row['custom_permissions'], true) : null;
        $row['custom_permissions'] = is_array($decodedCustom)
            ? self::normalizeCustomPermissions($decodedCustom)
            : ['granted' => [], 'denied' => []];

        $row['authority_tier'] = isset($row['authority_tier'])
            ? (int) $row['authority_tier']
            : RBACService::getAuthorityTier($row['roles']);

        return $row;
    }

    /**
     * @param array<int, string> $roles
     */
    private static function syncUserRolesPivot(PDO $pdo, string $userId, array $roles): void
    {
        $pdo->prepare('DELETE FROM `user_roles` WHERE `user_id` = ?')->execute([$userId]);
        if (empty($roles)) {
            return;
        }

        $placeholders = implode(',', array_fill(0, count($roles), '?'));
        $rStmt = $pdo->prepare("SELECT `id` FROM `roles` WHERE LOWER(`slug`) IN ({$placeholders})");
        $rStmt->execute($roles);
        $roleIds = $rStmt->fetchAll(PDO::FETCH_COLUMN);

        $ins = $pdo->prepare('INSERT IGNORE INTO `user_roles` (`user_id`, `role_id`) VALUES (?, ?)');
        foreach ($roleIds as $rid) {
            $ins->execute([$userId, $rid]);
        }
    }

    private static function removeOldAvatarFile(string $id): void
    {
        $existing = self::getById($id);
        $rel = (string) ($existing['avatar'] ?? '');
        if ($rel !== '' && str_starts_with($rel, 'images/avatars/')) {
            $full = dirname(__DIR__, 2) . '/assets/' . $rel;
            if (is_file($full)) {
                @unlink($full);
            }
        }
    }

    /**
     * @param array<int, mixed> $roles
     * @return array<int, string>
     */
    private static function normalizeRoles(array $roles): array
    {
        $normalized = array_values(array_unique(array_filter(array_map(
            static fn($r): string => strtolower(trim((string) $r)),
            $roles
        ), static fn(string $v): bool => $v !== '')));

        return !empty($normalized) ? $normalized : ['viewer'];
    }

    private static function normalizeScope(string $scope): string
    {
        $clean = strtolower(trim($scope));
        return in_array($clean, self::ALLOWED_SCOPES, true) ? $clean : 'crm_only';
    }

    private static function normalizeStatus(string $status): string
    {
        $clean = strtolower(trim($status));
        return in_array($clean, self::ALLOWED_STATUSES, true) ? $clean : 'active';
    }

    /**
     * @param mixed $custom
     * @return array{granted: array<int, string>, denied: array<int, string>}
     */
    private static function normalizeCustomPermissions(mixed $custom): array
    {
        if (!is_array($custom)) {
            return ['granted' => [], 'denied' => []];
        }

        $clean = static fn(array $list): array => array_values(array_unique(array_filter(array_map(
            static fn($p): string => strtolower(trim((string) $p)),
            $list
        ), static fn(string $v): bool => $v !== '')));

        return [
            'granted' => $clean((array) ($custom['granted'] ?? [])),
            'denied' => $clean((array) ($custom['denied'] ?? [])),
        ];
    }
}
