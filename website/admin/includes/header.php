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
                    <!-- Brand Header -->
                    <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom"
                        style="border-color: rgba(255, 255, 255, 0.08) !important;">
                        <a href="<?= admin_url() ?>" class="d-inline-flex align-items-center text-decoration-none">
                            <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="img-fluid"
                                style="max-height: 24px; object-fit: contain;">
                        </a>
                        <span class="badge fw-semibold d-inline-flex align-items-center gap-1"
                            style="font-size: 0.65rem; background: rgba(255, 140, 0, 0.14); color: #FFA940; border: 1px solid rgba(255, 140, 0, 0.4);">
                            <span class="cx-orange-dot" style="width: 5px; height: 5px;"></span>
                            Admin
                        </span>
                    </div>

                    <!-- Executive User Profile Card -->
                    <?php
                    $adminProfile = current_admin_profile();
                    $adminRoles = (array) ($adminProfile['roles'] ?? ['superadmin']);
                    $displayName = (string) ($adminProfile['name'] ?? $adminProfile['username'] ?? 'Admin');
                    $primaryRole = ucfirst((string) ($adminRoles[0] ?? 'admin'));
                    $extraRoles = count($adminRoles) > 1 ? ' · +' . (count($adminRoles) - 1) : '';
                    $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $displayName) ?: 'A', 0, 2));
                    $headerAvatar = class_exists('\\App\\Services\\UserService')
                        ? \App\Services\UserService::getAvatarInfo($adminProfile)
                        : ['image' => $adminProfile['avatar'] ?? null];
                    ?>
                    <div class="admin-profile-card">
                        <a href="<?= admin_url('profile') ?>" class="d-flex align-items-center justify-content-between gap-2 text-decoration-none" style="min-width: 0;" title="Open Account Profile">
                            <div class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                                <div class="admin-profile-avatar-wrap">
                                    <?php if (!empty($headerAvatar['image'])): ?>
                                        <img src="<?= asset($headerAvatar['image']) ?>"
                                            alt="<?= htmlspecialchars($displayName) ?>"
                                            class="admin-profile-avatar">
                                    <?php else: ?>
                                        <div class="admin-profile-initials"><?= htmlspecialchars($initials) ?></div>
                                    <?php endif; ?>
                                    <span class="admin-profile-status-dot" title="Active Session"></span>
                                </div>
                                <div style="min-width: 0; flex: 1;">
                                    <div class="fw-semibold text-white text-truncate" style="font-size: 0.84rem; line-height: 1.25;">
                                        <?= htmlspecialchars($displayName) ?>
                                    </div>
                                    <div class="text-truncate" style="font-size: 0.72rem; color: #94A3B8; line-height: 1.25;">
                                        <?= htmlspecialchars($primaryRole . $extraRoles) ?>
                                    </div>
                                </div>
                            </div>
                            <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; flex-shrink: 0;"></i>
                        </a>
                    </div>

                    <!-- Navigation Section Title -->
                    <div class="admin-sidebar-section-title">Workspace</div>

                    <!-- Dedicated Multi-Page Navigation Links -->
                    <nav class="nav flex-column mb-2" id="adminSidebarNav">
                        <a href="<?= admin_url() ?>"
                            class="admin-sidebar-link <?= ($currentPage === 'overview') ? 'active' : '' ?>">
                            <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-grid-1x2"></i><span>Overview</span></span>
                        </a>
                        <?php if (current_admin_can('portfolio.view')): ?>
                            <a href="<?= admin_url('deliverables') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'deliverables') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-collection-play"></i><span>Deliverables</span></span>
                                <span class="admin-sidebar-count"><?= $totalCount ?></span>
                            </a>
                            <a href="<?= admin_url('showcase') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'showcase') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-layers"></i><span>Showcase</span></span>
                                <span class="admin-sidebar-count"><?= min(6, $totalCount) ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if (current_admin_can('inquiries.view')): ?>
                            <a href="<?= admin_url('inquiries') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'inquiries') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-envelope-paper"></i><span>Inquiries</span></span>
                            </a>
                        <?php endif; ?>
                        <?php if (current_admin_can('careers.view')): ?>
                            <a href="<?= admin_url('careers') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'careers') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-briefcase"></i><span>Careers &amp; Hiring</span></span>
                                <span class="admin-sidebar-count">ATS</span>
                            </a>
                        <?php endif; ?>
                        <?php if (current_admin_can('users.view')): ?>
                            <a href="<?= admin_url('users') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'users') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-people"></i><span>Users &amp; Roles</span></span>
                            </a>
                        <?php endif; ?>
                        <?php if (current_admin_can('settings.view')): ?>
                            <a href="<?= admin_url('logs') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'logs') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-journal-text"></i><span>Audit Logs</span></span>
                            </a>
                            <a href="<?= admin_url('telemetry') ?>"
                                class="admin-sidebar-link <?= ($currentPage === 'telemetry') ? 'active' : '' ?>">
                                <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-activity"></i><span>Telemetry</span></span>
                            </a>
                        <?php endif; ?>
                        <a href="<?= admin_url('profile') ?>"
                            class="admin-sidebar-link <?= ($currentPage === 'profile') ? 'active' : '' ?>">
                            <span class="d-inline-flex align-items-center gap-2"><i class="bi bi-person-badge"></i><span>My Profile</span></span>
                        </a>
                    </nav>

                    <!-- Platform Bridges Section Title -->
                    <div class="admin-sidebar-section-title">Platform bridges</div>
                    <div class="admin-bridge-grid mb-2">
                        <?php
                        $crmAvailable = is_dir(dirname(__DIR__, 3) . '/crm');
                        $hasCrmClearance = $crmAvailable && in_array($adminProfile['access_scope'] ?? 'crm_only', ['both', 'crm_only'], true);
                        ?>
                        <?php if ($hasCrmClearance): ?>
                            <a href="../../crm/" target="_blank" class="admin-sidebar-bridge-link"
                                title="Access Company CRM Command (Authorized)">
                                <i class="bi bi-briefcase"></i><span>CRM</span>
                            </a>
                        <?php else: ?>
                            <span class="admin-sidebar-bridge-link text-muted opacity-50" style="cursor: not-allowed;"
                                title="<?= $crmAvailable ? 'Restricted: Dual or CRM clearance required.' : 'CRM portal is not deployed in this workspace.' ?>">
                                <i class="bi bi-lock"></i><span>CRM</span>
                            </span>
                        <?php endif; ?>
                        <a href="<?= url('#work') ?>" target="_blank" class="admin-sidebar-bridge-link"
                            title="Public Portfolio Showcase">
                            <i class="bi bi-globe2"></i><span>Public</span>
                        </a>
                        <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-sidebar-bridge-link"
                            title="Client Discovery Intake">
                            <i class="bi bi-lightning-charge"></i><span>Intake</span>
                        </a>
                    </div>

                    <div class="mt-3 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                        <a href="<?= admin_url('logout') ?>"
                            class="admin-profile-action is-danger w-100" title="Sign Out">
                            <i class="bi bi-box-arrow-right"></i><span>Sign out</span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- ======================================================== -->
            <!-- MAIN CONTENT AREA                                        -->
            <!-- ======================================================== -->
            <main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column"
                style="min-height: 100vh; min-width: 0; overflow-x: clip;">

                <!-- Top Header & Status Bar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom"
                    style="border-color: var(--cx-border) !important;">
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
                        <!-- Live Database Status Badge -->
                        <?php $dbHealthy = class_exists('Database') && \Database::getConnection() !== null; ?>
                        <div class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                            style="<?= $dbHealthy
                                ? 'background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34D399;'
                                : 'background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35); color: #F59E0B;' ?>">
                            <span class="live-dot"
                                style="width: 6px; height: 6px; <?= $dbHealthy ? '' : 'background-color: #F59E0B;' ?>"></span>
                            <span
                                class="fw-semibold"><?= $dbHealthy ? 'MySQL: Connected' : 'Fallback: JSON Store' ?></span>
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
                        <?php if (current_admin_can('portfolio.edit')): ?>
                            <a href="<?= admin_url('project-form') ?>" class="btn btn-sm btn-cx-primary px-3">
                                <i class="bi bi-plus-lg me-1"></i> New Deliverable
                            </a>
                        <?php endif; ?>
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