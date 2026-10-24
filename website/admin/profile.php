<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Portal: My Account Profile & Multi-Role Footprint
 */

require_once __DIR__ . '/auth.php';
require_admin_auth();

use CRM\Services\RBACService;
use CRM\Services\UserService;

$currentPage = 'profile';
$pageTitle = 'Account Profile & Multi-Role Footprint';
$pageSubtitle = 'Personal profile telemetry, active multi-role footprint, and effective system permission matrix';

$profile = current_admin_profile();
$myId = $profile['id'] ?? 'usr_admin_alex';

// Handle Profile & Password Updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        set_admin_flash('error', 'Security token expired. Please try again.');
        header('Location: ' . admin_url('profile'));
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        try {
            $updateData = [
                'name' => trim((string)($_POST['name'] ?? $profile['name'])),
                'phone' => trim((string)($_POST['phone'] ?? '')),
                'title' => trim((string)($_POST['title'] ?? '')),
                'department' => trim((string)($_POST['department'] ?? '')),
                'bio' => trim((string)($_POST['bio'] ?? '')),
                'timezone' => trim((string)($_POST['timezone'] ?? 'UTC')),
                'currency' => trim((string)($_POST['currency'] ?? 'USD'))
            ];
            if (isset($_POST['avatar'])) {
                $updateData['avatar'] = trim((string)$_POST['avatar']);
            }
            $updated = UserService::update($myId, $updateData);

            if (!empty($_FILES['avatar_file']['tmp_name']) && is_uploaded_file($_FILES['avatar_file']['tmp_name'])) {
                UserService::uploadAvatar($myId, $_FILES['avatar_file']);
                $updated = UserService::getById($myId);
            }

            if ($updated) {
                $_SESSION['codex_admin_profile'] = $updated;
                set_admin_flash('success', 'Profile information updated successfully.');
            }
        } catch (\Throwable $e) {
            set_admin_flash('error', 'Profile update failed: ' . $e->getMessage());
        }
    } elseif ($action === 'upload_avatar') {
        try {
            if (empty($_FILES['avatar_file']['tmp_name'])) {
                throw new \InvalidArgumentException('Please select an image file to upload.');
            }
            UserService::uploadAvatar($myId, $_FILES['avatar_file']);
            $updated = UserService::getById($myId);
            if ($updated) {
                $_SESSION['codex_admin_profile'] = $updated;
            }
            set_admin_flash('success', 'Profile display picture successfully updated!');
        } catch (\Throwable $e) {
            set_admin_flash('error', 'Avatar upload failed: ' . $e->getMessage());
        }
    } elseif ($action === 'remove_avatar') {
        try {
            UserService::removeAvatar($myId);
            $updated = UserService::getById($myId);
            if ($updated) {
                $_SESSION['codex_admin_profile'] = $updated;
            }
            set_admin_flash('info', 'Profile picture removed. Restored to default initials badge.');
        } catch (\Throwable $e) {
            set_admin_flash('error', 'Avatar removal error: ' . $e->getMessage());
        }
    } elseif ($action === 'change_password') {
        $currentPass = (string)($_POST['current_password'] ?? '');
        $newPass = (string)($_POST['new_password'] ?? '');
        $confirmPass = (string)($_POST['confirm_password'] ?? '');

        if ($newPass !== $confirmPass) {
            set_admin_flash('error', 'New password confirmation does not match.');
        } else {
            $userRec = UserService::getById($myId);
            if (!$userRec || empty($userRec['password_hash']) || !password_verify($currentPass, $userRec['password_hash'])) {
                set_admin_flash('error', 'Current password is incorrect.');
            } else {
                try {
                    UserService::updatePassword($myId, $newPass);
                    set_admin_flash('success', 'Your password has been changed successfully.');
                } catch (\Throwable $e) {
                    set_admin_flash('error', $e->getMessage());
                }
            }
        }
    }

    header('Location: ' . admin_url('profile'));
    exit;
}

$avatar = UserService::getAvatarInfo($profile);
$adminRoles = (array)($profile['roles'] ?? ['superadmin']);
$allRoles = RBACService::getAllRoles();
$allModules = RBACService::getAllModules();
$effectivePerms = RBACService::getEffectivePermissions($adminRoles, (array)($profile['custom_permissions'] ?? null));
$myScope = $profile['access_scope'] ?? 'crm_only';
$myTier = RBACService::getAuthorityTier($adminRoles);
$myTierTitle = RBACService::getTierTitle($myTier);
$canCreateUsers = RBACService::hasPermission($adminRoles, 'users.create', (array)($profile['custom_permissions'] ?? null));
$canEditUsers = RBACService::hasPermission($adminRoles, 'users.edit', (array)($profile['custom_permissions'] ?? null));
$canDelegate = RBACService::hasPermission($adminRoles, 'users.delegate', (array)($profile['custom_permissions'] ?? null)) || $canEditUsers;
$canScope = RBACService::hasPermission($adminRoles, 'users.scope', (array)($profile['custom_permissions'] ?? null)) || $canEditUsers;

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
<!-- 1. PROFILE HERO HEADER BANNER                            -->
<!-- ======================================================== -->
<div class="p-4 rounded-3 mb-4" style="background: rgba(11, 15, 25, 0.7); border: 1px solid rgba(56, 189, 248, 0.16);">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
        <div class="d-flex align-items-center gap-4">
            <!-- Large Styled Avatar with Upload / Remove Controls -->
            <div class="position-relative flex-shrink-0" style="width: 82px; height: 82px;">
                <div class="position-relative w-100 h-100">
                    <?php if (!empty($avatar['image'])): ?>
                        <img src="<?= htmlspecialchars(asset($avatar['image'])) ?>" alt="<?= htmlspecialchars((string)($profile['name'] ?? 'Admin')) ?>"
                             class="rounded-circle object-fit-cover shadow-lg border w-100 h-100"
                             style="width: 82px; height: 82px; min-width: 82px; min-height: 82px; border: 2px solid rgba(56, 189, 248, 0.45) !important;">
                    <?php else: ?>
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-lg w-100 h-100"
                             style="width: 82px; height: 82px; min-width: 82px; min-height: 82px; background: <?= $avatar['background'] ?>; color: <?= $avatar['color'] ?>; font-size: 1.6rem; border: 2px solid rgba(56, 189, 248, 0.4);">
                            <?= htmlspecialchars($avatar['initials']) ?>
                        </div>
                    <?php endif; ?>
                    <span class="position-absolute bottom-0 end-0 p-1.5 rounded-circle border border-dark"
                          style="width: 18px; height: 18px; background: #10B981;"
                          title="Active Authenticated Session"></span>
                </div>
            </div>

            <!-- Avatar Action Controls -->
            <div class="d-flex flex-column gap-1">
                <div class="d-flex align-items-center gap-2">
                    <form method="POST" enctype="multipart/form-data" id="adminFormUploadAvatar" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
                        <input type="hidden" name="action" value="upload_avatar">
                        <input type="file" name="avatar_file" id="adminAvatarFileInput" class="d-none" accept="image/png, image/jpeg, image/webp, image/svg+xml" onchange="document.getElementById('adminFormUploadAvatar').submit();">
                        <button type="button" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1.5 px-2.5 py-1" onclick="document.getElementById('adminAvatarFileInput').click();" title="Upload new display picture">
                            <i class="bi bi-camera-fill"></i>
                            <span style="font-size: 0.78rem;">Upload DP</span>
                        </button>
                    </form>

                    <?php if (!empty($avatar['image'])): ?>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Remove custom display picture and reset to initials badge?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generate_csrf_token()) ?>">
                            <input type="hidden" name="action" value="remove_avatar">
                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-2 py-1" title="Remove custom avatar">
                                <i class="bi bi-trash"></i>
                                <span style="font-size: 0.78rem;">Remove</span>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
                <small class="text-muted" style="font-size: 0.68rem;">PNG, JPG, WEBP, SVG &bull; Max 3MB</small>
            </div>

            <div>
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <h3 class="fw-bold text-white mb-0"><?= htmlspecialchars((string)($profile['name'] ?? 'Admin')) ?></h3>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i class="bi bi-patch-check-fill me-1"></i>Active Admin
                    </span>
                    <span class="badge bg-dark border border-secondary text-info mono">
                        @<?= htmlspecialchars((string)($profile['username'] ?? 'admin')) ?>
                    </span>

                    <!-- Portal Clearance Badge -->
                    <?php if ($myScope === 'both'): ?>
                        <span class="badge text-white" style="background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%);">
                            <i class="bi bi-shield-lock-fill me-1"></i>Dual Clearance: Both Portals
                        </span>
                    <?php elseif ($myScope === 'admin_only'): ?>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                            <i class="bi bi-globe me-1"></i>Admin Only Clearance
                        </span>
                    <?php else: ?>
                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                            <i class="bi bi-person-workspace me-1"></i>CRM Only Clearance
                        </span>
                    <?php endif; ?>

                    <!-- Authority Tier Badge -->
                    <?php if ($myTier === 1): ?>
                        <span class="badge text-white" style="background: linear-gradient(135deg, #EF4444 0%, #F59E0B 100%);">
                            <i class="bi bi-award-fill me-1"></i>Tier 1: Supreme Executive
                        </span>
                    <?php elseif ($myTier === 2): ?>
                        <span class="badge text-white" style="background: linear-gradient(135deg, #3B82F6 0%, #10B981 100%);">
                            <i class="bi bi-person-fill-gear me-1"></i>Tier 2: Senior Management
                        </span>
                    <?php else: ?>
                        <span class="badge text-secondary border border-secondary">
                            <i class="bi bi-person me-1"></i>Tier 3: Standard Workforce
                        </span>
                    <?php endif; ?>
                </div>
                <div class="text-muted small mb-2">
                    <span class="text-white fw-semibold"><?= htmlspecialchars((string)($profile['title'] ?? 'Administrator')) ?></span> &bull; 
                    <span><?= htmlspecialchars((string)($profile['department'] ?? 'Executive Leadership')) ?></span> &bull; 
                    <span class="mono text-info"><?= htmlspecialchars((string)($profile['email'] ?? 'admin@codex404solutions.online')) ?></span>
                </div>

                <!-- Multi-Role Badges -->
                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                    <span class="small text-muted fw-bold text-uppercase me-1" style="font-size: 0.68rem;">Assigned Roles:</span>
                    <?php foreach ($adminRoles as $rSlug): 
                        $rInfo = $allRoles[strtolower($rSlug)] ?? null;
                        $color = $rInfo['color'] ?? 'info';
                        $rName = $rInfo['name'] ?? ucfirst($rSlug);
                    ?>
                        <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> border border-<?= htmlspecialchars($color) ?>-subtle text-uppercase" style="font-size: 0.72rem; padding: 0.3em 0.6em;">
                            <i class="bi bi-<?= htmlspecialchars($rInfo['icon'] ?? 'shield') ?> me-1"></i><?= htmlspecialchars($rName) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <div class="text-center p-3 rounded-3" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.08); min-width: 110px;">
                <div class="h4 fw-bold text-info mb-0"><?= count($adminRoles) ?></div>
                <div class="small text-muted" style="font-size: 0.7rem;">Active Roles</div>
            </div>
            <div class="text-center p-3 rounded-3" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.08); min-width: 110px;">
                <div class="h4 fw-bold text-success mb-0"><?= count($effectivePerms['effective']) ?></div>
                <div class="small text-muted" style="font-size: 0.7rem;">Effective Perms</div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. TABBED PROFILE NAVIGATION                              -->
<!-- ======================================================== -->
<div class="p-4 rounded-3 mb-4" style="background: rgba(11, 15, 25, 0.7); border: 1px solid rgba(56, 189, 248, 0.16);">
    <ul class="nav nav-pills mb-4" id="adminProfileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="tab-admin-info-btn" data-bs-toggle="pill" data-bs-target="#tab-admin-info" type="button" role="tab">
                <i class="bi bi-person-lines-fill me-2"></i>Profile Information
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-admin-multirole-btn" data-bs-toggle="pill" data-bs-target="#tab-admin-roles" type="button" role="tab">
                <i class="bi bi-diagram-3-fill me-2"></i>Multi-Role Footprint (<?= count($adminRoles) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-admin-perms-btn" data-bs-toggle="pill" data-bs-target="#tab-admin-perms" type="button" role="tab">
                <i class="bi bi-key-fill me-2"></i>Effective Permissions (<?= count($effectivePerms['effective']) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-admin-sec-btn" data-bs-toggle="pill" data-bs-target="#tab-admin-sec" type="button" role="tab">
                <i class="bi bi-shield-lock-fill me-2"></i>Security &amp; Password
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-admin-gov-btn" data-bs-toggle="pill" data-bs-target="#tab-admin-governance" type="button" role="tab">
                <i class="bi bi-shield-shaded me-2"></i>Clearance &amp; Governance
            </button>
        </li>
    </ul>

    <div class="tab-content" id="adminProfileTabsContent">
        <!-- ======================================================== -->
        <!-- TAB 1: PROFILE INFO                                      -->
        <!-- ======================================================== -->
        <div class="tab-pane fade show active" id="tab-admin-info" role="tabpanel">
            <form method="POST">
                <?= csrf_input_field() ?>
                <input type="hidden" name="action" value="update_profile">

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Full Legal Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars((string)($profile['name'] ?? '')) ?>" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Username Handle</label>
                        <input type="text" class="form-control mono text-muted" value="@<?= htmlspecialchars((string)($profile['username'] ?? 'admin')) ?>" disabled readonly>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Primary Email</label>
                        <input type="email" class="form-control mono text-muted" value="<?= htmlspecialchars((string)($profile['email'] ?? '')) ?>" disabled readonly>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars((string)($profile['phone'] ?? '')) ?>" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Job Title / Designation</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars((string)($profile['title'] ?? '')) ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Department</label>
                        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars((string)($profile['department'] ?? '')) ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Timezone Setting</label>
                        <select name="timezone" class="form-select">
                            <option value="America/New_York" <?= ($profile['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' ?>>America/New_York (UTC-5)</option>
                            <option value="America/Los_Angeles" <?= ($profile['timezone'] ?? '') === 'America/Los_Angeles' ? 'selected' : '' ?>>America/Los_Angeles (UTC-8)</option>
                            <option value="Europe/London" <?= ($profile['timezone'] ?? '') === 'Europe/London' ? 'selected' : '' ?>>Europe/London (UTC+0)</option>
                            <option value="Europe/Berlin" <?= ($profile['timezone'] ?? '') === 'Europe/Berlin' ? 'selected' : '' ?>>Europe/Berlin (UTC+1)</option>
                            <option value="Asia/Dubai" <?= ($profile['timezone'] ?? '') === 'Asia/Dubai' ? 'selected' : '' ?>>Asia/Dubai (UTC+4)</option>
                            <option value="Asia/Kolkata" <?= ($profile['timezone'] ?? '') === 'Asia/Kolkata' ? 'selected' : '' ?>>Asia/Kolkata (UTC+5:30)</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Monetary Currency</label>
                        <select name="currency" class="form-select">
                            <option value="USD" <?= ($profile['currency'] ?? '') === 'USD' ? 'selected' : '' ?>>USD ($) — United States Dollar</option>
                            <option value="INR" <?= ($profile['currency'] ?? '') === 'INR' ? 'selected' : '' ?>>INR (₹) — Indian Rupee</option>
                            <option value="EUR" <?= ($profile['currency'] ?? '') === 'EUR' ? 'selected' : '' ?>>EUR (€) — Euro</option>
                            <option value="GBP" <?= ($profile['currency'] ?? '') === 'GBP' ? 'selected' : '' ?>>GBP (£) — British Pound</option>
                            <option value="AED" <?= ($profile['currency'] ?? '') === 'AED' ? 'selected' : '' ?>>AED (د.إ) — UAE Dirham</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Bio &amp; Summary</label>
                        <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars((string)($profile['bio'] ?? '')) ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-info fw-bold text-dark px-4 py-2">
                        <i class="bi bi-save me-1"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 2: MULTI-ROLE FOOTPRINT                              -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-admin-roles" role="tabpanel">
            <div class="p-3 rounded-3 mb-4" style="background: rgba(56, 189, 248, 0.05); border: 1px solid rgba(56, 189, 248, 0.2);">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-info-circle-fill text-info fs-5"></i>
                    <h6 class="fw-bold text-white mb-0">Multi-Role Profiling Rules (CodeX404 Mandatory Rules #1 &amp; #2)</h6>
                </div>
                <p class="small text-muted mb-0">
                    Your active capabilities are calculated from the union of your assigned concurrent roles. Permission checks evaluate <code class="text-info">current_admin_can('slug')</code> rather than hard-coded role names.
                </p>
            </div>

            <div class="row g-3">
                <?php foreach ($adminRoles as $rSlug): 
                    $roleData = $allRoles[strtolower($rSlug)] ?? null;
                    if (!$roleData) continue;
                    $color = $roleData['color'] ?? 'info';
                    $rolePerms = (array)($roleData['permissions'] ?? []);
                    $isWildcard = in_array('*', $rolePerms, true);
                ?>
                    <div class="col-12 col-md-6">
                        <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.2);">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="badge bg-<?= htmlspecialchars($color) ?>-subtle text-<?= htmlspecialchars($color) ?> border border-<?= htmlspecialchars($color) ?>-subtle text-uppercase px-2.5 py-1.5" style="font-size: 0.8rem;">
                                    <i class="bi bi-<?= htmlspecialchars($roleData['icon'] ?? 'shield-check') ?> me-1.5"></i><?= htmlspecialchars($roleData['name']) ?>
                                </span>
                                <span class="mono small text-muted">slug: <?= htmlspecialchars($rSlug) ?></span>
                            </div>

                            <p class="text-white small mb-3">
                                <?= htmlspecialchars($roleData['description']) ?>
                            </p>

                            <div class="p-2.5 rounded bg-black small">
                                <div class="text-muted fw-bold mb-1.5" style="font-size: 0.68rem; text-transform: uppercase;">
                                    Permissions (<?= $isWildcard ? 'Full Master Wildcard' : count($rolePerms) ?>):
                                </div>
                                <?php if ($isWildcard): ?>
                                    <span class="badge bg-danger-subtle text-danger"><i class="bi bi-asterisk me-1"></i>Full Access Wildcard (*)</span>
                                <?php else: ?>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <?php foreach ($rolePerms as $p): ?>
                                            <span class="badge bg-dark border border-secondary text-info"><?= htmlspecialchars($p) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 3: EFFECTIVE PERMISSIONS INSPECTOR                   -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-admin-perms" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-custom small mb-0">
                    <thead>
                        <tr>
                            <th style="width: 28%;">Permission Slug</th>
                            <th>Functional Module</th>
                            <th style="width: 25%;">Authority Source Attribution</th>
                            <th style="width: 15%; text-align: right;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $effectiveList = $effectivePerms['effective'];
                        $details = $effectivePerms['details'];

                        foreach ($allModules as $modKey => $modInfo): 
                            foreach ($modInfo['permissions'] as $pSlug => $pDesc):
                                $hasPerm = in_array($pSlug, $effectiveList, true) || in_array('*', $effectiveList, true);
                                $sourceInfo = $details[$pSlug] ?? null;
                                $sourceName = $sourceInfo['source'] ?? (in_array('*', $effectiveList, true) ? 'Wildcard (*)' : '—');
                        ?>
                            <tr>
                                <td class="mono fw-bold <?= $hasPerm ? 'text-info' : 'text-muted' ?>">
                                    <?= htmlspecialchars($pSlug) ?>
                                </td>
                                <td>
                                    <span class="text-white"><?= htmlspecialchars($modInfo['title']) ?></span>
                                    <div class="text-muted" style="font-size: 0.72rem;"><?= htmlspecialchars($pDesc) ?></div>
                                </td>
                                <td>
                                    <?php if ($hasPerm): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                                            <?= htmlspecialchars($sourceName) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align: right;">
                                    <?php if ($hasPerm): ?>
                                        <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Granted</span>
                                    <?php else: ?>
                                        <span class="badge bg-dark border border-secondary text-muted">Restricted</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php 
                            endforeach;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 4: SECURITY & CREDENTIALS                            -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-admin-sec" role="tabpanel">
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <h6 class="fw-bold text-white mb-3"><i class="bi bi-key text-warning me-2"></i>Change Master Admin Password</h6>
                        
                        <form method="POST">
                            <?= csrf_input_field() ?>
                            <input type="hidden" name="action" value="change_password">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required placeholder="Enter current password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">New Password</label>
                                <input type="password" name="new_password" class="form-control" required minlength="8" placeholder="Minimum 8 characters">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" required minlength="8" placeholder="Repeat new password">
                            </div>

                            <button type="submit" class="btn btn-warning fw-bold text-dark px-4">
                                <i class="bi bi-shield-lock me-1"></i> Update Credentials
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <h6 class="fw-bold text-white mb-3"><i class="bi bi-shield-check text-success me-2"></i>Active Session Diagnostics</h6>
                        
                        <div class="table-responsive">
                            <table class="table table-custom small mb-0">
                                <tr>
                                    <td class="text-muted">Client IP Address:</td>
                                    <td class="mono text-info"><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Session Cookie Flags:</td>
                                    <td><span class="badge bg-success-subtle text-success">HTTPOnly &bull; SameSite=Strict</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Idle Timeout:</td>
                                    <td><span class="badge bg-info-subtle text-info">30 Minutes Inactivity</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Storage Subsystem:</td>
                                    <td class="mono text-muted">Hybrid MySQL + Atomic JSON Fallback</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 5: CLEARANCE & DELEGATION GOVERNANCE                 -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-admin-governance" role="tabpanel">
            <div class="row g-4 mb-4">
                <!-- Portal Access Scope Card -->
                <div class="col-12 col-lg-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.55); border: 1px solid rgba(56, 189, 248, 0.2);">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-white mb-0">
                                <i class="bi bi-shield-lock-fill text-info me-2"></i>Active Portal Clearance
                            </h6>
                            <?php if ($myScope === 'both'): ?>
                                <span class="badge text-white" style="background: linear-gradient(135deg, #8B5CF6, #3B82F6);">Dual Clearance</span>
                            <?php elseif ($myScope === 'admin_only'): ?>
                                <span class="badge bg-warning-subtle text-warning">Admin Only</span>
                            <?php else: ?>
                                <span class="badge bg-info-subtle text-info">CRM Only</span>
                            <?php endif; ?>
                        </div>

                        <p class="small text-muted mb-3">
                            Access clearances enforce system perimeter isolation to prevent unauthorized cross-portal movement:
                        </p>

                        <div class="d-flex flex-column gap-2.5">
                            <div class="p-3 rounded border <?= $myScope === 'both' || $myScope === 'admin_only' ? 'border-success bg-success-subtle' : 'border-secondary opacity-50' ?>" style="--bs-bg-opacity: 0.1;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small fw-bold text-white"><i class="bi bi-globe me-2 text-warning"></i>Website Admin CMS Access</span>
                                    <?= $myScope === 'both' || $myScope === 'admin_only' ? '<span class="badge bg-success text-white">Active Clearance</span>' : '<span class="badge bg-secondary">Blocked</span>' ?>
                                </div>
                                <div class="small text-muted" style="font-size: 0.73rem;">Public website content management, articles, case studies, and brand media.</div>
                            </div>

                            <div class="p-3 rounded border <?= $myScope === 'both' || $myScope === 'crm_only' ? 'border-success bg-success-subtle' : 'border-secondary opacity-50' ?>" style="--bs-bg-opacity: 0.1;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small fw-bold text-white"><i class="bi bi-kanban me-2 text-info"></i>CRM Workspace Access</span>
                                    <?= $myScope === 'both' || $myScope === 'crm_only' ? '<span class="badge bg-success text-white">Active Clearance</span>' : '<span class="badge bg-secondary">Blocked</span>' ?>
                                </div>
                                <div class="small text-muted" style="font-size: 0.73rem;">Sales pipelines, project deliverables, tickets, client CRM, and invoices.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delegation Rights & User Provisioning Card -->
                <div class="col-12 col-lg-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.55); border: 1px solid rgba(56, 189, 248, 0.2);">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold text-white mb-0">
                                <i class="bi bi-person-fill-gear text-warning me-2"></i>Provisioning &amp; Delegation Authority
                            </h6>
                            <span class="badge bg-dark border border-secondary text-info"><?= htmlspecialchars($myTierTitle) ?></span>
                        </div>

                        <p class="small text-muted mb-3">
                            Your account's authority tier determines your rights to provision users and delegate access:
                        </p>

                        <div class="table-responsive">
                            <table class="table table-custom small mb-0">
                                <tr>
                                    <td class="text-muted">Create New Users:</td>
                                    <td>
                                        <?= $canCreateUsers ? '<span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Authorized (users.create)</span>' : '<span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-circle me-1"></i>Unauthorized</span>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Delegate Roles:</td>
                                    <td>
                                        <?= $canDelegate ? '<span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Authorized (' . ($myTier === 1 ? 'Direct' : 'Standard with HITL Guardrails') . ')</span>' : '<span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-circle me-1"></i>Restricted</span>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Scope Assignment:</td>
                                    <td>
                                        <?= $canScope ? '<span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Authorized</span>' : '<span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-circle me-1"></i>Restricted</span>' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">High-Privilege Approval Gate:</td>
                                    <td>
                                        <?= $myTier === 1 ? '<span class="badge bg-info-subtle text-info">Exempt (Supreme Executive)</span>' : '<span class="badge bg-warning-subtle text-warning">Approval Required for Tier 1/2 Roles or Dual Scope</span>' ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tiered Escalation Matrix Explainer -->
            <div class="p-4 rounded-3" style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.08);">
                <h6 class="fw-bold text-white mb-3">
                    <i class="bi bi-diagram-3-fill text-info me-2"></i>Hierarchical Governance &amp; Executive Approval Rules
                </h6>
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded border border-danger-subtle h-100" style="background: rgba(239, 68, 68, 0.05);">
                            <div class="fw-bold text-white mb-1"><i class="bi bi-award-fill text-danger me-1"></i>Tier 1: Supreme Executive</div>
                            <div class="small text-muted mb-2">Roles: <code>superadmin</code>, <code>founder</code></div>
                            <p class="small text-muted mb-0" style="font-size: 0.72rem;">
                                Unrestricted authority. Can provision any user, assign Tier 1/2/3 roles, grant Dual Clearance, and sign off on pending privilege elevation tickets.
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded border border-primary-subtle h-100" style="background: rgba(59, 130, 246, 0.05);">
                            <div class="fw-bold text-white mb-1"><i class="bi bi-person-fill-gear text-primary me-1"></i>Tier 2: Senior Management</div>
                            <div class="small text-muted mb-2">Roles: <code>ceo</code>, <code>cto</code>, <code>coo</code>, <code>hr</code>, <code>sales_manager</code></div>
                            <p class="small text-muted mb-0" style="font-size: 0.72rem;">
                                Operational authority. Can directly provision standard staff (Tier 3). If assigning Tier 1/2 roles or dual-portal clearance, the request is automatically routed to the Approval Queue for Tier 1 authorization.
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="p-3 rounded border border-secondary h-100" style="background: rgba(255, 255, 255, 0.02);">
                            <div class="fw-bold text-white mb-1"><i class="bi bi-person text-secondary me-1"></i>Tier 3: Standard Workforce</div>
                            <div class="small text-muted mb-2">Roles: <code>developer</code>, <code>sales</code>, <code>designer</code>, <code>qa</code>, etc.</div>
                            <p class="small text-muted mb-0" style="font-size: 0.72rem;">
                                Execution authority only. Profile is restricted to assigned module duties. Cannot create new users or alter clearance scopes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
