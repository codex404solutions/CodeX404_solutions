<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Deliverables Management Page (Multi-Page)
 */

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

$projects = ProjectService::getAll();
$totalCount = count($projects);
$activeCount = count(array_filter($projects, fn($p) => !empty($p['active'])));
$draftCount = $totalCount - $activeCount;
$categories = array_values(array_unique(array_filter(array_column($projects, 'category'))));

$currentPage = 'deliverables';
$pageTitle = 'Production Deliverables Management';
$pageSubtitle = 'Manage live client solutions, toggle public visibility, edit architecture specs, and monitor key metrics';

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- DELIVERABLES KPI STATS BAR                               -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card py-3 px-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Total Deliverables</span>
                    <div class="h3 fw-bold mb-0 text-gradient-cyan"><?= $totalCount ?></div>
                </div>
                <div class="stat-icon bg-info-subtle text-info" style="width: 40px; height: 40px; font-size: 1.15rem;">
                    <i class="bi bi-collection-play-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card accent-emerald py-3 px-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Published Live</span>
                    <div class="h3 fw-bold mb-0 text-success"><?= $activeCount ?></div>
                </div>
                <div class="stat-icon bg-success-subtle text-success" style="width: 40px; height: 40px; font-size: 1.15rem;">
                    <i class="bi bi-globe-americas"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card accent-amber py-3 px-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Staging Drafts</span>
                    <div class="h3 fw-bold mb-0 text-warning"><?= $draftCount ?></div>
                </div>
                <div class="stat-icon bg-warning-subtle text-warning" style="width: 40px; height: 40px; font-size: 1.15rem;">
                    <i class="bi bi-pencil-square"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card accent-indigo py-3 px-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-bold text-uppercase d-block mb-1">Domain Sectors</span>
                    <div class="h3 fw-bold mb-0 text-gradient-purple"><?= count($categories) ?></div>
                </div>
                <div class="stat-icon bg-primary-subtle text-primary" style="width: 40px; height: 40px; font-size: 1.15rem;">
                    <i class="bi bi-tags-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- SEARCH, FILTER & TAB CONTROLS                            -->
<!-- ======================================================== -->
<div class="admin-card p-3 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Search Input -->
        <div class="position-relative flex-grow-1" style="max-width: 380px;">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            <input type="text" id="projectSearch" class="form-control form-control-sm ps-5 py-2"
                placeholder="Search by title, category, host, tag..." style="border-radius: 10px;">
        </div>

        <!-- Filter Pills (Status) -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="filter-pill-btn active" data-filter-status="all">
                All Systems <span class="badge bg-dark border border-secondary text-white rounded-pill ms-1"><?= $totalCount ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter-status="active">
                <span class="live-dot me-1" style="width: 6px; height: 6px;"></span>
                Published <span class="badge bg-success-subtle text-success rounded-pill ms-1"><?= $activeCount ?></span>
            </button>
            <button type="button" class="filter-pill-btn" data-filter-status="draft">
                Draft <span class="badge bg-warning-subtle text-warning rounded-pill ms-1"><?= $draftCount ?></span>
            </button>
        </div>

        <!-- Category Filter Dropdown & Quick Add -->
        <div class="d-flex align-items-center gap-2">
            <select id="categoryFilter" class="form-select form-select-sm" style="border-radius: 8px; width: auto;">
                <option value="all">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars(ucfirst($cat)) ?></option>
                <?php endforeach; ?>
            </select>

            <a href="<?= admin_url('project-form') ?>" class="btn btn-sm btn-info fw-bold text-dark d-inline-flex align-items-center gap-1"
                style="background: #38BDF8; border-color: #38BDF8; border-radius: 8px;">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-sm-inline">Add Deliverable</span>
            </a>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- PROJECTS DATA TABLE CARD                                 -->
<!-- ======================================================== -->
<div class="admin-card overflow-hidden" id="portfolio-table">
    <?php if (empty($projects)): ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-folder-x fs-1 d-block mb-3 text-secondary"></i>
            <h5 class="fw-bold">No Projects in Portfolio</h5>
            <p class="small mb-3">Add your first production project deliverable to populate the website showcase.</p>
            <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm px-3 py-2 fw-bold" style="border-radius: 8px;">
                <i class="bi bi-plus-circle me-1"></i> Add First Project
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-admin align-middle" id="projectsTable">
                <thead>
                    <tr>
                        <th style="width: 60px;"># Order</th>
                        <th>Project &amp; Architecture</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Interactive Demo</th>
                        <th>Key Metric</th>
                        <th style="width: 160px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $idx => $p): ?>
                        <?php
                        $isActive = !empty($p['active']);
                        $category = strtolower((string) ($p['category'] ?? 'software'));
                        $tagsStr = implode(' ', (array) ($p['tags'] ?? []));
                        $searchBlob = strtolower(($p['title'] ?? '') . ' ' . ($p['id'] ?? '') . ' ' . $category . ' ' . ($p['mockup_host'] ?? '') . ' ' . $tagsStr);
                        ?>
                        <tr class="project-row" data-search="<?= htmlspecialchars($searchBlob) ?>"
                            data-status="<?= $isActive ? 'active' : 'draft' ?>"
                            data-category="<?= htmlspecialchars($category) ?>"
                            id="row-<?= htmlspecialchars($p['id']) ?>">

                            <!-- Order -->
                            <td class="fw-bold text-muted small" style="font-family: var(--font-mono);">
                                <?= (int) ($p['order'] ?? ($idx + 1)) ?>
                            </td>

                            <!-- Title, ID & Host -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Avatar Icon by Category -->
                                    <div class="rounded-3 d-flex align-items-center justify-content-center text-info fw-bold"
                                        style="width: 40px; height: 40px; background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.25); flex-shrink: 0;">
                                        <i class="bi <?= $category === 'ai' ? 'bi-cpu' : ($category === 'cloud' ? 'bi-cloud-check' : ($category === 'mobile' ? 'bi-phone' : 'bi-code-square')) ?> fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white fs-6 mb-1 project-title-text">
                                            <?= htmlspecialchars($p['title']) ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            <span class="project-id-chip"><?= htmlspecialchars($p['id']) ?></span>
                                            <?php if (!empty($p['live_url'])): ?>
                                                <span class="text-muted">&bull;</span>
                                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="text-info text-decoration-none small d-inline-flex align-items-center gap-1"
                                                    style="font-family: var(--font-mono); font-size: 0.76rem;">
                                                    <span><?= htmlspecialchars($p['mockup_host'] ?? 'Live URL') ?></span>
                                                    <i class="bi bi-box-arrow-up-right" style="font-size: 0.65rem;"></i>
                                                </a>
                                            <?php elseif (!empty($p['mockup_host'])): ?>
                                                <span class="text-muted">&bull;</span>
                                                <span class="text-muted small"
                                                    style="font-family: var(--font-mono); font-size: 0.76rem;"><?= htmlspecialchars($p['mockup_host']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td>
                                <span class="category-chip">
                                    <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($p['category_label'] ?? ucfirst($p['category'])) ?>
                                </span>
                            </td>

                            <!-- Status (Toggle button) -->
                            <td>
                                <form method="POST" action="<?= admin_url('toggle') ?>" class="d-inline">
                                    <?= csrf_input_field() ?>
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                    <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '') ?>">
                                    <?php if ($isActive): ?>
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill shadow-sm"
                                            style="font-size: 0.75rem;" title="Click to hide from public site">
                                            <span class="live-dot" style="width: 6px; height: 6px;"></span>
                                            <span>Published</span>
                                        </button>
                                    <?php else: ?>
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill"
                                            style="font-size: 0.75rem;" title="Click to publish on website">
                                            <i class="bi bi-circle"></i>
                                            <span>Draft</span>
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>

                            <!-- Demo Key -->
                            <td>
                                <span class="demo-chip">
                                    <i class="bi bi-play-circle-fill"></i>
                                    <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                                </span>
                            </td>

                            <!-- Key Metric -->
                            <td style="max-width: 250px;">
                                <div class="small text-muted text-truncate"
                                    title="<?= htmlspecialchars((string) ($p['metric'] ?? '')) ?>">
                                    <i class="bi bi-graph-up-arrow text-success me-1"></i><?= htmlspecialchars((string) ($p['metric'] ?? 'Active System')) ?>
                                </div>
                            </td>

                            <!-- Actions Toolbar -->
                            <td>
                                <div class="d-flex align-items-center justify-content-end gap-1">
                                    <!-- Quick Preview Modal Button -->
                                    <button type="button"
                                        class="btn btn-sm btn-outline-info btn-action-icon btn-preview-project"
                                        data-bs-toggle="modal" data-bs-target="#modalProjectPreview"
                                        data-title="<?= htmlspecialchars($p['title']) ?>"
                                        data-category="<?= htmlspecialchars($p['category_label'] ?? $p['category']) ?>"
                                        data-host="<?= htmlspecialchars($p['mockup_host'] ?? '') ?>"
                                        data-problem="<?= htmlspecialchars($p['problem'] ?? '') ?>"
                                        data-solution="<?= htmlspecialchars($p['solution'] ?? '') ?>"
                                        data-metric="<?= htmlspecialchars((string) ($p['metric'] ?? '')) ?>"
                                        data-stat1-val="<?= htmlspecialchars($p['stat_1_val'] ?? '') ?>"
                                        data-stat1-lbl="<?= htmlspecialchars($p['stat_1_lbl'] ?? '') ?>"
                                        data-stat2-val="<?= htmlspecialchars($p['stat_2_val'] ?? '') ?>"
                                        data-stat2-lbl="<?= htmlspecialchars($p['stat_2_lbl'] ?? '') ?>"
                                        data-stat3-val="<?= htmlspecialchars($p['stat_3_val'] ?? '') ?>"
                                        data-stat3-lbl="<?= htmlspecialchars($p['stat_3_lbl'] ?? '') ?>"
                                        data-live-url="<?= htmlspecialchars($p['live_url'] ?? '') ?>"
                                        data-tags='<?= json_encode($p['tags'] ?? []) ?>'
                                        title="Live Spec Preview">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Edit Project -->
                                    <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>"
                                        class="btn btn-sm btn-outline-primary btn-action-icon"
                                        title="Edit Deliverable">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete Modal Trigger -->
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-action-icon btn-delete-project"
                                        data-bs-toggle="modal" data-bs-target="#modalDeleteProject"
                                        data-id="<?= htmlspecialchars($p['id']) ?>"
                                        data-title="<?= htmlspecialchars($p['title']) ?>"
                                        title="Delete Project">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted small"
            style="border-color: var(--cx-border) !important;">
            <div id="tableCounterText">
                Showing <strong><?= $totalCount ?></strong> of <strong><?= $totalCount ?></strong> deliverables
            </div>
            <div class="d-flex align-items-center gap-1">
                <span class="live-dot" style="width: 6px; height: 6px;"></span>
                <span>All changes update instantly on public frontend.</span>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
