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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // =========================================================
            // Real-Time Filter & Search (For Deliverables Table)
            // =========================================================
            const searchInput = document.getElementById('projectSearch');
            const statusPillBtns = document.querySelectorAll('.filter-pill-btn');
            const categoryFilter = document.getElementById('categoryFilter');
            const rows = document.querySelectorAll('.project-row');
            const counterText = document.getElementById('tableCounterText');

            // Read URL parameter if prefiltered
            const urlParams = new URLSearchParams(window.location.search);
            const initialFilterParam = urlParams.get('filter');
            let currentStatus = (initialFilterParam === 'published' || initialFilterParam === 'active') ? 'active' : ((initialFilterParam === 'draft') ? 'draft' : 'all');
            let currentCategory = 'all';

            function filterRows() {
                if (!rows.length) return;
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                let visibleCount = 0;

                rows.forEach(row => {
                    const searchBlob = row.getAttribute('data-search') || '';
                    const status = row.getAttribute('data-status') || '';
                    const category = row.getAttribute('data-category') || '';

                    const matchesQuery = query === '' || searchBlob.includes(query);
                    const matchesStatus = currentStatus === 'all' || status === currentStatus;
                    const matchesCategory = currentCategory === 'all' || category === currentCategory;

                    if (matchesQuery && matchesStatus && matchesCategory) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (counterText) {
                    counterText.innerHTML = `Showing <strong>${visibleCount}</strong> of <strong>${rows.length}</strong> deliverables`;
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterRows);
            }

            const sidebarStatusBtns = document.querySelectorAll('.sidebar-status-filter');

            // Apply initial status if present from query
            if (currentStatus !== 'all') {
                statusPillBtns.forEach(b => {
                    b.classList.toggle('active', b.getAttribute('data-filter-status') === currentStatus);
                });
                sidebarStatusBtns.forEach(b => {
                    const target = currentStatus === 'active' ? 'published' : currentStatus;
                    b.classList.toggle('active', b.getAttribute('data-status-filter') === target);
                });
                filterRows();
            }

            statusPillBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    if (this.tagName === 'A' && this.getAttribute('href') && !this.getAttribute('href').startsWith('#')) {
                        return; // Let standard link navigate
                    }
                    e.preventDefault();
                    statusPillBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentStatus = this.getAttribute('data-filter-status') || 'all';

                    // Sync sidebar active state
                    sidebarStatusBtns.forEach(b => {
                        const target = currentStatus === 'active' ? 'published' : currentStatus;
                        b.classList.toggle('active', b.getAttribute('data-status-filter') === target);
                    });

                    filterRows();
                });
            });

            sidebarStatusBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetStatus = this.getAttribute('data-status-filter') || 'all';
                    currentStatus = (targetStatus === 'published') ? 'active' : targetStatus;

                    sidebarStatusBtns.forEach(b => {
                        b.classList.toggle('active', b.getAttribute('data-status-filter') === targetStatus);
                    });

                    statusPillBtns.forEach(b => {
                        b.classList.toggle('active', b.getAttribute('data-filter-status') === currentStatus);
                    });

                    filterRows();

                    const tableEl = document.getElementById('portfolio-table');
                    if (tableEl) {
                        tableEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            if (categoryFilter) {
                categoryFilter.addEventListener('change', function () {
                    currentCategory = this.value;
                    filterRows();
                });
            }

            // =========================================================
            // Preview Modal Data Hydration
            // =========================================================
            document.querySelectorAll('.btn-preview-project').forEach(btn => {
                btn.addEventListener('click', function () {
                    const titleEl = document.getElementById('previewTitle');
                    const catEl = document.getElementById('previewCategory');
                    const hostEl = document.getElementById('previewHost');
                    const probEl = document.getElementById('previewProblem');
                    const solEl = document.getElementById('previewSolution');

                    if (titleEl) titleEl.textContent = this.dataset.title || 'Project';
                    if (catEl) catEl.textContent = this.dataset.category || 'Software';
                    if (hostEl) hostEl.textContent = this.dataset.host || 'system.codex404solutions.online';
                    if (probEl) probEl.textContent = this.dataset.problem || 'No description provided.';
                    if (solEl) solEl.textContent = this.dataset.solution || 'No solution recorded.';

                    const stat1Val = document.getElementById('previewStat1Val');
                    const stat1Lbl = document.getElementById('previewStat1Lbl');
                    const stat2Val = document.getElementById('previewStat2Val');
                    const stat2Lbl = document.getElementById('previewStat2Lbl');
                    const stat3Val = document.getElementById('previewStat3Val');
                    const stat3Lbl = document.getElementById('previewStat3Lbl');

                    if (stat1Val) stat1Val.textContent = this.dataset.stat1Val || '-';
                    if (stat1Lbl) stat1Lbl.textContent = this.dataset.stat1Lbl || 'Metric 1';
                    if (stat2Val) stat2Val.textContent = this.dataset.stat2Val || '-';
                    if (stat2Lbl) stat2Lbl.textContent = this.dataset.stat2Lbl || 'Metric 2';
                    if (stat3Val) stat3Val.textContent = this.dataset.stat3Val || '-';
                    if (stat3Lbl) stat3Lbl.textContent = this.dataset.stat3Lbl || 'Metric 3';

                    const liveLink = document.getElementById('previewLiveLink');
                    if (liveLink) {
                        if (this.dataset.liveUrl) {
                            liveLink.href = this.dataset.liveUrl;
                            liveLink.classList.remove('d-none');
                        } else {
                            liveLink.classList.add('d-none');
                        }
                    }

                    const tagsContainer = document.getElementById('previewTags');
                    if (tagsContainer) {
                        tagsContainer.innerHTML = '';
                        try {
                            const tags = JSON.parse(this.dataset.tags || '[]');
                            tags.forEach(t => {
                                const span = document.createElement('span');
                                span.className = 'badge bg-secondary-subtle text-muted border border-secondary-subtle';
                                span.textContent = t;
                                tagsContainer.appendChild(span);
                            });
                        } catch (e) { }
                    }
                });
            });

            // =========================================================
            // Delete Modal Hydration
            // =========================================================
            document.querySelectorAll('.btn-delete-project').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id || '';
                    const title = this.dataset.title || '';
                    const deleteTitle = document.getElementById('deleteProjectTitle');
                    const deleteId = document.getElementById('deleteProjectId');
                    const deleteInputId = document.getElementById('deleteProjectInputId');

                    if (deleteTitle) deleteTitle.textContent = title;
                    if (deleteId) deleteId.textContent = 'ID: ' + id;
                    if (deleteInputId) deleteInputId.value = id;
                });
            });

            // =========================================================
            // Interactive Deliverables Slider Controller
            // =========================================================
            const sliderViewport = document.getElementById('deliverablesSliderViewport');
            const sliderTrack = document.getElementById('deliverablesSliderTrack');
            const prevBtn = document.getElementById('sliderPrevBtn');
            const nextBtn = document.getElementById('sliderNextBtn');
            const autoToggle = document.getElementById('sliderAutoToggle');
            const autoIcon = document.getElementById('sliderAutoIcon');
            const autoText = document.getElementById('sliderAutoText');
            const dotsContainer = document.getElementById('deliverablesSliderDots');

            if (sliderTrack && sliderViewport) {
                const cards = sliderTrack.querySelectorAll('.slider-card-item');
                let currentIndex = 0;
                let isAutoPlaying = true;
                let autoPlayTimer = null;

                const getItemsPerPage = () => {
                    const w = window.innerWidth;
                    if (w < 640) return 1;
                    if (w < 1024) return 2;
                    return 3;
                };

                const getMaxIndex = () => {
                    const perPage = getItemsPerPage();
                    return Math.max(0, cards.length - perPage);
                };

                const renderDots = () => {
                    if (!dotsContainer) return;
                    dotsContainer.innerHTML = '';
                    const max = getMaxIndex();
                    if (max <= 0) return;

                    for (let i = 0; i <= max; i++) {
                        const dot = document.createElement('button');
                        dot.type = 'button';
                        dot.className = 'slider-dot' + (i === currentIndex ? ' active' : '');
                        dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                        dot.addEventListener('click', () => {
                            currentIndex = i;
                            updateSlider();
                            resetTimer();
                        });
                        dotsContainer.appendChild(dot);
                    }
                };

                const updateSlider = () => {
                    const max = getMaxIndex();
                    if (currentIndex > max) currentIndex = max;
                    if (currentIndex < 0) currentIndex = 0;

                    const firstCard = cards[0];
                    if (!firstCard) return;

                    const cardWidth = firstCard.offsetWidth;
                    const gap = 16;
                    const offset = currentIndex * (cardWidth + gap);
                    sliderTrack.style.transform = `translateX(-${offset}px)`;

                    if (dotsContainer) {
                        const dots = dotsContainer.querySelectorAll('.slider-dot');
                        dots.forEach((d, idx) => {
                            d.classList.toggle('active', idx === currentIndex);
                        });
                    }
                };

                const nextSlide = () => {
                    const max = getMaxIndex();
                    currentIndex = (currentIndex >= max) ? 0 : currentIndex + 1;
                    updateSlider();
                };

                const prevSlide = () => {
                    const max = getMaxIndex();
                    currentIndex = (currentIndex <= 0) ? max : currentIndex - 1;
                    updateSlider();
                };

                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        nextSlide();
                        resetTimer();
                    });
                }

                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        prevSlide();
                        resetTimer();
                    });
                }

                const startTimer = () => {
                    if (autoPlayTimer) clearInterval(autoPlayTimer);
                    if (isAutoPlaying && cards.length > getItemsPerPage()) {
                        autoPlayTimer = setInterval(nextSlide, 4500);
                    }
                };

                const resetTimer = () => {
                    startTimer();
                };

                if (autoToggle) {
                    autoToggle.addEventListener('click', () => {
                        isAutoPlaying = !isAutoPlaying;
                        if (isAutoPlaying) {
                            if (autoIcon) autoIcon.className = 'bi bi-pause-fill';
                            if (autoText) autoText.textContent = 'Pause Slider';
                            startTimer();
                        } else {
                            if (autoIcon) autoIcon.className = 'bi bi-play-fill';
                            if (autoText) autoText.textContent = 'Play Slider';
                            if (autoPlayTimer) clearInterval(autoPlayTimer);
                        }
                    });
                }

                sliderViewport.addEventListener('mouseenter', () => {
                    if (autoPlayTimer) clearInterval(autoPlayTimer);
                });

                sliderViewport.addEventListener('mouseleave', () => {
                    if (isAutoPlaying) startTimer();
                });

                // Touch & Swipe gestures
                let touchStartX = 0;
                let touchEndX = 0;

                sliderViewport.addEventListener('touchstart', (e) => {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                sliderViewport.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    const diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 40) {
                        if (diff > 0) {
                            nextSlide();
                        } else {
                            prevSlide();
                        }
                        resetTimer();
                    }
                }, { passive: true });

                renderDots();
                updateSlider();
                startTimer();

                window.addEventListener('resize', () => {
                    renderDots();
                    updateSlider();
                });
            }

            // =========================================================
            // Dual-Theme Switcher (Combo, Dark, Light, Auto)
            // =========================================================
            const getStoredTheme = () => localStorage.getItem('codex_admin_theme');
            const setStoredTheme = theme => localStorage.setItem('codex_admin_theme', theme);
            const getPreferredTheme = () => {
                const storedTheme = getStoredTheme();
                if (storedTheme) return storedTheme;
                return 'combo';
            };

            const updateThemeUI = (theme) => {
                let label = 'Dark & Light';
                let iconClass = 'bi bi-circle-half text-primary theme-icon-active';

                if (theme === 'combo') {
                    label = 'Dark & Light';
                    iconClass = 'bi bi-circle-half text-primary theme-icon-active';
                } else if (theme === 'light') {
                    label = 'Light';
                    iconClass = 'bi bi-sun-fill text-warning theme-icon-active';
                } else if (theme === 'dark') {
                    label = 'Dark';
                    iconClass = 'bi bi-moon-stars-fill text-info theme-icon-active';
                } else {
                    label = 'Auto';
                    iconClass = 'bi bi-laptop text-secondary theme-icon-active';
                }

                const textEl = document.getElementById('bd-theme-admin-text');
                const iconEl = document.querySelector('#bd-theme-admin .theme-icon-active');
                if (textEl) textEl.textContent = label;
                if (iconEl) iconEl.className = iconClass;

                document.querySelectorAll('[data-bs-theme-value]').forEach(el => {
                    if (el.getAttribute('data-bs-theme-value') === theme) {
                        el.classList.add('active');
                    } else {
                        el.classList.remove('active');
                    }
                });
            };

            const applyTheme = (theme) => {
                const effectiveTheme = (theme === 'auto')
                    ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                    : theme;
                document.documentElement.setAttribute('data-bs-theme', effectiveTheme);
                updateThemeUI(theme);
            };

            applyTheme(getPreferredTheme());

            document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const selected = btn.getAttribute('data-bs-theme-value');
                    setStoredTheme(selected);
                    applyTheme(selected);
                });
            });

            window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', () => {
                const stored = getStoredTheme();
                if (!stored || stored === 'auto') {
                    applyTheme('auto');
                }
            });
        });
    </script>
</body>
</html>
