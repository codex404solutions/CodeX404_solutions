<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

$projects = ProjectService::getAll();
$totalCount = count($projects);
$activeCount = count(array_filter($projects, fn($p) => !empty($p['active'])));
$draftCount = $totalCount - $activeCount;
$categories = array_values(array_unique(array_filter(array_column($projects, 'category'))));

$initialStatus = strtolower(trim((string)($_GET['status'] ?? 'all')));
if ($initialStatus === 'published') {
    $initialStatus = 'active';
}

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliverables Directory — CodeX404 Solutions Admin</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts: Plus Jakarta Sans & Fira Code -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/logo/favicon-16x16.png') ?>">

    <style>
        :root {
            --cx-cyan: #22D3EE;
            --cx-cyan-hover: #06B6D4;
            --cx-blue: #3B82F6;
            --cx-indigo: #6366F1;
            --cx-purple: #A855F7;
            --cx-emerald: #10B981;
            --cx-amber: #F59E0B;
            --cx-rose: #F43F5E;
            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-mono: 'Fira Code', monospace;
        }

        [data-bs-theme="dark"] {
            --cx-bg-canvas: #030712;
            --cx-bg-surface: #0B0F19;
            --cx-bg-card: rgba(17, 24, 39, 0.75);
            --cx-bg-hover: rgba(31, 41, 55, 0.65);
            --cx-border: rgba(255, 255, 255, 0.08);
            --cx-border-focus: rgba(34, 211, 238, 0.45);
            --cx-text-primary: #F8FAFC;
            --cx-text-secondary: #94A3B8;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55);
            --cx-pill-bg: rgba(255, 255, 255, 0.05);
        }

        [data-bs-theme="light"] {
            --cx-bg-canvas: #F8FAFC;
            --cx-bg-surface: #FFFFFF;
            --cx-bg-card: #FFFFFF;
            --cx-bg-hover: #F1F5F9;
            --cx-border: #E2E8F0;
            --cx-border-focus: #0284C7;
            --cx-text-primary: #0F172A;
            --cx-text-secondary: #334155;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #FFFFFF;
            --cx-card-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            --cx-pill-bg: #F1F5F9;
        }

        [data-bs-theme="combo"] {
            --cx-bg-canvas: #F1F5F9;
            --cx-bg-surface: #FFFFFF;
            --cx-bg-card: #FFFFFF;
            --cx-bg-hover: #F8FAFC;
            --cx-border: #E2E8F0;
            --cx-border-focus: #0284C7;
            --cx-text-primary: #0F172A;
            --cx-text-secondary: #334155;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            --cx-pill-bg: #F1F5F9;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { max-width: 100%; overflow-x: hidden; }
        body {
            font-family: var(--font-sans);
            background-color: var(--cx-bg-canvas);
            color: var(--cx-text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            transition: background-color 0.2s ease, color 0.2s ease;
            -webkit-font-smoothing: antialiased;
        }

        .admin-navbar {
            background-color: var(--cx-nav-bg);
            border-bottom: 1px solid var(--cx-border);
            padding: 0.75rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            backdrop-filter: blur(16px);
        }

        .admin-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #0B0F19;
            padding: 6px 14px;
            border-radius: 12px;
            border: 1px solid rgba(34, 211, 238, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
            text-decoration: none;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }
        .admin-brand-pill:hover {
            transform: translateY(-1px);
            border-color: var(--cx-cyan);
        }

        .admin-nav-link {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            color: var(--cx-text-secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.15s ease;
        }
        .admin-nav-link:hover, .admin-nav-link.active {
            color: var(--cx-cyan);
            background: rgba(34, 211, 238, 0.12);
        }

        .admin-sidebar {
            background-color: var(--cx-bg-surface);
            border-right: 1px solid var(--cx-border);
        }

        .admin-sidebar-section-title {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--cx-text-muted);
            padding: 0.5rem 0.75rem;
            margin-top: 0.5rem;
        }

        .admin-sidebar-link {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--cx-text-secondary);
            padding: 0.6rem 0.75rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 2px;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }
        .admin-sidebar-link:hover, .admin-sidebar-link.active {
            color: var(--cx-cyan);
            background: rgba(34, 211, 238, 0.12);
            font-weight: 700;
        }

        .admin-sidebar-user-card {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.25rem;
        }

        .admin-card {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            box-shadow: var(--cx-card-shadow);
        }

        .filter-pill-btn {
            background: var(--cx-pill-bg);
            border: 1px solid var(--cx-border);
            color: var(--cx-text-secondary);
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .filter-pill-btn:hover, .filter-pill-btn.active {
            background: var(--cx-cyan);
            border-color: var(--cx-cyan);
            color: #030712;
            font-weight: 700;
        }

        .live-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--cx-emerald);
            display: inline-block;
            box-shadow: 0 0 10px var(--cx-emerald);
            animation: pulse-dot 2s infinite ease-in-out;
        }
        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
        }

        .table-admin {
            margin-bottom: 0;
            color: var(--cx-text-primary);
        }
        .table-admin th {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--cx-text-muted);
            border-bottom: 1px solid var(--cx-border);
            padding: 1rem 0.85rem;
            background: transparent;
        }
        .table-admin td {
            padding: 0.9rem 0.85rem;
            border-bottom: 1px solid var(--cx-border);
            background: transparent;
            font-size: 0.85rem;
        }
        .table-admin tr:hover td {
            background: var(--cx-bg-hover);
        }

        .project-id-chip {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            background: rgba(34, 211, 238, 0.1);
            color: var(--cx-cyan);
            border: 1px solid rgba(34, 211, 238, 0.25);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .demo-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            padding: 2px 8px;
            border-radius: 6px;
            background: rgba(168, 85, 247, 0.1);
            color: #C084FC;
            border: 1px solid rgba(168, 85, 247, 0.25);
        }

        .btn-action-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        /* ========================================================= */
        /* ADMIN CONSOLE ENTERPRISE FOOTER SYSTEM                    */
        /* ========================================================= */
        .admin-footer {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.75rem 1.5rem;
            margin-top: auto;
            box-shadow: var(--cx-card-shadow);
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer,
        [data-bs-theme="combo"] .admin-footer {
            background: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05) !important;
        }

        [data-bs-theme="dark"] .admin-footer {
            background: rgba(11, 15, 25, 0.85) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55) !important;
            backdrop-filter: blur(12px);
        }

        .admin-footer-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #070B14;
            padding: 4px 10px;
            border-radius: 10px;
            border: 1px solid rgba(34, 211, 238, 0.25);
            text-decoration: none;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .admin-footer-brand-pill:hover {
            transform: translateY(-1px);
            border-color: var(--cx-cyan);
        }

        .admin-footer-badge {
            background: #0B0F19;
            color: #22D3EE;
            border: 1px solid rgba(34, 211, 238, 0.3);
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            padding: 0.35rem 0.55rem;
            border-radius: 6px;
        }

        [data-bs-theme="light"] .admin-footer-badge,
        [data-bs-theme="combo"] .admin-footer-badge {
            background: #0F172A !important;
            color: #38BDF8 !important;
            border-color: #38BDF8 !important;
        }

        .admin-footer-telemetry {
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer-telemetry,
        [data-bs-theme="combo"] .admin-footer-telemetry {
            background: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
        }

        [data-bs-theme="dark"] .admin-footer-telemetry {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .admin-footer-stat-box {
            padding: 0.5rem 0.25rem;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.15s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer-stat-box,
        [data-bs-theme="combo"] .admin-footer-stat-box {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }

        [data-bs-theme="dark"] .admin-footer-stat-box {
            background: rgba(0, 0, 0, 0.45) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .admin-footer-stat-box:hover {
            transform: translateY(-2px);
        }

        .admin-footer-stat-label {
            font-size: 0.65rem;
            color: var(--cx-text-muted);
            margin-top: 2px;
        }

        .admin-footer-link {
            color: var(--cx-text-secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .admin-footer-link:hover {
            color: var(--cx-cyan) !important;
            background: rgba(34, 211, 238, 0.08);
            transform: translateX(2px);
        }

        [data-bs-theme="light"] .admin-footer-link,
        [data-bs-theme="combo"] .admin-footer-link {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .admin-footer-link:hover,
        [data-bs-theme="combo"] .admin-footer-link:hover {
            color: #0284C7 !important;
            background: rgba(2, 132, 199, 0.08);
        }

        .admin-footer-divider {
            border-top: 1px solid var(--cx-border) !important;
        }

        [data-bs-theme="light"] .admin-footer-divider,
        [data-bs-theme="combo"] .admin-footer-divider {
            border-top-color: #E2E8F0 !important;
        }

        [data-bs-theme="dark"] .admin-footer-divider {
            border-top-color: rgba(255, 255, 255, 0.08) !important;
        }
    </style>
</head>
<body>

<!-- TOP COMMAND NAVIGATION BAR -->
<nav class="admin-navbar">
    <div class="container-fluid px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= admin_url() ?>" class="admin-brand-pill" title="CodeX404 Solutions Admin">
                <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" style="height: 30px; object-fit: contain;">
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-dark border border-secondary text-info text-uppercase px-2 py-1" style="font-size: 0.68rem; letter-spacing: 0.08em;">
                    PORTFOLIO ADMIN
                </span>
                <span class="d-none d-sm-inline-flex align-items-center gap-1 text-success small fw-semibold" style="font-size: 0.75rem;">
                    <span class="live-dot"></span> Live Sync
                </span>
            </div>
        </div>

        <div class="d-none d-lg-flex align-items-center gap-1">
            <a href="<?= admin_url() ?>" class="admin-nav-link">
                <i class="bi bi-speedometer2 text-info"></i> Overview
            </a>
            <a href="<?= admin_url('projects') ?>" class="admin-nav-link active">
                <i class="bi bi-grid-1x2-fill text-primary"></i> Deliverables
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-1"><?= $totalCount ?></span>
            </a>
            <a href="<?= admin_url('project-form') ?>" class="admin-nav-link">
                <i class="bi bi-plus-circle text-success"></i> New Deliverable
            </a>
            <a href="../../crm/" target="_blank" class="admin-nav-link">
                <i class="bi bi-robot text-warning"></i> CRM &amp; Paperclip
                <i class="bi bi-box-arrow-up-right small text-muted" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Theme Toggle -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1" id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-circle-half theme-icon-active text-info"></i>
                    <span class="small d-none d-sm-inline" id="bd-theme-admin-text">Dark &amp; Light</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="combo"><i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark"><i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light"><i class="bi bi-sun-fill text-warning"></i> Pure Light Mode</button></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto"><i class="bi bi-laptop text-secondary"></i> System Auto</button></li>
                </ul>
            </div>

            <!-- Upload New Project Quick Action CTA -->
            <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm fw-bold d-none d-sm-inline-flex align-items-center gap-2 px-3 py-1" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 8px;">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Upload</span>
            </a>

            <!-- User Menu -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1" type="button" data-bs-toggle="dropdown" style="border-radius: 8px;">
                    <i class="bi bi-person-circle text-info"></i>
                    <span class="small d-none d-md-inline"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li class="dropdown-header">
                        <div class="fw-bold"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></div>
                        <small class="text-muted">Superadmin Access</small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="<?= admin_url() ?>" class="dropdown-item d-flex align-items-center gap-2"><i class="bi bi-speedometer2 text-info"></i> Overview Dashboard</a></li>
                    <li><a href="<?= admin_url('projects') ?>" class="dropdown-item d-flex align-items-center gap-2"><i class="bi bi-grid-1x2-fill text-primary"></i> Deliverables Directory</a></li>
                    <li><a href="<?= admin_url('project-form') ?>" class="dropdown-item d-flex align-items-center gap-2"><i class="bi bi-plus-circle text-success"></i> New Deliverable</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="<?= admin_url('logout') ?>" class="dropdown-item d-flex align-items-center gap-2 text-danger"><i class="bi bi-box-arrow-left"></i> Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- 2-COLUMN LAYOUT: SIDEBAR + MAIN CONTENT AREA -->
<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ADMIN SIDEBAR -->
        <aside class="col-12 col-lg-2 d-none d-lg-block admin-sidebar p-3 position-sticky" style="top: 61px; height: calc(100vh - 61px); overflow-y: auto;">
            <div class="admin-sidebar-user-card">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="fw-bold small"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                    <span class="live-dot" title="Live Session Active"></span>
                </div>
                <div class="d-flex align-items-center gap-1 flex-wrap">
                    <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;">Superadmin</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">Live Sync</span>
                </div>
            </div>

            <div class="d-grid mb-3">
                <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>New Deliverable</span>
                </a>
            </div>

            <div class="admin-sidebar-section-title">Navigation</div>
            <nav class="nav flex-column mb-3">
                <a href="<?= admin_url() ?>" class="admin-sidebar-link">
                    <span><i class="bi bi-speedometer2 me-2 text-info"></i> Overview</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Top</span>
                </a>
                <a href="<?= admin_url('projects') ?>" class="admin-sidebar-link active">
                    <span><i class="bi bi-collection-play-fill me-2 text-warning"></i> Deliverables</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $totalCount ?></span>
                </a>
                <a href="<?= admin_url('project-form') ?>" class="admin-sidebar-link">
                    <span><i class="bi bi-plus-square me-2 text-success"></i> New Project</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Add</span>
                </a>
            </nav>

            <div class="admin-sidebar-section-title">Filter Status</div>
            <div class="nav flex-column mb-3">
                <button type="button" class="admin-sidebar-link sidebar-status-filter <?= $initialStatus === 'all' ? 'active' : '' ?>" data-status-filter="all">
                    <span><i class="bi bi-grid-3x3-gap-fill me-2 text-info"></i> All Items</span>
                    <span class="badge bg-secondary-subtle text-muted rounded-pill"><?= $totalCount ?></span>
                </button>
                <button type="button" class="admin-sidebar-link sidebar-status-filter <?= $initialStatus === 'active' ? 'active' : '' ?>" data-status-filter="active">
                    <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"><?= $activeCount ?></span>
                </button>
                <button type="button" class="admin-sidebar-link sidebar-status-filter <?= $initialStatus === 'draft' ? 'active' : '' ?>" data-status-filter="draft">
                    <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $draftCount ?></span>
                </button>
            </div>

            <div class="admin-sidebar-section-title">Platform Bridges</div>
            <nav class="nav flex-column mb-3">
                <a href="../../crm/" target="_blank" class="admin-sidebar-link">
                    <span><i class="bi bi-robot me-2 text-warning"></i> CRM &amp; Paperclip</span>
                    <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <a href="<?= url('#work') ?>" target="_blank" class="admin-sidebar-link">
                    <span><i class="bi bi-globe2 me-2 text-primary"></i> Public Portfolio</span>
                    <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-sidebar-link">
                    <span><i class="bi bi-lightning-charge me-2 text-info"></i> Lead Intake Form</span>
                    <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
            </nav>

            <hr style="border-color: var(--cx-border);">
            <div class="d-grid">
                <a href="<?= admin_url('logout') ?>" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                    <i class="bi bi-box-arrow-left"></i> Sign Out
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column" style="min-height: calc(100vh - 61px); overflow-x: hidden;">

            <?php if ($flash): ?>
                <div class="alert alert-<?= $flash['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show border-0 shadow-sm d-flex align-items-center justify-content-between mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill' ?> fs-5"></i>
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Page Title Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                        <a href="<?= admin_url() ?>" class="text-decoration-none text-muted">Admin Console</a>
                        <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                        <span class="text-info">Deliverables Management</span>
                    </div>
                    <h1 class="h3 fw-bold mb-1">Production Deliverables Directory</h1>
                    <p class="text-muted small mb-0">Manage verified enterprise showcase applications, interactive sandboxes, and portfolio live states.</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm d-flex align-items-center gap-2 px-3 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>New Deliverable</span>
                    </a>
                </div>
            </div>

            <!-- SEARCH, FILTER & TAB CONTROLS -->
            <div class="admin-card p-3 mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="position-relative flex-grow-1" style="max-width: 380px;">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="projectSearch" class="form-control form-control-sm ps-5 py-2" placeholder="Search by title, category, host, tag..." style="border-radius: 10px;">
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="filter-pill-btn <?= $initialStatus === 'all' ? 'active' : '' ?>" data-filter-status="all">
                            All <span class="badge bg-dark border border-secondary text-white rounded-pill ms-1"><?= $totalCount ?></span>
                        </button>
                        <button type="button" class="filter-pill-btn <?= $initialStatus === 'active' ? 'active' : '' ?>" data-filter-status="active">
                            <span class="live-dot me-1" style="width: 6px; height: 6px;"></span>
                            Published <span class="badge bg-success-subtle text-success rounded-pill ms-1"><?= $activeCount ?></span>
                        </button>
                        <button type="button" class="filter-pill-btn <?= $initialStatus === 'draft' ? 'active' : '' ?>" data-filter-status="draft">
                            Draft <span class="badge bg-warning-subtle text-warning rounded-pill ms-1"><?= $draftCount ?></span>
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <select id="categoryFilter" class="form-select form-select-sm" style="border-radius: 8px; width: auto;">
                            <option value="all">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars(ucfirst($cat)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- PROJECTS DATA TABLE CARD -->
            <div class="admin-card overflow-hidden mb-4" id="portfolio-table">
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
                                    $category = strtolower((string)($p['category'] ?? 'software'));
                                    $tagsStr = implode(' ', (array)($p['tags'] ?? []));
                                    $searchBlob = strtolower(($p['title'] ?? '') . ' ' . ($p['id'] ?? '') . ' ' . $category . ' ' . ($p['mockup_host'] ?? '') . ' ' . $tagsStr);
                                    ?>
                                    <tr class="project-row" 
                                        data-search="<?= htmlspecialchars($searchBlob) ?>" 
                                        data-status="<?= $isActive ? 'active' : 'draft' ?>"
                                        data-category="<?= htmlspecialchars($category) ?>"
                                        id="row-<?= htmlspecialchars($p['id']) ?>">
                                        
                                        <td>
                                            <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle">
                                                <?= htmlspecialchars((string)($p['order'] ?? ($idx + 1))) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <div class="fw-bold text-truncate" style="max-width: 260px;" title="<?= htmlspecialchars($p['title']) ?>">
                                                <?= htmlspecialchars($p['title']) ?>
                                            </div>
                                            <div class="d-flex align-items-center gap-1 mt-1 text-muted" style="font-size: 0.72rem;">
                                                <code class="project-id-chip"><?= htmlspecialchars($p['id']) ?></code>
                                                <?php if (!empty($p['mockup_host'])): ?>
                                                    <span>&bull;</span>
                                                    <span class="text-truncate" style="font-family: var(--font-mono); max-width: 160px;"><?= htmlspecialchars($p['mockup_host']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.68rem;">
                                                <?= htmlspecialchars($p['category_label'] ?? $p['category']) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <form method="POST" action="<?= admin_url('toggle') ?>" class="d-inline">
                                                <?= csrf_input_field() ?>
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                                <?php if ($isActive): ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill" style="font-size: 0.75rem;" title="Click to move to Draft">
                                                        <span class="live-dot" style="width: 6px; height: 6px;"></span>
                                                        <span>Published</span>
                                                    </button>
                                                <?php else: ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill" style="font-size: 0.75rem;" title="Click to publish on website">
                                                        <i class="bi bi-circle"></i>
                                                        <span>Draft</span>
                                                    </button>
                                                <?php endif; ?>
                                            </form>
                                        </td>

                                        <td>
                                            <span class="demo-chip">
                                                <i class="bi bi-play-circle-fill"></i>
                                                <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                                            </span>
                                        </td>

                                        <td style="max-width: 250px;">
                                            <div class="small text-muted text-truncate" title="<?= htmlspecialchars((string)($p['metric'] ?? '')) ?>">
                                                <i class="bi bi-graph-up-arrow text-success me-1"></i><?= htmlspecialchars((string)($p['metric'] ?? 'Active System')) ?>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-end gap-1">
                                                <button type="button" 
                                                    class="btn btn-sm btn-outline-info btn-action-icon btn-preview-project" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalProjectPreview"
                                                    data-title="<?= htmlspecialchars($p['title']) ?>"
                                                    data-category="<?= htmlspecialchars($p['category_label'] ?? $p['category']) ?>"
                                                    data-host="<?= htmlspecialchars($p['mockup_host'] ?? '') ?>"
                                                    data-problem="<?= htmlspecialchars($p['problem'] ?? '') ?>"
                                                    data-solution="<?= htmlspecialchars($p['solution'] ?? '') ?>"
                                                    data-metric="<?= htmlspecialchars((string)($p['metric'] ?? '')) ?>"
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

                                                <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>" class="btn btn-sm btn-outline-primary btn-action-icon" title="Edit Deliverable">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-action-icon btn-delete-project"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDeleteProject"
                                                    data-id="<?= htmlspecialchars($p['id']) ?>"
                                                    data-title="<?= htmlspecialchars($p['title']) ?>"
                                                    title="Permanently Delete">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted small" style="border-color: var(--cx-border) !important;">
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

            <!-- ADMIN CONSOLE ENTERPRISE FOOTER -->
            <footer class="admin-footer mt-auto">
                <div class="row g-4 align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="admin-footer-brand-pill">
                                <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" style="height: 26px; object-fit: contain;">
                            </span>
                            <span class="badge admin-footer-badge text-uppercase">PORTFOLIO ADMIN</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.68rem;">v14.2 Enterprise</span>
                        </div>
                        <p class="text-muted small mb-2" style="max-width: 440px;">
                            Production Deliverables &amp; Client Project Management Console. Real-time orchestration of verified enterprise systems, interactive sandboxes, and high-availability showcase specs.
                        </p>
                        <div class="d-flex align-items-center gap-3 text-muted small flex-wrap" style="font-size: 0.75rem;">
                            <span><i class="bi bi-shield-check text-success me-1"></i> Strict CSRF Protection</span>
                            <span>&bull;</span>
                            <span><i class="bi bi-speedometer2 text-info me-1"></i> 99.98% SLA Uptime</span>
                            <span>&bull;</span>
                            <span><i class="bi bi-hdd-network text-primary me-1"></i> Sub-100ms Edge</span>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="admin-footer-telemetry">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.06em;">Repository Status</span>
                                <span class="d-flex align-items-center gap-1 text-success small" style="font-size: 0.72rem;">
                                    <span class="live-dot" style="width: 6px; height: 6px;"></span> Active Synchronization
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

                    <div class="col-12 col-md-3 text-md-end">
                        <div class="small fw-bold text-uppercase text-muted mb-2" style="font-size: 0.68rem; letter-spacing: 0.06em;">Platform Bridges</div>
                        <div class="d-flex flex-column gap-1 align-items-md-end">
                            <a href="../../crm/" target="_blank" class="admin-footer-link text-warning">
                                <i class="bi bi-robot"></i> <span>Company CRM &amp; Paperclip OS</span>
                            </a>
                            <a href="<?= url('#work') ?>" target="_blank" class="admin-footer-link">
                                <i class="bi bi-box-arrow-up-right text-primary"></i> <span>Public Portfolio Showcase</span>
                            </a>
                            <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-footer-link">
                                <i class="bi bi-lightning-charge text-info"></i> <span>Client Discovery Intake Form</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="admin-footer-divider pt-3 mt-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.75rem;">
                    <div class="text-muted">
                        &copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong>. Enterprise Deliverables Admin Console &bull; Built with PHP 8.3 &bull; Bootstrap 5.3.3 &bull; All Rights Reserved.
                    </div>
                    <div class="d-flex align-items-center gap-3 text-muted flex-wrap">
                        <span class="d-flex align-items-center gap-1"><i class="bi bi-database-check text-info"></i> Storage: JSON Data Store</span>
                        <span>&bull;</span>
                        <span class="d-flex align-items-center gap-1"><i class="bi bi-shield-lock text-success"></i> Active Session</span>
                        <span>&bull;</span>
                        <a href="<?= admin_url('logout') ?>" class="text-danger text-decoration-none fw-semibold"><i class="bi bi-box-arrow-left me-1"></i>Sign Out</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>
</div>

<!-- MODAL: PROJECT SPEC PREVIEW -->
<div class="modal fade" id="modalProjectPreview" tabindex="-1" aria-labelledby="modalProjectPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" id="previewCategory">Software</span>
                    <h5 class="modal-title fw-bold mb-0" id="previewTitle">Project Title</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 rounded-3 mb-3 d-flex align-items-center justify-content-between" style="background: rgba(34, 211, 238, 0.05); border: 1px solid rgba(34, 211, 238, 0.2);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-hdd-network text-info"></i>
                        <span class="small fw-bold text-muted">HOST:</span>
                        <code class="text-white" id="previewHost">app.system.online</code>
                    </div>
                    <a href="#" id="previewLiveLink" target="_blank" class="btn btn-xs btn-outline-info py-1 px-2" style="font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Visit System
                    </a>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold small text-muted text-uppercase mb-1"><i class="bi bi-exclamation-circle text-warning me-1"></i> Client Challenge &amp; Problem</h6>
                    <p class="small text-muted p-3 rounded-3" style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);" id="previewProblem">-</p>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold small text-muted text-uppercase mb-1"><i class="bi bi-gear-wide-connected text-primary me-1"></i> CodeX404 Engineering Solution</h6>
                    <p class="small text-muted p-3 rounded-3" style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);" id="previewSolution">-</p>
                </div>

                <h6 class="fw-bold small text-muted text-uppercase mb-2"><i class="bi bi-speedometer2 text-success me-1"></i> Verified Performance Metrics</h6>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                            <div class="h4 fw-bold text-success mb-0" id="previewStat1Val">-</div>
                            <small class="text-muted" id="previewStat1Lbl">Metric 1</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.2);">
                            <div class="h4 fw-bold text-info mb-0" id="previewStat2Val">-</div>
                            <small class="text-muted" id="previewStat2Lbl">Metric 2</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background: rgba(168, 85, 247, 0.08); border: 1px solid rgba(168, 85, 247, 0.2);">
                            <div class="h4 fw-bold text-primary mb-0" id="previewStat3Val">-</div>
                            <small class="text-muted" id="previewStat3Lbl">Metric 3</small>
                        </div>
                    </div>
                </div>

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

<!-- MODAL: DELETE CONFIRMATION -->
<div class="modal fade" id="modalDeleteProject" tabindex="-1" aria-labelledby="modalDeleteProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom border-danger-subtle">
                <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p>Are you sure you want to permanently delete this deliverable from the CodeX404 website portfolio?</p>
                <div class="p-3 rounded-3 mb-2" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25);">
                    <strong class="text-danger" id="deleteProjectTitle">Project Title</strong>
                    <div class="small text-muted" id="deleteProjectId">ID: project-id</div>
                </div>
                <small class="text-muted">This action cannot be undone. Public links to this showcase item will become 404.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="<?= admin_url('delete') ?>" id="deleteProjectForm">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="id" id="deleteProjectInputId" value="">
                    <button type="submit" class="btn btn-danger btn-sm fw-bold">
                        <i class="bi bi-trash3 me-1"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3.3 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('projectSearch');
    const statusPillBtns = document.querySelectorAll('.filter-pill-btn');
    const sidebarStatusBtns = document.querySelectorAll('.sidebar-status-filter');
    const categoryFilter = document.getElementById('categoryFilter');
    const rows = document.querySelectorAll('.project-row');
    const counterText = document.getElementById('tableCounterText');

    let currentStatus = '<?= $initialStatus ?>';
    let currentCategory = 'all';

    function filterRows() {
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

    statusPillBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            statusPillBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentStatus = this.getAttribute('data-filter-status') || 'all';

            sidebarStatusBtns.forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-status-filter') === currentStatus);
            });

            filterRows();
        });
    });

    sidebarStatusBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetStatus = this.getAttribute('data-status-filter') || 'all';
            currentStatus = targetStatus;

            sidebarStatusBtns.forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-status-filter') === targetStatus);
            });

            statusPillBtns.forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-filter-status') === targetStatus);
            });

            filterRows();
        });
    });

    if (categoryFilter) {
        categoryFilter.addEventListener('change', function () {
            currentCategory = this.value;
            filterRows();
        });
    }

    // Initialize with query status filter if any
    filterRows();

    // Preview Modal Data Hydration
    document.querySelectorAll('.btn-preview-project').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('previewTitle').textContent = this.dataset.title || 'Project';
            document.getElementById('previewCategory').textContent = this.dataset.category || 'Software';
            document.getElementById('previewHost').textContent = this.dataset.host || 'system.codex404solutions.online';
            document.getElementById('previewProblem').textContent = this.dataset.problem || 'No description provided.';
            document.getElementById('previewSolution').textContent = this.dataset.solution || 'No solution recorded.';

            document.getElementById('previewStat1Val').textContent = this.dataset.stat1Val || '-';
            document.getElementById('previewStat1Lbl').textContent = this.dataset.stat1Lbl || 'Metric 1';
            document.getElementById('previewStat2Val').textContent = this.dataset.stat2Val || '-';
            document.getElementById('previewStat2Lbl').textContent = this.dataset.stat2Lbl || 'Metric 2';
            document.getElementById('previewStat3Val').textContent = this.dataset.stat3Val || '-';
            document.getElementById('previewStat3Lbl').textContent = this.dataset.stat3Lbl || 'Metric 3';

            const liveLink = document.getElementById('previewLiveLink');
            if (this.dataset.liveUrl) {
                liveLink.href = this.dataset.liveUrl;
                liveLink.classList.remove('d-none');
            } else {
                liveLink.classList.add('d-none');
            }

            const tagsContainer = document.getElementById('previewTags');
            tagsContainer.innerHTML = '';
            try {
                const tags = JSON.parse(this.dataset.tags || '[]');
                tags.forEach(t => {
                    const span = document.createElement('span');
                    span.className = 'badge bg-secondary-subtle text-muted border border-secondary-subtle';
                    span.textContent = t;
                    tagsContainer.appendChild(span);
                });
            } catch (e) {}
        });
    });

    // Delete Modal Hydration
    document.querySelectorAll('.btn-delete-project').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id || '';
            const title = this.dataset.title || '';
            document.getElementById('deleteProjectTitle').textContent = title;
            document.getElementById('deleteProjectId').textContent = 'ID: ' + id;
            document.getElementById('deleteProjectInputId').value = id;
        });
    });

    // Theme Switcher Logic
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
});
</script>

</body>
</html>
