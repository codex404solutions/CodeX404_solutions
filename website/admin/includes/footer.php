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
                <!-- ADMIN CONSOLE ENTERPRISE FOOTER                          -->
                <!-- ======================================================== -->
                <footer class="admin-footer mt-auto">
                    <div class="row g-4 align-items-center">
                        <!-- Brand & Scope -->
                        <div class="col-12 col-md-5">
                            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                <span class="admin-footer-brand-pill">
                                    <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions"
                                        style="height: 26px; object-fit: contain;">
                                </span>
                                <span class="badge border text-uppercase"
                                    style="font-size: 0.6rem; letter-spacing: 0.08em; background: #0F172A; color: #38BDF8; border-color: rgba(56, 189, 248, 0.3) !important;">
                                    DELIVERABLES ADMIN
                                </span>
                                <span class="admin-footer-badge">Production v2.4</span>
                            </div>
                            <p class="text-muted small mb-2" style="max-width: 440px; font-size: 0.8rem; line-height: 1.5;">
                                Centralized administration console for CodeX404 production solutions, live client systems,
                                high-throughput interactive sandboxes, and verified engineering telemetry.
                            </p>
                            <div class="d-flex align-items-center gap-2 text-muted small" style="font-size: 0.75rem;">
                                <span><i class="bi bi-shield-check text-success me-1"></i> ISO/IEC 27001 Aligned</span>
                                <span>&bull;</span>
                                <span><i class="bi bi-speedometer2 text-info me-1"></i> 99.98% SLA Uptime</span>
                                <span>&bull;</span>
                                <span><i class="bi bi-hdd-network text-primary me-1"></i> Sub-100ms Edge</span>
                            </div>
                        </div>

                        <!-- Telemetry Summary -->
                        <div class="col-12 col-md-4">
                            <div class="admin-footer-telemetry">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="small fw-bold text-uppercase text-muted"
                                        style="font-size: 0.68rem; letter-spacing: 0.06em;">Repository Status</span>
                                    <span class="d-flex align-items-center gap-1 text-success small"
                                        style="font-size: 0.72rem;">
                                        <span class="live-dot" style="width: 6px; height: 6px;"></span> Active
                                        Synchronization
                                    </span>
                                </div>
                                <div class="row g-2 text-center" style="font-size: 0.75rem;">
                                    <div class="col-4">
                                        <div class="admin-footer-stat-box">
                                            <div class="fw-bold text-info"><?= $totalCount ?></div>
                                            <div class="admin-footer-stat-label">Total Projects</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="admin-footer-stat-box">
                                            <div class="fw-bold text-success"><?= $activeCount ?></div>
                                            <div class="admin-footer-stat-label">Published</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="admin-footer-stat-box">
                                            <div class="fw-bold text-warning"><?= $draftCount ?></div>
                                            <div class="admin-footer-stat-label">In Review</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cross-Platform Navigation -->
                        <div class="col-12 col-md-3 text-md-end">
                            <div class="small fw-bold text-uppercase text-muted mb-2"
                                style="font-size: 0.68rem; letter-spacing: 0.06em;">Platform Bridges</div>
                            <div class="d-flex flex-column gap-1 align-items-md-end">
                                <a href="../../crm/" target="_blank" class="admin-footer-link text-warning">
                                    <i class="bi bi-robot"></i> <span>Company CRM &amp; Paperclip</span>
                                </a>
                                <a href="<?= url('#work') ?>" target="_blank" class="admin-footer-link">
                                    <i class="bi bi-box-arrow-up-right text-primary"></i> <span>Public Portfolio
                                        Showcase</span>
                                </a>
                                <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-footer-link">
                                    <i class="bi bi-lightning-charge text-info"></i> <span>Client Discovery Intake
                                        Form</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Copyright & Security Notice -->
                    <div class="admin-footer-divider pt-3 mt-3 d-flex flex-wrap align-items-center justify-content-between gap-2"
                        style="font-size: 0.75rem;">
                        <div class="text-muted">
                            &copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong>. Enterprise Deliverables Admin
                            Console &bull; Built with PHP 8.3 &bull; Bootstrap 5.3.3 &bull; All Rights Reserved.
                        </div>
                        <div class="d-flex align-items-center gap-3 text-muted flex-wrap">
                            <span class="d-flex align-items-center gap-1"><i class="bi bi-database-check text-info"></i>
                                Storage: JSON Data Store</span>
                            <span>&bull;</span>
                            <span class="d-flex align-items-center gap-1"><i class="bi bi-shield-lock text-success"></i>
                                Active Session</span>
                            <span>&bull;</span>
                            <a href="<?= admin_url('logout') ?>" class="text-danger text-decoration-none fw-semibold"><i
                                    class="bi bi-box-arrow-left me-1"></i>Sign Out</a>
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
                                style="background: rgba(168, 85, 247, 0.08); border: 1px solid rgba(168, 85, 247, 0.2);">
                                <div class="h4 fw-bold text-primary mb-0" id="previewStat3Val">-</div>
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
            <!-- User Status Card -->
            <div class="p-2 mb-3 rounded-3"
                style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="d-flex align-items-center gap-2">
                        <span class="live-dot" title="Active Session" style="width: 6px; height: 6px;"></span>
                        <span class="fw-bold small text-white"
                            style="font-size: 0.78rem;"><?= htmlspecialchars((string) ($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                    </div>
                    <a href="<?= admin_url('logout') ?>" class="text-danger small text-decoration-none" title="Sign Out"
                        style="font-size: 0.75rem;"><i class="bi bi-box-arrow-left"></i></a>
                </div>
                <div class="d-flex gap-1 flex-wrap">
                    <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase"
                        style="font-size: 0.58rem;">Superadmin</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle"
                        style="font-size: 0.58rem;">Live Sync</span>
                </div>
            </div>

            <div class="d-grid mb-3">
                <a href="<?= admin_url('project-form') ?>"
                    class="btn btn-info btn-sm fw-bold text-dark d-flex align-items-center justify-content-center gap-2 py-2"
                    style="background: #38BDF8; border-color: #38BDF8; border-radius: 8px;">
                    <i class="bi bi-plus-lg"></i>
                    <span>New Deliverable</span>
                </a>
            </div>

            <div class="admin-sidebar-section-title">Pages</div>
            <nav class="nav flex-column mb-3">
                <a href="<?= admin_url() ?>" class="admin-sidebar-link <?= ($currentPage === 'overview') ? 'active' : '' ?>">
                    <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Overview</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Top</span>
                </a>
                <a href="<?= admin_url('deliverables') ?>" class="admin-sidebar-link <?= ($currentPage === 'deliverables') ? 'active' : '' ?>">
                    <span><i class="bi bi-collection-play-fill me-2 text-warning"></i> Deliverables</span>
                    <span
                        class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $totalCount ?></span>
                </a>
                <a href="<?= admin_url('showcase') ?>" class="admin-sidebar-link <?= ($currentPage === 'showcase') ? 'active' : '' ?>">
                    <span><i class="bi bi-stars me-2 text-primary"></i> Showcase</span>
                    <span
                        class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill"><?= min(6, $totalCount) ?></span>
                </a>
                <a href="<?= admin_url('users') ?>" class="admin-sidebar-link <?= ($currentPage === 'users') ? 'active' : '' ?>">
                    <span><i class="bi bi-people-fill me-2 text-info"></i> Users &amp; Roles</span>
                    <span
                        class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">RBAC</span>
                </a>
                <a href="<?= admin_url('profile') ?>" class="admin-sidebar-link <?= ($currentPage === 'profile') ? 'active' : '' ?>">
                    <span><i class="bi bi-person-badge me-2 text-primary"></i> My Profile</span>
                </a>
                <a href="<?= admin_url('telemetry') ?>" class="admin-sidebar-link <?= ($currentPage === 'telemetry') ? 'active' : '' ?>">
                    <span><i class="bi bi-activity me-2 text-success"></i> Telemetry</span>
                    <span
                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Live</span>
                </a>
            </nav>

            <div class="admin-sidebar-section-title">Filter By Status</div>
            <div class="d-flex flex-column gap-1 mb-3">
                <?php if ($currentPage === 'deliverables'): ?>
                    <button type="button" class="admin-sidebar-link sidebar-status-filter active" data-status-filter="all"
                        data-bs-dismiss="offcanvas">
                        <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                        <span
                            class="badge bg-dark border border-secondary text-white rounded-pill"><?= $totalCount ?></span>
                    </button>
                    <button type="button" class="admin-sidebar-link sidebar-status-filter" data-status-filter="published"
                        data-bs-dismiss="offcanvas">
                        <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                        <span
                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"><?= $activeCount ?></span>
                    </button>
                    <button type="button" class="admin-sidebar-link sidebar-status-filter" data-status-filter="draft"
                        data-bs-dismiss="offcanvas">
                        <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                        <span
                            class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $draftCount ?></span>
                    </button>
                <?php else: ?>
                    <a href="<?= admin_url('deliverables?filter=all') ?>" class="admin-sidebar-link">
                        <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                        <span
                            class="badge bg-dark border border-secondary text-white rounded-pill"><?= $totalCount ?></span>
                    </a>
                    <a href="<?= admin_url('deliverables?filter=published') ?>" class="admin-sidebar-link">
                        <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                        <span
                            class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"><?= $activeCount ?></span>
                    </a>
                    <a href="<?= admin_url('deliverables?filter=draft') ?>" class="admin-sidebar-link">
                        <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                        <span
                            class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $draftCount ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <div class="admin-sidebar-section-title">Platform Bridges</div>
            <div class="d-flex gap-1 mb-3">
                <a href="../../crm/" target="_blank"
                    class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                    style="font-size: 0.72rem;">
                    <i class="bi bi-robot me-1 text-warning"></i> CRM
                </a>
                <a href="<?= url('#work') ?>" target="_blank"
                    class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                    style="font-size: 0.72rem;">
                    <i class="bi bi-globe2 me-1 text-primary"></i> Public
                </a>
                <a href="<?= url('discovery-call') ?>" target="_blank"
                    class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                    style="font-size: 0.72rem;">
                    <i class="bi bi-lightning-charge me-1 text-info"></i> Intake
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
