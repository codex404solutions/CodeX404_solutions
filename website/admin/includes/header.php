<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Multi-Page Header & Navigation Include
 */

require_once dirname(__DIR__) . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

// Ensure portfolio data is loaded and calculated
if (!isset($projects)) {
    $projects = ProjectService::getAll();
}
$totalCount = count($projects);
$activeCount = count(array_filter($projects, fn($p) => !empty($p['active'])));
$draftCount = $totalCount - $activeCount;
if (!isset($categories)) {
    $categories = array_values(array_unique(array_filter(array_column($projects, 'category'))));
}

// Active page & title defaults
$currentPage = $currentPage ?? 'overview';
$pageTitle = $pageTitle ?? 'Portfolio & Deliverables Command Center';
$pageSubtitle = $pageSubtitle ?? 'Production deliverables, interactive sandboxes, and verified showcase specs';

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — CodeX404 Admin</title>
    <meta name="robots" content="noindex, nofollow">

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_admin_theme');
            let theme = storedTheme ? storedTheme : 'combo';
            const effective = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effective);
        })();
    </script>

    <!-- Bootstrap 5.3.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts: Plus Jakarta Sans & Fira Code -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/logo/favicon-16x16.png') ?>">

    <!-- Admin Console CSS (Browser-Cached) -->
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>

<body>

    <!-- ======================================================== -->
    <!-- 2-COLUMN LAYOUT: SIDEBAR + MAIN CONTENT AREA             -->
    <!-- ======================================================== -->
    <div class="container-fluid p-0">
        <div class="row g-0">

            <!-- ======================================================== -->
            <!-- SIDEBAR NAVIGATION (Desktop)                            -->
            <!-- ======================================================== -->
            <aside class="col-12 col-lg-2 d-none d-lg-block admin-sidebar p-0">
                <div class="admin-sidebar-inner p-2 position-sticky top-0" style="max-height: 100vh; overflow-y: auto;">
                    <!-- Brand with Original Logo -->
                    <div class="mb-1 px-1 pt-1 text-center">
                        <a href="<?= admin_url() ?>" class="d-block text-decoration-none">
                            <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="img-fluid"
                                style="max-height: 28px; object-fit: contain;">
                        </a>
                        <div class="mt-1 d-flex align-items-center justify-content-center gap-1">
                            <span class="badge border text-uppercase"
                                style="font-size: 0.58rem; letter-spacing: 0.08em; background: #0F172A; color: #38BDF8; border-color: rgba(56, 189, 248, 0.3) !important;">PORTFOLIO
                                ADMIN</span>
                        </div>
                    </div>

                    <!-- User Status Card with Multi-Role Footprint -->
                    <?php 
                    $adminProfile = current_admin_profile();
                    $adminRoles = (array)($adminProfile['roles'] ?? ['superadmin']);
                    ?>
                    <div class="p-2 mb-2 rounded-3"
                        style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <a href="<?= admin_url('profile') ?>" class="d-flex align-items-center gap-1.5 text-decoration-none">
                                <?php 
                                $headerAvatar = \CRM\Services\UserService::getAvatarInfo($adminProfile);
                                if (!empty($headerAvatar['image'])): 
                                ?>
                                    <img src="<?= asset($headerAvatar['image']) ?>" alt="<?= htmlspecialchars((string)($adminProfile['name'] ?? 'Admin')) ?>" class="rounded-circle object-fit-cover border" style="width: 20px; height: 20px; border-color: rgba(56, 189, 248, 0.4) !important;">
                                <?php else: ?>
                                    <span class="live-dot" title="Active Session" style="width: 5px; height: 5px;"></span>
                                <?php endif; ?>
                                <span class="fw-bold small text-white text-truncate"
                                    style="font-size: 0.75rem; max-width: 100px;"><?= htmlspecialchars((string) ($adminProfile['name'] ?? $adminProfile['username'] ?? 'Admin')) ?></span>
                            </a>
                            <div class="d-flex align-items-center gap-1">
                                <a href="<?= admin_url('profile') ?>" class="text-info small text-decoration-none" title="My Account Profile" style="font-size: 0.72rem;"><i class="bi bi-person-badge"></i></a>
                                <a href="<?= admin_url('logout') ?>" class="text-danger small text-decoration-none ms-1"
                                    title="Sign Out" style="font-size: 0.72rem;"><i class="bi bi-box-arrow-left"></i></a>
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-wrap">
                            <?php foreach (array_slice($adminRoles, 0, 2) as $r): ?>
                                <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase"
                                    style="font-size: 0.55rem; padding: 0.2em 0.4em;"><?= htmlspecialchars($r) ?></span>
                            <?php endforeach; ?>
                            <?php if (count($adminRoles) > 2): ?>
                                <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.55rem;">+<?= count($adminRoles) - 2 ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Navigation Section Title -->
                    <div class="admin-sidebar-section-title">Pages</div>

                    <!-- Dedicated Multi-Page Navigation Links -->
                    <nav class="nav flex-column mb-2" id="adminSidebarNav">
                        <a href="<?= admin_url() ?>" class="admin-sidebar-link <?= ($currentPage === 'overview') ? 'active' : '' ?>">
                            <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Overview</span>
                            <span class="badge rounded-pill bg-dark border border-secondary text-muted"
                                style="font-size: 0.62rem;">Top</span>
                        </a>
                        <a href="<?= admin_url('deliverables') ?>" class="admin-sidebar-link <?= ($currentPage === 'deliverables') ? 'active' : '' ?>">
                            <span><i class="bi bi-collection-play-fill me-2 text-warning"></i> Deliverables</span>
                            <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"
                                style="font-size: 0.62rem;"><?= $totalCount ?></span>
                        </a>
                        <a href="<?= admin_url('showcase') ?>" class="admin-sidebar-link <?= ($currentPage === 'showcase') ? 'active' : '' ?>">
                            <span><i class="bi bi-stars me-2 text-primary"></i> Showcase</span>
                            <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle"
                                style="font-size: 0.62rem;"><?= min(6, $totalCount) ?></span>
                        </a>
                        <a href="<?= admin_url('users') ?>" class="admin-sidebar-link <?= ($currentPage === 'users') ? 'active' : '' ?>">
                            <span><i class="bi bi-people-fill me-2 text-info"></i> Users &amp; Roles</span>
                            <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle"
                                style="font-size: 0.62rem;">RBAC</span>
                        </a>
                        <a href="<?= admin_url('telemetry') ?>" class="admin-sidebar-link <?= ($currentPage === 'telemetry') ? 'active' : '' ?>">
                            <span><i class="bi bi-activity me-2 text-success"></i> Telemetry</span>
                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"
                                style="font-size: 0.62rem;">Live</span>
                        </a>
                    </nav>

                    <!-- Filter By Status Section Title -->
                    <div class="admin-sidebar-section-title">Filter By Status</div>
                    <div class="d-flex flex-column gap-1 mb-2">
                        <?php if ($currentPage === 'deliverables'): ?>
                            <button type="button" class="admin-sidebar-link sidebar-status-filter active"
                                data-status-filter="all">
                                <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                                <span class="badge rounded-pill bg-dark border border-secondary text-muted"
                                    style="font-size: 0.62rem;"><?= $totalCount ?></span>
                            </button>
                            <button type="button" class="admin-sidebar-link sidebar-status-filter"
                                data-status-filter="published">
                                <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"
                                    style="font-size: 0.62rem;"><?= $activeCount ?></span>
                            </button>
                            <button type="button" class="admin-sidebar-link sidebar-status-filter"
                                data-status-filter="draft">
                                <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"
                                    style="font-size: 0.62rem;"><?= $draftCount ?></span>
                            </button>
                        <?php else: ?>
                            <a href="<?= admin_url('deliverables?filter=all') ?>" class="admin-sidebar-link">
                                <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                                <span class="badge rounded-pill bg-dark border border-secondary text-muted"
                                    style="font-size: 0.62rem;"><?= $totalCount ?></span>
                            </a>
                            <a href="<?= admin_url('deliverables?filter=published') ?>" class="admin-sidebar-link">
                                <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"
                                    style="font-size: 0.62rem;"><?= $activeCount ?></span>
                            </a>
                            <a href="<?= admin_url('deliverables?filter=draft') ?>" class="admin-sidebar-link">
                                <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"
                                    style="font-size: 0.62rem;"><?= $draftCount ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Platform Bridges Section Title -->
                    <div class="admin-sidebar-section-title">Platform Bridges</div>
                    <div class="d-flex gap-1 mb-2">
                        <?php 
                        $hasCrmClearance = in_array($adminProfile['access_scope'] ?? 'crm_only', ['both', 'crm_only'], true);
                        ?>
                        <?php if ($hasCrmClearance): ?>
                            <a href="../../crm/" target="_blank"
                                class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                                style="font-size: 0.72rem;" title="Access Company CRM Command (Authorized)">
                                <i class="bi bi-robot me-1 text-warning"></i> CRM
                            </a>
                        <?php else: ?>
                            <span class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1 text-muted opacity-50"
                                style="font-size: 0.72rem; cursor: not-allowed;" title="Restricted: Your account is Admin-Only. Dual or CRM clearance required to access CRM portal.">
                                <i class="bi bi-lock-fill me-1 text-secondary"></i> CRM
                            </span>
                        <?php endif; ?>
                        <a href="<?= url('#work') ?>" target="_blank"
                            class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                            style="font-size: 0.72rem;" title="Public Portfolio Showcase">
                            <i class="bi bi-globe2 me-1 text-primary"></i> Public
                        </a>
                        <a href="<?= url('discovery-call') ?>" target="_blank"
                            class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                            style="font-size: 0.72rem;" title="Client Discovery Intake">
                            <i class="bi bi-lightning-charge me-1 text-info"></i> Intake
                        </a>
                    </div>
                </div>
            </aside>

            <!-- ======================================================== -->
            <!-- MAIN CONTENT AREA                                        -->
            <!-- ======================================================== -->
            <main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column" style="min-height: 100vh; overflow-x: hidden;">

                <!-- Top Header & Status Bar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom"
                    style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Mobile Hamburger -->
                        <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar"
                            aria-label="Toggle Navigation">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <div>
                            <h1 class="h4 mb-0 fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>
                            <p class="text-muted small mb-0"><?= htmlspecialchars($pageSubtitle) ?></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <!-- Repository Status Badge with pulse -->
                        <div class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                            style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34D399;">
                            <span class="live-dot" style="width: 6px; height: 6px;"></span>
                            <span class="fw-semibold">Repository: Active Sync</span>
                        </div>

                        <!-- Bootstrap Theme Toggle Dropdown -->
                        <div class="dropdown">
                            <button
                                class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1"
                                id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-circle-half theme-icon-active text-primary"></i>
                                <span class="small d-none d-md-inline" id="bd-theme-admin-text">Dark &amp; Light</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="combo">
                                        <i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="dark">
                                        <i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="light">
                                        <i class="bi bi-sun-fill text-warning"></i> Pure Light Mode
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="auto">
                                        <i class="bi bi-laptop text-secondary"></i> System Auto
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- New Deliverable Action Button -->
                        <a href="<?= admin_url('project-form') ?>" class="btn btn-info btn-sm fw-bold text-dark px-3"
                            style="background: #38BDF8; border-color: #38BDF8;">
                            <i class="bi bi-plus-lg me-1"></i> New Deliverable
                        </a>
                    </div>
                </div>

                <!-- Flash Notifications -->
                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : 'info') ?> alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3 mb-4"
                        role="alert">
                        <i
                            class="bi <?= $flash['type'] === 'error' ? 'bi-exclamation-triangle-fill' : ($flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill') ?> fs-5"></i>
                        <div><?= htmlspecialchars($flash['message']) ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
