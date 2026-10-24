<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Workforce Directory & Multi-Role RBAC Management
 */

namespace CRM;

use CRM\Services\RBACService;
use CRM\Services\UserService;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'users';
$pageTitle = 'Workforce Directory & Multi-Role RBAC';
$pageSubtitle = 'Provision team accounts, assign multiple concurrent roles, configure granular permission overrides, and inspect authorization footprints';
$htmlTitle = 'Workforce & Multi-Role RBAC — CodeX404 Solutions CRM';

// Calculate Multi-Role Stats
$multiRoleCount = count(array_filter($allUsers, fn($u) => count((array)($u['roles'] ?? [])) > 1));
$totalPermissionsCount = 0;
foreach ($allModules as $mod) {
    $totalPermissionsCount += count($mod['permissions']);
}

require_once __DIR__ . '/includes/header.php';
?>

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
<!-- 2. ACTION CONTROLS & TABBED INTERFACE                     -->
<!-- ======================================================== -->
<div class="crm-card p-4 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <ul class="nav nav-pills" id="usersTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="users-directory-tab" data-bs-toggle="pill" data-bs-target="#tab-users" type="button" role="tab">
                    <i class="bi bi-people me-2"></i>Team Directory &amp; Profiling
                    <span class="badge bg-secondary-subtle text-muted ms-2"><?= count($allUsers) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="roles-matrix-tab" data-bs-toggle="pill" data-bs-target="#tab-roles" type="button" role="tab">
                    <i class="bi bi-shield-check me-2"></i>Multi-Role Catalog &amp; Matrix
                    <span class="badge bg-secondary-subtle text-muted ms-2"><?= count($allRoles) ?></span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="permissions-catalog-tab" data-bs-toggle="pill" data-bs-target="#tab-permissions" type="button" role="tab">
                    <i class="bi bi-key me-2"></i>Permissions Directory (<?= $totalPermissionsCount ?>)
                </button>
            </li>
        </ul>

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-info btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#modalNewRole">
                <i class="bi bi-plus-circle me-1"></i> New Custom Role
            </button>
            <button class="btn btn-info btn-sm fw-bold text-dark px-3" data-bs-toggle="modal" data-bs-target="#modalNewUser">
                <i class="bi bi-person-plus-fill me-1"></i> Provision New User
            </button>
        </div>
    </div>

    <div class="tab-content" id="usersTabContent">
        <!-- ======================================================== -->
        <!-- TAB 1: WORKFORCE TEAM DIRECTORY & PROFILING               -->
        <!-- ======================================================== -->
        <div class="tab-pane fade show active" id="tab-users" role="tabpanel">
            <!-- Search & Filter Controls -->
            <div class="row g-3 mb-4 align-items-center">
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="userSearchInput" placeholder="Search by name, @username, or email...">
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select class="form-select" id="scopeFilterSelect">
                        <option value="all">All Clearance Scopes</option>
                        <option value="both">Both Admin &amp; CRM</option>
                        <option value="crm_only">CRM Only</option>
                        <option value="admin_only">Admin Only</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select class="form-select" id="roleFilterSelect">
                        <option value="all">All Assigned Roles</option>
                        <?php foreach ($allRoles as $rSlug => $rData): ?>
                            <option value="<?= htmlspecialchars($rSlug) ?>"><?= htmlspecialchars($rData['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select class="form-select" id="statusFilterSelect">
                        <option value="all">All Statuses</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex justify-content-end align-items-center">
                    <span class="small text-muted" id="userResultCount">Showing <?= count($allUsers) ?> team members</span>
                </div>
            </div>

            <!-- User Cards Grid -->
            <div class="row g-3" id="usersGrid">
                <?php foreach ($allUsers as $u): 
                    $uRoles = (array)($u['roles'] ?? ['viewer']);
                    $uEffective = RBACService::getEffectivePermissions($uRoles, (array)($u['custom_permissions'] ?? null));
                    $avatar = UserService::getAvatarInfo($u);
                    $isSelf = ($u['id'] ?? '') === ($currentUser['id'] ?? '');
                    $status = $u['status'] ?? 'active';
                    $scope = $u['access_scope'] ?? 'crm_only';
                    $tier = RBACService::getAuthorityTier($uRoles);
                ?>
                    <div class="col-12 col-lg-6 user-card-col" 
                         data-name="<?= htmlspecialchars(strtolower($u['name'] ?? '')) ?>" 
                         data-username="<?= htmlspecialchars(strtolower($u['username'] ?? '')) ?>" 
                         data-email="<?= htmlspecialchars(strtolower($u['email'] ?? '')) ?>" 
                         data-roles="<?= htmlspecialchars(strtolower(implode(' ', $uRoles))) ?>" 
                         data-scope="<?= htmlspecialchars($scope) ?>" 
                         data-status="<?= htmlspecialchars($status) ?>">
                        
                        <div class="p-3 rounded-3 h-100 position-relative user-card" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.15); transition: border-color 0.2s, transform 0.2s;">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Avatar -->
                                    <div class="position-relative">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                             style="width: 48px; height: 48px; background: <?= $avatar['background'] ?>; color: <?= $avatar['color'] ?>; font-size: 1rem;">
                                            <?= htmlspecialchars($avatar['initials']) ?>
                                        </div>
                                        <span class="position-absolute bottom-0 end-0 p-1 rounded-circle border border-dark"
                                              style="width: 12px; height: 12px; background: <?= $status === 'active' ? '#10B981' : ($status === 'suspended' ? '#EF4444' : '#6B7280') ?>;"
                                              title="Status: <?= htmlspecialchars(ucfirst($status)) ?>"></span>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <h6 class="fw-bold text-white mb-0"><?= htmlspecialchars($u['name'] ?? 'Unnamed') ?></h6>
                                            <?php if ($isSelf): ?>
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
                                            <button class="dropdown-item btn-view-profile" type="button" data-user='<?= htmlspecialchars(json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                                <i class="bi bi-person-badge text-info me-2"></i> View Full Profile
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item btn-edit-user" type="button" data-user='<?= htmlspecialchars(json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                                <i class="bi bi-pencil-square text-warning me-2"></i> Edit User &amp; Roles
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item btn-reset-pass" type="button" data-id="<?= htmlspecialchars($u['id']) ?>" data-name="<?= htmlspecialchars($u['name']) ?>">
                                                <i class="bi bi-key text-primary me-2"></i> Reset Password
                                            </button>
                                        </li>
                                        <?php if (!$isSelf): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger btn-delete-user" type="button" data-id="<?= htmlspecialchars($u['id']) ?>" data-name="<?= htmlspecialchars($u['name']) ?>">
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
                                        <i class="bi bi-shield-shaded me-1"></i>Both Portals
                                    </span>
                                <?php elseif ($scope === 'admin_only'): ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.68rem;" title="Clearance restricted to Website Admin only">
                                        <i class="bi bi-globe me-1"></i>Admin Only
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.68rem;" title="Clearance restricted to CRM Operations only">
                                        <i class="bi bi-kanban me-1"></i>CRM Only
                                    </span>
                                <?php endif; ?>

                                <!-- Delegation Authority Tier Badge -->
                                <span class="badge <?= $tier === 1 ? 'bg-danger-subtle text-danger border border-danger-subtle' : ($tier === 2 ? 'bg-primary-subtle text-primary border border-primary-subtle' : 'bg-secondary-subtle text-muted') ?>" style="font-size: 0.68rem;">
                                    <?= $tier === 1 ? 'Tier 1: Supreme' : ($tier === 2 ? 'Tier 2: Mgmt' : 'Tier 3: Staff') ?>
                                </span>

                                <?php if (($u['approval_status'] ?? 'approved') === 'pending_elevation'): ?>
                                    <span class="badge bg-warning text-dark fw-bold" style="font-size: 0.65rem;" title="Privilege escalation requested, pending Founder sign-off">
                                        <i class="bi bi-hourglass-split me-1"></i>Pending Sign-Off
                                    </span>
                                <?php endif; ?>

                                <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.7rem;">
                                    <i class="bi bi-briefcase me-1"></i><?= htmlspecialchars($u['title'] ?? 'Staff') ?>
                                </span>
                                <span class="badge bg-dark border border-secondary text-info" style="font-size: 0.7rem;">
                                    <i class="bi bi-building me-1"></i><?= htmlspecialchars($u['department'] ?? 'General') ?>
                                </span>
                                <?php if (!empty($u['phone'])): ?>
                                    <span class="small text-muted" style="font-size: 0.72rem;">
                                        <i class="bi bi-telephone me-1"></i><?= htmlspecialchars($u['phone']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Multi-Role Badges Footprint -->
                            <div class="p-2.5 rounded-2 mb-3" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.05);">
                                <div class="d-flex align-items-center justify-content-between mb-1.5">
                                    <span class="small text-muted fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.05em;">
                                        <i class="bi bi-shield-check text-info me-1"></i>Assigned Multi-Roles (<?= count($uRoles) ?>):
                                    </span>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.65rem;">
                                        <?= count($uEffective['effective']) ?> Effective Perms
                                    </span>
                                </div>
                                <div class="d-flex gap-1.5 flex-wrap">
                                    <?php foreach ($uRoles as $rSlug): 
                                        $rData = $allRoles[strtolower($rSlug)] ?? null;
                                        $color = $rData['color'] ?? 'info';
                                        $rName = $rData['name'] ?? ucfirst($rSlug);
                                    ?>
                                        <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> border border-<?= htmlspecialchars($color) ?>-subtle" style="font-size: 0.68rem; padding: 0.25em 0.5em;" title="<?= htmlspecialchars($rData['description'] ?? '') ?>">
                                            <i class="bi bi-<?= htmlspecialchars($rData['icon'] ?? 'person-badge') ?> me-1"></i><?= htmlspecialchars($rName) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Footer Meta & Inspect Link -->
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-secondary-subtle" style="font-size: 0.72rem;">
                                <span class="text-muted">
                                    <i class="bi bi-clock-history me-1"></i>Last active: <?= !empty($u['last_login']) ? date('M j, Y H:i', strtotime($u['last_login'])) : 'Never' ?>
                                </span>
                                <button type="button" class="btn btn-link text-info p-0 text-decoration-none small btn-view-profile" data-user='<?= htmlspecialchars(json_encode($u, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                    Inspect Footprint <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 2: MULTI-ROLE CATALOG & PERMISSIONS MATRIX           -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-roles" role="tabpanel">
            <p class="text-muted small mb-3">
                Roles map high-level responsibilities directly into granular system permissions. Users can hold multiple roles simultaneously, inheriting the union of all permissions.
            </p>

            <div class="row g-3">
                <?php foreach ($allRoles as $rSlug => $rData): 
                    $rolePerms = (array)($rData['permissions'] ?? []);
                    $isWildcard = in_array('*', $rolePerms, true);
                    $color = $rData['color'] ?? 'info';
                    $isSystem = !empty($rData['is_system']);
                    
                    // Count users holding this role
                    $assignedUsersCount = count(array_filter($allUsers, function($u) use ($rSlug) {
                        return in_array(strtolower($rSlug), array_map('strtolower', (array)($u['roles'] ?? [])), true);
                    }));
                ?>
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="p-3 rounded-3 h-100 d-flex flex-column justify-content-between" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(56, 189, 248, 0.15);">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> border border-<?= htmlspecialchars($color) ?>-subtle text-uppercase" style="font-size: 0.72rem;">
                                        <i class="bi bi-<?= htmlspecialchars($rData['icon'] ?? 'shield') ?> me-1"></i><?= htmlspecialchars($rData['name']) ?>
                                    </span>
                                    <div>
                                        <?php if ($isSystem): ?>
                                            <span class="badge bg-dark border border-secondary text-muted" style="font-size: 0.6rem;">System</span>
                                        <?php else: ?>
                                            <span class="badge bg-info-subtle text-info" style="font-size: 0.6rem;">Custom</span>
                                        <?php endif; ?>
                                        <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.6rem;"><?= $assignedUsersCount ?> Users</span>
                                    </div>
                                </div>
                                <div class="mono small text-muted mb-2" style="font-size: 0.72rem;">slug: <?= htmlspecialchars($rSlug) ?></div>
                                <p class="text-muted small mb-3" style="font-size: 0.78rem; min-height: 38px;">
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
                                    <button type="button" class="btn btn-sm btn-outline-info btn-edit-role" data-role='<?= htmlspecialchars(json_encode($rData, JSON_HEX_APOS | JSON_HEX_QUOT), ENT_QUOTES, 'UTF-8') ?>'>
                                        <i class="bi bi-sliders me-1"></i> Edit Permissions
                                    </button>
                                    <?php if (!$isSystem): ?>
                                        <form method="POST" onsubmit="return confirm('Delete custom role <?= htmlspecialchars($rData['name']) ?>?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                            <input type="hidden" name="action" value="delete_role">
                                            <input type="hidden" name="slug" value="<?= htmlspecialchars($rSlug) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Role"><i class="bi bi-trash"></i></button>
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
        <div class="tab-pane fade" id="tab-permissions" role="tabpanel">
            <p class="text-muted small mb-3">
                Granular permission hierarchy enforcing strict Rule #2 (Roles Are Not Permissions). Code verifies <code class="text-info">AuthService::can('slug')</code> rather than role strings.
            </p>

            <div class="accordion crm-accordion" id="accordionPermissions">
                <?php foreach ($allModules as $modKey => $modInfo): ?>
                    <div class="accordion-item bg-dark border-secondary mb-2 rounded-2 overflow-hidden">
                        <h2 class="accordion-header" id="heading-<?= htmlspecialchars($modKey) ?>">
                            <button class="accordion-button collapsed bg-dark text-white fw-bold py-2.5 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= htmlspecialchars($modKey) ?>">
                                <i class="bi bi-<?= htmlspecialchars($modInfo['icon']) ?> text-info me-2"></i>
                                <?= htmlspecialchars($modInfo['title']) ?>
                                <span class="badge bg-secondary-subtle text-muted ms-2" style="font-size: 0.65rem;"><?= count($modInfo['permissions']) ?> slugs</span>
                            </button>
                        </h2>
                        <div id="collapse-<?= htmlspecialchars($modKey) ?>" class="accordion-collapse collapse" data-bs-parent="#accordionPermissions">
                            <div class="accordion-body p-3 bg-black">
                                <div class="table-responsive">
                                    <table class="table table-custom small mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 25%;">Permission Slug</th>
                                                <th>Functional Scope &amp; Operation</th>
                                                <th style="width: 30%;">Roles Inheriting</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($modInfo['permissions'] as $pSlug => $pDesc): 
                                                // Find which roles have this permission
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
<!-- MODAL 1: PROVISION NEW USER (CREATE ACCOUNT)             -->
<!-- ======================================================== -->
<div class="modal fade" id="modalNewUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST" id="formNewUser">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="action" value="create_user">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi bi-person-plus-fill text-info me-2"></i>Provision New Team User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Liam Sterling" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Username Handle <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary text-muted">@</span>
                                <input type="text" name="username" class="form-control" placeholder="liam.tech" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Work Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="liam@codex404solutions.online" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+1 (415) 555-0199">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Job Title / Designation</label>
                            <input type="text" name="title" class="form-control" placeholder="Senior Backend Architect">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Department</label>
                            <input type="text" name="department" class="form-control" placeholder="Engineering & Cloud">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Initial Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" value="admin@1234" required>
                            <div class="form-text text-muted" style="font-size: 0.72rem;">Default temporary password is <code class="text-info">admin@1234</code>.</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Account Status</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>Active &bull; Operational</option>
                                <option value="inactive">Inactive &bull; Onboarding</option>
                                <option value="suspended">Suspended &bull; Locked</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Profile Bio &amp; Specialty</label>
                            <textarea name="bio" class="form-control" rows="2" placeholder="Brief professional background, technical competencies, and responsibilities..."></textarea>
                        </div>

                        <!-- Portal Access Clearance Scope -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-white mb-2">
                                <i class="bi bi-shield-lock-fill text-info me-1"></i>Portal Clearance Scope <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="newUserScopeCRM" value="crm_only" checked>
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="newUserScopeCRM">
                                            <span class="badge bg-info-subtle text-info border border-info-subtle me-1"><i class="bi bi-person-workspace me-1"></i>CRM Only</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">CRM access only. Blocked from Website Admin CMS.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="newUserScopeBoth" value="both">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="newUserScopeBoth">
                                            <span class="badge text-white me-1 border" style="background: linear-gradient(135deg, #8B5CF6, #3B82F6); border-color: rgba(255,255,255,0.2) !important;"><i class="bi bi-shield-lock-fill me-1"></i>Dual Clearance (Both)</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">Both Website Admin & CRM. Requires Tier 1 or approval.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="newUserScopeAdmin" value="admin_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="newUserScopeAdmin">
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

                    <!-- Multi-Role Selection Matrix -->
                    <div class="p-3 rounded-3 mb-3" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(56, 189, 248, 0.2);">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label small fw-bold text-white mb-0">
                                <i class="bi bi-diagram-3-fill text-info me-1"></i>Assign Multi-Roles (Select all that apply)
                            </label>
                            <span class="small text-muted" style="font-size: 0.7rem;">Union of all checked role permissions</span>
                        </div>
                        <div class="row g-2" style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($allRoles as $rSlug => $rData): 
                                $color = $rData['color'] ?? 'info';
                            ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-check p-2 rounded border border-secondary" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= htmlspecialchars($rSlug) ?>" id="role-chk-<?= htmlspecialchars($rSlug) ?>" <?= $rSlug === 'developer' ? 'checked' : '' ?>>
                                        <label class="form-check-label small fw-bold text-white" for="role-chk-<?= htmlspecialchars($rSlug) ?>" style="font-size: 0.75rem;">
                                            <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> me-1"><?= htmlspecialchars($rData['name']) ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info fw-bold text-dark px-4">
                        <i class="bi bi-check-circle me-1"></i> Create Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: EDIT USER & MULTI-ROLES                         -->
<!-- ======================================================== -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST" id="formEditUser">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="action" value="update_user">
                <input type="hidden" name="user_id" id="editUserId">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Edit User Profile &amp; Multi-Roles
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editUserName" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Username Handle <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-secondary text-muted">@</span>
                                <input type="text" name="username" id="editUserUsername" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="editUserEmail" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Phone Number</label>
                            <input type="text" name="phone" id="editUserPhone" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Job Title / Designation</label>
                            <input type="text" name="title" id="editUserTitle" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Department</label>
                            <input type="text" name="department" id="editUserDepartment" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Account Status</label>
                            <select name="status" id="editUserStatus" class="form-select">
                                <option value="active">Active &bull; Operational</option>
                                <option value="inactive">Inactive &bull; Onboarding</option>
                                <option value="suspended">Suspended &bull; Locked</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Preferred Currency</label>
                            <select name="currency" id="editUserCurrency" class="form-select">
                                <option value="USD">USD ($)</option>
                                <option value="INR">INR (₹)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="AED">AED (د.إ)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Profile Bio &amp; Background</label>
                            <textarea name="bio" id="editUserBio" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- Portal Access Clearance Scope -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-white mb-2">
                                <i class="bi bi-shield-lock-fill text-info me-1"></i>Portal Clearance Scope <span class="text-danger">*</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="editUserScope_crm_only" value="crm_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="editUserScope_crm_only">
                                            <span class="badge bg-info-subtle text-info border border-info-subtle me-1"><i class="bi bi-person-workspace me-1"></i>CRM Only</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">CRM access only. Blocked from Website Admin CMS.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="editUserScope_both" value="both">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="editUserScope_both">
                                            <span class="badge text-white me-1 border" style="background: linear-gradient(135deg, #8B5CF6, #3B82F6); border-color: rgba(255,255,255,0.2) !important;"><i class="bi bi-shield-lock-fill me-1"></i>Dual Clearance (Both)</span>
                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.72rem;">Both Website Admin & CRM. Requires Tier 1 or approval.</div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-check p-2.5 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input" type="radio" name="access_scope" id="editUserScope_admin_only" value="admin_only">
                                        <label class="form-check-label small fw-bold text-white d-block cursor-pointer" for="editUserScope_admin_only">
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

                    <!-- Multi-Role Selection Matrix -->
                    <div class="p-3 rounded-3 mb-3" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(56, 189, 248, 0.2);">
                        <label class="form-label small fw-bold text-white mb-2">
                            <i class="bi bi-diagram-3-fill text-info me-1"></i>Assign Multiple Concurrent Roles:
                        </label>
                        <div class="row g-2" style="max-height: 200px; overflow-y: auto;">
                            <?php foreach ($allRoles as $rSlug => $rData): 
                                $color = $rData['color'] ?? 'info';
                            ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-check p-2 rounded border border-secondary" style="background: rgba(255, 255, 255, 0.02);">
                                        <input class="form-check-input edit-role-chk" type="checkbox" name="roles[]" value="<?= htmlspecialchars($rSlug) ?>" id="edit-role-chk-<?= htmlspecialchars($rSlug) ?>">
                                        <label class="form-check-label small fw-bold text-white" for="edit-role-chk-<?= htmlspecialchars($rSlug) ?>" style="font-size: 0.75rem;">
                                            <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> me-1"><?= htmlspecialchars($rData['name']) ?></span>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 3: VIEW FULL MULTI-ROLE PROFILE                    -->
<!-- ======================================================== -->
<div class="modal fade" id="modalViewUserProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-person-badge text-info me-2"></i>Full Multi-Role Profile &amp; Permissions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- User Profile Banner -->
                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <div id="viewUserAvatar" class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow" style="width: 60px; height: 60px; font-size: 1.25rem;">
                        CX
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="fw-bold text-white mb-0" id="viewUserName">User Name</h5>
                            <span class="badge bg-success-subtle text-success" id="viewUserStatus">Active</span>
                        </div>
                        <div class="mono small text-info" id="viewUserHandle">@username</div>
                        <div class="small text-muted" id="viewUserTitleDept">Designation &bull; Department</div>
                    </div>
                </div>

                <div class="row g-3 mb-3 small">
                    <div class="col-12 col-md-6">
                        <div class="text-muted">Work Email:</div>
                        <div class="fw-bold text-white" id="viewUserEmail">user@codex404.com</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="text-muted">Phone:</div>
                        <div class="fw-bold text-white" id="viewUserPhone">—</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted">Bio &amp; Summary:</div>
                        <div class="text-white" id="viewUserBio">—</div>
                    </div>
                </div>

                <!-- Portal Clearance & Authority Tier Footprint -->
                <div class="row g-2 mb-4 p-3 rounded-3" style="background: rgba(0, 0, 0, 0.35); border: 1px solid rgba(56, 189, 248, 0.2);">
                    <div class="col-12 col-md-6 d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold">Clearance Scope:</span>
                        <span id="viewUserScopeBadge" class="badge bg-secondary">CRM Only</span>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center gap-2">
                        <span class="small text-muted fw-bold">Authority Tier:</span>
                        <span id="viewUserTierBadge" class="badge bg-secondary">Tier 3</span>
                    </div>
                    <div class="col-12 mt-1">
                        <div class="small text-muted" id="viewUserScopeDescription" style="font-size: 0.72rem;"></div>
                    </div>
                </div>

                <!-- Active Multi-Role Footprint -->
                <div class="mb-4">
                    <h6 class="fw-bold text-white mb-2"><i class="bi bi-shield-check text-info me-1"></i>Active Multi-Roles:</h6>
                    <div class="d-flex gap-2 flex-wrap" id="viewUserRolesList">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <!-- Effective Permissions Matrix -->
                <div>
                    <h6 class="fw-bold text-white mb-2"><i class="bi bi-key-fill text-success me-1"></i>Effective Permissions Breakdown:</h6>
                    <div class="p-3 rounded bg-black" style="max-height: 220px; overflow-y: auto;" id="viewUserPermsContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 4: RESET USER PASSWORD                             -->
<!-- ======================================================== -->
<div class="modal fade" id="modalResetUserPass" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="action" value="change_user_password">
                <input type="hidden" name="user_id" id="resetPassUserId">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-key text-warning me-2"></i>Reset Password</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Set a new password for <strong class="text-white" id="resetPassUserName">User</strong>:
                    </p>
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
<!-- MODAL 5: CREATE CUSTOM ROLE                              -->
<!-- ======================================================== -->
<div class="modal fade" id="modalNewRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="action" value="save_role">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-shield-plus text-info me-2"></i>Create Custom Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Solution Architect" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Role Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" class="form-control mono" placeholder="solution_architect" required>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label small fw-bold text-muted">Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Role scope, access boundaries, and operational duties">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold text-muted">Badge Color Tag</label>
                            <select name="color" class="form-select">
                                <option value="info" selected>Cyan / Info</option>
                                <option value="primary">Blue / Primary</option>
                                <option value="purple">Purple / Tech</option>
                                <option value="warning">Amber / Warning</option>
                                <option value="success">Emerald / Success</option>
                                <option value="danger">Rose / Danger</option>
                            </select>
                        </div>
                    </div>

                    <!-- Permissions Checklist Grouped by Module -->
                    <label class="form-label small fw-bold text-white mb-2">Granted Permissions:</label>
                    <div class="p-3 rounded bg-black" style="max-height: 250px; overflow-y: auto;">
                        <?php foreach ($allModules as $modKey => $modInfo): ?>
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-1.5 border-bottom border-secondary pb-1">
                                    <span class="small fw-bold text-info"><i class="bi bi-<?= htmlspecialchars($modInfo['icon']) ?> me-1"></i><?= htmlspecialchars($modInfo['title']) ?></span>
                                    <button type="button" class="btn btn-link p-0 text-muted small text-decoration-none select-all-mod" data-mod="<?= htmlspecialchars($modKey) ?>" style="font-size: 0.68rem;">Select All</button>
                                </div>
                                <div class="row g-1">
                                    <?php foreach ($modInfo['permissions'] as $pSlug => $pDesc): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input perm-mod-<?= htmlspecialchars($modKey) ?>" type="checkbox" name="permissions[]" value="<?= htmlspecialchars($pSlug) ?>" id="newrole-p-<?= htmlspecialchars($pSlug) ?>">
                                                <label class="form-check-label small text-muted" for="newrole-p-<?= htmlspecialchars($pSlug) ?>" style="font-size: 0.75rem;">
                                                    <code class="text-white"><?= htmlspecialchars($pSlug) ?></code>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info fw-bold text-dark px-4">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 6: EDIT ROLE PERMISSIONS                           -->
<!-- ======================================================== -->
<div class="modal fade" id="modalEditRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white shadow-lg">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="action" value="save_role">
                <input type="hidden" name="slug" id="editRoleSlug">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold text-white"><i class="bi bi-sliders text-info me-2"></i>Edit Role &amp; Permissions</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Role Name</label>
                            <input type="text" name="name" id="editRoleName" class="form-control" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-bold text-muted">Badge Color Tag</label>
                            <select name="color" id="editRoleColor" class="form-select">
                                <option value="info">Cyan / Info</option>
                                <option value="primary">Blue / Primary</option>
                                <option value="purple">Purple / Tech</option>
                                <option value="warning">Amber / Warning</option>
                                <option value="success">Emerald / Success</option>
                                <option value="danger">Rose / Danger</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Description</label>
                            <input type="text" name="description" id="editRoleDesc" class="form-control">
                        </div>
                    </div>

                    <label class="form-label small fw-bold text-white mb-2">Configure Assigned Permissions:</label>
                    <div class="p-3 rounded bg-black" style="max-height: 250px; overflow-y: auto;">
                        <?php foreach ($allModules as $modKey => $modInfo): ?>
                            <div class="mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-1.5 border-bottom border-secondary pb-1">
                                    <span class="small fw-bold text-info"><i class="bi bi-<?= htmlspecialchars($modInfo['icon']) ?> me-1"></i><?= htmlspecialchars($modInfo['title']) ?></span>
                                </div>
                                <div class="row g-1">
                                    <?php foreach ($modInfo['permissions'] as $pSlug => $pDesc): ?>
                                        <div class="col-12 col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input edit-perm-chk" type="checkbox" name="permissions[]" value="<?= htmlspecialchars($pSlug) ?>" id="editrole-p-<?= htmlspecialchars($pSlug) ?>">
                                                <label class="form-check-label small text-muted" for="editrole-p-<?= htmlspecialchars($pSlug) ?>" style="font-size: 0.75rem;">
                                                    <code class="text-white"><?= htmlspecialchars($pSlug) ?></code>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info fw-bold text-dark px-4">Save Role Permissions</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- JAVASCRIPT LOGIC & DYNAMIC MODAL BINDINGS                -->
<!-- ======================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Client-Side Filtering & Search
    const searchInput = document.getElementById('userSearchInput');
    const roleFilter = document.getElementById('roleFilterSelect');
    const scopeFilter = document.getElementById('scopeFilterSelect');
    const statusFilter = document.getElementById('statusFilterSelect');
    const userCards = document.querySelectorAll('.user-card-col');
    const countDisplay = document.getElementById('userResultCount');

    function filterUsers() {
        const query = (searchInput.value || '').toLowerCase().trim();
        const role = (roleFilter.value || 'all').toLowerCase();
        const scope = (scopeFilter ? scopeFilter.value : 'all').toLowerCase();
        const status = (statusFilter.value || 'all').toLowerCase();
        let visibleCount = 0;

        userCards.forEach(card => {
            const name = card.dataset.name || '';
            const username = card.dataset.username || '';
            const email = card.dataset.email || '';
            const cardRoles = card.dataset.roles || '';
            const cardScope = card.dataset.scope || 'crm_only';
            const cardStatus = card.dataset.status || '';

            const matchesQuery = query === '' || name.includes(query) || username.includes(query) || email.includes(query);
            const matchesRole = role === 'all' || cardRoles.includes(role);
            const matchesScope = scope === 'all' || cardScope === scope;
            const matchesStatus = status === 'all' || cardStatus === status;

            if (matchesQuery && matchesRole && matchesScope && matchesStatus) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        countDisplay.textContent = `Showing ${visibleCount} of ${userCards.length} team members`;
    }

    if (searchInput) searchInput.addEventListener('input', filterUsers);
    if (roleFilter) roleFilter.addEventListener('change', filterUsers);
    if (scopeFilter) scopeFilter.addEventListener('change', filterUsers);
    if (statusFilter) statusFilter.addEventListener('change', filterUsers);

    // 2. View Full Profile Modal Populator
    const viewModal = new bootstrap.Modal(document.getElementById('modalViewUserProfile'));
    document.querySelectorAll('.btn-view-profile').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.user);
            document.getElementById('viewUserName').textContent = data.name || 'User';
            document.getElementById('viewUserHandle').textContent = '@' + (data.username || 'user');
            document.getElementById('viewUserStatus').textContent = (data.status || 'active').toUpperCase();
            document.getElementById('viewUserTitleDept').textContent = (data.title || 'Staff') + ' • ' + (data.department || 'General');
            document.getElementById('viewUserEmail').textContent = data.email || '—';
            document.getElementById('viewUserPhone').textContent = data.phone || '—';
            document.getElementById('viewUserBio').textContent = data.bio || 'No profile summary provided.';

            // Render Portal Clearance and Authority Tier
            const roles = data.roles || ['viewer'];
            const userScope = data.access_scope || 'crm_only';
            const scopeBadge = document.getElementById('viewUserScopeBadge');
            const scopeDesc = document.getElementById('viewUserScopeDescription');
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

            const tierBadge = document.getElementById('viewUserTierBadge');
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

            // Render Assigned Roles
            const rolesContainer = document.getElementById('viewUserRolesList');
            rolesContainer.innerHTML = '';
            roles.forEach(r => {
                const badge = document.createElement('span');
                badge.className = 'badge bg-info-subtle text-info border border-info-subtle text-uppercase p-2';
                badge.style.fontSize = '0.75rem';
                badge.innerHTML = `<i class="bi bi-shield-check me-1"></i>${r}`;
                rolesContainer.appendChild(badge);
            });

            // Calculate Permissions
            const permsContainer = document.getElementById('viewUserPermsContainer');
            permsContainer.innerHTML = '<div class="text-muted small">Loading effective authorization footprint...</div>';

            fetch(`api/v1/permissions?roles=${encodeURIComponent(roles.join(','))}`)
                .then(r => r.json())
                .catch(() => ({ perms: roles.includes('superadmin') ? ['* (Full Access)'] : ['leads.view', 'opportunities.view', 'projects.view'] }))
                .then(res => {
                    const list = res.perms || ['leads.view', 'opportunities.view', 'projects.view'];
                    permsContainer.innerHTML = '';
                    list.forEach(p => {
                        const span = document.createElement('span');
                        span.className = 'badge bg-dark border border-secondary text-info me-1.5 mb-1.5 p-1.5';
                        span.style.fontSize = '0.72rem';
                        span.textContent = p;
                        permsContainer.appendChild(span);
                    });
                });

            viewModal.show();
        });
    });

    // 3. Edit User Modal Populator
    const editModal = new bootstrap.Modal(document.getElementById('modalEditUser'));
    document.querySelectorAll('.btn-edit-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.user);
            document.getElementById('editUserId').value = data.id || '';
            document.getElementById('editUserName').value = data.name || '';
            document.getElementById('editUserUsername').value = data.username || '';
            document.getElementById('editUserEmail').value = data.email || '';
            document.getElementById('editUserPhone').value = data.phone || '';
            document.getElementById('editUserTitle').value = data.title || '';
            document.getElementById('editUserDepartment').value = data.department || '';
            document.getElementById('editUserBio').value = data.bio || '';
            document.getElementById('editUserStatus').value = data.status || 'active';
            if (document.getElementById('editUserCurrency')) {
                document.getElementById('editUserCurrency').value = data.currency || 'USD';
            }

            // Set access scope radio
            const userScope = data.access_scope || 'crm_only';
            const scopeRadio = document.getElementById('editUserScope_' + userScope);
            if (scopeRadio) {
                scopeRadio.checked = true;
            }

            // Uncheck all role checkboxes
            document.querySelectorAll('.edit-role-chk').forEach(chk => chk.checked = false);

            // Check assigned roles
            const roles = data.roles || [];
            roles.forEach(r => {
                const chk = document.getElementById(`edit-role-chk-${r.toLowerCase()}`);
                if (chk) chk.checked = true;
            });

            editModal.show();
        });
    });

    // 4. Reset Password Modal Populator
    const resetModal = new bootstrap.Modal(document.getElementById('modalResetUserPass'));
    document.querySelectorAll('.btn-reset-pass').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('resetPassUserId').value = this.dataset.id;
            document.getElementById('resetPassUserName').textContent = this.dataset.name;
            resetModal.show();
        });
    });

    // 5. Delete User Form Trigger
    document.querySelectorAll('.btn-delete-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            if (confirm(`Are you sure you want to permanently delete account for '${name}'? This action cannot be undone.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // 6. Edit Role Modal Populator
    const editRoleModal = new bootstrap.Modal(document.getElementById('modalEditRole'));
    document.querySelectorAll('.btn-edit-role').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.dataset.role);
            document.getElementById('editRoleSlug').value = data.slug || '';
            document.getElementById('editRoleName').value = data.name || '';
            document.getElementById('editRoleDesc').value = data.description || '';
            document.getElementById('editRoleColor').value = data.color || 'info';

            // Check permissions
            document.querySelectorAll('.edit-perm-chk').forEach(chk => chk.checked = false);
            const perms = data.permissions || [];
            perms.forEach(p => {
                const chk = document.getElementById(`editrole-p-${p}`);
                if (chk) chk.checked = true;
            });

            editRoleModal.show();
        });
    });

    // 7. Select All by Module helper
    document.querySelectorAll('.select-all-mod').forEach(btn => {
        btn.addEventListener('click', function() {
            const mod = this.dataset.mod;
            const chks = document.querySelectorAll(`.perm-mod-${mod}`);
            const allChecked = Array.from(chks).every(c => c.checked);
            chks.forEach(c => c.checked = !allChecked);
            this.textContent = allChecked ? 'Select All' : 'Deselect All';
        });
    });
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
