<?php
declare(strict_types=1);

namespace App\Services;

use Database;
use PDO;

/**
 * MySQL-backed Role-Based Access Control (RBAC) Service.
 * Evaluates multi-role unions, custom per-user overrides, and authority tiers.
 */
final class RBACService
{
    private const TOP_EXECUTIVE_ROLES = ['superadmin', 'founder', 'ceo'];

    private const MANAGEMENT_ROLES = [
        'cto',
        'coo',
        'lead_developer',
        'project_manager',
        'sales_manager',
        'marketing_manager',
        'hr',
        'recruiter',
        'finance',
    ];

    private const PROTECTED_SYSTEM_ROLES = ['superadmin', 'founder', 'ceo', 'cto', 'viewer'];

    private const MODULE_META = [
        'portfolio' => ['title' => 'Portfolio & Deliverables', 'icon' => 'collection-play-fill'],
        'inquiries' => ['title' => 'Website Inquiries & Leads', 'icon' => 'envelope-paper-fill'],
        'careers' => ['title' => 'Careers & Recruitment ATS', 'icon' => 'briefcase-fill'],
        'users' => ['title' => 'Workforce & RBAC Governance', 'icon' => 'people-fill'],
        'approvals' => ['title' => 'Executive HITL Approvals', 'icon' => 'shield-check'],
        'settings' => ['title' => 'Audit Logs & Telemetry', 'icon' => 'gear-fill'],
    ];

    /**
     * Return all defined roles keyed by lowercase slug, including assigned permission slugs.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getAllRoles(): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return [];
        }

        $roles = [];
        $stmt = $pdo->query('SELECT `id`, `slug`, `name`, `description`, `color`, `is_system` FROM `roles` ORDER BY `is_system` DESC, `name` ASC');
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $slug = strtolower((string) $row['slug']);
            $roles[$slug] = [
                'id' => (string) $row['id'],
                'slug' => $slug,
                'name' => (string) $row['name'],
                'description' => (string) ($row['description'] ?? ''),
                'color' => (string) ($row['color'] ?: 'info'),
                'icon' => in_array($slug, self::TOP_EXECUTIVE_ROLES, true) ? 'shield-lock-fill' : 'shield-check',
                'is_system' => !empty($row['is_system']),
                'permissions' => in_array($slug, self::TOP_EXECUTIVE_ROLES, true) ? ['*'] : [],
            ];
        }

        $permSql = '
            SELECT LOWER(r.slug) AS role_slug, LOWER(p.slug) AS perm_slug
            FROM `role_permissions` rp
            INNER JOIN `roles` r ON r.id = rp.role_id
            INNER JOIN `permissions` p ON p.id = rp.permission_id
            ORDER BY p.slug ASC
        ';
        foreach ($pdo->query($permSql)->fetchAll(PDO::FETCH_ASSOC) as $link) {
            $rSlug = (string) $link['role_slug'];
            if (!isset($roles[$rSlug]) || in_array('*', $roles[$rSlug]['permissions'], true)) {
                continue;
            }
            $roles[$rSlug]['permissions'][] = (string) $link['perm_slug'];
        }

        return $roles;
    }

    /**
     * Return all permission modules with titles, icons, and permission slug => description maps.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getAllModules(): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return [];
        }

        $modules = [];
        $stmt = $pdo->query('SELECT `slug`, `module`, `description` FROM `permissions` ORDER BY `module` ASC, `slug` ASC');
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $modKey = strtolower((string) $row['module']);
            if (!isset($modules[$modKey])) {
                $meta = self::MODULE_META[$modKey] ?? [
                    'title' => ucfirst($modKey),
                    'icon' => 'key-fill',
                ];
                $modules[$modKey] = [
                    'title' => $meta['title'],
                    'icon' => $meta['icon'],
                    'permissions' => [],
                ];
            }
            $modules[$modKey]['permissions'][(string) $row['slug']] = (string) ($row['description'] ?? '');
        }

        return $modules;
    }

    /**
     * Compute effective permissions from the union of roles plus custom granted/denied overrides.
     *
     * @param array<int, string> $roles
     * @param array<string, mixed>|null $customPermissions
     * @return array{
     *   effective: array<int, string>,
     *   from_roles: array<int, string>,
     *   granted: array<int, string>,
     *   denied: array<int, string>,
     *   details: array<string, array{source: string}>
     * }
     */
    public static function getEffectivePermissions(array $roles, ?array $customPermissions = null): array
    {
        $normalizedRoles = self::normalizeList($roles);
        $allRoles = self::getAllRoles();
        $allModules = self::getAllModules();

        $allPermissionSlugs = [];
        foreach ($allModules as $mod) {
            foreach (array_keys($mod['permissions']) as $slug) {
                $allPermissionSlugs[] = strtolower((string) $slug);
            }
        }
        $allPermissionSlugs = array_values(array_unique($allPermissionSlugs));

        $fromRoles = [];
        $details = [];
        $hasWildcard = false;
        $wildcardSource = '';

        foreach ($normalizedRoles as $rSlug) {
            $roleName = (string) ($allRoles[$rSlug]['name'] ?? ucfirst($rSlug));
            $rolePerms = $allRoles[$rSlug]['permissions'] ?? [];
            if (in_array($rSlug, self::TOP_EXECUTIVE_ROLES, true) || in_array('*', $rolePerms, true)) {
                $hasWildcard = true;
                if ($wildcardSource === '') {
                    $wildcardSource = $roleName . ' (*)';
                }
                continue;
            }
            foreach ($rolePerms as $p) {
                $pLower = strtolower((string) $p);
                $fromRoles[] = $pLower;
                if (!isset($details[$pLower])) {
                    $details[$pLower] = ['source' => $roleName];
                }
            }
        }

        if ($hasWildcard) {
            $fromRoles = $allPermissionSlugs;
            foreach ($allPermissionSlugs as $pSlug) {
                if (!isset($details[$pSlug])) {
                    $details[$pSlug] = ['source' => $wildcardSource ?: 'Executive Wildcard (*)'];
                }
            }
        } else {
            $fromRoles = array_values(array_unique($fromRoles));
        }

        $granted = self::normalizeList((array) ($customPermissions['granted'] ?? []));
        $denied = self::normalizeList((array) ($customPermissions['denied'] ?? []));

        foreach ($granted as $gSlug) {
            $details[$gSlug] = ['source' => 'Custom Grant'];
        }
        foreach ($denied as $dSlug) {
            unset($details[$dSlug]);
        }

        $effective = array_values(array_diff(
            array_values(array_unique(array_merge($fromRoles, $granted))),
            $denied
        ));
        sort($effective);

        return [
            'effective' => $effective,
            'from_roles' => $fromRoles,
            'granted' => $granted,
            'denied' => $denied,
            'details' => $details,
        ];
    }

    /**
     * Evaluate whether the given roles & custom overrides permit a specific permission slug.
     * Deny overrides always take precedence over role and grant entries.
     *
     * @param array<int, string> $roles
     * @param array<string, mixed>|null $customPermissions
     */
    public static function hasPermission(array $roles, string $permission, ?array $customPermissions = null): bool
    {
        $target = strtolower(trim($permission));
        if ($target === '') {
            return false;
        }

        if (is_array($customPermissions)) {
            $denied = self::normalizeList((array) ($customPermissions['denied'] ?? []));
            if (in_array($target, $denied, true)) {
                return false;
            }
            $granted = self::normalizeList((array) ($customPermissions['granted'] ?? []));
            if (in_array($target, $granted, true)) {
                return true;
            }
        }

        $normalizedRoles = self::normalizeList($roles);
        if (empty($normalizedRoles)) {
            return false;
        }

        if (!empty(array_intersect($normalizedRoles, self::TOP_EXECUTIVE_ROLES))) {
            return true;
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return false;
        }

        try {
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
            $stmt->execute(array_merge($normalizedRoles, [$target]));
            return (int) $stmt->fetchColumn() > 0;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Compute delegation authority tier (1 = Supreme, 2 = Management, 3 = Standard).
     *
     * @param array<int, string> $roles
     */
    public static function getAuthorityTier(array $roles): int
    {
        $normalized = self::normalizeList($roles);
        if (!empty(array_intersect($normalized, self::TOP_EXECUTIVE_ROLES))) {
            return 1;
        }
        if (!empty(array_intersect($normalized, self::MANAGEMENT_ROLES))) {
            return 2;
        }
        return 3;
    }

    public static function getTierTitle(int $tier): string
    {
        return match ($tier) {
            1 => 'Tier 1: Supreme Executive Authority',
            2 => 'Tier 2: Management & Delegation',
            default => 'Tier 3: Standard Workforce',
        };
    }

    /**
     * Create or update a role and sync its permission assignments.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public static function saveRole(array $data): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            throw new \RuntimeException('Database connection unavailable.');
        }

        $slug = strtolower(trim((string) ($data['slug'] ?? '')));
        $slug = preg_replace('/[^a-z0-9_-]/', '_', $slug) ?? '';
        $name = trim((string) ($data['name'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        $color = trim((string) ($data['color'] ?? 'info')) ?: 'info';
        $permSlugs = self::normalizeList((array) ($data['permissions'] ?? []));

        if ($slug === '' || $name === '') {
            throw new \InvalidArgumentException('Role slug and name are required.');
        }

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('SELECT `id`, `is_system` FROM `roles` WHERE LOWER(`slug`) = ? LIMIT 1');
            $stmt->execute([$slug]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                $roleId = (string) $existing['id'];
                $upd = $pdo->prepare('UPDATE `roles` SET `name` = ?, `description` = ?, `color` = ? WHERE `id` = ?');
                $upd->execute([$name, $description, $color, $roleId]);
            } else {
                $roleId = 'role_' . $slug;
                $ins = $pdo->prepare('INSERT INTO `roles` (`id`, `slug`, `name`, `description`, `color`, `is_system`) VALUES (?, ?, ?, ?, ?, 0)');
                $ins->execute([$roleId, $slug, $name, $description, $color]);
            }

            // Replace role_permissions unless top-executive wildcard role
            if (!in_array($slug, self::TOP_EXECUTIVE_ROLES, true)) {
                $pdo->prepare('DELETE FROM `role_permissions` WHERE `role_id` = ?')->execute([$roleId]);

                if (!empty($permSlugs)) {
                    $placeholders = implode(',', array_fill(0, count($permSlugs), '?'));
                    $pStmt = $pdo->prepare("SELECT `id` FROM `permissions` WHERE LOWER(`slug`) IN ({$placeholders})");
                    $pStmt->execute($permSlugs);
                    $permIds = $pStmt->fetchAll(PDO::FETCH_COLUMN);

                    $insPerm = $pdo->prepare('INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`) VALUES (?, ?)');
                    foreach ($permIds as $pid) {
                        $insPerm->execute([$roleId, $pid]);
                    }
                }
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }

        $allRoles = self::getAllRoles();
        return $allRoles[$slug] ?? [
            'id' => $roleId,
            'slug' => $slug,
            'name' => $name,
            'description' => $description,
            'color' => $color,
            'permissions' => $permSlugs,
        ];
    }

    /**
     * Delete a non-system custom role.
     */
    public static function deleteRole(string $slug): bool
    {
        $cleanSlug = strtolower(trim($slug));
        if ($cleanSlug === '' || in_array($cleanSlug, self::PROTECTED_SYSTEM_ROLES, true)) {
            return false;
        }

        $pdo = Database::getConnection();
        if (!$pdo) {
            return false;
        }

        $stmt = $pdo->prepare('SELECT `id`, `is_system` FROM `roles` WHERE LOWER(`slug`) = ? LIMIT 1');
        $stmt->execute([$cleanSlug]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$role || !empty($role['is_system'])) {
            return false;
        }

        $roleId = (string) $role['id'];
        $pdo->beginTransaction();
        try {
            $pdo->prepare('DELETE FROM `role_permissions` WHERE `role_id` = ?')->execute([$roleId]);
            $pdo->prepare('DELETE FROM `user_roles` WHERE `role_id` = ?')->execute([$roleId]);
            $pdo->prepare('DELETE FROM `roles` WHERE `id` = ?')->execute([$roleId]);
            $pdo->commit();
            return true;
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return false;
        }
    }

    /**
     * @param array<int, mixed> $items
     * @return array<int, string>
     */
    private static function normalizeList(array $items): array
    {
        return array_values(array_unique(array_filter(array_map(
            static fn($item): string => strtolower(trim((string) $item)),
            $items
        ), static fn(string $v): bool => $v !== '')));
    }
}
