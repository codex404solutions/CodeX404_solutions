<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — User Profile, Multi-Role Profiling & Effective Permissions
 */

namespace CRM;

use CRM\Services\RBACService;
use CRM\Services\UserService;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'profile';
$pageTitle = 'Account Profiling & Multi-Role Footprint';
$pageSubtitle = 'Personal profile telemetry, active multi-role footprint, and effective system permission matrix';
$htmlTitle = 'User Profile & Multi-Role Footprint — CodeX404 Solutions CRM';

$avatar = UserService::getAvatarInfo($currentUser);
$myRoles = (array)($currentUser['roles'] ?? ['admin']);
$effectivePerms = RBACService::getEffectivePermissions($myRoles, (array)($currentUser['custom_permissions'] ?? null));
$myScope = $currentUser['access_scope'] ?? 'crm_only';
$myTier = RBACService::getAuthorityTier($myRoles);
$myTierTitle = RBACService::getTierTitle($myTier);
$canCreateUsers = RBACService::hasPermission($myRoles, 'users.create', (array)($currentUser['custom_permissions'] ?? null));
$canEditUsers = RBACService::hasPermission($myRoles, 'users.edit', (array)($currentUser['custom_permissions'] ?? null));
$canDelegate = RBACService::hasPermission($myRoles, 'users.delegate', (array)($currentUser['custom_permissions'] ?? null)) || $canEditUsers;
$canScope = RBACService::hasPermission($myRoles, 'users.scope', (array)($currentUser['custom_permissions'] ?? null)) || $canEditUsers;

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- 1. PROFILE HERO HEADER BANNER                            -->
<!-- ======================================================== -->
<div class="crm-card p-4 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-4">
        <div class="d-flex align-items-center gap-4">
            <!-- Large Styled Avatar with Upload / Remove Controls -->
            <div class="position-relative group">
                <div class="position-relative">
                    <?php if (!empty($avatar['image'])): ?>
                        <img src="<?= htmlspecialchars($avatar['image']) ?>" alt="<?= htmlspecialchars($currentUser['name'] ?? 'User') ?>"
                             id="userProfileAvatarPreview"
                             class="rounded-circle object-fit-cover shadow-lg border"
                             style="width: 82px; height: 82px; border: 2px solid rgba(56, 189, 248, 0.45) !important;">
                    <?php else: ?>
                        <div id="userProfileAvatarPreview"
                             class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-lg"
                             style="width: 82px; height: 82px; background: <?= $avatar['background'] ?>; color: <?= $avatar['color'] ?>; font-size: 1.6rem; border: 2px solid rgba(56, 189, 248, 0.4);">
                            <?= htmlspecialchars($avatar['initials']) ?>
                        </div>
                    <?php endif; ?>
                    <span class="position-absolute bottom-0 end-0 p-1.5 rounded-circle border border-dark"
                          style="width: 18px; height: 18px; background: #10B981;"
                          title="Session: Authenticated &amp; Active"></span>
                </div>
            </div>

            <!-- Avatar Action Controls -->
            <div class="d-flex flex-column gap-1">
                <div class="d-flex align-items-center gap-2">
                    <form method="POST" enctype="multipart/form-data" id="formUploadAvatar" class="d-inline">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                        <input type="hidden" name="action" value="upload_avatar">
                        <input type="file" name="avatar_file" id="avatarFileInput" class="d-none" accept="image/png, image/jpeg, image/webp, image/svg+xml" onchange="document.getElementById('formUploadAvatar').submit();">
                        <button type="button" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1.5 px-2.5 py-1" onclick="document.getElementById('avatarFileInput').click();" title="Upload new display picture">
                            <i class="bi bi-camera-fill"></i>
                            <span style="font-size: 0.78rem;">Upload DP</span>
                        </button>
                    </form>

                    <?php if (!empty($avatar['image'])): ?>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Remove custom display picture and reset to initials badge?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
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
                    <h3 class="fw-bold text-white mb-0"><?= htmlspecialchars($currentUser['name'] ?? 'User') ?></h3>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i class="bi bi-patch-check-fill me-1"></i>Active Account
                    </span>
                    <span class="badge bg-dark border border-secondary text-info mono">
                        @<?= htmlspecialchars($currentUser['username'] ?? 'user') ?>
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
                    <span class="text-white fw-semibold"><?= htmlspecialchars($currentUser['title'] ?? 'Staff') ?></span> &bull; 
                    <span><?= htmlspecialchars($currentUser['department'] ?? 'Operations') ?></span> &bull; 
                    <span class="mono text-info"><?= htmlspecialchars($currentUser['email'] ?? '') ?></span>
                </div>

                <!-- Multi-Role Badges -->
                <div class="d-flex align-items-center gap-1.5 flex-wrap">
                    <span class="small text-muted fw-bold text-uppercase me-1" style="font-size: 0.68rem;">Active Multi-Roles:</span>
                    <?php foreach ($myRoles as $rSlug): 
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

        <!-- Quick Summary Metrics -->
        <div class="d-flex align-items-center gap-3">
            <div class="text-center p-3 rounded-3" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.08); min-width: 110px;">
                <div class="h4 fw-bold text-info mb-0"><?= count($myRoles) ?></div>
                <div class="small text-muted" style="font-size: 0.7rem;">Concurrent Roles</div>
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
<div class="crm-card p-4">
    <ul class="nav nav-pills mb-4" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="tab-info-btn" data-bs-toggle="pill" data-bs-target="#tab-profile-info" type="button" role="tab">
                <i class="bi bi-person-lines-fill me-2"></i>Profile Information
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-multirole-btn" data-bs-toggle="pill" data-bs-target="#tab-profile-roles" type="button" role="tab">
                <i class="bi bi-diagram-3-fill me-2"></i>Multi-Role Footprint (<?= count($myRoles) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-perms-btn" data-bs-toggle="pill" data-bs-target="#tab-profile-perms" type="button" role="tab">
                <i class="bi bi-key-fill me-2"></i>Effective Permissions (<?= count($effectivePerms['effective']) ?>)
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-sec-btn" data-bs-toggle="pill" data-bs-target="#tab-profile-security" type="button" role="tab">
                <i class="bi bi-shield-lock-fill me-2"></i>Security &amp; Password
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="tab-gov-btn" data-bs-toggle="pill" data-bs-target="#tab-profile-governance" type="button" role="tab">
                <i class="bi bi-shield-shaded me-2"></i>Clearance &amp; Governance
            </button>
        </li>
    </ul>

    <div class="tab-content" id="profileTabsContent">
        <!-- ======================================================== -->
        <div class="tab-pane fade show active" id="tab-profile-info" role="tabpanel">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <input type="hidden" name="action" value="update_my_profile">

                <!-- Display Picture Quick Field -->
                <div class="p-3 mb-4 rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.2);">
                    <div class="d-flex align-items-center gap-3">
                        <?php if (!empty($avatar['image'])): ?>
                            <img src="<?= htmlspecialchars($avatar['image']) ?>" alt="Current Avatar" class="rounded-circle object-fit-cover border" style="width: 48px; height: 48px; border-color: rgba(56, 189, 248, 0.4) !important;">
                        <?php else: ?>
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 48px; height: 48px; background: <?= $avatar['background'] ?>; color: <?= $avatar['color'] ?>; font-size: 1rem;">
                                <?= htmlspecialchars($avatar['initials']) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="fw-bold text-white small">Profile Display Picture</div>
                            <div class="text-muted" style="font-size: 0.72rem;">Choose a PNG, JPG, WEBP or SVG photo to represent you across CRM and Website portals.</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <input type="file" name="avatar_file" class="form-control form-control-sm" accept="image/png, image/jpeg, image/webp, image/svg+xml" style="max-width: 260px;">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Full Legal Name</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($currentUser['name'] ?? '') ?>" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Username Handle</label>
                        <input type="text" class="form-control mono text-muted" value="@<?= htmlspecialchars($currentUser['username'] ?? 'admin') ?>" disabled readonly>
                        <div class="form-text text-muted" style="font-size: 0.72rem;">Usernames are permanently bound to system activity records.</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Primary Work Email</label>
                        <input type="email" class="form-control mono text-muted" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" disabled readonly>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Direct Phone / Signal Contact</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Organizational Title / Designation</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($currentUser['title'] ?? '') ?>" placeholder="Chief Technology Officer">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Department Unit</label>
                        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($currentUser['department'] ?? '') ?>" placeholder="Executive Engineering">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Timezone Setting</label>
                        <select name="timezone" class="form-select">
                            <option value="America/New_York" <?= ($currentUser['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' ?>>America/New_York (UTC-5)</option>
                            <option value="America/Los_Angeles" <?= ($currentUser['timezone'] ?? '') === 'America/Los_Angeles' ? 'selected' : '' ?>>America/Los_Angeles (UTC-8)</option>
                            <option value="Europe/London" <?= ($currentUser['timezone'] ?? '') === 'Europe/London' ? 'selected' : '' ?>>Europe/London (UTC+0)</option>
                            <option value="Europe/Berlin" <?= ($currentUser['timezone'] ?? '') === 'Europe/Berlin' ? 'selected' : '' ?>>Europe/Berlin (UTC+1)</option>
                            <option value="Asia/Dubai" <?= ($currentUser['timezone'] ?? '') === 'Asia/Dubai' ? 'selected' : '' ?>>Asia/Dubai (UTC+4)</option>
                            <option value="Asia/Kolkata" <?= ($currentUser['timezone'] ?? '') === 'Asia/Kolkata' ? 'selected' : '' ?>>Asia/Kolkata (UTC+5:30)</option>
                            <option value="Asia/Singapore" <?= ($currentUser['timezone'] ?? '') === 'Asia/Singapore' ? 'selected' : '' ?>>Asia/Singapore (UTC+8)</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label small fw-bold text-muted">Preferred Monetary Currency</label>
                        <select name="currency" class="form-select">
                            <option value="USD" <?= ($currentUser['currency'] ?? '') === 'USD' ? 'selected' : '' ?>>USD ($) — United States Dollar</option>
                            <option value="INR" <?= ($currentUser['currency'] ?? '') === 'INR' ? 'selected' : '' ?>>INR (₹) — Indian Rupee</option>
                            <option value="EUR" <?= ($currentUser['currency'] ?? '') === 'EUR' ? 'selected' : '' ?>>EUR (€) — Euro</option>
                            <option value="GBP" <?= ($currentUser['currency'] ?? '') === 'GBP' ? 'selected' : '' ?>>GBP (£) — British Pound</option>
                            <option value="AED" <?= ($currentUser['currency'] ?? '') === 'AED' ? 'selected' : '' ?>>AED (د.إ) — UAE Dirham</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted">Professional Summary &amp; Bio</label>
                        <textarea name="bio" class="form-control" rows="3"><?= htmlspecialchars($currentUser['bio'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-info fw-bold text-dark px-4 py-2">
                        <i class="bi bi-save me-1"></i> Update Profile Information
                    </button>
                </div>
            </form>
        </div>

        <!-- ======================================================== -->
        <!-- TAB 2: MULTI-ROLE FOOTPRINT & ARCHITECTURAL LOGIC        -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-profile-roles" role="tabpanel">
            <div class="p-3 rounded-3 mb-4" style="background: rgba(56, 189, 248, 0.05); border: 1px solid rgba(56, 189, 248, 0.2);">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <i class="bi bi-info-circle-fill text-info fs-5"></i>
                    <h6 class="fw-bold text-white mb-0">Multi-Role Architecture Policy (CodeX404 Mandatory Rule #1)</h6>
                </div>
                <p class="small text-muted mb-0">
                    A single team member can hold multiple roles simultaneously without needing multiple separate accounts. Your authorized system capability is the strict <strong>Union of permissions from all active roles</strong> (plus custom grants, minus explicit denials).
                </p>
            </div>

            <div class="row g-3">
                <?php foreach ($myRoles as $rSlug): 
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
                                    Inherited Permissions (<?= $isWildcard ? 'Full Access' : count($rolePerms) ?>):
                                </div>
                                <?php if ($isWildcard): ?>
                                    <span class="badge bg-danger-subtle text-danger"><i class="bi bi-asterisk me-1"></i>Full Master Wildcard (*)</span>
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
        <div class="tab-pane fade" id="tab-profile-perms" role="tabpanel">
            <p class="text-muted small mb-3">
                Calculated union of all permissions granted across your <?= count($myRoles) ?> assigned roles. Every check evaluates <code class="text-info">AuthService::can('slug')</code>.
            </p>

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
                                            <i class="bi bi-shield-check me-1"></i><?= htmlspecialchars($sourceName) ?>
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
        <!-- TAB 4: SECURITY & CREDENTIALS MANAGEMENT                 -->
        <!-- ======================================================== -->
        <div class="tab-pane fade" id="tab-profile-security" role="tabpanel">
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="p-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <h6 class="fw-bold text-white mb-3"><i class="bi bi-key text-warning me-2"></i>Change Master Password</h6>
                        
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                            <input type="hidden" name="action" value="change_my_password">

                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required placeholder="Enter current password">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted">New Password</label>
                                <input type="password" name="new_password" id="newPasswordInput" class="form-control" required minlength="8" placeholder="Minimum 8 characters">
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
                        <h6 class="fw-bold text-white mb-3"><i class="bi bi-shield-check text-success me-2"></i>Active Session Security Telemetry</h6>
                        
                        <div class="table-responsive">
                            <table class="table table-custom small mb-0">
                                <tr>
                                    <td class="text-muted">Client IP Address:</td>
                                    <td class="mono text-info"><?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">User Agent Signature:</td>
                                    <td class="small text-muted text-truncate" style="max-width: 250px;">
                                        <?= htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Session Cookie Flags:</td>
                                    <td><span class="badge bg-success-subtle text-success">HTTPOnly &bull; SameSite=Lax</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Session Rotation:</td>
                                    <td><span class="badge bg-info-subtle text-info">Regenerated on Privilege Change</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Storage Subsystem:</td>
                                    <td class="mono text-muted">StorageService (Hybrid MySQL + JSON)</td>
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
        <div class="tab-pane fade" id="tab-profile-governance" role="tabpanel">
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
                            <div class="p-3 rounded border <?= $myScope === 'both' || $myScope === 'crm_only' ? 'border-success bg-success-subtle' : 'border-secondary opacity-50' ?>" style="--bs-bg-opacity: 0.1;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small fw-bold text-white"><i class="bi bi-kanban me-2 text-info"></i>CRM Workspace Access</span>
                                    <?= $myScope === 'both' || $myScope === 'crm_only' ? '<span class="badge bg-success text-white">Active Clearance</span>' : '<span class="badge bg-secondary">Blocked</span>' ?>
                                </div>
                                <div class="small text-muted" style="font-size: 0.73rem;">Sales pipelines, project deliverables, tickets, client CRM, and invoices.</div>
                            </div>

                            <div class="p-3 rounded border <?= $myScope === 'both' || $myScope === 'admin_only' ? 'border-success bg-success-subtle' : 'border-secondary opacity-50' ?>" style="--bs-bg-opacity: 0.1;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small fw-bold text-white"><i class="bi bi-globe me-2 text-warning"></i>Website Admin CMS Access</span>
                                    <?= $myScope === 'both' || $myScope === 'admin_only' ? '<span class="badge bg-success text-white">Active Clearance</span>' : '<span class="badge bg-secondary">Blocked</span>' ?>
                                </div>
                                <div class="small text-muted" style="font-size: 0.73rem;">Public website content management, articles, case studies, and brand media.</div>
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
