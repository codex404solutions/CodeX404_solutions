<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Multi-Page Footer & Modals Include
 */

// Ensure variables are defined
$totalCount = $totalCount ?? 0;
$activeCount = $activeCount ?? 0;
$draftCount = $draftCount ?? 0;
$currentPage = $currentPage ?? 'overview';
?>
                <!-- ======================================================== -->
                <!-- ADMIN CONSOLE FOOTER                                     -->
                <!-- ======================================================== -->
                <footer class="admin-footer mt-auto py-3 px-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.76rem;">
                        <div class="text-muted d-flex align-items-center gap-2 flex-wrap">
                            <span>&copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong>.</span>
                            <span>&middot;</span>
                            <span class="d-inline-flex align-items-center gap-1">
                                Developed by
                                <a href="https://codex404solutions.com" target="_blank" rel="noopener noreferrer"
                                    class="d-inline-flex align-items-center text-decoration-none">
                                    <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions"
                                        style="height: 15px; object-fit: contain;">
                                </a>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-muted">
                            <span>Admin Console v2.4</span>
                            <span>&middot;</span>
                            <span>PHP <?= PHP_VERSION ?></span>
                            <span>&middot;</span>
                            <a href="<?= admin_url('logout') ?>" class="text-danger text-decoration-none fw-semibold d-inline-flex align-items-center gap-1">
                                <i class="bi bi-box-arrow-left"></i><span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </footer>

            </main>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: PROJECT SPEC PREVIEW                              -->
    <!-- ======================================================== -->
    <div class="modal fade" id="modalProjectPreview" tabindex="-1" aria-labelledby="modalProjectPreviewLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase"
                            id="previewCategory">Software</span>
                        <h5 class="modal-title fw-bold mb-0" id="previewTitle">Project Title</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Host preview banner -->
                    <div class="p-3 rounded-3 mb-3 d-flex align-items-center justify-content-between"
                        style="background: rgba(34, 211, 238, 0.05); border: 1px solid rgba(34, 211, 238, 0.2);">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-hdd-network text-info"></i>
                            <span class="small fw-bold text-muted">HOST:</span>
                            <code class="text-white" id="previewHost">app.system.online</code>
                        </div>
                        <a href="#" id="previewLiveLink" target="_blank" class="btn btn-xs btn-outline-info py-1 px-2"
                            style="font-size: 0.75rem;">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Visit System
                        </a>
                    </div>

                    <!-- Problem Statement -->
                    <div class="mb-3">
                        <h6 class="fw-bold small text-muted text-uppercase mb-1"><i
                                class="bi bi-exclamation-circle text-warning me-1"></i> Client Challenge &amp; Problem
                        </h6>
                        <p class="small text-muted p-3 rounded-3"
                            style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);"
                            id="previewProblem">-</p>
                    </div>

                    <!-- Engineering Solution -->
                    <div class="mb-3">
                        <h6 class="fw-bold small text-muted text-uppercase mb-1"><i
                                class="bi bi-gear-wide-connected text-primary me-1"></i> CodeX404 Engineering Solution
                        </h6>
                        <p class="small text-muted p-3 rounded-3"
                            style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);"
                            id="previewSolution">-</p>
                    </div>

                    <!-- 3 Key Metric Cards -->
                    <h6 class="fw-bold small text-muted text-uppercase mb-2"><i
                            class="bi bi-speedometer2 text-success me-1"></i> Verified Performance Metrics</h6>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="p-3 text-center rounded-3"
                                style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                                <div class="h4 fw-bold text-success mb-0" id="previewStat1Val">-</div>
                                <small class="text-muted" id="previewStat1Lbl">Metric 1</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 text-center rounded-3"
                                style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.2);">
                                <div class="h4 fw-bold text-info mb-0" id="previewStat2Val">-</div>
                                <small class="text-muted" id="previewStat2Lbl">Metric 2</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 text-center rounded-3"
                                style="background: var(--cx-accent-soft); border: 1px solid var(--cx-accent-border);">
                                <div class="h4 fw-bold mb-0" style="color: var(--cx-accent);" id="previewStat3Val">-</div>
                                <small class="text-muted" id="previewStat3Lbl">Metric 3</small>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Container -->
                    <div>
                        <h6 class="fw-bold small text-muted text-uppercase mb-1">Architecture Tags</h6>
                        <div id="previewTags" class="d-flex flex-wrap gap-1"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL: DELETE CONFIRMATION                               -->
    <!-- ======================================================== -->
    <div class="modal fade" id="modalDeleteProject" tabindex="-1" aria-labelledby="modalDeleteProjectLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom border-danger-subtle">
                    <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p>Are you sure you want to permanently delete this deliverable from the CodeX404 website portfolio?
                    </p>
                    <div class="p-3 rounded-3 mb-2"
                        style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25);">
                        <strong class="text-danger" id="deleteProjectTitle">Project Title</strong>
                        <div class="small text-muted" id="deleteProjectId">ID: project-id</div>
                    </div>
                    <small class="text-muted">This action cannot be undone. Public links to this showcase item will
                        become 404.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="<?= admin_url('delete') ?>" id="deleteProjectForm">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="id" id="deleteProjectInputId" value="">
                        <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '') ?>">
                        <button type="submit" class="btn btn-danger btn-sm fw-bold">
                            <i class="bi bi-trash3 me-1"></i> Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MOBILE OFFCANVAS SIDEBAR                                 -->
    <!-- ======================================================== -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="adminMobileSidebar"
        style="width: 280px;">
        <div class="offcanvas-header border-bottom border-secondary">
            <a href="<?= admin_url() ?>" class="d-inline-block text-decoration-none">
                <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions"
                    style="max-height: 32px; object-fit: contain;">
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge border text-uppercase"
                    style="font-size: 0.6rem; letter-spacing: 0.08em; background: #0F172A; color: #38BDF8; border-color: rgba(56, 189, 248, 0.3) !important;">ADMIN</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body p-3">
            <!-- User Profile Card -->
            <?php
            $mobProfile = $adminProfile ?? current_admin_profile();
            $mobRoles = (array) ($mobProfile['roles'] ?? ['superadmin']);
            $mobName = (string) ($mobProfile['name'] ?? $mobProfile['username'] ?? 'Admin');
            $mobRoleLbl = ucfirst((string) ($mobRoles[0] ?? 'admin')) . (count($mobRoles) > 1 ? ' · +' . (count($mobRoles) - 1) : '');
            $mobInitials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $mobName) ?: 'A', 0, 2));
            ?>
            <div class="admin-profile-card">
                <a href="<?= admin_url('profile') ?>" class="d-flex align-items-center justify-content-between gap-2 text-decoration-none" style="min-width: 0;" title="Open Account Profile">
                    <div class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                        <div class="admin-profile-avatar-wrap">
                            <?php if (!empty($headerAvatar['image'])): ?>
                                <img src="<?= asset($headerAvatar['image']) ?>" alt="<?= htmlspecialchars($mobName) ?>" class="admin-profile-avatar">
                            <?php else: ?>
                                <div class="admin-profile-initials"><?= htmlspecialchars($mobInitials) ?></div>
                            <?php endif; ?>
                            <span class="admin-profile-status-dot" title="Active Session"></span>
                        </div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="fw-semibold text-white text-truncate" style="font-size: 0.84rem;"><?= htmlspecialchars($mobName) ?></div>
                            <div class="text-truncate" style="font-size: 0.72rem; color: #94A3B8;"><?= htmlspecialchars($mobRoleLbl) ?></div>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; flex-shrink: 0;"></i>
                </a>
            </div>

            <div class="d-grid mb-3">
                <a href="<?= admin_url('project-form') ?>"
                    class="btn btn-sm btn-cx-primary d-flex align-items-center justify-content-center gap-2 py-2">
                    <i class="bi bi-plus-lg"></i>
                    <span>New Deliverable</span>
                </a>
            </div>

            <div class="admin-sidebar-section-title">Pages</div>
            <nav class="nav flex-column mb-3">
                <a href="<?= admin_url() ?>" class="admin-sidebar-link <?= ($currentPage === 'overview') ? 'active' : '' ?>">
                    <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-grid-1x2"></i><span>Overview</span></span>
                </a>
                <?php if (current_admin_can('portfolio.view')): ?>
                    <a href="<?= admin_url('deliverables') ?>" class="admin-sidebar-link <?= ($currentPage === 'deliverables') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-collection-play"></i><span>Deliverables</span></span>
                        <span class="admin-sidebar-count"><?= $totalCount ?></span>
                    </a>
                    <a href="<?= admin_url('showcase') ?>" class="admin-sidebar-link <?= ($currentPage === 'showcase') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-layers"></i><span>Showcase</span></span>
                        <span class="admin-sidebar-count"><?= min(6, $totalCount) ?></span>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('inquiries.view')): ?>
                    <a href="<?= admin_url('inquiries') ?>" class="admin-sidebar-link <?= ($currentPage === 'inquiries') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-envelope-paper"></i><span>Inquiries</span></span>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('careers.view')): ?>
                    <a href="<?= admin_url('careers') ?>" class="admin-sidebar-link <?= ($currentPage === 'careers') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-briefcase"></i><span>Careers &amp; Hiring</span></span>
                        <span class="admin-sidebar-count">ATS</span>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('users.view')): ?>
                    <a href="<?= admin_url('users') ?>" class="admin-sidebar-link <?= ($currentPage === 'users') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-people"></i><span>Users &amp; Roles</span></span>
                    </a>
                <?php endif; ?>
                <a href="<?= admin_url('profile') ?>" class="admin-sidebar-link <?= ($currentPage === 'profile') ? 'active' : '' ?>">
                    <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-person-badge"></i><span>My Profile</span></span>
                </a>
                <?php if (current_admin_can('settings.view')): ?>
                    <a href="<?= admin_url('logs') ?>" class="admin-sidebar-link <?= ($currentPage === 'logs') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-journal-text"></i><span>Audit Logs</span></span>
                    </a>
                    <a href="<?= admin_url('telemetry') ?>" class="admin-sidebar-link <?= ($currentPage === 'telemetry') ? 'active' : '' ?>">
                        <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-activity"></i><span>Telemetry</span></span>
                    </a>
                <?php endif; ?>
            </nav>

            <div class="admin-sidebar-section-title">Platform bridges</div>
            <div class="admin-bridge-grid mb-3">
                <?php $crmMobileOk = is_dir(dirname(__DIR__, 3) . '/crm'); ?>
                <?php if ($crmMobileOk): ?>
                    <a href="../../crm/" target="_blank" class="admin-sidebar-bridge-link">
                        <i class="bi bi-robot text-warning"></i><span>CRM</span>
                    </a>
                <?php else: ?>
                    <span class="admin-sidebar-bridge-link text-muted opacity-50" style="cursor: not-allowed;">
                        <i class="bi bi-lock-fill text-secondary"></i><span>CRM</span>
                    </span>
                <?php endif; ?>
                <a href="<?= url('#work') ?>" target="_blank" class="admin-sidebar-bridge-link">
                    <i class="bi bi-globe2 text-primary"></i><span>Public</span>
                </a>
                <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-sidebar-bridge-link">
                    <i class="bi bi-lightning-charge text-info"></i><span>Intake</span>
                </a>
            </div>

            <hr style="border-color: rgba(255, 255, 255, 0.1);">
            <div class="d-grid">
                <a href="<?= admin_url('logout') ?>"
                    class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-left"></i> Sign Out
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Admin Console JS (Browser-Cached) -->
    <script src="<?= asset('js/admin.js') ?>" defer></script>
</body>
</html>
