<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Overview / Dashboard (Multi-Page)
 */



$currentPage = 'overview';
$pageTitle = 'Portfolio & Deliverables Command Center';
$pageSubtitle = 'Production deliverables, interactive sandboxes, and verified showcase specs';

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- 1. EXECUTIVE COMMAND HEADER                              -->
<!-- ======================================================== -->
<section class="admin-hero-banner" id="admin-hero">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
        <div class="banner-content">
            <div class="banner-tech-pill">
                <span class="live-dot" style="width: 6px; height: 6px;"></span>
                <span>Operations Console &middot; Production</span>
            </div>
            <h2 class="banner-title mb-2" style="color: var(--cx-text-primary);">
                Portfolio &amp; Deliverables Control
            </h2>
            <p class="banner-description mb-0">
                Manage live client systems, case studies, recruitment workflows, and role-based access from one unified workspace.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap flex-shrink-0">
            <?php if (current_admin_can('portfolio.view')): ?>
                <a href="<?= admin_url('deliverables') ?>" class="btn btn-info btn-sm fw-semibold text-dark px-3 py-2 d-inline-flex align-items-center gap-2"
                    style="background: #38BDF8; border-color: #38BDF8; border-radius: 10px;">
                    <i class="bi bi-collection-play-fill"></i>
                    <span>Deliverables (<?= $totalCount ?>)</span>
                </a>
                <a href="<?= admin_url('showcase') ?>" class="btn btn-outline-secondary btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center gap-2"
                    style="border-radius: 10px;">
                    <i class="bi bi-stars text-primary"></i>
                    <span>Showcase</span>
                </a>
            <?php endif; ?>
            <?php if (current_admin_can('users.view')): ?>
                <a href="<?= admin_url('users') ?>" class="btn btn-outline-secondary btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center gap-2"
                    style="border-radius: 10px;">
                    <i class="bi bi-people-fill text-info"></i>
                    <span>Users &amp; Roles</span>
                </a>
            <?php endif; ?>
            <?php if (is_dir(dirname(__DIR__, 2) . '/crm')): ?>
                <a href="../../crm/" target="_blank" class="btn btn-outline-warning btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center gap-2"
                    style="border-radius: 10px;">
                    <i class="bi bi-robot"></i>
                    <span>CRM</span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- 2. SYSTEM TELEMETRY STRIP                                -->
<!-- ======================================================== -->
<div class="admin-status-strip" id="telemetry-ticker">
    <div class="admin-status-item">
        <i class="bi bi-collection-play-fill text-info"></i>
        <span>Deliverables: <strong><?= $totalCount ?> Systems</strong></span>
    </div>
    <div class="admin-status-item">
        <i class="bi bi-check-circle-fill text-success"></i>
        <span>Published: <strong><?= $activeCount ?> Live</strong></span>
    </div>
    <div class="admin-status-item">
        <i class="bi bi-shield-lock-fill text-warning"></i>
        <span>Staging: <strong><?= $draftCount ?> Drafts</strong></span>
    </div>
    <div class="admin-status-item">
        <i class="bi bi-hdd-network-fill text-primary"></i>
        <span>Runtime: <strong>PHP <?= PHP_VERSION ?> &middot; MySQL PDO</strong></span>
    </div>
</div>

<!-- ======================================================== -->
<!-- 3. KPI STATS CARDS ROW                                   -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Total Projects -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="<?= admin_url('deliverables') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Deliverables</span>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-collection-play-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold mb-1 text-gradient-cyan"><?= $totalCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-right-circle text-info"></i> View all systems &rarr;
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 2: Active on Website -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="<?= admin_url('deliverables?filter=published') ?>" class="text-decoration-none">
            <div class="stat-card accent-emerald">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Active on Website</span>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-success mb-1"><?= $activeCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <?php $pct = $totalCount > 0 ? round(($activeCount / $totalCount) * 100) : 0; ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle"><?= $pct ?>% Published</span>
                    <span>Live on frontend</span>
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 3: Draft / Hidden -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="<?= admin_url('deliverables?filter=draft') ?>" class="text-decoration-none">
            <div class="stat-card accent-amber">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Draft / Staging</span>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-warning mb-1"><?= $draftCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-shield-lock text-muted"></i> Hidden from public feed
                </div>
            </div>
        </a>
    </div>

    <!-- Stat 4: Active Categories -->
    <div class="col-12 col-sm-6 col-xl-3">
        <a href="<?= admin_url('deliverables') ?>" class="text-decoration-none">
            <div class="stat-card accent-indigo">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Industry Domains</span>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-gradient-purple mb-1"><?= count($categories) ?></div>
                <div class="small text-muted d-flex align-items-center gap-1 text-truncate">
                    <span><?= htmlspecialchars(implode(', ', array_slice($categories, 0, 3))) ?></span>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ======================================================== -->
<!-- 4. ACTION HUB: MULTI-PAGE NAVIGATION CARDS               -->
<!-- ======================================================== -->
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-grid-fill text-info"></i>
            <span>Admin Workspace Hub</span>
        </h5>
        <span class="text-muted small">Select a dedicated module to manage</span>
    </div>
    <div class="row g-3">
        <!-- Module 1: Deliverables Table -->
        <div class="col-12 col-md-6 col-xl-3">
            <a href="<?= admin_url('deliverables') ?>" class="action-hub-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-warning-subtle text-warning" style="width: 44px; height: 44px;">
                        <i class="bi bi-collection-play-fill fs-5"></i>
                    </div>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><?= $totalCount ?> Items</span>
                </div>
                <h6 class="fw-bold mb-1">Deliverables Manager</h6>
                <p class="text-muted small mb-3">Full data table, live status filters, search, toggle switches, and quick actions.</p>
                <div class="d-flex align-items-center gap-1 text-warning small fw-bold">
                    <span>Open Deliverables</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Module 2: Showcase Carousel -->
        <div class="col-12 col-md-6 col-xl-3">
            <a href="<?= admin_url('showcase') ?>" class="action-hub-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-primary-subtle text-primary" style="width: 44px; height: 44px;">
                        <i class="bi bi-stars fs-5"></i>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Sandbox</span>
                </div>
                <h6 class="fw-bold mb-1">Interactive Showcase</h6>
                <p class="text-muted small mb-3">Browse touch-enabled deliverables carousel, interactive specs, and mockup hosts.</p>
                <div class="d-flex align-items-center gap-1 text-primary small fw-bold">
                    <span>Explore Showcase</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Module 3: Telemetry & Health -->
        <div class="col-12 col-md-6 col-xl-3">
            <a href="<?= admin_url('telemetry') ?>" class="action-hub-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-success-subtle text-success" style="width: 44px; height: 44px;">
                        <i class="bi bi-activity fs-5"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">99.98% SLA</span>
                </div>
                <h6 class="fw-bold mb-1">System Telemetry</h6>
                <p class="text-muted small mb-3">Live storage health, PHP engine runtime stats, security audits, and CRM connectivity.</p>
                <div class="d-flex align-items-center gap-1 text-success small fw-bold">
                    <span>View Telemetry</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>

        <!-- Module 4: Add New Deliverable -->
        <div class="col-12 col-md-6 col-xl-3">
            <a href="<?= admin_url('project-form') ?>" class="action-hub-card" style="border-style: dashed; border-color: rgba(56, 189, 248, 0.4);">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon bg-info-subtle text-info" style="width: 44px; height: 44px;">
                        <i class="bi bi-plus-lg fs-5"></i>
                    </div>
                    <span class="badge bg-info-subtle text-info border border-info-subtle">New</span>
                </div>
                <h6 class="fw-bold mb-1">Add Deliverable</h6>
                <p class="text-muted small mb-3">Register and deploy a new client solution, production demo, or SaaS case study.</p>
                <div class="d-flex align-items-center gap-1 text-info small fw-bold">
                    <span>Launch Creator</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 5. RECENT DELIVERABLES PREVIEW SNAPSHOT                  -->
<!-- ======================================================== -->
<div class="admin-card overflow-hidden mb-4">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2"
        style="border-color: var(--cx-border) !important;">
        <div>
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-info"></i>
                <span>Recent Production Deliverables</span>
                <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.7rem;">Top 5 Active</span>
            </h6>
            <small class="text-muted">Instant overview of key solutions currently in the portfolio store</small>
        </div>
        <a href="<?= admin_url('deliverables') ?>" class="btn btn-sm btn-outline-info d-inline-flex align-items-center gap-1 py-1 px-3"
            style="border-radius: 8px; font-size: 0.8rem;">
            <span>View All Deliverables (<?= $totalCount ?>)</span>
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Project &amp; Architecture</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Interactive Demo</th>
                    <th style="width: 140px; text-align: right;">Quick Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($projects, 0, 5) as $idx => $p): ?>
                    <?php
                    $isActive = !empty($p['active']);
                    $category = strtolower((string) ($p['category'] ?? 'software'));
                    ?>
                    <tr>
                        <td class="fw-bold text-muted small" style="font-family: var(--font-mono);">
                            <?= (int) ($p['order'] ?? ($idx + 1)) ?>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3" style="min-width: 0;">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-info fw-bold"
                                    style="width: 36px; height: 36px; background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.25); flex-shrink: 0;">
                                    <i class="bi <?= $category === 'ai' ? 'bi-cpu' : ($category === 'cloud' ? 'bi-cloud-check' : ($category === 'mobile' ? 'bi-phone' : 'bi-code-square')) ?>"></i>
                                </div>
                                <div style="min-width: 0;">
                                    <div class="project-title-text text-truncate mb-0" style="max-width: 280px;">
                                        <?= htmlspecialchars($p['title']) ?>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted flex-wrap" style="font-size: 0.74rem;">
                                        <code class="project-id-chip" title="<?= htmlspecialchars($p['id']) ?>"><?= htmlspecialchars($p['id']) ?></code>
                                        <?php if (!empty($p['mockup_host'])): ?>
                                            <span>&bull;</span>
                                            <span class="text-truncate" style="font-family: var(--font-mono); max-width: 200px; display: inline-block; vertical-align: middle;"><?= htmlspecialchars($p['mockup_host']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="category-chip">
                                <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($p['category_label'] ?? ucfirst($p['category'])) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($isActive): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1"
                                    style="font-size: 0.72rem;">
                                    <span class="live-dot" style="width: 5px; height: 5px;"></span> Published
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle" style="font-size: 0.72rem;">
                                    Draft
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="demo-chip">
                                <i class="bi bi-play-circle-fill"></i>
                                <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-info btn-action-icon btn-preview-project"
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
                                    title="Quick Preview">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <?php if (current_admin_can('portfolio.edit')): ?>
                                    <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>"
                                        class="btn btn-sm btn-outline-primary btn-action-icon" title="Edit Deliverable">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>