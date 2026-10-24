<?php
declare(strict_types=1);

namespace CRM\Services;

require_once __DIR__ . '/StorageService.php';
require_once __DIR__ . '/RBACService.php';

/**
 * UserService
 * Manages full user profiling, multi-role assignment, custom permission overrides,
 * password security, and lifecycle management.
 */
class UserService
{
    /**
     * Retrieve all users.
     * 
     * @return array<int, array>
     */
    public static function getAll(): array
    {
        self::seedDefaultUsersIfEmpty();
        $users = StorageService::read('users', []);
        if (!is_array($users)) {
            return [];
        }

        $needsSave = false;
        foreach ($users as &$u) {
            // Normalize legacy single role to roles array
            if (!isset($u['roles']) || !is_array($u['roles']) || empty($u['roles'])) {
                if (!empty($u['role'])) {
                    $u['roles'] = [(string)$u['role']];
                } else {
                    $u['roles'] = ['employee'];
                }
                $needsSave = true;
            }

            // Ensure superadmin has foundational executive roles
            if (($u['username'] ?? '') === 'admin' && count($u['roles']) < 2) {
                $u['roles'] = ['superadmin', 'founder', 'ceo', 'cto'];
                if (empty($u['title']) || $u['title'] === 'Team Member') $u['title'] = 'Chief Executive Officer & Founder';
                if (empty($u['department']) || $u['department'] === 'Operations') $u['department'] = 'Executive Leadership';
                if (empty($u['name']) || $u['name'] === 'CodeX404 Admin') $u['name'] = 'Alex Rivera';
                if (empty($u['phone'])) $u['phone'] = '+1 (415) 555-0140';
                $needsSave = true;
            }

            // Normalize custom_permissions structure
            if (!isset($u['custom_permissions']) || !is_array($u['custom_permissions'])) {
                $u['custom_permissions'] = ['granted' => [], 'denied' => []];
                $needsSave = true;
            } else {
                if (!isset($u['custom_permissions']['granted']) || !is_array($u['custom_permissions']['granted'])) {
                    $u['custom_permissions']['granted'] = [];
                    $needsSave = true;
                }
                if (!isset($u['custom_permissions']['denied']) || !is_array($u['custom_permissions']['denied'])) {
                    $u['custom_permissions']['denied'] = [];
                    $needsSave = true;
                }
            }

            // Ensure profile fields and portal access scopes exist
            $defaults = [
                'phone' => '',
                'title' => 'Team Member',
                'department' => 'Operations',
                'bio' => '',
                'avatar' => '',
                'timezone' => 'America/New_York',
                'currency' => 'USD',
                'status' => 'active',
                'access_scope' => 'crm_only', // 'both' | 'crm_only' | 'admin_only'
                'approval_status' => 'approved', // 'approved' | 'pending_approval' | 'pending_elevation'
                'last_login' => null,
                'last_ip' => null
            ];
            foreach ($defaults as $k => $defVal) {
                if (!isset($u[$k])) {
                    $u[$k] = $defVal;
                    $needsSave = true;
                }
            }

            // Executive roles automatically have full ecosystem clearance ('both')
            $rList = array_map('strtolower', (array)($u['roles'] ?? []));
            if (in_array('superadmin', $rList, true) || in_array('founder', $rList, true) || ($u['username'] ?? '') === 'admin') {
                if (($u['access_scope'] ?? '') !== 'both') {
                    $u['access_scope'] = 'both';
                    $needsSave = true;
                }
            } elseif (in_array('cto', $rList, true) && empty($u['access_scope'])) {
                $u['access_scope'] = 'both';
                $needsSave = true;
            }
        }
        unset($u);

        if ($needsSave) {
            StorageService::write('users', $users);
        }

        return array_values($users);
    }

    /**
     * Find a user by their unique ID.
     */
    public static function getById(string $id): ?array
    {
        $users = self::getAll();
        foreach ($users as $u) {
            if (($u['id'] ?? '') === $id) {
                return $u;
            }
        }
        return null;
    }

    /**
     * Find a user by username or email (case-insensitive).
     */
    public static function getByUsernameOrEmail(string $identifier): ?array
    {
        $clean = strtolower(trim($identifier));
        if ($clean === '') {
            return null;
        }

        $users = self::getAll();
        foreach ($users as $u) {
            $userEmail = strtolower(trim((string)($u['email'] ?? '')));
            $userName = strtolower(trim((string)($u['username'] ?? '')));
            if ($userEmail === $clean || $userName === $clean) {
                return $u;
            }
        }

        return null;
    }

    /**
     * Create a new user with full profiling, portal access scoping, and multi-role assignments.
     * Evaluates delegation authority if an actor is provided.
     * 
     * @param array $data Inbound user attributes
     * @param array|null $actor Active session profile of the user provisioning this account
     * @return array Created user array or approval required response
     */
    public static function create(array $data, ?array $actor = null): array
    {
        $users = self::getAll();

        $email = strtolower(trim((string)($data['email'] ?? '')));
        $username = strtolower(trim((string)($data['username'] ?? '')));
        $name = trim((string)($data['name'] ?? ''));
        $plainPassword = (string)($data['password'] ?? 'admin@1234');

        if ($email === '' || $name === '') {
            throw new \InvalidArgumentException('Full Name and Email are required.');
        }

        if ($username === '') {
            $username = explode('@', $email)[0];
        }

        // Validate uniqueness
        foreach ($users as $existing) {
            if (strtolower((string)($existing['email'] ?? '')) === $email) {
                throw new \InvalidArgumentException("Email '{$email}' is already registered.");
            }
            if (!empty($existing['username']) && strtolower((string)$existing['username']) === $username) {
                throw new \InvalidArgumentException("Username '{$username}' is already taken.");
            }
        }

        // Process Multi-Roles
        $roles = (array)($data['roles'] ?? ['viewer']);
        $roles = array_values(array_unique(array_filter(array_map('strtolower', array_map('trim', $roles)))));
        if (empty($roles)) {
            $roles = ['viewer'];
        }

        // Portal Access Scope ('both' | 'crm_only' | 'admin_only')
        $accessScope = strtolower(trim((string)($data['access_scope'] ?? 'crm_only')));
        if (!in_array($accessScope, ['both', 'crm_only', 'admin_only'], true)) {
            $accessScope = 'crm_only';
        }

        // Custom Permissions (Direct Grants & Explicit Denials)
        $customPerms = [
            'granted' => array_values(array_unique((array)($data['custom_permissions']['granted'] ?? []))),
            'denied' => array_values(array_unique((array)($data['custom_permissions']['denied'] ?? [])))
        ];

        // Actor-Based Delegation & Authority Verification Gate
        if ($actor !== null) {
            $actorRoles = (array)($actor['roles'] ?? []);
            $actorPerms = (array)($actor['custom_permissions'] ?? null);

            if (!RBACService::hasPermission($actorRoles, 'users.create', $actorPerms)) {
                throw new \RuntimeException('Permission denied: You do not have authority to create workforce accounts.');
            }

            $eval = RBACService::evaluateDelegationAuthority($actorRoles, $roles, $accessScope, $customPerms['granted']);
            if ($eval['status'] === 'denied') {
                throw new \RuntimeException('Delegation denied: ' . implode(' ', $eval['reasons']));
            }

            if ($eval['status'] === 'approval_required') {
                // High-authority approval required! Route to ApprovalService HITL gate
                require_once __DIR__ . '/ApprovalService.php';
                $approval = ApprovalService::submit(
                    'user_provisioning_elevation',
                    "Elevated Account Provisioning: {$name} (@{$username}) [Scope: {$accessScope}]",
                    [
                        'user_data' => array_merge($data, [
                            'name' => $name,
                            'username' => $username,
                            'email' => $email,
                            'roles' => $roles,
                            'access_scope' => $accessScope,
                            'custom_permissions' => $customPerms,
                            'password' => $plainPassword
                        ]),
                        'target_roles' => $roles,
                        'target_scope' => $accessScope,
                        'reasons' => $eval['reasons'],
                        'requested_by_id' => $actor['id'] ?? '',
                        'requested_by_name' => $actor['name'] ?? 'Team Manager'
                    ],
                    $actor['name'] ?? 'Team Manager'
                );

                return [
                    'approval_required' => true,
                    'approval_id' => $approval['id'],
                    'reasons' => $eval['reasons'],
                    'name' => $name,
                    'username' => $username,
                    'roles' => $roles,
                    'access_scope' => $accessScope
                ];
            }
        }

        $newUser = [
            'id' => 'usr_' . bin2hex(random_bytes(8)),
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'phone' => trim((string)($data['phone'] ?? '')),
            'title' => trim((string)($data['title'] ?? 'Team Member')),
            'department' => trim((string)($data['department'] ?? 'General')),
            'bio' => trim((string)($data['bio'] ?? '')),
            'avatar' => trim((string)($data['avatar'] ?? '')),
            'password_hash' => password_hash($plainPassword, PASSWORD_DEFAULT),
            'roles' => $roles,
            'access_scope' => $accessScope,
            'custom_permissions' => $customPerms,
            'status' => in_array($data['status'] ?? 'active', ['active', 'inactive', 'suspended'], true) ? $data['status'] : 'active',
            'approval_status' => 'approved',
            'timezone' => trim((string)($data['timezone'] ?? 'UTC')),
            'currency' => trim((string)($data['currency'] ?? 'USD')),
            'last_login' => null,
            'last_ip' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $users[] = $newUser;
        StorageService::write('users', $users);

        return $newUser;
    }

    /**
     * Update an existing user's profile, portal clearance, and multi-role configuration.
     * Enforces delegation tier limits and routes privileged escalations to HITL approval.
     */
    public static function update(string $id, array $data, ?array $actor = null): ?array
    {
        $users = self::getAll();
        $targetIndex = null;

        foreach ($users as $idx => $u) {
            if (($u['id'] ?? '') === $id) {
                $targetIndex = $idx;
                break;
            }
        }

        if ($targetIndex === null) {
            return null;
        }

        $user = $users[$targetIndex];

        // Validate uniqueness if email/username changed
        if (isset($data['email'])) {
            $newEmail = strtolower(trim((string)$data['email']));
            if ($newEmail === '') {
                throw new \InvalidArgumentException('Email cannot be empty.');
            }
            foreach ($users as $idx => $u) {
                if ($idx !== $targetIndex && strtolower((string)($u['email'] ?? '')) === $newEmail) {
                    throw new \InvalidArgumentException("Email '{$newEmail}' is already in use by another user.");
                }
            }
            $user['email'] = $newEmail;
        }

        if (isset($data['username'])) {
            $newUsername = strtolower(trim((string)$data['username']));
            if ($newUsername !== '') {
                foreach ($users as $idx => $u) {
                    if ($idx !== $targetIndex && strtolower((string)($u['username'] ?? '')) === $newUsername) {
                        throw new \InvalidArgumentException("Username '{$newUsername}' is already taken.");
                    }
                }
                $user['username'] = $newUsername;
            }
        }

        // Apply safe profile telemetry
        if (isset($data['name'])) {
            $user['name'] = trim((string)$data['name']);
        }
        if (isset($data['phone'])) {
            $user['phone'] = trim((string)$data['phone']);
        }
        if (isset($data['title'])) {
            $user['title'] = trim((string)$data['title']);
        }
        if (isset($data['department'])) {
            $user['department'] = trim((string)$data['department']);
        }
        if (isset($data['bio'])) {
            $user['bio'] = trim((string)$data['bio']);
        }
        if (isset($data['avatar'])) {
            $user['avatar'] = trim((string)$data['avatar']);
        }
        if (isset($data['timezone'])) {
            $user['timezone'] = trim((string)$data['timezone']);
        }
        if (isset($data['currency'])) {
            $user['currency'] = trim((string)$data['currency']);
        }
        if (isset($data['status']) && in_array($data['status'], ['active', 'inactive', 'suspended'], true)) {
            $user['status'] = $data['status'];
        }

        // Target portal scope and roles
        $targetScope = isset($data['access_scope'])
            ? (in_array($data['access_scope'], ['both', 'crm_only', 'admin_only'], true) ? $data['access_scope'] : ($user['access_scope'] ?? 'crm_only'))
            : ($user['access_scope'] ?? 'crm_only');

        $targetRoles = isset($data['roles']) && is_array($data['roles'])
            ? array_values(array_unique(array_filter(array_map('strtolower', array_map('trim', $data['roles'])))))
            : ($user['roles'] ?? ['viewer']);

        $targetCustomPerms = isset($data['custom_permissions']) && is_array($data['custom_permissions'])
            ? [
                'granted' => array_values(array_unique((array)($data['custom_permissions']['granted'] ?? []))),
                'denied' => array_values(array_unique((array)($data['custom_permissions']['denied'] ?? [])))
            ]
            : ($user['custom_permissions'] ?? ['granted' => [], 'denied' => []]);

        // Actor delegation check if privileged settings were modified
        if ($actor !== null) {
            $actorRoles = (array)($actor['roles'] ?? []);
            $actorPerms = (array)($actor['custom_permissions'] ?? null);

            if (!RBACService::hasPermission($actorRoles, 'users.edit', $actorPerms)) {
                throw new \RuntimeException('Permission denied: You do not have authority to edit workforce profiles.');
            }

            $rolesChanged = ($targetRoles != ($user['roles'] ?? []));
            $scopeChanged = ($targetScope !== ($user['access_scope'] ?? 'crm_only'));
            $permsChanged = ($targetCustomPerms['granted'] != ($user['custom_permissions']['granted'] ?? []));

            if ($rolesChanged || $scopeChanged || $permsChanged) {
                $eval = RBACService::evaluateDelegationAuthority($actorRoles, $targetRoles, $targetScope, $targetCustomPerms['granted']);
                if ($eval['status'] === 'denied') {
                    throw new \RuntimeException('Delegation denied: ' . implode(' ', $eval['reasons']));
                }

                if ($eval['status'] === 'approval_required') {
                    // Update safe profile attributes immediately, stage privilege elevation in approval queue
                    $user['approval_status'] = 'pending_elevation';
                    $user['updated_at'] = date('Y-m-d H:i:s');
                    $users[$targetIndex] = $user;
                    StorageService::write('users', $users);

                    require_once __DIR__ . '/ApprovalService.php';
                    $approval = ApprovalService::submit(
                        'privilege_elevation',
                        "Privilege Escalation Request: {$user['name']} (@{$user['username']})",
                        [
                            'user_id' => $id,
                            'target_name' => $user['name'],
                            'target_username' => $user['username'],
                            'current_roles' => $user['roles'] ?? [],
                            'requested_roles' => $targetRoles,
                            'current_scope' => $user['access_scope'] ?? 'crm_only',
                            'requested_scope' => $targetScope,
                            'current_permissions' => $user['custom_permissions'] ?? [],
                            'requested_permissions' => $targetCustomPerms,
                            'reasons' => $eval['reasons'],
                            'requested_by_id' => $actor['id'] ?? '',
                            'requested_by_name' => $actor['name'] ?? 'Team Manager'
                        ],
                        $actor['name'] ?? 'Team Manager'
                    );

                    return [
                        'approval_required' => true,
                        'approval_id' => $approval['id'],
                        'reasons' => $eval['reasons'],
                        'user' => $user
                    ];
                }
            }
        }

        // Apply privileged updates directly if authorized
        $user['roles'] = $targetRoles;
        $user['access_scope'] = $targetScope;
        $user['custom_permissions'] = $targetCustomPerms;
        $user['approval_status'] = 'approved';
        $user['updated_at'] = date('Y-m-d H:i:s');
        $users[$targetIndex] = $user;

        StorageService::write('users', $users);

        return $user;
    }

    /**
     * Apply approved privilege escalation (executed by ApprovalService upon founder sign-off).
     */
    public static function applyElevatedPrivileges(string $userId, array $payload): bool
    {
        $users = self::getAll();
        foreach ($users as $idx => $u) {
            if (($u['id'] ?? '') === $userId) {
                if (!empty($payload['requested_roles'])) {
                    $users[$idx]['roles'] = (array)$payload['requested_roles'];
                }
                if (!empty($payload['requested_scope'])) {
                    $users[$idx]['access_scope'] = (string)$payload['requested_scope'];
                }
                if (isset($payload['requested_permissions'])) {
                    $users[$idx]['custom_permissions'] = (array)$payload['requested_permissions'];
                }
                $users[$idx]['approval_status'] = 'approved';
                $users[$idx]['updated_at'] = date('Y-m-d H:i:s');
                return StorageService::write('users', $users);
            }
        }
        return false;
    }

    /**
     * Apply approved user creation (executed by ApprovalService upon founder sign-off).
     */
    public static function applyApprovedUserCreation(array $userData): array
    {
        return self::create($userData, null);
    }

    /**
     * Change user password.
     */
    public static function updatePassword(string $id, string $newPassword): bool
    {
        if (strlen($newPassword) < 8) {
            throw new \InvalidArgumentException('Password must be at least 8 characters long.');
        }

        $users = self::getAll();
        foreach ($users as $idx => $u) {
            if (($u['id'] ?? '') === $id) {
                $users[$idx]['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
                $users[$idx]['updated_at'] = date('Y-m-d H:i:s');
                return StorageService::write('users', $users);
            }
        }

        return false;
    }

    /**
     * Record a successful user login with timestamp and IP.
     */
    public static function recordLogin(string $id, ?string $ip = null): void
    {
        $users = self::getAll();
        foreach ($users as $idx => $u) {
            if (($u['id'] ?? '') === $id) {
                $users[$idx]['last_login'] = date('Y-m-d H:i:s');
                $users[$idx]['last_ip'] = $ip ?? ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
                StorageService::write('users', $users);
                break;
            }
        }
    }

    /**
     * Delete a user account (with safeguards against self-deletion and orphan lockout).
     */
    public static function delete(string $id, ?string $currentUserId = null): bool
    {
        if ($currentUserId !== null && $id === $currentUserId) {
            throw new \RuntimeException('You cannot delete your own currently active account.');
        }

        $users = self::getAll();
        $targetUser = null;
        $superadminCount = 0;

        foreach ($users as $u) {
            if (($u['id'] ?? '') === $id) {
                $targetUser = $u;
            }
            if (in_array('superadmin', (array)($u['roles'] ?? []), true) && ($u['status'] ?? 'active') === 'active') {
                $superadminCount++;
            }
        }

        if (!$targetUser) {
            return false;
        }

        if (in_array('superadmin', (array)($targetUser['roles'] ?? []), true) && $superadminCount <= 1) {
            throw new \RuntimeException('Cannot delete the last remaining Super Administrator account.');
        }

        $filtered = array_values(array_filter($users, fn($u) => ($u['id'] ?? '') !== $id));
        return StorageService::write('users', $filtered);
    }

    /**
     * Generate an initial avatar color and initials for presentation.
     */
    public static function getAvatarInfo(array $user): array
    {
        $name = trim((string)($user['name'] ?? 'User'));
        $parts = preg_split('/\s+/', $name) ?: [];
        $initials = '';

        if (count($parts) >= 2) {
            $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        } elseif (count($parts) === 1 && strlen($parts[0]) > 0) {
            $initials = strtoupper(substr($parts[0], 0, 2));
        } else {
            $initials = 'CX';
        }

        $colors = [
            ['bg' => 'linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%)', 'text' => '#FFFFFF'],
            ['bg' => 'linear-gradient(135deg, #8B5CF6 0%, #6366F1 100%)', 'text' => '#FFFFFF'],
            ['bg' => 'linear-gradient(135deg, #10B981 0%, #059669 100%)', 'text' => '#FFFFFF'],
            ['bg' => 'linear-gradient(135deg, #F59E0B 0%, #D97706 100%)', 'text' => '#FFFFFF'],
            ['bg' => 'linear-gradient(135deg, #EC4899 0%, #DB2777 100%)', 'text' => '#FFFFFF'],
            ['bg' => 'linear-gradient(135deg, #06B6D4 0%, #0891B2 100%)', 'text' => '#FFFFFF'],
            ['bg' => 'linear-gradient(135deg, #F43F5E 0%, #E11D48 100%)', 'text' => '#FFFFFF']
        ];

        $idx = abs(crc32($user['email'] ?? $name)) % count($colors);
        return [
            'initials' => $initials,
            'background' => $colors[$idx]['bg'],
            'color' => $colors[$idx]['text']
        ];
    }

    /**
     * Seed initial workforce accounts if user store is completely uninitialized.
     */
    public static function seedDefaultUsersIfEmpty(): void
    {
        $existing = StorageService::read('users', []);
        if (!is_array($existing)) {
            $existing = [];
        }

        // Universal initial password: admin@1234
        $hash = '$2y$10$Yv8Ajnfiz8az97yFdzqsNu4UGR4SNUMp09M1BNYfl0vDt4Yjn1Boi';

        $initialUsers = [
            [
                'id' => 'usr_admin_alex',
                'username' => 'admin',
                'name' => 'Alex Rivera',
                'email' => 'admin@codex404solutions.online',
                'phone' => '+1 (415) 555-0140',
                'title' => 'Chief Executive Officer & Founder',
                'department' => 'Executive Leadership',
                'bio' => 'Founder & Principal Systems Architect at CodeX404 Solutions. Overseeing business strategy, technical execution, and client deliveries.',
                'avatar' => '',
                'password_hash' => $hash,
                'roles' => ['superadmin', 'founder', 'ceo', 'cto'],
                'access_scope' => 'both',
                'approval_status' => 'approved',
                'custom_permissions' => ['granted' => [], 'denied' => []],
                'status' => 'active',
                'timezone' => 'America/New_York',
                'currency' => 'USD',
                'last_login' => date('Y-m-d H:i:s', strtotime('-15 mins')),
                'last_ip' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days')),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 'usr_tech_elena',
                'username' => 'elena.tech',
                'name' => 'Elena Rostova',
                'email' => 'elena@codex404solutions.online',
                'phone' => '+49 30 555-0188',
                'title' => 'VP of Engineering & Delivery Lead',
                'department' => 'Engineering',
                'bio' => 'Directing system architecture, engineering milestone velocity, code reviews, and technical project management.',
                'avatar' => '',
                'password_hash' => $hash,
                'roles' => ['cto', 'lead_developer', 'project_manager'],
                'access_scope' => 'both',
                'approval_status' => 'approved',
                'custom_permissions' => ['granted' => [], 'denied' => []],
                'status' => 'active',
                'timezone' => 'Europe/Berlin',
                'currency' => 'EUR',
                'last_login' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'last_ip' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 'usr_sales_marcus',
                'username' => 'marcus.sales',
                'name' => 'Marcus Vance',
                'email' => 'marcus@codex404solutions.online',
                'phone' => '+44 20 7946 0192',
                'title' => 'Head of Business Development & Sales Manager',
                'department' => 'Revenue & Growth',
                'bio' => 'Leading high-ticket enterprise client acquisitions, discovery calls, scoping proposals, and pipeline progression.',
                'avatar' => '',
                'password_hash' => $hash,
                'roles' => ['sales_manager', 'sales', 'bd'],
                'access_scope' => 'crm_only',
                'approval_status' => 'approved',
                'custom_permissions' => ['granted' => [], 'denied' => []],
                'status' => 'active',
                'timezone' => 'Europe/London',
                'currency' => 'GBP',
                'last_login' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'last_ip' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days')),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 'usr_ai_sophia',
                'username' => 'sophia.ai',
                'name' => 'Dr. Sophia Chen',
                'email' => 'sophia@codex404solutions.online',
                'phone' => '+1 (617) 555-0199',
                'title' => 'Lead AI & Autonomous Systems Engineer',
                'department' => 'AI & Paperclip Automation',
                'bio' => 'Engineering Paperclip multi-agent orchestrations, model benchmark routines, and autonomous data pipelines.',
                'avatar' => '',
                'password_hash' => $hash,
                'roles' => ['ai_engineer', 'developer'],
                'access_scope' => 'crm_only',
                'approval_status' => 'approved',
                'custom_permissions' => ['granted' => ['approvals.view'], 'denied' => []],
                'status' => 'active',
                'timezone' => 'America/Los_Angeles',
                'currency' => 'USD',
                'last_login' => date('Y-m-d H:i:s', strtotime('-4 hours')),
                'last_ip' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s', strtotime('-18 days')),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        if (empty($existing)) {
            StorageService::write('users', $initialUsers);
            return;
        }

        $existingUsernames = array_map(fn($u) => strtolower(trim((string)($u['username'] ?? ''))), $existing);
        $dirty = false;

        foreach ($initialUsers as $initUser) {
            if (!in_array(strtolower($initUser['username']), $existingUsernames, true)) {
                $existing[] = $initUser;
                $dirty = true;
            }
        }

        if ($dirty) {
            StorageService::write('users', $existing);
        }
    }
}
