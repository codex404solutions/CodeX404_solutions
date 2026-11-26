<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/app/Services/ProjectService.php';

use App\Services\ProjectService;

$projectId = trim((string)($_GET['id'] ?? ''));

if ($projectId === '') {
    header('Location: ' . url('portfolio.php'));
    exit;
}

// Fetch sanitized project data (automatically strips internal notes and respects client NDA permissions)
$project = ProjectService::getById($projectId, false);

if (!$project || empty($project['active'])) {
    http_response_code(404);
    $pageMeta = [
        'title' => 'Project Deliverable Not Found — CodeX404 Solutions',
        'description' => 'The requested engineering project deliverable could not be found or is currently in private staging review.',
        'canonical' => url('portfolio.php')
    ];
    require_once __DIR__ . '/includes/header.php';
    ?>
    <section class="section" style="padding-top: calc(var(--nav-height) + 4rem); min-height: 70vh; display: flex; align-items: center;">
        <div class="container text-center" style="max-width: 600px; margin: 0 auto;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
            <h1 class="section-title" style="font-size: 2rem; margin-bottom: 1rem;">Deliverable Not Found</h1>
            <p style="color: var(--slate); line-height: 1.6; margin-bottom: 2rem;">
                The project deliverable <code><?= htmlspecialchars($projectId) ?></code> was not found in our public portfolio. It may be under private staging review or has been archived.
            </p>
            <a href="<?= url('portfolio.php') ?>" class="btn btn-primary">Browse All Deliverables →</a>
        </div>
    </section>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$projectTypes = ProjectService::getProjectTypes();
$showcaseStatuses = ProjectService::getShowcaseStatuses();

$typeKey = $project['project_type'] ?? 'client';
$typeInfo = $projectTypes[$typeKey] ?? $projectTypes['client'];

$statusKey = $project['showcase_status'] ?? 'live_website';
$statusInfo = $showcaseStatuses[$statusKey] ?? $showcaseStatuses['live_website'];

// Navigation between adjacent projects
$allProjects = ProjectService::getActive();
$currentIndex = -1;
foreach ($allProjects as $idx => $p) {
    if ($p['id'] === $project['id']) {
        $currentIndex = $idx;
        break;
    }
}
$prevProject = ($currentIndex > 0) ? $allProjects[$currentIndex - 1] : null;
$nextProject = ($currentIndex >= 0 && $currentIndex < count($allProjects) - 1) ? $allProjects[$currentIndex + 1] : null;

$pageMeta = [
    'title' => htmlspecialchars($project['title']) . ' — Engineering Architecture & Case Study',
    'description' => htmlspecialchars(substr($project['solution'] ?? $project['problem'] ?? '', 0, 160)),
    'canonical' => url('project.php?id=' . urlencode($project['id'])),
    'keywords' => implode(', ', array_merge([$project['category_label'] ?? '', $project['title']], $project['tags'] ?? []))
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- PROJECT DETAIL MAIN SECTION -->
<main id="main-content" class="project-detail-page" style="padding-top: calc(var(--nav-height) + 2.5rem); padding-bottom: 5rem;">
    <div class="container">

        <!-- BREADCRUMBS -->
        <nav class="cx-breadcrumbs" aria-label="Breadcrumb" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--slate); margin-bottom: 2rem; flex-wrap: wrap;">
            <a href="<?= url() ?>" style="color: var(--slate); text-decoration: none;">Home</a>
            <span style="opacity: 0.4;">/</span>
            <a href="<?= url('portfolio.php') ?>" style="color: var(--slate); text-decoration: none;">Portfolio</a>
            <span style="opacity: 0.4;">/</span>
            <span style="color: var(--cyan);"><?= htmlspecialchars($project['category_label'] ?? 'Deliverable') ?></span>
            <span style="opacity: 0.4;">/</span>
            <span style="color: var(--white); font-weight: 500;" class="text-truncate"><?= htmlspecialchars($project['title']) ?></span>
        </nav>

        <!-- HERO HEADER -->
        <div class="project-detail-hero" style="background: rgba(11, 23, 44, 0.65); border: 1px solid rgba(34, 211, 238, 0.2); border-radius: 1.25rem; padding: clamp(1.75rem, 4vw, 3rem); margin-bottom: 2.75rem; backdrop-filter: blur(16px); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -80px; right: -80px; width: 280px; height: 280px; background: radial-gradient(circle, rgba(34, 211, 238, 0.12) 0%, transparent 70%); pointer-events: none;"></div>

            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Taxonomy Badges -->
                <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
                    <!-- Project Type Badge -->
                    <span class="cpc-type-pill <?= htmlspecialchars($typeInfo['badge']) ?>" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.85rem; border-radius: 2rem; font-size: 0.8rem; font-weight: 600; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); color: <?= $typeInfo['color'] ?>;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: <?= $typeInfo['color'] ?>;"></span>
                        <span><?= htmlspecialchars($typeInfo['label']) ?></span>
                    </span>

                    <!-- Showcase Status Badge -->
                    <span class="cpc-status-pill" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.85rem; border-radius: 2rem; font-size: 0.8rem; font-weight: 600; background: rgba(6, 182, 212, 0.12); border: 1px solid rgba(6, 182, 212, 0.25); color: #22D3EE;">
                        <span><?= htmlspecialchars($statusInfo['label']) ?></span>
                    </span>

                    <!-- Category Badge -->
                    <span style="padding: 0.35rem 0.85rem; border-radius: 2rem; font-size: 0.8rem; font-weight: 500; background: rgba(148, 163, 184, 0.1); border: 1px solid rgba(148, 163, 184, 0.2); color: #E2E8F0;">
                        <?= htmlspecialchars($project['category_label'] ?? 'Custom Software') ?>
                    </span>
                </div>

                <!-- Live Domain Host Pill (Only if host or live link exists) -->
                <?php if (!empty($project['live_url'])): ?>
                    <a href="<?= htmlspecialchars($project['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-domain-pill" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(7, 17, 31, 0.85); border: 1px solid rgba(34, 211, 238, 0.35); padding: 0.4rem 0.9rem; border-radius: 2rem; font-family: var(--font-mono); font-size: 0.82rem; color: var(--cyan); text-decoration: none; transition: all 0.2s;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #10B981; box-shadow: 0 0 8px #10B981;"></span>
                        <span><?= htmlspecialchars($project['mockup_host'] ?? parse_url($project['live_url'], PHP_URL_HOST)) ?></span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                <?php elseif (!empty($project['mockup_host'])): ?>
                    <span class="cpc-domain-pill" style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(7, 17, 31, 0.85); border: 1px solid rgba(148, 163, 184, 0.2); padding: 0.4rem 0.9rem; border-radius: 2rem; font-family: var(--font-mono); font-size: 0.82rem; color: #94A3B8;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #38BDF8;"></span>
                        <span><?= htmlspecialchars($project['mockup_host']) ?></span>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Title & Client Attribution -->
            <h1 style="font-size: clamp(1.85rem, 3.5vw, 2.75rem); color: var(--white); line-height: 1.2; margin-bottom: 1rem; font-weight: 800;">
                <?= htmlspecialchars($project['title']) ?>
            </h1>

            <!-- Client attribution -->
            <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--slate); font-size: 0.95rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <?php if (!empty($project['client_logo'])): ?>
                    <img src="<?= asset($project['client_logo']) ?>" alt="<?= htmlspecialchars($project['public_client_name'] ?? 'Client') ?>" style="height: 24px; max-width: 100px; object-fit: contain; border-radius: 4px;">
                <?php else: ?>
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; background: rgba(34, 211, 238, 0.14); color: var(--cyan);"><?= codex_icon('building', 14) ?></span>
                <?php endif; ?>

                <span>
                    Client / Organization: 
                    <strong style="color: <?= !empty($project['is_anonymized']) ? '#F59E0B' : 'var(--white)' ?>;">
                        <?= htmlspecialchars($project['public_client_name'] ?? 'Verified Commercial Client') ?>
                    </strong>
                    <?php if (!empty($project['is_anonymized'])): ?>
                        <span style="font-size: 0.75rem; color: #F59E0B; margin-left: 0.4rem; padding: 0.15rem 0.5rem; border-radius: 4px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25);">Anonymized per NDA</span>
                    <?php endif; ?>
                </span>
            </div>

            <!-- Key Quick Triplets (If available) -->
            <?php if (!empty($project['stat_1_val']) || !empty($project['stat_2_val']) || !empty($project['stat_3_val'])): ?>
                <div class="project-stat-triplets" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-top: 1.75rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <?php if (!empty($project['stat_1_val'])): ?>
                        <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem 1.15rem; border-radius: 0.75rem; border: 1px solid rgba(16, 185, 129, 0.2);">
                            <div style="font-size: 1.35rem; font-weight: 800; color: #10B981; line-height: 1.2;"><?= htmlspecialchars($project['stat_1_val']) ?></div>
                            <div style="font-size: 0.78rem; color: var(--slate); margin-top: 0.2rem;"><?= htmlspecialchars($project['stat_1_lbl']) ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($project['stat_2_val'])): ?>
                        <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem 1.15rem; border-radius: 0.75rem; border: 1px solid rgba(56, 189, 248, 0.2);">
                            <div style="font-size: 1.35rem; font-weight: 800; color: #38BDF8; line-height: 1.2;"><?= htmlspecialchars($project['stat_2_val']) ?></div>
                            <div style="font-size: 0.78rem; color: var(--slate); margin-top: 0.2rem;"><?= htmlspecialchars($project['stat_2_lbl']) ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($project['stat_3_val'])): ?>
                        <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem 1.15rem; border-radius: 0.75rem; border: 1px solid rgba(129, 140, 248, 0.2);">
                            <div style="font-size: 1.35rem; font-weight: 800; color: #818CF8; line-height: 1.2;"><?= htmlspecialchars($project['stat_3_val']) ?></div>
                            <div style="font-size: 0.78rem; color: var(--slate); margin-top: 0.2rem;"><?= htmlspecialchars($project['stat_3_lbl']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- TWO-COLUMN LAYOUT -->
        <div class="project-content-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; align-items: start;">
            
            <!-- LEFT MAIN CONTENT -->
            <div class="project-main-column" style="display: flex; flex-direction: column; gap: 2.5rem;">
                
                <!-- 1. PROBLEM VS SOLUTION SPLIT CARDS -->
                <section class="project-section">
                    <h2 style="font-size: 1.35rem; color: var(--white); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="color: var(--cyan); display: inline-flex;"><?= codex_icon('zap', 18) ?></span> Operational Context &amp; Engineered Solution
                    </h2>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                        <!-- The Bottleneck -->
                        <div class="card" style="padding: 1.75rem; border-left: 3px solid #EF4444; background: rgba(239, 68, 68, 0.04);">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; background: rgba(239, 68, 68, 0.15); color: #EF4444; font-size: 0.85rem;">⚠️</span>
                                <h3 style="font-size: 1.05rem; color: #F87171; margin: 0; font-weight: 700;">The Operational Bottleneck</h3>
                            </div>
                            <p style="font-size: 0.925rem; line-height: 1.65; color: #CBD5E1; margin: 0;">
                                <?= nl2br(htmlspecialchars($project['problem'])) ?>
                            </p>
                        </div>

                        <!-- The Solution -->
                        <div class="card" style="padding: 1.75rem; border-left: 3px solid #10B981; background: rgba(16, 185, 129, 0.04);">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); color: #10B981; font-size: 0.85rem;">✓</span>
                                <h3 style="font-size: 1.05rem; color: #34D399; margin: 0; font-weight: 700;">CodeX404 Engineering Solution</h3>
                            </div>
                            <p style="font-size: 0.925rem; line-height: 1.65; color: #CBD5E1; margin: 0;">
                                <?= nl2br(htmlspecialchars($project['solution'])) ?>
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 2. MAIN DELIVERABLE FEATURES -->
                <?php if (!empty($project['features'])): ?>
                    <section class="project-section">
                        <h2 style="font-size: 1.35rem; color: var(--white); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--cyan);">✦</span> Core Engineering Capabilities &amp; Features
                        </h2>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem;">
                            <?php foreach ($project['features'] as $feat): ?>
                                <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 0.75rem; padding: 1.15rem 1.25rem; display: flex; align-items: flex-start; gap: 0.75rem;">
                                    <span style="color: var(--cyan); font-size: 1rem; line-height: 1.2; flex-shrink: 0;">✓</span>
                                    <span style="font-size: 0.9rem; line-height: 1.5; color: #E2E8F0;"><?= htmlspecialchars($feat) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- 3. VERIFIED OUTCOMES & TEAM ROLE -->
                <section class="project-section">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                        
                        <!-- Verified Results -->
                        <?php if (!empty($project['verified_results']) || !empty($project['metric'])): ?>
                            <div class="card" style="padding: 1.75rem; border-color: rgba(16, 185, 129, 0.25); background: rgba(7, 17, 31, 0.75);">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); color: #10B981;">📊</span>
                                    <h3 style="font-size: 1.05rem; color: var(--white); margin: 0; font-weight: 700;">Verified Business Impact</h3>
                                </div>
                                <?php if (!empty($project['metric'])): ?>
                                    <div style="font-size: 1.1rem; font-weight: 700; color: #10B981; margin-bottom: 0.75rem; line-height: 1.4;">
                                        <?= htmlspecialchars($project['metric']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($project['verified_results'])): ?>
                                    <p style="font-size: 0.875rem; line-height: 1.6; color: #94A3B8; margin: 0;">
                                        <?= nl2br(htmlspecialchars($project['verified_results'])) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Team Role & Contribution -->
                        <?php if (!empty($project['team_role'])): ?>
                            <div class="card" style="padding: 1.75rem; border-color: rgba(99, 102, 241, 0.25); background: rgba(7, 17, 31, 0.75);">
                                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 26px; height: 26px; border-radius: 50%; background: rgba(99, 102, 241, 0.15); color: #818CF8;">🛡️</span>
                                    <h3 style="font-size: 1.05rem; color: var(--white); margin: 0; font-weight: 700;">CodeX404 Team Contribution</h3>
                                </div>
                                <p style="font-size: 0.9rem; line-height: 1.65; color: #CBD5E1; margin: 0;">
                                    <?= nl2br(htmlspecialchars($project['team_role'])) ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- 4. SCREENSHOTS & IMAGE GALLERY (If available) -->
                <?php if (!empty($project['gallery'])): ?>
                    <section class="project-section">
                        <h2 style="font-size: 1.35rem; color: var(--white); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--cyan);">🖼️</span> Interface Gallery &amp; Architecture Previews
                        </h2>

                        <div class="project-gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                            <?php foreach ($project['gallery'] as $imgUrl): ?>
                                <a href="<?= htmlspecialchars($imgUrl) ?>" target="_blank" rel="noopener noreferrer" style="display: block; border-radius: 0.75rem; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.1); background: rgba(0,0,0,0.4); aspect-ratio: 16/10; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                    <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Screenshot for <?= htmlspecialchars($project['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- 5. CASE STUDY CONTENT (If provided) -->
                <?php if (!empty($project['case_study_content'])): ?>
                    <section class="project-section card" style="padding: 2.25rem;">
                        <h2 style="font-size: 1.35rem; color: var(--white); margin-bottom: 1.25rem;">
                            In-Depth Architecture Breakdown
                        </h2>
                        <div class="project-case-body" style="font-size: 0.95rem; line-height: 1.7; color: #CBD5E1;">
                            <?= nl2br(htmlspecialchars($project['case_study_content'])) ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <!-- RIGHT SIDEBAR (SPECIFICATIONS & ACTIONS) -->
            <aside class="project-sidebar" style="display: flex; flex-direction: column; gap: 1.75rem;">
                
                <!-- ACTION BUTTONS CARD -->
                <div class="card" style="padding: 1.75rem; border-color: rgba(34, 211, 238, 0.3); background: rgba(11, 23, 44, 0.85);">
                    <h3 style="font-size: 1.1rem; color: var(--white); margin-bottom: 1.25rem; font-weight: 700;">
                        Direct Project Access
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <!-- Live URL Button (Only rendered if URL exists) -->
                        <?php if (!empty($project['live_url'])): ?>
                            <a href="<?= htmlspecialchars($project['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="justify-content: center; padding: 0.85rem 1.25rem; font-size: 0.95rem;">
                                <span>Visit Live Production Site ↗</span>
                            </a>
                        <?php endif; ?>

                        <!-- Interactive Demo Sandbox Button -->
                        <?php if (!empty($project['demo_url'])): ?>
                            <a href="<?= htmlspecialchars($project['demo_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="justify-content: center; padding: 0.85rem 1.25rem; font-size: 0.95rem;">
                                <span>⚡ Launch Interactive Demo</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= url('index.php#projects') ?>" class="btn btn-secondary btn-demo-trigger" data-demo="<?= htmlspecialchars($project['demo_key'] ?? 'erp') ?>" style="justify-content: center; padding: 0.85rem 1.25rem; font-size: 0.95rem;">
                                <span>⚡ In-Browser Simulator</span>
                            </a>
                        <?php endif; ?>

                        <!-- Video Walkthrough Button (If URL exists) -->
                        <?php if (!empty($project['video_url'])): ?>
                            <a href="<?= htmlspecialchars($project['video_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="justify-content: center; padding: 0.85rem 1.25rem; font-size: 0.95rem; border-color: rgba(255, 140, 0, 0.6); color: #FFFFFF;">
                                <span>🎬 Watch Video Walkthrough</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- SYSTEM SPECIFICATIONS CARD -->
                <div class="card" style="padding: 1.75rem; background: rgba(7, 17, 31, 0.85);">
                    <h3 style="font-size: 1.05rem; color: var(--white); margin-bottom: 1.25rem; font-weight: 700; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 0.75rem;">
                        Deliverable Specifications
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 0.9rem; font-size: 0.85rem;">
                        <div>
                            <span style="color: var(--slate); display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em;">Project Type</span>
                            <span style="color: var(--white); font-weight: 600;"><?= htmlspecialchars($typeInfo['label']) ?></span>
                        </div>

                        <div>
                            <span style="color: var(--slate); display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em;">Client / Organization</span>
                            <span style="color: var(--white); font-weight: 600;"><?= htmlspecialchars($project['public_client_name'] ?? 'Commercial Client') ?></span>
                        </div>

                        <div>
                            <span style="color: var(--slate); display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em;">Category</span>
                            <span style="color: var(--white); font-weight: 600;"><?= htmlspecialchars($project['category_label'] ?? 'Custom Software') ?></span>
                        </div>

                        <div>
                            <span style="color: var(--slate); display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em;">Showcase Status</span>
                            <span style="color: var(--cyan); font-weight: 600;"><?= htmlspecialchars($statusInfo['label']) ?></span>
                        </div>

                        <?php if (!empty($project['mockup_host'])): ?>
                            <div>
                                <span style="color: var(--slate); display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em;">Host / Domain</span>
                                <code style="color: var(--cyan); font-family: var(--font-mono); font-size: 0.8rem;"><?= htmlspecialchars($project['mockup_host']) ?></code>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- TECH STACK TAGS -->
                <?php if (!empty($project['tags'])): ?>
                    <div class="card" style="padding: 1.75rem; background: rgba(7, 17, 31, 0.85);">
                        <h3 style="font-size: 1.05rem; color: var(--white); margin-bottom: 1rem; font-weight: 700;">
                            Technology Stack
                        </h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                            <?php foreach ($project['tags'] as $tag): ?>
                                <span class="cpc-tag" style="padding: 0.3rem 0.65rem; font-size: 0.75rem;"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- CONTACT CTA CARD -->
                <div class="card" style="padding: 1.75rem; background: linear-gradient(135deg, rgba(14, 165, 233, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%); border-color: rgba(34, 211, 238, 0.25);">
                    <h3 style="font-size: 1.1rem; color: var(--white); margin-bottom: 0.5rem; font-weight: 700;">
                        Need Similar Architecture?
                    </h3>
                    <p style="font-size: 0.85rem; line-height: 1.6; color: var(--slate); margin-bottom: 1.25rem;">
                        Our senior team builds custom platforms, booking systems, and automation pipelines with zero fluff and fixed milestones.
                    </p>
                    <a href="<?= url('contact.php') ?>" class="btn btn-primary" style="justify-content: center; width: 100%; font-size: 0.9rem;">
                        Discuss Your Requirements →
                    </a>
                </div>
            </aside>
        </div>

        <!-- ADJACENT PROJECT NAVIGATION -->
        <nav class="project-pagination" style="display: flex; justify-content: space-between; align-items: center; margin-top: 4rem; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.08); flex-wrap: wrap; gap: 1rem;" aria-label="Adjacent Projects">
            <?php if ($prevProject): ?>
                <a href="<?= url('project.php?id=' . urlencode($prevProject['id'])) ?>" class="btn btn-secondary" style="font-size: 0.85rem;">
                    ← <?= htmlspecialchars($prevProject['title']) ?>
                </a>
            <?php else: ?>
                <div></div>
            <?php endif; ?>

            <a href="<?= url('portfolio.php') ?>" class="btn btn-outline" style="font-size: 0.85rem;">
                Back to All Projects ✦
            </a>

            <?php if ($nextProject): ?>
                <a href="<?= url('project.php?id=' . urlencode($nextProject['id'])) ?>" class="btn btn-secondary" style="font-size: 0.85rem;">
                    <?= htmlspecialchars($nextProject['title']) ?> →
                </a>
            <?php endif; ?>
        </nav>
    </div>
</main>

<style>
@media (max-width: 900px) {
    .project-content-layout {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php include __DIR__ . '/components/demo-modal.php'; ?>

<?php
require_once __DIR__ . '/includes/footer.php';

