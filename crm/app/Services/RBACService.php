<?php
declare(strict_types=1);

namespace CRM\Services;

require_once __DIR__ . '/StorageService.php';

/**
 * RBACService
 * Comprehensive Multi-Role Profiling & Granular Permission Engine for CodeX404 Solutions.
 * 
 * Complies strictly with CRM Mandatory Rules:
 * 1. Multi-Role Is Mandatory: One person may hold multiple roles simultaneously (e.g. CEO + CTO, Founder + Sales).
 *    Effective permissions = Union of permissions from active roles + direct grants - explicit denials.
 * 2. Roles Are Not Permissions: All access checks use RBACService::hasPermission() or AuthService::can('perm.slug').
 * 3. Deny > Allow: Explicit user-level denials override any role-based permissions.
 */
class RBACService
{
    // Portal Access Scopes
    public const SCOPE_BOTH = 'both';
    public const SCOPE_CRM_ONLY = 'crm_only';
    public const SCOPE_ADMIN_ONLY = 'admin_only';

    // Delegation Authority Tiers
    public const TIER_1_SUPREME = 1;     // superadmin, founder (Unrestricted Supreme Authority)
    public const TIER_2_MANAGEMENT = 2;  // ceo, cto, coo, hr, sales_manager (Departmental / Operational Management)
    public const TIER_3_STANDARD = 3;    // sales, bd, developer, designer, qa, finance, support, viewer (Standard Workforce)

    /**
     * Catalog of Portal Access Scopes.
     */
    public static function getAllScopes(): array
    {
        return [
            self::SCOPE_BOTH => [
                'slug' => self::SCOPE_BOTH,
                'name' => 'Both Admin & CRM',
                'description' => 'Dual authorization for Website Admin Portal and CRM Operations OS',
                'badge' => 'purple',
                'icon' => 'shield-shaded',
                'requires_approval' => true
            ],
            self::SCOPE_CRM_ONLY => [
                'slug' => self::SCOPE_CRM_ONLY,
                'name' => 'CRM Operations Only',
                'description' => 'Dedicated access to CRM leads, deals, deliverables, and agent swarm',
                'badge' => 'info',
                'icon' => 'kanban-fill',
                'requires_approval' => false
            ],
            self::SCOPE_ADMIN_ONLY => [
                'slug' => self::SCOPE_ADMIN_ONLY,
                'name' => 'Website Admin Only',
                'description' => 'Dedicated access to Website CMS, deliverables showcase, and portfolio telemetry',
                'badge' => 'warning',
                'icon' => 'globe-americas',
                'requires_approval' => true
            ]
        ];
    }

    /**
     * Determine authority tier for a given set of active roles.
     */
    public static function getAuthorityTier(array $roles): int
    {
        $clean = array_map('strtolower', array_map('trim', $roles));
        if (in_array('superadmin', $clean, true) || in_array('founder', $clean, true)) {
            return self::TIER_1_SUPREME;
        }

        $tier2Roles = ['ceo', 'cto', 'coo', 'hr', 'sales_manager', 'marketing_manager'];
        foreach ($tier2Roles as $t2) {
            if (in_array($t2, $clean, true)) {
                return self::TIER_2_MANAGEMENT;
            }
        }

        return self::TIER_3_STANDARD;
    }

    /**
     * Get human-readable title for an authority tier.
     */
    public static function getTierTitle(int $tier): string
    {
        return match($tier) {
            self::TIER_1_SUPREME => 'Tier 1: Supreme Executive Authority',
            self::TIER_2_MANAGEMENT => 'Tier 2: Senior Management Authority',
            default => 'Tier 3: Standard Workforce Authority',
        };
    }

    /**
     * Check if a role is classified as high-privilege / executive.
     */
    public static function isHighPrivilegeRole(string $roleSlug): bool
    {
        $high = ['superadmin', 'founder', 'ceo', 'cto', 'coo', 'finance'];
        return in_array(strtolower(trim($roleSlug)), $high, true);
    }

    /**
     * Check if a permission slug is classified as high-privilege.
     */
    public static function isHighPrivilegePermission(string $permSlug): bool
    {
        $high = ['*', 'settings.edit', 'roles.manage', 'users.delete', 'approvals.decide', 'users.scope', 'users.delegate'];
        return in_array(strtolower(trim($permSlug)), $high, true);
    }

    /**
     * Check if a portal access scope is classified as elevated.
     */
    public static function isHighPrivilegeScope(string $scope): bool
    {
        return in_array(strtolower(trim($scope)), [self::SCOPE_BOTH, self::SCOPE_ADMIN_ONLY], true);
    }

    /**
     * Evaluate whether an actor can grant or elevate roles/permissions to a target user,
     * or if high-authority approval from a Tier 1 executive is required.
     * 
     * @param array $actorRoles Active roles of the user performing the change
     * @param array $targetRoles Desired roles being assigned
     * @param string $targetScope Desired portal access scope (both, crm_only, admin_only)
     * @param array $targetPermissions Explicit custom permissions being granted
     * @return array [
     *     'status' => 'allowed' | 'approval_required' | 'denied',
     *     'reasons' => string[],
     *     'actor_tier' => int,
     *     'can_bypass' => bool
     * ]
     */
    public static function evaluateDelegationAuthority(
        array $actorRoles,
        array $targetRoles,
        string $targetScope = self::SCOPE_CRM_ONLY,
        array $targetPermissions = []
    ): array {
        $actorTier = self::getAuthorityTier($actorRoles);

        // Tier 1 (Superadmin / Founder) has unrestricted supreme authority
        if ($actorTier === self::TIER_1_SUPREME) {
            return [
                'status' => 'allowed',
                'reasons' => [],
                'actor_tier' => self::TIER_1_SUPREME,
                'can_bypass' => true
            ];
        }

        // Tier 3 cannot assign roles or permissions at all
        if ($actorTier === self::TIER_3_STANDARD) {
            return [
                'status' => 'denied',
                'reasons' => ['Standard workforce members do not possess user delegation or role assignment authority.'],
                'actor_tier' => self::TIER_3_STANDARD,
                'can_bypass' => false
            ];
        }

        $reasons = [];

        // Tier 2 (Management): Can assign standard roles, but high-privilege requires approval
        $cleanTargetRoles = array_map('strtolower', array_map('trim', $targetRoles));
        foreach ($cleanTargetRoles as $rSlug) {
            if (self::isHighPrivilegeRole($rSlug)) {
                $roleName = self::$systemRoles[$rSlug]['name'] ?? ucfirst($rSlug);
                $reasons[] = "Assigning High-Privilege role '{$roleName}' requires Founder / Superadmin sign-off.";
            }
        }

        if (self::isHighPrivilegeScope($targetScope)) {
            $scopeName = $targetScope === self::SCOPE_BOTH ? 'Both Admin & CRM Dual Clearance' : 'Website Admin Console Access';
            $reasons[] = "Granting elevated portal scope '{$scopeName}' requires Supreme Executive authorization.";
        }

        foreach ($targetPermissions as $pSlug) {
            if (self::isHighPrivilegePermission($pSlug)) {
                $reasons[] = "Direct grant of restricted permission '{$pSlug}' requires Founder approval.";
            }
        }

        if (!empty($reasons)) {
            return [
                'status' => 'approval_required',
                'reasons' => $reasons,
                'actor_tier' => $actorTier,
                'can_bypass' => false
            ];
        }

        return [
            'status' => 'allowed',
            'reasons' => [],
            'actor_tier' => $actorTier,
            'can_bypass' => false
        ];
    }

    /**
     * Complete Catalog of System-Defined Standard Roles.
     */
    private static array $systemRoles = [
        'superadmin' => [
            'slug' => 'superadmin',
            'name' => 'Super Administrator',
            'description' => 'Unrestricted authority across CRM, website administration, security policies, and team credentials.',
            'color' => 'danger',
            'icon' => 'shield-lock-fill',
            'is_system' => true,
            'permissions' => ['*']
        ],
        'founder' => [
            'slug' => 'founder',
            'name' => 'Founder',
            'description' => 'Full executive oversight across revenue, engineering, finances, strategy, and company deliverables.',
            'color' => 'primary',
            'icon' => 'gem',
            'is_system' => true,
            'permissions' => ['*']
        ],
        'ceo' => [
            'slug' => 'ceo',
            'name' => 'Chief Executive Officer',
            'description' => 'Executive business leadership, pipeline oversight, strategic approvals, and high-level financial metrics.',
            'color' => 'info',
            'icon' => 'briefcase-fill',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'leads.create', 'leads.edit', 'leads.convert', 'leads.assign',
                'opportunities.view', 'opportunities.create', 'opportunities.edit', 'opportunities.advance', 'proposals.create',
                'projects.view', 'projects.create', 'projects.edit', 'milestones.toggle',
                'approvals.view', 'approvals.decide', 'approvals.create',
                'users.view', 'finance.view', 'finance.rates', 'settings.view', 'portfolio.view'
            ]
        ],
        'cto' => [
            'slug' => 'cto',
            'name' => 'Chief Technology Officer',
            'description' => 'Technical governance, deliverable velocity, engineering milestones, AI agents, and infrastructure architecture.',
            'color' => 'purple',
            'icon' => 'cpu-fill',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'projects.create', 'projects.edit', 'projects.delete', 'milestones.toggle',
                'approvals.view', 'approvals.decide', 'approvals.create',
                'users.view', 'settings.view', 'settings.edit', 'portfolio.view', 'portfolio.edit',
                'leads.view', 'opportunities.view'
            ]
        ],
        'coo' => [
            'slug' => 'coo',
            'name' => 'Chief Operating Officer',
            'description' => 'Operations management, resource dispatch, milestone delivery, and cross-department execution.',
            'color' => 'indigo',
            'icon' => 'diagram-3-fill',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'opportunities.view', 'projects.view', 'projects.create', 'projects.edit',
                'milestones.toggle', 'approvals.view', 'approvals.decide', 'users.view', 'finance.view'
            ]
        ],
        'sales_manager' => [
            'slug' => 'sales_manager',
            'name' => 'Sales Manager',
            'description' => 'Full authority over deals pipeline, client scoping, proposal creation, and sales team assignments.',
            'color' => 'warning',
            'icon' => 'graph-up-arrow',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'leads.create', 'leads.edit', 'leads.delete', 'leads.convert', 'leads.assign',
                'opportunities.view', 'opportunities.create', 'opportunities.edit', 'opportunities.advance', 'opportunities.delete', 'proposals.create',
                'approvals.view', 'approvals.create', 'finance.view', 'finance.rates'
            ]
        ],
        'sales' => [
            'slug' => 'sales',
            'name' => 'Sales Executive',
            'description' => 'Assigned prospect nurturing, client discovery calls, deal progression, and quotation scoping.',
            'color' => 'amber',
            'icon' => 'telephone-outbound-fill',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'leads.create', 'leads.edit', 'leads.convert',
                'opportunities.view', 'opportunities.create', 'opportunities.edit', 'opportunities.advance', 'proposals.create',
                'approvals.view', 'approvals.create', ]
        ],
        'bd' => [
            'slug' => 'bd',
            'name' => 'Business Development',
            'description' => 'Inbound qualification, outbound market prospecting, lead enrichment, and discovery scheduling.',
            'color' => 'cyan',
            'icon' => 'compass-fill',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'leads.create', 'leads.edit', 'leads.convert',
                'opportunities.view', 'opportunities.create', ]
        ],
        'marketing_manager' => [
            'slug' => 'marketing_manager',
            'name' => 'Marketing Manager',
            'description' => 'Lead generation campaigns, attribution tracking, marketing email drafts, and showcase content.',
            'color' => 'pink',
            'icon' => 'megaphone-fill',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'leads.create', 'leads.edit', 'approvals.view', 'approvals.create',
                'portfolio.view', 'portfolio.edit'
            ]
        ],
        'marketing' => [
            'slug' => 'marketing',
            'name' => 'Growth Marketer',
            'description' => 'Outreach execution, campaign monitoring, and marketing draft submissions for HITL sign-off.',
            'color' => 'rose',
            'icon' => 'bullseye',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'leads.create', 'approvals.view', 'approvals.create',
                'portfolio.view'
            ]
        ],
        'account_manager' => [
            'slug' => 'account_manager',
            'name' => 'Account Manager',
            'description' => 'Client success governance, deliverable status reviews, upsells, and retainer continuity.',
            'color' => 'teal',
            'icon' => 'person-hearts',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'opportunities.view', 'projects.view', 'projects.edit',
                'milestones.toggle', 'finance.view'
            ]
        ],
        'project_manager' => [
            'slug' => 'project_manager',
            'name' => 'Project Manager',
            'description' => 'Sprint orchestration, delivery schedules, client communications, and deliverable milestones.',
            'color' => 'emerald',
            'icon' => 'kanban-fill',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'projects.create', 'projects.edit', 'projects.delete',
                'milestones.toggle', 'approvals.view', 'approvals.create', ]
        ],
        'lead_developer' => [
            'slug' => 'lead_developer',
            'name' => 'Lead / Senior Engineer',
            'description' => 'Architecture leadership, code reviews, milestone completions, and technical deployments.',
            'color' => 'primary',
            'icon' => 'terminal-fill',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'projects.edit', 'milestones.toggle', 'approvals.view',
                'approvals.create', 'settings.view', 'portfolio.view', 'portfolio.edit'
            ]
        ],
        'developer' => [
            'slug' => 'developer',
            'name' => 'Software Engineer',
            'description' => 'Assigned technical deliverable development and project milestone task completion.',
            'color' => 'blue',
            'icon' => 'code-slash',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'milestones.toggle', 'portfolio.view'
            ]
        ],
        'ai_engineer' => [
            'slug' => 'ai_engineer',
            'name' => 'AI & ML Engineer',
            'description' => 'Autonomous workflow configuration, prompt engineering, and system automation.',
            'color' => 'purple',
            'icon' => 'robot',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'milestones.toggle', 'settings.view'
            ]
        ],
        'designer' => [
            'slug' => 'designer',
            'name' => 'UI/UX Designer',
            'description' => 'Design systems, high-fidelity prototypes, user experience flows, and visual deliverables.',
            'color' => 'orange',
            'icon' => 'palette-fill',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'portfolio.view', 'portfolio.edit', 'approvals.view', 'approvals.create'
            ]
        ],
        'qa' => [
            'slug' => 'qa',
            'name' => 'QA & Security Engineer',
            'description' => 'System testing, automated security scans, HITL deployment validation, and quality telemetry.',
            'color' => 'emerald',
            'icon' => 'check-circle-fill',
            'is_system' => true,
            'permissions' => [
                'projects.view', 'milestones.toggle', 'approvals.view', 'approvals.create',
                'settings.view'
            ]
        ],
        'finance' => [
            'slug' => 'finance',
            'name' => 'Finance & Accounts',
            'description' => 'Billing records, client invoice generation, real-time FX currency rates, and cash flow reconciliation.',
            'color' => 'success',
            'icon' => 'cash-stack',
            'is_system' => true,
            'permissions' => [
                'finance.view', 'finance.rates', 'opportunities.view', 'projects.view', 'approvals.view'
            ]
        ],
        'hr' => [
            'slug' => 'hr',
            'name' => 'Human Resources',
            'description' => 'Employee directory, internal team onboarding, multi-role profile maintenance, and staff records.',
            'color' => 'secondary',
            'icon' => 'people-fill',
            'is_system' => true,
            'permissions' => [
                'users.view', 'users.create', 'users.edit'
            ]
        ],
        'support' => [
            'slug' => 'support',
            'name' => 'Customer Support',
            'description' => 'Client communications, prospect inquiry triage, project delivery status updates, and assistance.',
            'color' => 'cyan',
            'icon' => 'headset',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'projects.view', ]
        ],
        'viewer' => [
            'slug' => 'viewer',
            'name' => 'Read-Only Observer',
            'description' => 'Read-only visibility into high-level dashboard summaries, pipeline totals, and public showcases.',
            'color' => 'slate',
            'icon' => 'eye-fill',
            'is_system' => true,
            'permissions' => [
                'leads.view', 'opportunities.view', 'projects.view', 'portfolio.view', 'settings.view'
            ]
        ]
    ];

    /**
     * Standard Catalog of Granular Permission Slugs Grouped by Module.
     */
    private static array $modules = [
        'leads' => [
            'title' => 'Leads & Prospect Intake',
            'icon' => 'person-lines-fill',
            'description' => 'Prospect discovery inquiries, qualification scores, and intake routing',
            'permissions' => [
                'leads.view' => 'Browse and inspect inbound prospect inquiries and lead scoring',
                'leads.create' => 'Ingest from webhooks or manually register new prospective clients',
                'leads.edit' => 'Update contact information, qualification criteria, and notes',
                'leads.convert' => 'Convert qualified lead into an active commercial deal opportunity',
                'leads.assign' => 'Reassign leads to specific sales engineers and team members',
                'leads.delete' => 'Disqualify or delete lead records from the system'
            ]
        ],
        'opportunities' => [
            'title' => 'Pipeline & Commercial Deals',
            'icon' => 'kanban-fill',
            'description' => 'Sales stages, deal valuations, probability forecasting, and quotes',
            'permissions' => [
                'opportunities.view' => 'Access sales pipeline board, deal cards, and conversion metrics',
                'opportunities.create' => 'Open and structure new commercial sales opportunities',
                'opportunities.edit' => 'Modify deal valuation, expected close dates, and technical scope',
                'opportunities.advance' => 'Advance deals across Kanban stages (Discovery to Closed-Won)',
                'opportunities.delete' => 'Remove or archive opportunities from the pipeline',
                'proposals.create' => 'Draft proposals, quotations, and commercial scope definitions'
            ]
        ],
        'projects' => [
            'title' => 'Projects & Client Deliverables',
            'icon' => 'rocket-takeoff-fill',
            'description' => 'Active client deliverables, milestone checklists, and delivery timelines',
            'permissions' => [
                'projects.view' => 'Access client engineering projects and delivery status trackers',
                'projects.create' => 'Initialize new client deliverable workspaces and milestones',
                'projects.edit' => 'Adjust milestone deadlines, budgets, and lead engineers',
                'milestones.toggle' => 'Sign off on milestone completion and release delivery phases',
                'projects.delete' => 'Archive or delete completed client project records'
            ]
        ],
        'approvals' => [
            'title' => 'Human-in-the-Loop (HITL) Gate',
            'icon' => 'shield-check',
            'description' => 'Executive review and sign-off queue for autonomous agent actions',
            'permissions' => [
                'approvals.view' => 'Inspect pending drafts, quotes, and deployment requests',
                'approvals.decide' => 'Formally approve or reject high-impact agent actions',
                'approvals.create' => 'Submit drafts and requests into the executive approval queue'
            ]
        ],
        'users' => [
            'title' => 'User Workforce & Multi-Role RBAC',
            'icon' => 'people-fill',
            'description' => 'Team accounts, multi-role profiling, and granular permission overrides',
            'permissions' => [
                'users.view' => 'Browse employee directory, member profiles, and role footprints',
                'users.create' => 'Provision new team accounts and assign multi-role sets',
                'users.edit' => 'Update user profiles, alter role assignments, and set permissions',
                'users.delete' => 'Deactivate, suspend, or delete user accounts',
                'roles.manage' => 'Create custom roles, edit descriptions, and adjust permission matrices',
                'users.scope' => 'Configure and grant portal access scopes (Admin only, CRM only, Both)',
                'users.delegate' => 'Assign and delegate high-privilege roles or permissions across the workforce'
            ]
        ],
        'finance' => [
            'title' => 'Finance & Multi-Currency Engine',
            'icon' => 'currency-exchange',
            'description' => 'Commercial figures, deal values, and real-time FX exchange conversion',
            'permissions' => [
                'finance.view' => 'Access revenue KPIs, deal valuations, and project budgets',
                'finance.rates' => 'View, refresh, and inspect real-time FX currency conversions'
            ]
        ],
        'settings' => [
            'title' => 'System & API Ingestion',
            'icon' => 'sliders',
            'description' => 'Integration diagnostic parameters, webhook endpoints, and HMAC keys',
            'permissions' => [
                'settings.view' => 'Inspect diagnostic telemetry, storage status, and API routes',
                'settings.edit' => 'Modify system configurations, API credentials, and webhook keys'
            ]
        ],
        'portfolio' => [
            'title' => 'Website Showcase & Admin',
            'icon' => 'collection-play-fill',
            'description' => 'Public website portfolio, live sandboxes, and deliverables showcase',
            'permissions' => [
                'portfolio.view' => 'Browse showcase items, interactive sandboxes, and telemetry',
                'portfolio.edit' => 'Create, edit, and publish client deliverables and case studies'
            ]
        ]
    ];

    /**
     * Retrieve all available roles (System Roles merged with Custom Roles).
     * 
     * @return array<string, array>
     */
    public static function getAllRoles(): array
    {
        $customRoles = StorageService::read('roles', []);
        $merged = self::$systemRoles;

        if (is_array($customRoles)) {
            foreach ($customRoles as $cr) {
                if (!empty($cr['slug'])) {
                    $slug = strtolower(trim((string)$cr['slug']));
                    $isSystem = isset(self::$systemRoles[$slug]);
                    $baseSystem = self::$systemRoles[$slug] ?? [];

                    $merged[$slug] = array_merge(
                        [
                            'slug' => $slug,
                            'name' => (string)($cr['name'] ?? ucfirst($slug)),
                            'description' => (string)($cr['description'] ?? 'Custom role'),
                            'color' => (string)($cr['color'] ?? 'info'),
                            'icon' => (string)($cr['icon'] ?? 'person-badge'),
                            'is_system' => $isSystem,
                            'permissions' => $baseSystem['permissions'] ?? (array)($cr['permissions'] ?? [])
                        ],
                        $cr
                    );

                    // Ensure system role permissions are never overwritten with empty arrays
                    if ($isSystem && empty($cr['permissions']) && !empty($baseSystem['permissions'])) {
                        $merged[$slug]['permissions'] = $baseSystem['permissions'];
                    }
                }
            }
        }

        return $merged;
    }

    /**
     * Retrieve a specific role by its slug.
     */
    public static function getRole(string $slug): ?array
    {
        $roles = self::getAllRoles();
        return $roles[strtolower(trim($slug))] ?? null;
    }

    /**
     * Save or update a custom role.
     */
    public static function saveRole(array $roleData): bool
    {
        $slug = strtolower(trim((string)($roleData['slug'] ?? '')));
        if ($slug === '') {
            return false;
        }

        $allCustom = StorageService::read('roles', []);
        $found = false;

        $newEntry = [
            'id' => $roleData['id'] ?? ('role_' . $slug),
            'slug' => $slug,
            'name' => trim((string)($roleData['name'] ?? ucfirst($slug))),
            'description' => trim((string)($roleData['description'] ?? '')),
            'color' => trim((string)($roleData['color'] ?? 'info')),
            'icon' => trim((string)($roleData['icon'] ?? 'person-badge')),
            'is_system' => false,
            'permissions' => array_values(array_unique((array)($roleData['permissions'] ?? []))),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        foreach ($allCustom as $idx => $cRole) {
            if (strtolower((string)($cRole['slug'] ?? '')) === $slug) {
                $allCustom[$idx] = array_merge($cRole, $newEntry);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $newEntry['created_at'] = date('Y-m-d H:i:s');
            $allCustom[] = $newEntry;
        }

        return StorageService::write('roles', $allCustom);
    }

    /**
     * Delete a custom role (built-in system roles cannot be deleted).
     */
    public static function deleteRole(string $slug): bool
    {
        $cleanSlug = strtolower(trim($slug));
        if (isset(self::$systemRoles[$cleanSlug])) {
            return false; // Cannot delete protected system roles
        }

        $allCustom = StorageService::read('roles', []);
        $filtered = array_values(array_filter($allCustom, function ($r) use ($cleanSlug) {
            return strtolower((string)($r['slug'] ?? '')) !== $cleanSlug;
        }));

        return StorageService::write('roles', $filtered);
    }

    /**
     * Retrieve all modules and their permission slugs.
     */
    public static function getAllModules(): array
    {
        return self::$modules;
    }

    /**
     * Check if a user's multi-role footprint and custom permissions grant access.
     * 
     * Rule 1: Multi-Role union of permissions.
     * Rule 2: Explicit Denials > Grants (Deny > Allow).
     * Rule 3: Direct custom grants allow access even if not in any role.
     * Rule 4: Superadmin role grants all permissions unless explicitly denied.
     */
    public static function hasPermission(array $userOrRoles, string $requiredPermission, ?array $customPermissions = null): bool
    {
        $req = strtolower(trim($requiredPermission));

        // Detect if a full user record array was passed instead of roles array
        if (isset($userOrRoles['roles']) || isset($userOrRoles['username']) || isset($userOrRoles['custom_permissions'])) {
            $userRoles = (array)($userOrRoles['roles'] ?? ['viewer']);
            if ($customPermissions === null && isset($userOrRoles['custom_permissions'])) {
                $customPermissions = (array)$userOrRoles['custom_permissions'];
            }
        } else {
            $userRoles = $userOrRoles;
        }

        // Clean and filter roles array safely
        $cleanRoles = [];
        foreach ($userRoles as $r) {
            if (is_string($r)) {
                $cleanRoles[] = strtolower(trim($r));
            }
        }

        // 1. Check Explicit User-Level Denials (Deny > Allow)
        $denied = array_map('strtolower', (array)($customPermissions['denied'] ?? []));
        if (in_array($req, $denied, true) || in_array('*', $denied, true)) {
            return false;
        }

        // 2. Check Explicit User-Level Grants
        $granted = array_map('strtolower', (array)($customPermissions['granted'] ?? []));
        if (in_array($req, $granted, true) || in_array('*', $granted, true)) {
            return true;
        }

        // 3. Check Active Roles (Union of permissions)
        $allRoles = self::getAllRoles();

        foreach ($cleanRoles as $roleSlug) {
            $role = $allRoles[$roleSlug] ?? null;
            if (!$role) {
                continue;
            }

            $perms = (array)($role['permissions'] ?? []);
            if (in_array('*', $perms, true)) {
                return true; // Superadmin / full access role
            }

            foreach ($perms as $p) {
                if (strtolower(trim((string)$p)) === $req) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Compute comprehensive Multi-Role Effective Permissions breakdown for a user.
     * Returns:
     * - 'effective': array of all granted permission slugs
     * - 'details': [ perm_slug => ['granted' => bool, 'source' => 'Role: CEO' | 'Direct Grant', 'source_type' => 'role'|'grant'|'wildcard'] ]
     * - 'denied': array of explicitly denied permissions
     * - 'role_breakdown': [ role_slug => ['name' => ..., 'permissions' => [...]] ]
     */
    public static function getEffectivePermissions(array $userRoles, ?array $customPermissions = null): array
    {
        $allRoles = self::getAllRoles();
        $cleanRoles = array_map('strtolower', array_map('trim', $userRoles));
        $denied = array_map('strtolower', (array)($customPermissions['denied'] ?? []));
        $granted = array_map('strtolower', (array)($customPermissions['granted'] ?? []));

        $effective = [];
        $details = [];
        $roleBreakdown = [];

        // Collect all available system permissions
        $allKnownPermissions = [];
        foreach (self::$modules as $modKey => $modData) {
            foreach ($modData['permissions'] as $pSlug => $pDesc) {
                $allKnownPermissions[$pSlug] = [
                    'module' => $modKey,
                    'module_title' => $modData['title'],
                    'description' => $pDesc
                ];
            }
        }

        // Map permissions provided by each active role
        foreach ($cleanRoles as $rSlug) {
            if (isset($allRoles[$rSlug])) {
                $role = $allRoles[$rSlug];
                $roleBreakdown[$rSlug] = [
                    'name' => $role['name'],
                    'color' => $role['color'],
                    'permissions' => $role['permissions']
                ];

                $isWildcard = in_array('*', $role['permissions'], true);

                if ($isWildcard) {
                    foreach (array_keys($allKnownPermissions) as $pSlug) {
                        if (!isset($details[$pSlug]) && !in_array($pSlug, $denied, true)) {
                            $effective[] = $pSlug;
                            $details[$pSlug] = [
                                'granted' => true,
                                'source' => $role['name'] . ' (Wildcard *)',
                                'source_type' => 'wildcard',
                                'role_slug' => $rSlug
                            ];
                        }
                    }
                } else {
                    foreach ($role['permissions'] as $pSlug) {
                        $pSlug = strtolower(trim((string)$pSlug));
                        if (!isset($details[$pSlug]) && !in_array($pSlug, $denied, true)) {
                            $effective[] = $pSlug;
                            $details[$pSlug] = [
                                'granted' => true,
                                'source' => $role['name'],
                                'source_type' => 'role',
                                'role_slug' => $rSlug
                            ];
                        }
                    }
                }
            }
        }

        // Direct Grants
        foreach ($granted as $gSlug) {
            if ($gSlug === '*') {
                foreach (array_keys($allKnownPermissions) as $pSlug) {
                    if (!in_array($pSlug, $denied, true)) {
                        $effective[] = $pSlug;
                        $details[$pSlug] = [
                            'granted' => true,
                            'source' => 'Direct Wildcard Grant',
                            'source_type' => 'grant'
                        ];
                    }
                }
            } elseif (!in_array($gSlug, $denied, true)) {
                $effective[] = $gSlug;
                $details[$gSlug] = [
                    'granted' => true,
                    'source' => 'Direct User Grant',
                    'source_type' => 'grant'
                ];
            }
        }

        // De-duplicate
        $effective = array_values(array_unique($effective));

        return [
            'effective' => $effective,
            'details' => $details,
            'denied' => $denied,
            'role_breakdown' => $roleBreakdown,
            'total_possible' => count($allKnownPermissions)
        ];
    }
}
