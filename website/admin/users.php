<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Portal: Workforce Directory & Multi-Role RBAC Management
 */

require_once __DIR__ . '/auth.php';
require_admin_auth();

use CRM\Services\RBACService;
use CRM\Services\UserService;

$currentPage = 'users';
$pageTitle = 'Workforce Directory & Multi-Role RBAC';
$pageSubtitle = 'Provision enterprise accounts, assign concurrent roles, manage granular permissions, and inspect authorization footprints';

// Handle POST Mutations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        set_admin_flash('error', 'Security token expired. Please try again.');
        header('Location: ' . admin_url('users'));
        exit;
    }

    $action = $_POST['action'] ?? '';
    $currentAdmin = current_admin_profile();
    $currentUserId = $currentAdmin['id'] ?? '';

    switch ($action) {
        case 'create_user':
            try {
                $grantedPerms = isset($_POST['custom_granted']) && is_array($_POST['custom_granted']) ? $_POST['custom_granted'] : [];
                $deniedPerms = isset($_POST['custom_denied']) && is_array($_POST['custom_denied']) ? $_POST['custom_denied'] : [];
                $userAssignedRoles = isset($_POST['roles']) && is_array($_POST['roles']) ? $_POST['roles'] : ['viewer'];
                $accessScope = trim((string)($_POST['access_scope'] ?? 'crm_only'));

                $newUser = UserService::create([
                    'name' => trim((string)($_POST['name'] ?? '')),
                    'username' => trim((string)($_POST['username'] ?? '')),
                    'email' => trim((string)($_POST['email'] ?? '')),
                    'phone' => trim((string)($_POST['phone'] ?? '')),
                    'title' => trim((string)($_POST['title'] ?? 'Staff Member')),
                    'department' => trim((string)($_POST['department'] ?? 'Operations')),
                    'bio' => trim((string)($_POST['bio'] ?? '')),
                    'password' => (string)($_POST['password'] ?? 'admin@1234'),
                    'status' => trim((string)($_POST['status'] ?? 'active')),
                    'access_scope' => $accessScope,
                    'roles' => $userAssignedRoles,
                    'custom_permissions' => [
                        'granted' => $grantedPerms,
                        'denied' => $deniedPerms
                    ]
                ], $currentAdmin);

                if (!empty($newUser['approval_required'])) {
                    set_admin_flash('warning', "🛡️ Privilege Escalation Notice: Account provisioning for '{$newUser['name']}' requires Founder / Superadmin sign-off. Request has been routed to the Executive HITL Queue.");
                } else {
                    $scopeTitle = $newUser['access_scope'] === 'both' ? 'Both Admin & CRM' : ($newUser['access_scope'] === 'admin_only' ? 'Website Admin Only' : 'CRM Only');
                    set_admin_flash('success', "Workforce account for '{$newUser['name']}' (@{$newUser['username']}) created with clearance [{$scopeTitle}] and " . count($newUser['roles']) . " active multi-roles!");
                }
            } catch (\Throwable $e) {
                set_admin_flash('error', 'Failed to create user: ' . $e->getMessage());
            }
            break;

        case 'update_user':
            $targetId = trim((string)($_POST['user_id'] ?? ''));
            try {
                $grantedPerms = isset($_POST['custom_granted']) && is_array($_POST['custom_granted']) ? $_POST['custom_granted'] : [];
                $deniedPerms = isset($_POST['custom_denied']) && is_array($_POST['custom_denied']) ? $_POST['custom_denied'] : [];
                $userAssignedRoles = isset($_POST['roles']) && is_array($_POST['roles']) ? $_POST['roles'] : null;
                $accessScope = isset($_POST['access_scope']) ? trim((string)$_POST['access_scope']) : null;

                $updatePayload = [
                    'name' => trim((string)($_POST['name'] ?? '')),
                    'username' => trim((string)($_POST['username'] ?? '')),
                    'email' => trim((string)($_POST['email'] ?? '')),
                    'phone' => trim((string)($_POST['phone'] ?? '')),
                    'title' => trim((string)($_POST['title'] ?? '')),
                    'department' => trim((string)($_POST['department'] ?? '')),
                    'bio' => trim((string)($_POST['bio'] ?? '')),
                    'status' => trim((string)($_POST['status'] ?? 'active')),
                    'custom_permissions' => [
                        'granted' => $grantedPerms,
                        'denied' => $deniedPerms
                    ]
                ];

                if ($userAssignedRoles !== null) {
                    $updatePayload['roles'] = $userAssignedRoles;
                }
                if ($accessScope !== null) {
                    $updatePayload['access_scope'] = $accessScope;
                }

                $updated = UserService::update($targetId, $updatePayload, $currentAdmin);

                if (!empty($updated['approval_required'])) {
                    set_admin_flash('warning', "🛡️ Privilege Escalation Notice: Elevated roles or portal access changes for '{$updated['user']['name']}' require Founder / Superadmin sign-off. Request has been routed to the Executive HITL Queue.");
                } elseif ($updated) {
                    if ($targetId === $currentUserId) {
                        $_SESSION['codex_admin_profile'] = $updated;
                    }
                    set_admin_flash('success', "Profile & Multi-Role settings for '{$updated['name']}' updated successfully.");
                } else {
                    set_admin_flash('error', 'Target user account not found.');
                }
            } catch (\Throwable $e) {
                set_admin_flash('error', 'Update error: ' . $e->getMessage());
            }
            break;

        case 'change_user_password':
            $targetId = trim((string)($_POST['user_id'] ?? ''));
            $newPass = (string)($_POST['new_password'] ?? '');
            try {
                if (UserService::updatePassword($targetId, $newPass)) {
                    set_admin_flash('success', 'User password updated successfully.');
                } else {
                    set_admin_flash('error', 'Failed to update user password.');
                }
            } catch (\Throwable $e) {
                set_admin_flash('error', $e->getMessage());
            }
            break;

        case 'delete_user':
            $targetId = trim((string)($_POST['user_id'] ?? ''));
            try {
                if (UserService::delete($targetId, $currentUserId)) {
                    set_admin_flash('success', 'User account permanently removed.');
                } else {
                    set_admin_flash('error', 'Could not delete user.');
                }
            } catch (\Throwable $e) {
                set_admin_flash('error', $e->getMessage());
            }
            break;

        case 'save_role':
            $slug = strtolower(trim((string)($_POST['slug'] ?? '')));
            $name = trim((string)($_POST['name'] ?? ''));
            $desc = trim((string)($_POST['description'] ?? ''));
            $color = trim((string)($_POST['color'] ?? 'info'));
            $perms = isset($_POST['permissions']) && is_array($_POST['permissions']) ? $_POST['permissions'] : [];

            if ($slug === '' || $name === '') {
                set_admin_flash('error', 'Role Slug and Name are required.');
                break;
            }

            RBACService::saveRole([
                'slug' => $slug,
                'name' => $name,
                'description' => $desc,
                'color' => $color,
                'permissions' => $perms
            ]);
            set_admin_flash('success', "Custom Role '{$name}' configured with " . count($perms) . " permissions.");
            break;

        case 'delete_role':
            $slug = trim((string)($_POST['slug'] ?? ''));
            if (RBACService::deleteRole($slug)) {
                set_admin_flash('success', "Role '{$slug}' deleted.");
            } else {
                set_admin_flash('error', 'Protected system roles cannot be deleted.');
            }
            break;
    }

    header('Location: ' . admin_url('users'));
    exit;
}

$allUsers = UserService::getAll();
$allRoles = RBACService::getAllRoles();
$allModules = RBACService::getAllModules();
$multiRoleCount = count(array_filter($allUsers, fn($u) => count((array)($u['roles'] ?? [])) > 1));
$totalPermissionsCount = 0;
foreach ($allModules as $mod) {
    $totalPermissionsCount += count($mod['permissions']);
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Flash message container -->
<?php $flash = get_admin_flash(); if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : htmlspecialchars($flash['type']) ?> alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <div><?= htmlspecialchars($flash['message']) ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- ======================================================== -->
<!-- 1. EXECUTIVE KPI SUMMARY TILES                           -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Workforce Total</span>
                <div class="p-2 rounded bg-info-subtle text-info"><i class="bi bi-people-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-white mb-1"><?= count($allUsers) ?></div>
            <div class="small text-muted"><span class="text-success"><i class="bi bi-check-circle me-1"></i>Synchronized</span> across CRM &amp; Admin</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Multi-Role Users</span>
                <div class="p-2 rounded bg-primary-subtle text-primary"><i class="bi bi-diagram-3-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-primary mb-1"><?= $multiRoleCount ?></div>
            <div class="small text-muted"><span class="text-info"><?= round(($multiRoleCount / max(1, count($allUsers))) * 100) ?>%</span> holding multiple roles</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Defined Roles</span>
                <div class="p-2 rounded bg-warning-subtle text-warning"><i class="bi bi-shield-lock-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-warning mb-1"><?= count($allRoles) ?></div>
            <div class="small text-muted">21 standard roles &bull; Custom extensible</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">System Permissions</span>
                <div class="p-2 rounded bg-success-subtle text-success"><i class="bi bi-key-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-success mb-1"><?= $totalPermissionsCount ?></div>
            <div class="small text-muted">Across 9 functional modules</div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. MAIN TABS & ACTION BUTTONS                            -->
<!-- ======================================================== -->
<div class="p-4 rounded-3 mb-4" style="background: rgba(11, 15, 25, 0.7); border: 1px solid rgba(56, 189, 248, 0.16);">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <ul class="nav nav-pills" id="adminUsersTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="tab-users-btn" data-bs-toggle="pill" data-bs-target="#admin-tab-users" type="button" role="tab">
                    <i class="bi bi-people me-2"></i>Workforce Directory
                    <span class="badge bg-secondary-subtle text-muted ms-2"><?= count($allUsers) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="tab-roles-btn" data-bs-toggle="pill" data-bs-target="#admin-tab-roles" type="button" role="tab">
                    <i class="bi bi-shield-check me-2"></i>Multi-Role Catalog &amp; Matrix
                    <span class="badge bg-secondary-subtle text-muted ms-2"><?= count($allRoles) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="tab-perms-btn" data-bs-toggle="pill" data-bs-target="#admin-tab-perms" type="button" role="tab">
                    <i class="bi bi-key me-2"></i>Permissions Directory (<?= $totalPermissionsCount ?>)
                </button>
            </li>
        </ul>

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-info btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalAdminNewRole">
                <i class="bi bi-plus-circle me-1"></i> New Custom Role
            </button>
            <button class="btn btn-info btn-sm fw-bold text-dark px-3" data-bs-toggle="modal" data-bs-target="#modalAdminNewUser">
                <i class="bi bi-person-plus-fill me-1"></i> Provision New User
            </button>
        </div>
    </div>

    <div class="tab-content" id="adminUsersTabContent">
        <!-- ======================================================== -->
        <!-- TAB 1: WORKFORCE DIRECTORY                               -->
        <!-- ======================================================== -->
        <div class="tab-pane fade show active" id="admin-tab-users" role="tabpanel">
            <!-- Search & Filters -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="adminUserSearch" placeholder="Search by name, @handle, or email...">
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select class="form-select" id="adminScopeFilter">
                        <option value="all">All Clearance Scopes</option>
                        <option value="both">Dual Clearance (Both)</option>
                        <option value="admin_only">Website Admin Only</option>
                        <option value="crm_only">CRM Only</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select class="form-select" id="adminRoleFilter">
                        <option value="all">All Assigned Roles</option>
                        <?php foreach ($allRoles as $rSlug => $rData): ?>
                            <option value="<?= htmlspecialchars($rSlug) ?>"><?= htmlspecialchars($rData['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select class="form-select" id="adminStatusFilter">
                        <option value="all">All Statuses</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div class="col-6 col-md-2 d-flex justify-content-end align-items-center">
                    <span class="small text-muted" id="adminUserCountText">Showing <?= count($allUsers) ?> members</span>
                </div>
            </div>

            <!-- User Cards Grid -->
            <div class="row g-3" id="adminUsersGrid">
                <?php foreach ($allUsers as $u): 
                    $uRoles = (array)($u['roles'] ?? ['viewer']);
                    $uEffective = RBACService::getEffectivePermissions($uRoles, (array)($u['custom_permissions'] ?? null));
                    $avatar = UserService::getAvatarInfo($u);
                    $status = $u['status'] ?? 'active';
                    $isAdminSelf = ($u['id'] ?? '') === ($currentAdmin['id'] ?? '');
                    $scope = $u['access_scope'] ?? 'crm_only';
                    $tier = RBACService::getAuthorityTier($uRoles);
                    $isPendingApproval = ($u['approval_status'] ?? 'approved') !== 'approved';
                ?>
                    <div class="col-12 col-lg-6 admin-user-card-col"
                         data-name="<?= htmlspecialchars(strtolower($u['name'] ?? '')) ?>"
                         data-username="<?= htmlspecialchars(strtolower($u['username'] ?? '')) ?>"
                         data-email="<?= htmlspecialchars(strtolower($u['email'] ?? '')) ?>"
                         data-roles="<?= htmlspecialchars(strtolower(implode(' ', $uRoles))) ?>"
                         data-scope="<?= htmlspecialchars($scope) ?>"
                         data-status="<?= htmlspecialchars($status) ?>">
                        
                        <div class="p-3 rounded-3 h-100 position-relative" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.16);">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="position-relative">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                             style="width: 46px; height: 46px; background: <?= $avatar['background'] ?>; color: <?= $avatar['color'] ?>; font-size: 1rem;">
                                            <?= htmlspecialchars($avatar['initials']) ?>
                                        </div>
                                        <span class="position-absolute bottom-0 end-0 p-1 rounded-circle border border-dark"
                                              style="width: 12px; height: 12px; background: <?= $status === 'active' ? '#10B981' : ($status === 'suspended' ? '#EF4444' : '#6B7280') ?>;"
                                              title="Status: <?= htmlspecialchars(ucfirst($status)) ?>"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="fw-bold text-white mb-0"><?= htmlspecialchars($u['name'] ?? 'Unnamed') ?></h6>
                                            <?php if ($isAdminSelf): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.6rem;">You</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="small mono text-info" style="font-size: 0.78rem;">@<?= htmlspecialchars($u['username'] ?? 'user') ?></div>
                                        <div class="small text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($u['email'] ?? '') ?></div>
                                    </div>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary px-2 py-1" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <button class="dropdown-item btn-admin-view-profile" type="button" data-user='<?= htmlspecialchars(json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                                <i class="bi bi-person-badge text-info me-2"></i> View Full Profile
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item btn-admin-edit-user" type="button" data-user='<?= htmlspecialchars(json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                                <i class="bi bi-pencil-square text-warning me-2"></i> Edit User &amp; Roles
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item btn-admin-reset-pass" type="button" data-id="<?= htmlspecialchars($u['id']) ?>" data-name="<?= htmlspecialchars($u['name']) ?>">
                                                <i class="bi bi-key text-primary me-2"></i> Reset Password
                                            </button>
                                        </li>
                                        <?php if (!$isAdminSelf): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger btn-admin-delete-user" type="button" data-id="<?= htmlspecialchars($u['id']) ?>" data-name="<?= htmlspecialchars($u['name']) ?>">
                                                    <i class="bi bi-trash me-2"></i> Delete User
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Title, Department & Clearance Badges -->
                            <div class="mb-2 d-flex align-items-center gap-1.5 flex-wrap">
                                <!-- Portal Clearance Badge -->
                                <?php if ($scope === 'both'): ?>
                                    <span class="badge text-white" style="background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); font-size: 0.68rem;" title="Dual Clearance: Website Admin & CRM Portal">
                                        <i class="bi bi-shield-lock-fill me-1"></i>Both Portals
                                    </span>
                                <?php elseif ($scope === 'admin_only'): ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.68rem;" title="Admin Portal Only Clearance">
                                        <i class="bi bi-globe me-1"></i>Admin Only
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.68rem;" title="CRM Portal Only Clearance">
                                        <i class="bi bi-person-workspace me-1"></i>CRM Only
                                    </span>
                                <?php endif; ?>

                                <!-- Delegation Authority Tier Badge -->
                                <?php if ($tier === 1): ?>
                                    <span class="badge text-white" style="background: linear-gradient(135deg, #EF4444 0%, #F59E0B 100%); font-size: 0.68rem;" title="Supreme Delegation: Direct assignment & full overrides">
                                        <i class="bi bi-award-fill me-1"></i>Tier 1: Supreme
                                    </span>
                                <?php elseif ($tier === 2): ?>
                                    <span class="badge text-white" style="background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%); font-size: 0.68rem;" title="Management Delegation: Can provision standard staff, high-privilege requires approval">
                                        <i class="bi bi-person-fill-gear me-1"></i>Tier 2: Mgmt
                                    </span>
                                <?php else: ?>
                                    <span class="badge text-secondary border border-secondary" style="font-size: 0.68rem;" title="Standard Workforce: Read-only governance">
                                        <i class="bi bi-person me-1"></i>Tier 3: Staff
                                    </span>
                                <?php endif; ?>

                                <?php if ($isPendingApproval): ?>
                                    <span class="badge bg-warning text-dark border border-warning" style="font-size: 0.68rem;" title="Elevation Pending Approval">
                                        <i class="bi bi-hourglass-split me-1"></i>Pending Approval
                                    </span>
                                <?php endif; ?>

                                <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.68rem;">
                                    <i class="bi bi-briefcase me-1"></i><?= htmlspecialchars($u['title'] ?? 'Staff') ?>
                                </span>
                                <span class="badge bg-dark border border-secondary text-info" style="font-size: 0.68rem;">
                                    <i class="bi bi-building me-1"></i><?= htmlspecialchars($u['department'] ?? 'General') ?>
                                </span>
                            </div>

                            <!-- Multi-Role Badges -->
                            <div class="p-2 rounded mb-3" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small text-muted fw-bold text-uppercase" style="font-size: 0.62rem;">
                                        Multi-Roles (<?= count($uRoles) ?>):
                                    </span>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.62rem;">
                                        <?= count($uEffective['effective']) ?> Perms
                                    </span>
                                </div>
                                <div class="d-flex gap-1 flex-wrap">
                                    <?php foreach ($uRoles as $rSlug): 
                                        $rData = $allRoles[strtolower($rSlug)] ?? null;
                                        $color = $rData['color'] ?? 'info';
                                        $rName = $rData['name'] ?? ucfirst($rSlug);
                                    ?>
                                        <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> border border-<?= htmlspecialchars($color) ?>-subtle" style="font-size: 0.65rem;">
                                            <?= htmlspecialchars($rName) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary-subtle" style="font-size: 0.72rem;">
                                <span class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>Active: <?= !empty($u['last_login']) ? date('M j, Y H:i', strtotime($u['last_login'])) : 'Never' ?>
                                </span>
                                <button type="button" class="btn btn-link text-info p-0 text-decoration-none small btn-admin-view-profile" data-user='<?= htmlspecialchars(json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                    Inspect Footprint <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 2: MULTI-ROLE CATALOG & MATRIX                       -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="admin-tab-roles" role="tabpanel">
            <p class="text-muted small mb-3">
                Roles define job responsibilities. Users hold multiple roles simultaneously, inheriting the union of all role permissions.
            </p>

            <div class="row g-3">
                <?php foreach ($allRoles as $rSlug => $rData): 
                    $rolePerms = (array)($rData['permissions'] ?? []);
                    $isWildcard = in_array('*', $rolePerms, true);
                    $color = $rData['color'] ?? 'info';
                    $isSystem = !empty($rData['is_system']);
                    $assignedCount = count(array_filter($allUsers, function($u) use ($rSlug) {
                        return in_array(strtolower($rSlug), array_map('strtolower', (array)($u['roles'] ?? [])), true);
                    }));
                ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="p-3 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(56, 189, 248, 0.16);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> border border-<?= htmlspecialchars($color) ?>-subtle text-uppercase" style="font-size: 0.72rem;">
                                        <i class="bi bi-<?= htmlspecialchars($rData['icon'] ?? 'shield') ?> me-1"></i><?= htmlspecialchars($rData['name']) ?>
                                    </span>
                                    <div>
                                        <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.6rem;"><?= $assignedCount ?> Users</span>
                                    </div>
                                </div>
                                <div class="mono small text-muted mb-2" style="font-size: 0.72rem;">slug: <?= htmlspecialchars($rSlug) ?></div>
                                <p class="text-muted small mb-3" style="font-size: 0.78rem;">
                                    <?= htmlspecialchars($rData['description']) ?>
                                </p>
                            </div>

                            <div>
                                <div class="p-2 rounded bg-black mb-2" style="font-size: 0.72rem; max-height: 80px; overflow-y: auto;">
                                    <?php if ($isWildcard): ?>
                                        <span class="badge bg-danger-subtle text-danger"><i class="bi bi-asterisk me-1"></i>Full Access Wildcard (*)</span>
                                    <?php else: ?>
                                        <?php foreach (array_slice($rolePerms, 0, 4) as $p): ?>
                                            <span class="badge bg-dark border border-secondary text-info me-1 mb-1"><?= htmlspecialchars($p) ?></span>
                                        <?php endforeach; ?>
                                        <?php if (count($rolePerms) > 4): ?>
                                            <span class="badge bg-secondary-subtle text-muted">+<?= count($rolePerms) - 4 ?> more</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-sm btn-outline-info btn-admin-edit-role" data-role='<?= htmlspecialchars(json_encode($rData, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                        <i class="bi bi-sliders me-1"></i> Edit
                                    </button>
                                    <?php if (!$isSystem): ?>
                                        <form method="POST" onsubmit="return confirm('Delete custom role <?= htmlspecialchars($rData['name']) ?>?');">
                                            <?= csrf_input_field() ?>
                                            <input type="hidden" name="action" value="delete_role">
                                            <input type="hidden" name="slug" value="<?= htmlspecialchars($rSlug) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 3: SYSTEM PERMISSIONS DIRECTORY                      -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="admin-tab-perms" role="tabpanel">
            <div class="accordion crm-accordion" id="adminAccordionPerms">
                <?php foreach ($allModules as $modKey => $modInfo): ?>
                    <div class="accordion-item bg-dark border-secondary mb-2 rounded-2 overflow-hidden">
                        <h2 class="accordion-header" id="heading-admin-<?= htmlspecialchars($modKey) ?>">
                            <button class="accordion-button collapsed bg-dark text-white fw-bold py-2.5 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-admin-<?= htmlspecialchars($modKey) ?>">
                                <i class="bi bi-<?= htmlspecialchars($modInfo['icon']) ?> text-info me-2"></i>
                                <?= htmlspecialchars($modInfo['title']) ?>
                                <span class="badge bg-secondary-subtle text-muted ms-2" style="font-size: 0.65rem;"><?= count($modInfo['permissions']) ?> slugs</span>
                            </button>
                        </h2>
                        <div id="collapse-admin-<?= htmlspecialchars($modKey) ?>" class="accordion-collapse collapse" data-bs-parent="#adminAccordionPerms">
                            <div class="accordion-body p-3 bg-black">
                                <div class="table-responsive">
                                    <table class="table table-custom small mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 25%;">Permission Slug</th>
                                                <th>Functional Scope</th>
                                                <th style="width: 30%;">Roles Inheriting</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($modInfo['permissions'] as $pSlug => $pDesc): 
                                                $matchingRoles = [];
                                                foreach ($allRoles as $rSlug => $rData) {
                                                    $rPerms = (array)($rData['permissions'] ?? []);
                                                    if (in_array('*', $rPerms, true) || in_array($pSlug, $rPerms, true)) {
                                                        $matchingRoles[] = $rData['name'];
                                                    }
                                                }
                                            ?>
                                                <tr>
                                                    <td class="mono fw-bold text-info"><?= htmlspecialchars($pSlug) ?></td>
                                                    <td class="text-muted"><?= htmlspecialchars($pDesc) ?></td>
                                                    <td>
                                                        <div class="d-flex gap-1 flex-wrap">
                                                            <?php foreach (array_slice($matchingRoles, 0, 3) as $mr): ?>
                                                                <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.6rem;"><?= htmlspecialchars($mr) ?></span>
                                                            <?php endforeach; ?>
                                                            <?php if (count($matchingRoles) > 3): ?>
                                                                <span class="badge bg-dark border border-secondary text-info" style="font-size: 0.6rem;">+<?= count($matchingRoles) - 3 ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: PROVISION NEW USER                                -->
<!-- ======================================================== -->
<div class="modal fade" id="modalAdminNewUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST">
                <?= csrf_input_field() ?>
                <input type="hidden" name="action" value="create_user">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-plus-fill text-info me-2"></i>Provision New Team User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Full Name">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Username Handle <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary text-muted">@</span>
                                <input type="text" name="username" class="form-control" required placeholder="username">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="name@codex404solutions.online">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Title / Designation</label>
                            <input type="text" name="title" class="form-control" placeholder="Software Engineer">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Department</label>
                            <input type="text" name="department" class="form-control" placeholder="Engineering">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Initial Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required value="admin@1234">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>Active &bull; Operational</option>
                                <option value="inactive">Inactive &bull; Onboarding</option>
                                <option value="suspended">Suspended &bull; Locked</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Bio &amp; Summary</label>
                            <textarea name="bio" class="form-control" rows="2" placeholder="Responsibilities and expertise..."></textarea>
                        </div>

                        <!-- Portal Access Clearance Scope -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-white mb-2">
                                <i class="bi bi-shield-lock-fill text-info me-1"></i>Portal Clearance Scope <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="adminNewScopeCRM" value="crm_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="adminNewScopeCRM">
                                            <span class="badge bg-info-subtle text-info border border-info-subtle me-1"><i class="bi bi-person-workspace me-1"></i>CRM Only</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">CRM access only. Blocked from Website Admin CMS.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="adminNewScopeBoth" value="both" checked>
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="adminNewScopeBoth">
                                            <span class="badge text-white me-1 border" style="background: linear-gradient(135deg, #8B5CF6, #3B82F6); border-color: rgba(255,255,255,0.2) !important;"><i class="bi bi-shield-lock-fill me-1"></i>Dual Clearance (Both)</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">Both Website Admin & CRM. Requires Tier 1 or approval.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="adminNewScopeAdmin" value="admin_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="adminNewScopeAdmin">
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle me-1"><i class="bi bi-globe me-1"></i>Admin Only</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">Website Admin CMS only. Blocked from CRM workspace.</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delegation Governance Guardrail Note -->
                    <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3" style="background: rgba(14, 165, 233, 0.1); border-color: rgba(14, 165, 233, 0.25);">
                        <i class="bi bi-info-circle-fill text-info fs-6"></i>
                        <span style="font-size: 0.75rem;"><strong>Governance Guardrail:</strong> Provisioning Tier 1/2 roles or dual-portal clearance by non-executive managers automatically submits a privileged elevation ticket to the Approval Queue for Superadmin authorization.</span>
                    </div>

                    <!-- Multi-Role Checkboxes -->
                    <div class="p-3 rounded bg-black mb-3">
                        <label class="form-label small fw-bold text-white mb-2">Assign Multi-Roles:</label>
                        <div class="row g-2" style="max-height: 180px; overflow-y: auto;">
                            <?php foreach ($allRoles as $rSlug => $rData): 
                                $color = $rData['color'] ?? 'info';
                            ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-check p-2 rounded border border-secondary">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= htmlspecialchars($rSlug) ?>" id="admin-new-role-<?= htmlspecialchars($rSlug) ?>" <?= $rSlug === 'developer' ? 'checked' : '' ?>>
                                        <label class="form-check-label small text-white" for="admin-new-role-<?= htmlspecialchars($rSlug) ?>">
                                            <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($rData['name']) ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info fw-bold text-dark px-4">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: EDIT USER & ROLES                                 -->
<!-- ======================================================== -->
<div class="modal fade" id="modalAdminEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST">
                <?= csrf_input_field() ?>
                <input type="hidden" name="action" value="update_user">
                <input type="hidden" name="user_id" id="adminEditUserId">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-pencil-square text-warning me-2"></i>Edit User &amp; Multi-Roles</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name</label>
                            <input type="text" name="name" id="adminEditUserName" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Username Handle</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary text-muted">@</span>
                                <input type="text" name="username" id="adminEditUserUsername" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Email</label>
                            <input type="email" name="email" id="adminEditUserEmail" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number</label>
                            <input type="text" name="phone" id="adminEditUserPhone" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Title / Designation</label>
                            <input type="text" name="title" id="adminEditUserTitle" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Department</label>
                            <input type="text" name="department" id="adminEditUserDepartment" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Status</label>
                            <select name="status" id="adminEditUserStatus" class="form-select">
                                <option value="active">Active &bull; Operational</option>
                                <option value="inactive">Inactive &bull; Onboarding</option>
                                <option value="suspended">Suspended &bull; Locked</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Bio</label>
                            <textarea name="bio" id="adminEditUserBio" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- Portal Access Clearance Scope -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-white mb-2">
                                <i class="bi bi-shield-lock-fill text-info me-1"></i>Portal Clearance Scope <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="adminEditScope_crm_only" value="crm_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="adminEditScope_crm_only">
                                            <span class="badge bg-info-subtle text-info border border-info-subtle me-1"><i class="bi bi-person-workspace me-1"></i>CRM Only</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">CRM access only. Blocked from Website Admin CMS.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="adminEditScope_both" value="both">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="adminEditScope_both">
                                            <span class="badge text-white me-1 border" style="background: linear-gradient(135deg, #8B5CF6, #3B82F6); border-color: rgba(255,255,255,0.2) !important;"><i class="bi bi-shield-lock-fill me-1"></i>Dual Clearance (Both)</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">Both Website Admin & CRM. Requires Tier 1 or approval.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="adminEditScope_admin_only" value="admin_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="adminEditScope_admin_only">
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle me-1"><i class="bi bi-globe me-1"></i>Admin Only</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">Website Admin CMS only. Blocked from CRM workspace.</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delegation Governance Guardrail Note -->
                    <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3" style="background: rgba(14, 165, 233, 0.1); border-color: rgba(14, 165, 233, 0.25);">
                        <i class="bi bi-info-circle-fill text-info fs-6"></i>
                        <span style="font-size: 0.75rem;"><strong>Governance Guardrail:</strong> Modifying scopes to dual-portal clearance or granting Tier 1/2 roles requires Founder/Superadmin sign-off. Changes will be queued in Approvals if unauthorized.</span>
                    </div>

                    <!-- Roles -->
                    <div class="p-3 rounded bg-black mb-3">
                        <label class="form-label small fw-bold text-white mb-2">Assign Multi-Roles:</label>
                        <div class="row g-2" style="max-height: 180px; overflow-y: auto;">
                            <?php foreach ($allRoles as $rSlug => $rData): 
                                $color = $rData['color'] ?? 'info';
                            ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-check p-2 rounded border border-secondary">
                                        <input class="form-check-input admin-edit-role-chk" type="checkbox" name="roles[]" value="<?= htmlspecialchars($rSlug) ?>" id="admin-chk-<?= htmlspecialchars($rSlug) ?>">
                                        <label class="form-check-label small text-white" for="admin-chk-<?= htmlspecialchars($rSlug) ?>">
                                            <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?>"><?= htmlspecialchars($rData['name']) ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: VIEW FULL MULTI-ROLE PROFILE                      -->
<!-- ======================================================== -->
<div class="modal fade" id="modalAdminViewProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-white"><i class="bi bi-person-badge text-info me-2"></i>Full Multi-Role Profile</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <div id="adminViewAvatar" class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow" style="width: 58px; height: 58px; font-size: 1.2rem; background: #2563EB;">
                        CX
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="fw-bold text-white mb-0" id="adminViewName">User Name</h5>
                            <span class="badge bg-success-subtle text-success" id="adminViewStatus">Active</span>
                        </div>
                        <div class="mono small text-info" id="adminViewHandle">@username</div>
                        <div class="small text-muted" id="adminViewTitleDept">Title &bull; Dept</div>
                    </div>
                </div>

                <!-- Portal Clearance & Authority Tier Footprint -->
                <div class="row g-2 mb-4 p-3 rounded-3" style="background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(56, 189, 248, 0.2);">
                    <div class="col-12 col-md-6 d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold">Clearance Scope:</span>
                        <span id="adminViewScopeBadge" class="badge bg-secondary">CRM Only</span>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold">Authority Tier:</span>
                        <span id="adminViewTierBadge" class="badge bg-secondary">Tier 3</span>
                    </div>
                    <div class="col-12 mt-1">
                        <div class="small text-muted" id="adminViewScopeDescription" style="font-size: 0.72rem;"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold text-white mb-2">Assigned Multi-Roles:</h6>
                    <div class="d-flex gap-2 flex-wrap" id="adminViewRoles"></div>
                </div>

                <div>
                    <h6 class="fw-bold text-white mb-2">Effective Authorization Footprint:</h6>
                    <div class="p-3 rounded bg-black" style="max-height: 200px; overflow-y: auto;" id="adminViewPerms"></div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: RESET PASSWORD                                    -->
<!-- ======================================================== -->
<div class="modal fade" id="modalAdminResetPass" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST">
                <?= csrf_input_field() ?>
                <input type="hidden" name="action" value="change_user_password">
                <input type="hidden" name="user_id" id="adminResetPassUserId">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-key text-warning me-2"></i>Reset User Password</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Set new password for <strong class="text-white" id="adminResetPassUserName">User</strong>:</p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">New Password</label>
                        <input type="password" name="new_password" class="form-control" required minlength="8" placeholder="At least 8 characters">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold text-dark px-3">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- JAVASCRIPT BINDINGS                                      -->
<!-- ======================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search & Filter
    const search = document.getElementById('adminUserSearch');
    const scopeSel = document.getElementById('adminScopeFilter');
    const roleSel = document.getElementById('adminRoleFilter');
    const statusSel = document.getElementById('adminStatusFilter');
    const cards = document.querySelectorAll('.admin-user-card-col');
    const countText = document.getElementById('adminUserCountText');

    function filterAdminUsers() {
        const q = (search.value || '').toLowerCase().trim();
        const sc = (scopeSel ? scopeSel.value : 'all').toLowerCase();
        const r = (roleSel.value || 'all').toLowerCase();
        const s = (statusSel.value || 'all').toLowerCase();
        let visible = 0;

        cards.forEach(c => {
            const name = c.dataset.name || '';
            const uname = c.dataset.username || '';
            const email = c.dataset.email || '';
            const roles = c.dataset.roles || '';
            const scope = c.dataset.scope || 'crm_only';
            const status = c.dataset.status || '';

            const matchQ = q === '' || name.includes(q) || uname.includes(q) || email.includes(q);
            const matchScope = sc === 'all' || scope === sc;
            const matchR = r === 'all' || roles.includes(r);
            const matchS = s === 'all' || status === s;

            if (matchQ && matchScope && matchR && matchS) {
                c.style.display = '';
                visible++;
            } else {
                c.style.display = 'none';
            }
        });

        countText.textContent = `Showing ${visible} of ${cards.length} members`;
    }

    if (search) search.addEventListener('input', filterAdminUsers);
    if (scopeSel) scopeSel.addEventListener('change', filterAdminUsers);
    if (roleSel) roleSel.addEventListener('change', filterAdminUsers);
    if (statusSel) statusSel.addEventListener('change', filterAdminUsers);

    // View Profile
    const viewModal = new bootstrap.Modal(document.getElementById('modalAdminViewProfile'));
    document.querySelectorAll('.btn-admin-view-profile').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.user);
            document.getElementById('adminViewName').textContent = data.name || 'User';
            document.getElementById('adminViewHandle').textContent = '@' + (data.username || 'user');
            document.getElementById('adminViewStatus').textContent = (data.status || 'active').toUpperCase();
            document.getElementById('adminViewTitleDept').textContent = (data.title || 'Staff') + ' • ' + (data.department || 'General');

            // Render Portal Clearance and Authority Tier
            const roles = data.roles || ['viewer'];
            const userScope = data.access_scope || 'crm_only';
            const scopeBadge = document.getElementById('adminViewScopeBadge');
            const scopeDesc = document.getElementById('adminViewScopeDescription');
            if (scopeBadge) {
                if (userScope === 'both') {
                    scopeBadge.className = 'badge text-white border';
                    scopeBadge.style.background = 'linear-gradient(135deg, #8B5CF6, #3B82F6)';
                    scopeBadge.innerHTML = '<i class="bi bi-shield-lock-fill me-1"></i>Dual Clearance (Both Portals)';
                    if (scopeDesc) scopeDesc.textContent = 'Account cleared for Website Admin CMS and CRM Workspace.';
                } else if (userScope === 'admin_only') {
                    scopeBadge.className = 'badge bg-warning-subtle text-warning border border-warning-subtle';
                    scopeBadge.style.background = '';
                    scopeBadge.innerHTML = '<i class="bi bi-globe me-1"></i>Admin Only (Website CMS)';
                    if (scopeDesc) scopeDesc.textContent = 'Restricted to Website Admin. Access to CRM workspace is blocked.';
                } else {
                    scopeBadge.className = 'badge bg-info-subtle text-info border border-info-subtle';
                    scopeBadge.style.background = '';
                    scopeBadge.innerHTML = '<i class="bi bi-person-workspace me-1"></i>CRM Only (Sales & Delivery)';
                    if (scopeDesc) scopeDesc.textContent = 'Restricted to CRM workspace. Access to Website Admin CMS is blocked.';
                }
            }

            const tierBadge = document.getElementById('adminViewTierBadge');
            if (tierBadge) {
                const isT1 = roles.includes('superadmin') || roles.includes('founder');
                const isT2 = roles.includes('ceo') || roles.includes('cto') || roles.includes('coo') || roles.includes('hr') || roles.includes('sales_manager');
                if (isT1) {
                    tierBadge.className = 'badge text-white';
                    tierBadge.style.background = 'linear-gradient(135deg, #EF4444, #F59E0B)';
                    tierBadge.innerHTML = '<i class="bi bi-award-fill me-1"></i>Tier 1: Supreme Executive';
                } else if (isT2) {
                    tierBadge.className = 'badge text-white';
                    tierBadge.style.background = 'linear-gradient(135deg, #3B82F6, #10B981)';
                    tierBadge.innerHTML = '<i class="bi bi-person-fill-gear me-1"></i>Tier 2: Senior Management';
                } else {
                    tierBadge.className = 'badge text-secondary border border-secondary';
                    tierBadge.style.background = '';
                    tierBadge.innerHTML = '<i class="bi bi-person me-1"></i>Tier 3: Standard Workforce';
                }
            }

            const rolesContainer = document.getElementById('adminViewRoles');
            rolesContainer.innerHTML = '';
            roles.forEach(r => {
                const b = document.createElement('span');
                b.className = 'badge bg-info-subtle text-info border border-info-subtle text-uppercase p-2';
                b.textContent = r;
                rolesContainer.appendChild(b);
            });

            const permsContainer = document.getElementById('adminViewPerms');
            permsContainer.innerHTML = '<div class="text-muted small">Loading effective footprint...</div>';

            fetch(`../../crm/api/v1/permissions?roles=${encodeURIComponent(roles.join(','))}`)
                .then(r => r.json())
                .catch(() => ({ perms: roles.includes('superadmin') ? ['* (Full Access)'] : ['leads.view', 'projects.view'] }))
                .then(res => {
                    const list = res.perms || ['leads.view', 'projects.view'];
                    permsContainer.innerHTML = '';
                    list.forEach(p => {
                        const span = document.createElement('span');
                        span.className = 'badge bg-dark border border-secondary text-info me-1.5 mb-1.5 p-1.5';
                        span.textContent = p;
                        permsContainer.appendChild(span);
                    });
                });

            viewModal.show();
        });
    });

    // Edit User
    const editModal = new bootstrap.Modal(document.getElementById('modalAdminEditUser'));
    document.querySelectorAll('.btn-admin-edit-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.user);
            document.getElementById('adminEditUserId').value = data.id || '';
            document.getElementById('adminEditUserName').value = data.name || '';
            document.getElementById('adminEditUserUsername').value = data.username || '';
            document.getElementById('adminEditUserEmail').value = data.email || '';
            document.getElementById('adminEditUserPhone').value = data.phone || '';
            document.getElementById('adminEditUserTitle').value = data.title || '';
            document.getElementById('adminEditUserDepartment').value = data.department || '';
            document.getElementById('adminEditUserBio').value = data.bio || '';
            document.getElementById('adminEditUserStatus').value = data.status || 'active';

            // Set access scope radio
            const userScope = data.access_scope || 'crm_only';
            const scopeRadio = document.getElementById('adminEditScope_' + userScope);
            if (scopeRadio) {
                scopeRadio.checked = true;
            }

            document.querySelectorAll('.admin-edit-role-chk').forEach(c => c.checked = false);
            (data.roles || []).forEach(r => {
                const c = document.getElementById(`admin-chk-${r.toLowerCase()}`);
                if (c) c.checked = true;
            });

            editModal.show();
        });
    });

    // Reset Password
    const resetModal = new bootstrap.Modal(document.getElementById('modalAdminResetPass'));
    document.querySelectorAll('.btn-admin-reset-pass').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('adminResetPassUserId').value = this.dataset.id;
            document.getElementById('adminResetPassUserName').textContent = this.dataset.name;
            resetModal.show();
        });
    });

    // Delete User
    document.querySelectorAll('.btn-admin-delete-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            if (confirm(`Delete user account '${name}'? This cannot be undone.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
