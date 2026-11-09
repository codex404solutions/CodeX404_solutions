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
<!-- 1. FUTURISTIC ANIMATED SVG HERO BANNER                   -->
<!-- ======================================================== -->
<section class="admin-hero-banner" id="admin-hero">
    <!-- High-Detail Animated Cyber Vector SVG Canvas -->
    <svg class="banner-svg-canvas" viewBox="0 0 650 320" fill="none" xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <defs>
            <linearGradient id="cyberGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#22D3EE" stop-opacity="0.8" />
                <stop offset="50%" stop-color="#3B82F6" stop-opacity="0.6" />
                <stop offset="100%" stop-color="#8B5CF6" stop-opacity="0.2" />
            </linearGradient>
            <linearGradient id="cyberGrad2" x1="100%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#EC4899" stop-opacity="0.7" />
                <stop offset="100%" stop-color="#6366F1" stop-opacity="0.2" />
            </linearGradient>
            <filter id="glowFilter" x="-20%" y="-20%" width="140%" height="140%">
                <feGaussianBlur stdDeviation="6" result="blur" />
                <feComposite in="SourceGraphic" in2="blur" operator="over" />
            </filter>
            <pattern id="adminGrid" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(34, 211, 238, 0.08)" stroke-width="1" />
                <circle cx="40" cy="40" r="1.5" fill="rgba(34, 211, 238, 0.25)" />
            </pattern>
        </defs>

        <rect width="650" height="320" fill="url(#adminGrid)" />

        <g class="svg-floating-group">
            <path d="M 120 280 C 220 180, 320 240, 480 90" stroke="url(#cyberGrad1)" stroke-width="2.5" fill="none" class="svg-flow-path" />
            <path d="M 180 310 C 280 230, 360 210, 560 140" stroke="url(#cyberGrad2)" stroke-width="2" fill="none" class="svg-flow-path" style="animation-duration: 20s; animation-direction: reverse;" />
            <path d="M 280 20 L 400 120 L 320 240 Z" stroke="rgba(99, 102, 241, 0.25)" stroke-width="1.5" fill="none" />
        </g>

        <g class="svg-rotating-ring">
            <circle cx="350" cy="180" r="90" stroke="rgba(34, 211, 238, 0.2)" stroke-width="1.5" stroke-dasharray="10 8" fill="none" />
            <circle cx="350" cy="180" r="60" stroke="rgba(168, 85, 247, 0.25)" stroke-width="1" stroke-dasharray="6 6" fill="none" />
            <circle cx="440" cy="180" r="4.5" fill="#22D3EE" filter="url(#glowFilter)" />
            <circle cx="290" cy="180" r="3.5" fill="#EC4899" filter="url(#glowFilter)" />
        </g>

        <g class="svg-pulsing-node">
            <circle cx="480" cy="90" r="6" fill="#22D3EE" filter="url(#glowFilter)" />
            <circle cx="480" cy="90" r="14" stroke="#22D3EE" stroke-width="1" opacity="0.4" />
        </g>
        <g class="svg-pulsing-node" style="animation-delay: 1.2s;">
            <circle cx="180" cy="310" r="5" fill="#3B82F6" filter="url(#glowFilter)" />
        </g>
        <g class="svg-pulsing-node" style="animation-delay: 2s;">
            <circle cx="320" cy="240" r="5.5" fill="#EC4899" filter="url(#glowFilter)" />
        </g>
    </svg>

    <div class="banner-content">
        <div class="banner-tech-pill">
            <i class="bi bi-cpu-fill"></i>
            <span>Central Admin Engine &bull; Production v2.4</span>
        </div>
        <h2 class="banner-title text-gradient-rainbow">
            CodeX404 Multi-Page Mission Control
        </h2>
        <p class="banner-description">
            Live orchestrator for production client systems, verified architectural performance metrics, high-throughput sandboxes, and cross-platform CRM synchronization.
        </p>

        <!-- Banner Quick Action Buttons -->
        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
            <a href="<?= admin_url('deliverables') ?>" class="btn btn-info btn-sm fw-bold text-dark px-3 py-2 d-inline-flex align-items-center gap-2"
                style="background: #38BDF8; border-color: #38BDF8; border-radius: 10px;">
                <i class="bi bi-collection-play-fill"></i>
                <span>Manage All Deliverables (<?= $totalCount ?>)</span>
            </a>
            <a href="<?= admin_url('showcase') ?>" class="btn btn-outline-primary btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center gap-2"
                style="border-radius: 10px;">
                <i class="bi bi-stars text-warning"></i>
                <span>Open Showcase Carousel</span>
            </a>
            <a href="../../crm/" target="_blank" class="btn btn-outline-warning btn-sm fw-semibold px-3 py-2 d-inline-flex align-items-center gap-2"
                style="border-radius: 10px;">
                <i class="bi bi-robot text-warning"></i>
                <span>Launch CRM Command</span>
            </a>
        </div>

        <div class="banner-meta-bar">
            <div class="banner-meta-item">
                <i class="bi bi-shield-check text-success"></i>
                <span>Sync: <strong>Instant Webhooks</strong></span>
            </div>
            <div class="banner-meta-item">
                <i class="bi bi-speedometer2 text-info"></i>
                <span>Uptime SLA: <strong>99.98% High-Avail</strong></span>
            </div>
            <div class="banner-meta-item">
                <i class="bi bi-hdd-network text-primary"></i>
                <span>Inventory: <strong><?= $totalCount ?> Total Systems</strong></span>
            </div>
        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- 2. CONTINUOUS MARQUEE SCROLLER TICKER                    -->
<!-- ======================================================== -->
<div class="admin-marquee-wrap" id="telemetry-ticker">
    <div class="admin-marquee-label">
        <span class="live-dot" style="width: 6px; height: 6px;"></span>
        <span>Live Telemetry</span>
    </div>
    <div class="admin-marquee-viewport">
        <div class="admin-marquee-track">
            <!-- Set 1 -->
            <div class="admin-marquee-item">
                <i class="bi bi-collection-play-fill text-info"></i>
                <span>Deliverables: <strong><?= $totalCount ?> Managed Applications</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Public Showcase: <strong><?= $activeCount ?> Published Live</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-shield-lock-fill text-warning"></i>
                <span>Staging Sandbox: <strong><?= $draftCount ?> In Review</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-cpu-fill text-primary"></i>
                <span>Tech Stack: <strong>PHP 8.3 &bull; Bootstrap 5.3.3 &bull; Dual-Tone Engine</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-robot text-warning"></i>
                <span>CRM Operations: <strong>Armed &amp; Connected</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-globe-americas text-info"></i>
                <span>Domains: <strong><?= count($categories) ?> Industry Categories Synchronized</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                <span>SLA Response: <strong>Sub-100ms Optimized Edge Cache</strong></span>
                <span class="sep">&bull;</span>
            </div>

            <!-- Set 2 (Continuous Duplicate) -->
            <div class="admin-marquee-item">
                <i class="bi bi-collection-play-fill text-info"></i>
                <span>Deliverables: <strong><?= $totalCount ?> Managed Applications</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Public Showcase: <strong><?= $activeCount ?> Published Live</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-shield-lock-fill text-warning"></i>
                <span>Staging Sandbox: <strong><?= $draftCount ?> In Review</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-cpu-fill text-primary"></i>
                <span>Tech Stack: <strong>PHP 8.3 &bull; Bootstrap 5.3.3 &bull; Dual-Tone Engine</strong></span>
                <span class="sep">&bull;</span>
            </div>
        </div>
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
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-info fw-bold"
                                    style="width: 36px; height: 36px; background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.25); flex-shrink: 0;">
                                    <i class="bi <?= $category === 'ai' ? 'bi-cpu' : ($category === 'cloud' ? 'bi-cloud-check' : ($category === 'mobile' ? 'bi-phone' : 'bi-code-square')) ?>"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-white small mb-0">
                                        <?= htmlspecialchars($p['title']) ?>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.74rem;">
                                        <code class="project-id-chip"><?= htmlspecialchars($p['id']) ?></code>
                                        <?php if (!empty($p['mockup_host'])): ?>
                                            <span>&bull;</span>
                                            <span style="font-family: var(--font-mono);"><?= htmlspecialchars($p['mockup_host']) ?></span>
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
                                <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>"
                                    class="btn btn-sm btn-outline-primary btn-action-icon" title="Edit Deliverable">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>