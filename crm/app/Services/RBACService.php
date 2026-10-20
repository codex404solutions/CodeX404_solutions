<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * RBACService
 * Manages roles and permissions with full multi-role support.
 * Users can have multiple roles simultaneously (e.g. CEO + CTO + Developer).
 */
class RBACService
{
    private static array $defaultRoles = [
        'ceo' => [
            'name' => 'Chief Executive Officer',
            'permissions' => ['*'] // full access
        ],
        'founder' => [
            'name' => 'Solo Founder',
            'permissions' => ['*']
        ],
        'sales' => [
            'name' => 'Sales Lead',
            'permissions' => [
                'leads.view', 'leads.create', 'leads.edit', 'leads.status',
                'opportunities.view', 'opportunities.edit', 'opportunities.create',
                'proposals.create', 'proposals.view'
            ]
        ],
        'cto' => [
            'name' => 'Chief Technology Officer',
            'permissions' => [
                'projects.view', 'projects.create', 'projects.edit',
                'approvals.view', 'approvals.decide', 'settings.view'
            ]
        ],
        'developer' => [
            'name' => 'Software Engineer',
            'permissions' => ['projects.view', 'tasks.view', 'tasks.edit']
        ],
        'marketing' => [
            'name' => 'Growth Marketer',
            'permissions' => [
                'leads.view', 'campaigns.view', 'campaigns.create',
                'approvals.create'
            ]
        ]
    ];

    /**
     * Check if a set of user roles has a specific permission.
     */
    public static function hasPermission(array $userRoles, string $requiredPermission): bool
    {
        foreach ($userRoles as $roleSlug) {
            $roleConfig = self::$defaultRoles[strtolower($roleSlug)] ?? null;
            if (!$roleConfig) {
                continue;
            }
            $perms = $roleConfig['permissions'] ?? [];
            if (in_array('*', $perms, true) || in_array($requiredPermission, $perms, true)) {
                return true;
            }
        }
        return false;
    }

    public static function getRoles(): array
    {
        return self::$defaultRoles;
    }
}
