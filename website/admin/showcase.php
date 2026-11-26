<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Deliverables Showcase & Sandboxes (Multi-Page)
 */

require_once __DIR__ . '/auth.php';
require_admin_permission('portfolio.view');

use App\Services\ProjectService;

$currentPage = 'showcase';
$pageTitle = 'Featured Showcase & Interactive Sandboxes';
$pageSubtitle = 'Experience interactive deliverables carousel, client architecture cards, live previews, and verified performance triplets';

require_once __DIR__ . '/includes/header.php';

$projectTypes = ProjectService::getProjectTypes();
$showcaseStatuses = ProjectService::getShowcaseStatuses();
?>

<!-- ======================================================== -->
<!-- 1. INTERACTIVE DELIVERABLES SHOWCASE SLIDER               -->
<!-- ======================================================== -->
<?php if (!empty($projects)): ?>
    <section class="deliverables-slider-section" id="showcase-slider">
        <div class="slider-header">
            <div>
                <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-stars text-warning"></i>
                    <span>Featured Showcase Carousel</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.72rem;">Interactive Touch &amp; Swipe</span>
                </h5>
                <p class="text-muted small mb-0">Browse production applications, verified performance metrics, and interactive sandboxes.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button"
                    class="btn btn-xs btn-outline-secondary py-1 px-2 d-none d-sm-inline-flex align-items-center gap-1"
                    id="sliderAutoToggle" style="font-size: 0.75rem; border-radius: 8px;">
                    <i class="bi bi-pause-fill" id="sliderAutoIcon"></i>
                    <span id="sliderAutoText">Pause Slider</span>
                </button>
                <button type="button" class="slider-nav-btn" id="sliderPrevBtn" aria-label="Previous slide"
                    title="Previous Slide">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="slider-nav-btn" id="sliderNextBtn" aria-label="Next slide"
                    title="Next Slide">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="slider-viewport" id="deliverablesSliderViewport">
            <div class="slider-track" id="deliverablesSliderTrack">
                <?php foreach ($projects as $idx => $p): ?>
                    <?php
                    $isActive = !empty($p['active']);
                    $category = strtolower((string) ($p['category'] ?? 'software'));
                    $typeKey = $p['project_type'] ?? 'client';
                    $type = $projectTypes[$typeKey] ?? $projectTypes['client'];
                    $clientName = !empty($p['client_name']) ? $p['client_name'] : ($p['anonymized_name'] ?? 'Commercial Client');
                    ?>
                    <div class="slider-card-item">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="category-chip">
                                        <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($p['category_label'] ?? ucfirst($p['category'])) ?>
                                    </span>
                                    <span class="badge" style="background: rgba(99, 102, 241, 0.15); color: <?= $type['color'] ?>; border: 1px solid rgba(99, 102, 241, 0.3); font-size: 0.68rem;">
                                        <?= htmlspecialchars($type['label']) ?>
                                    </span>
                                </div>
                                <?php if ($isActive): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1"
                                        style="font-size: 0.7rem;">
                                        <span class="live-dot" style="width: 5px; height: 5px;"></span> Live
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle"
                                        style="font-size: 0.7rem;">
                                        Draft
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h6 class="fw-bold mb-1 text-truncate" title="<?= htmlspecialchars($p['title']) ?>">
                                <?= htmlspecialchars($p['title']) ?>
                            </h6>
                            <div class="d-flex align-items-center gap-2 mb-2 text-muted small">
                                <code class="project-id-chip"><?= htmlspecialchars($p['id']) ?></code>
                                <span>&bull;</span>
                                <span class="text-truncate text-white-50" style="font-size: 0.76rem;"><i class="bi bi-building me-1"></i><?= htmlspecialchars($clientName) ?></span>
                            </div>

                            <p class="small text-muted mb-3"
                                style="font-size: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.4em;">
                                <?= htmlspecialchars(!empty($p['problem']) ? $p['problem'] : 'Verified production system built for high-throughput enterprise performance.') ?>
                            </p>
                        </div>

                        <div>
                            <?php if (!empty($p['metric'])): ?>
                                <div class="p-2 rounded-3 mb-3 d-flex align-items-center gap-2"
                                    style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                                    <i class="bi bi-graph-up-arrow text-success"></i>
                                    <span class="small fw-semibold text-success text-truncate" style="font-size: 0.78rem;"><?= htmlspecialchars($p['metric']) ?></span>
                                </div>
                            <?php else: ?>
                                <div class="p-2 rounded-3 mb-3 d-flex align-items-center gap-2"
                                    style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.2);">
                                    <i class="bi bi-hdd-network text-info"></i>
                                    <span class="small fw-semibold text-info" style="font-size: 0.78rem;">Verified Client Architecture</span>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center justify-content-between gap-2 pt-2 border-top"
                                style="border-color: var(--cx-border) !important;">
                                <span class="demo-chip">
                                    <i class="bi bi-play-circle-fill"></i>
                                    <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                                </span>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" target="_blank"
                                        class="btn btn-xs btn-outline-info py-1 px-2"
                                        style="font-size: 0.75rem; border-radius: 6px;"
                                        title="View Public Page">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-xs btn-outline-secondary btn-preview-project py-1 px-2"
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
                                        style="font-size: 0.75rem; border-radius: 6px;">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>"
                                        class="btn btn-xs btn-outline-primary py-1 px-2"
                                        style="font-size: 0.75rem; border-radius: 6px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Slider Pagination Dots Container -->
        <div class="slider-dots" id="deliverablesSliderDots"></div>
    </section>
<?php endif; ?>

<!-- ======================================================== -->
<!-- 2. COMPREHENSIVE DELIVERABLES SHOWCASE GRID              -->
<!-- ======================================================== -->
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-grid-3x3-gap-fill text-info"></i>
                <span>All Architecture Sandboxes &amp; Specs</span>
            </h5>
            <p class="text-muted small mb-0">Direct access to individual sandbox simulators, metrics, and case studies.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark border border-secondary text-info" style="font-size: 0.75rem;">
                <?= $totalCount ?> Total Systems
            </span>
        </div>
    </div>

    <div class="row g-3">
        <?php foreach ($projects as $p): ?>
            <?php
            $typeKey = $p['project_type'] ?? 'client';
            $type = $projectTypes[$typeKey] ?? $projectTypes['client'];
            $clientName = !empty($p['client_name']) ? $p['client_name'] : ($p['anonymized_name'] ?? 'Commercial Client');
            ?>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="admin-card p-3 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="category-chip">
                                <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($p['category_label'] ?? ucfirst($p['category'])) ?>
                            </span>
                            <span class="badge" style="background: rgba(99, 102, 241, 0.15); color: <?= $type['color'] ?>; border: 1px solid rgba(99, 102, 241, 0.3); font-size: 0.7rem;">
                                <?= htmlspecialchars($type['label']) ?>
                            </span>
                        </div>

                        <h6 class="fw-bold text-white mb-1"><?= htmlspecialchars($p['title']) ?></h6>
                        <div class="text-muted small mb-2 d-flex align-items-center gap-2">
                            <code class="project-id-chip"><?= htmlspecialchars($p['id']) ?></code>
                            <span>&bull;</span>
                            <span class="text-white-50"><i class="bi bi-building me-1"></i><?= htmlspecialchars($clientName) ?></span>
                        </div>

                        <p class="small text-muted mb-3" style="font-size: 0.82rem; line-height: 1.5;">
                            <?= htmlspecialchars(!empty($p['problem']) ? $p['problem'] : 'Verified production system built for high-throughput enterprise performance.') ?>
                        </p>
                    </div>

                    <div>
                        <?php if (!empty($p['metric'])): ?>
                            <div class="p-2 rounded-3 mb-3 d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                                <i class="bi bi-graph-up-arrow text-success"></i>
                                <span class="small fw-semibold text-success text-truncate" style="font-size: 0.78rem;"><?= htmlspecialchars($p['metric']) ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex align-items-center justify-content-between pt-2 border-top" style="border-color: var(--cx-border) !important;">
                            <span class="demo-chip">
                                <i class="bi bi-play-circle-fill"></i>
                                <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                            </span>
                            <div class="d-flex align-items-center gap-1">
                                <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" target="_blank"
                                    class="btn btn-xs btn-outline-info py-1 px-2" style="font-size: 0.75rem; border-radius: 6px;" title="View Public Page">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Public
                                </a>
                                <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>"
                                    class="btn btn-xs btn-outline-primary py-1 px-2" style="font-size: 0.75rem; border-radius: 6px;" title="Edit Deliverable">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
