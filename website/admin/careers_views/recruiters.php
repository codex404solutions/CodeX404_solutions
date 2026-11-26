<?php
declare(strict_types=1);

use App\Careers\RecruitmentAuthService;

$staff = RecruitmentAuthService::listAdminUsers();
$canManageRbac = current_admin_can('careers.settings.manage');
?>

<div class="row g-4">
    <div class="col-12 col-xl-8">
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">
                Recruiters &amp; Admin Access Control
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" style="background:transparent;">
                    <thead>
                        <tr class="small text-muted">
                            <th>Staff Member</th>
                            <th>Portal Scope</th>
                            <th>Assigned Roles</th>
                            <th class="text-end">Recruitment Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($staff as $u): ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?= htmlspecialchars((string)$u['name']) ?></div>
                                    <div class="small text-muted">@<?= htmlspecialchars((string)$u['username']) ?> &bull; <?= htmlspecialchars((string)$u['email']) ?></div>
                                </td>
                                <td class="small"><span class="badge bg-dark border border-secondary text-light"><?= htmlspecialchars((string)$u['access_scope']) ?></span></td>
                                <td class="small">
                                    <?php foreach ($u['roles_list'] as $r): ?>
                                        <span class="badge bg-info-subtle text-info me-1"><?= htmlspecialchars((string)$r) ?></span>
                                    <?php endforeach; ?>
                                </td>
                                <td class="text-end">
                                    <?php if ($canManageRbac): ?>
                                        <form method="POST" action="<?= admin_url('careers?tab=recruiters') ?>" class="d-inline-flex gap-1 align-items-center">
                                            <?= csrf_input_field() ?>
                                            <input type="hidden" name="action" value="assign_recruitment_role">
                                            <input type="hidden" name="user_id" value="<?= htmlspecialchars((string)$u['id']) ?>">
                                            <select name="role_slug" class="form-select form-select-sm" style="width:auto;">
                                                <option value="superadmin" <?= strtolower((string)$u['role']) === 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                                                <option value="recruiter" <?= in_array(strtolower((string)$u['role']), ['recruiter', 'hr'], true) ? 'selected' : '' ?>>Recruiter</option>
                                                <option value="viewer" <?= strtolower((string)$u['role']) === 'viewer' ? 'selected' : '' ?>>Viewer (Read-Only)</option>
                                            </select>
                                            <button type="submit" class="btn btn-outline-warning btn-sm">Apply</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="small text-muted">Super Admin Only</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-warning" style="border-color:rgba(255,255,255,0.08) !important;">Role Capabilities Matrix</div>
            <div class="card-body small">
                <div class="mb-3">
                    <strong class="text-white d-block">Super Admin</strong>
                    <span class="text-muted">Full access: manage jobs, forms, applications, interviews, emails, staff RBAC, recruitment settings &amp; logs.</span>
                </div>
                <div class="mb-3">
                    <strong class="text-info d-block">Recruiter</strong>
                    <span class="text-muted">Manage vacancies, customize forms, move candidate stages, add notes, schedule interviews, download CVs, edit templates, export CSV.</span>
                </div>
                <div class="mb-0">
                    <strong class="text-secondary d-block">Viewer</strong>
                    <span class="text-muted">Strict read-only visibility across vacancies and applications. Blocked at backend from status updates, form edits, CV export, or settings.</span>
                </div>
            </div>
        </div>
    </div>
</div>
