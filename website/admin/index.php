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

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeX404 Solutions — Production Portfolio & Deliverables Admin</title>
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
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/logo.png') ?>">

    <style>
        /* ========================================================= */
        /* DESIGN TOKENS & COLOR SYSTEM                             */
        /* ========================================================= */
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

        /* 1. DARK MODE (Obsidian Cyber) */
        [data-bs-theme="dark"] {
            --cx-bg-canvas: #030712;
            --cx-bg-surface: #0B0F19;
            --cx-bg-card: rgba(17, 24, 39, 0.7);
            --cx-bg-hover: rgba(31, 41, 55, 0.6);
            --cx-border: rgba(255, 255, 255, 0.08);
            --cx-border-focus: rgba(34, 211, 238, 0.4);
            --cx-text-primary: #F8FAFC;
            --cx-text-secondary: #94A3B8;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            --cx-pill-bg: rgba(255, 255, 255, 0.05);
        }

        /* 2. PURE LIGHT MODE */
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

        /* 3. DARK & LIGHT COMBO (Recommended Pro SaaS Aesthetic) */
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
            --cx-nav-bg: #070B14; /* Dark command navigation */
            --cx-card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            --cx-pill-bg: #F1F5F9;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--cx-bg-canvas);
            color: var(--cx-text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* ========================================================= */
        /* TOP NAVIGATION BAR                                        */
        /* ========================================================= */
        .admin-navbar {
            background-color: var(--cx-nav-bg);
            border-bottom: 1px solid var(--cx-border);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            backdrop-filter: blur(16px);
        }

        [data-bs-theme="combo"] .admin-navbar,
        [data-bs-theme="dark"] .admin-navbar {
            border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        }

        /* Brand Pill Container: Keeps Logo Pristine in ALL Themes */
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
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        [data-bs-theme="combo"] .admin-navbar .admin-nav-link,
        [data-bs-theme="dark"] .admin-navbar .admin-nav-link {
            color: #94A3B8;
        }

        .admin-nav-link:hover,
        .admin-nav-link.active {
            color: var(--cx-cyan);
            background: rgba(34, 211, 238, 0.1);
        }

        /* Live Pulse Dot */
        .live-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--cx-emerald);
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* ========================================================= */
        /* CARDS & METRIC WIDGETS                                    */
        /* ========================================================= */
        .admin-card {
            background-color: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            box-shadow: var(--cx-card-shadow);
            transition: all 0.2s ease;
        }

        .stat-card {
            background-color: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.35rem 1.5rem;
            box-shadow: var(--cx-card-shadow);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--cx-cyan);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-accent, var(--cx-cyan));
        }

        .stat-card.accent-emerald::before { background: var(--cx-emerald); }
        .stat-card.accent-amber::before { background: var(--cx-amber); }
        .stat-card.accent-indigo::before { background: var(--cx-indigo); }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        /* ========================================================= */
        /* TABLE STYLING                                             */
        /* ========================================================= */
        .table-admin {
            --bs-table-bg: transparent;
            --bs-table-border-color: var(--cx-border);
            color: var(--cx-text-primary);
            margin-bottom: 0;
        }

        .table-admin th {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--cx-text-muted);
            padding: 1rem 1.15rem;
            background: rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid var(--cx-border);
        }

        [data-bs-theme="dark"] .table-admin th {
            background: rgba(255, 255, 255, 0.02);
        }

        .table-admin td {
            padding: 1.15rem 1.15rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--cx-border);
        }

        .table-admin tr:hover td {
            background-color: var(--cx-bg-hover);
        }

        .project-id-chip {
            font-family: var(--font-mono);
            font-size: 0.74rem;
            color: var(--cx-text-muted);
        }

        .demo-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            background: rgba(168, 85, 247, 0.12);
            color: #A855F7;
            border: 1px solid rgba(168, 85, 247, 0.25);
        }

        .category-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            background: rgba(56, 189, 248, 0.1);
            color: #0284C7;
            border: 1px solid rgba(56, 189, 248, 0.2);
        }

        [data-bs-theme="dark"] .category-chip {
            color: #38BDF8;
        }

        /* Filter Pills */
        .filter-pill-btn {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            border: 1px solid var(--cx-border);
            background: var(--cx-bg-card);
            color: var(--cx-text-secondary);
            transition: all 0.15s ease;
            cursor: pointer;
        }

        .filter-pill-btn:hover,
        .filter-pill-btn.active {
            background: var(--cx-cyan);
            border-color: var(--cx-cyan);
            color: #030712;
            font-weight: 700;
        }

        /* Quick Action Toolbar Buttons */
        .btn-action-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.15s ease;
        }

        /* Modals */
        .modal-content {
            background-color: var(--cx-bg-surface);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: var(--cx-text-primary);
        }

        .modal-header, .modal-footer {
            border-color: var(--cx-border);
        }
    </style>
</head>
<body>

<!-- ======================================================== -->
<!-- TOP COMMAND NAVIGATION BAR                               -->
<!-- ======================================================== -->
<nav class="admin-navbar">
    <div class="container-fluid px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Brand with Original Logo in Dark Pill -->
        <div class="d-flex align-items-center gap-3">
            <a href="index.php" class="admin-brand-pill" title="CodeX404 Solutions Admin">
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

        <!-- Center Cross-Platform Nav Links -->
        <div class="d-none d-lg-flex align-items-center gap-1">
            <a href="index.php" class="admin-nav-link active">
                <i class="bi bi-grid-1x2-fill text-info"></i> Projects Portfolio
            </a>
            <a href="../../crm/public/index.php" target="_blank" class="admin-nav-link">
                <i class="bi bi-robot text-warning"></i>
                <span>CRM &amp; Paperclip OS</span>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle ms-1" style="font-size: 0.65rem;">Autonomous</span>
            </a>
            <a href="../index.php#work" target="_blank" class="admin-nav-link">
                <i class="bi bi-box-arrow-up-right text-primary"></i> Public Work
            </a>
            <a href="../discovery-call.php" target="_blank" class="admin-nav-link">
                <i class="bi bi-lightning-charge-fill text-warning"></i> Lead Intake
            </a>
        </div>

        <!-- Right Side Controls: Theme Switcher & Admin User Dropdown -->
        <div class="d-flex align-items-center gap-2">
            <!-- Bootstrap Theme Toggle Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1" id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-circle-half theme-icon-active text-info"></i>
                    <span class="small d-none d-sm-inline" id="bd-theme-admin-text">Dark &amp; Light</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="combo">
                            <i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark">
                            <i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light">
                            <i class="bi bi-sun-fill text-warning"></i> Pure Light Mode
                        </button>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto">
                            <i class="bi bi-laptop text-secondary"></i> System Auto
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Admin Profile Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 py-1 px-2" type="button" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.72rem;">
                        A
                    </div>
                    <span class="small fw-semibold d-none d-md-inline"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="adminUserDropdown">
                    <li class="dropdown-header small text-uppercase fw-bold text-muted">Session Info</li>
                    <li class="px-3 py-1">
                        <small class="text-muted d-block">IP: <code><?= htmlspecialchars(get_client_ip()) ?></code></small>
                        <small class="text-muted d-block">Role: <span class="badge bg-info-subtle text-info">Superadmin</span></small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="../../crm/public/index.php" target="_blank" class="dropdown-item d-flex align-items-center gap-2">
                            <i class="bi bi-robot text-warning"></i> Open CRM Command Center
                        </a>
                    </li>
                    <li>
                        <a href="../index.php#work" target="_blank" class="dropdown-item d-flex align-items-center gap-2">
                            <i class="bi bi-globe2 text-primary"></i> View Public Website
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="logout.php" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                            <i class="bi bi-box-arrow-left"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ======================================================== -->
<!-- MAIN CONTENT CONTAINER                                   -->
<!-- ======================================================== -->
<main class="container-fluid px-3 px-md-4 py-4" style="max-width: 1400px;">

    <!-- Flash Notifications -->
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : 'info') ?> alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi <?= $flash['type'] === 'error' ? 'bi-exclamation-triangle-fill' : ($flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill') ?> fs-5"></i>
            <div><?= htmlspecialchars($flash['message']) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Breadcrumbs & Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                <span>CodeX404 Portal</span>
                <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                <span class="text-info fw-semibold">Portfolio Management</span>
                <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                <span>Production Deliverables</span>
            </div>
            <h1 class="h3 fw-bold mb-1">Projects &amp; Production Deliverables</h1>
            <p class="text-muted small mb-0">Configure, reorder, preview, and publish verified client systems across the public showcase.</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="../index.php#work" target="_blank" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2 px-3 py-2" style="border-radius: 10px;">
                <i class="bi bi-eye"></i>
                <span>Preview Public Work</span>
            </a>
            <a href="project-form.php" class="btn btn-primary btn-sm d-flex align-items-center gap-2 px-3 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Upload New Project</span>
            </a>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- KPI STATS CARDS ROW                                      -->
    <!-- ======================================================== -->
    <div class="row g-3 mb-4">
        <!-- Stat 1: Total Projects -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Deliverables</span>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-collection-play-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold mb-1"><?= $totalCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-check-all text-success"></i> Synchronized in repository
                </div>
            </div>
        </div>

        <!-- Stat 2: Active on Website -->
        <div class="col-12 col-sm-6 col-xl-3">
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
                    <span>Visible to prospects</span>
                </div>
            </div>
        </div>

        <!-- Stat 3: Draft / Hidden -->
        <div class="col-12 col-sm-6 col-xl-3">
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
        </div>

        <!-- Stat 4: Active Categories -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card accent-indigo">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Industry Domains</span>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-primary mb-1"><?= count($categories) ?></div>
                <div class="small text-muted d-flex align-items-center gap-1 text-truncate">
                    <span><?= htmlspecialchars(implode(', ', array_slice($categories, 0, 3))) ?></span>
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
                <input type="text" id="projectSearch" class="form-control form-control-sm ps-5 py-2" placeholder="Search by title, category, host, tag..." style="border-radius: 10px;">
            </div>

            <!-- Filter Pills (Status) -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="filter-pill-btn active" data-filter-status="all">
                    All <span class="badge bg-dark border border-secondary text-white rounded-pill ms-1"><?= $totalCount ?></span>
                </button>
                <button type="button" class="filter-pill-btn" data-filter-status="active">
                    <span class="live-dot me-1" style="width: 6px; height: 6px;"></span>
                    Published <span class="badge bg-success-subtle text-success rounded-pill ms-1"><?= $activeCount ?></span>
                </button>
                <button type="button" class="filter-pill-btn" data-filter-status="draft">
                    Draft <span class="badge bg-warning-subtle text-warning rounded-pill ms-1"><?= $draftCount ?></span>
                </button>
            </div>

            <!-- Category Filter Dropdown -->
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

    <!-- ======================================================== -->
    <!-- PROJECTS DATA TABLE CARD                                 -->
    <!-- ======================================================== -->
    <div class="admin-card overflow-hidden">
        <?php if (empty($projects)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-3 text-secondary"></i>
                <h5 class="fw-bold">No Projects in Portfolio</h5>
                <p class="small mb-3">Add your first production project deliverable to populate the website showcase.</p>
                <a href="project-form.php" class="btn btn-primary btn-sm px-3 py-2 fw-bold" style="border-radius: 8px;">
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
                                
                                <!-- Order -->
                                <td class="fw-bold text-muted small" style="font-family: var(--font-mono);">
                                    <?= (int)($p['order'] ?? ($idx + 1)) ?>
                                </td>

                                <!-- Title, ID & Host -->
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Avatar Icon by Category -->
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-info fw-bold" style="width: 40px; height: 40px; background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.25); flex-shrink: 0;">
                                            <i class="bi <?= $category === 'ai' ? 'bi-cpu' : ($category === 'cloud' ? 'bi-cloud-check' : ($category === 'mobile' ? 'bi-phone' : 'bi-code-square')) ?> fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-white fs-6 mb-1 project-title-text"><?= htmlspecialchars($p['title']) ?></div>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="project-id-chip"><?= htmlspecialchars($p['id']) ?></span>
                                                <?php if (!empty($p['live_url'])): ?>
                                                    <span class="text-muted">&bull;</span>
                                                    <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-info text-decoration-none small d-inline-flex align-items-center gap-1" style="font-family: var(--font-mono); font-size: 0.76rem;">
                                                        <span><?= htmlspecialchars($p['mockup_host'] ?? 'Live URL') ?></span>
                                                        <i class="bi bi-box-arrow-up-right" style="font-size: 0.65rem;"></i>
                                                    </a>
                                                <?php elseif (!empty($p['mockup_host'])): ?>
                                                    <span class="text-muted">&bull;</span>
                                                    <span class="text-muted small" style="font-family: var(--font-mono); font-size: 0.76rem;"><?= htmlspecialchars($p['mockup_host']) ?></span>
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
                                    <form method="POST" action="toggle.php" class="d-inline">
                                        <?= csrf_input_field() ?>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                        <?php if ($isActive): ?>
                                            <button type="submit" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" title="Click to hide from public site">
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

                                <!-- Demo Key -->
                                <td>
                                    <span class="demo-chip">
                                        <i class="bi bi-play-circle-fill"></i>
                                        <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                                    </span>
                                </td>

                                <!-- Key Metric -->
                                <td style="max-width: 250px;">
                                    <div class="small text-muted text-truncate" title="<?= htmlspecialchars((string)($p['metric'] ?? '')) ?>">
                                        <i class="bi bi-graph-up-arrow text-success me-1"></i><?= htmlspecialchars((string)($p['metric'] ?? 'Active System')) ?>
                                    </div>
                                </td>

                                <!-- Actions Toolbar -->
                                <td>
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <!-- Quick Preview Modal Button -->
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

                                        <!-- Edit Project -->
                                        <a href="project-form.php?id=<?= urlencode($p['id']) ?>" class="btn btn-sm btn-outline-primary btn-action-icon" title="Edit Deliverable">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Delete Modal Trigger -->
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-action-icon btn-delete-project"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteProject"
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

</main>

<!-- ======================================================== -->
<!-- MODAL: PROJECT SPEC PREVIEW                              -->
<!-- ======================================================== -->
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
                <!-- Host preview banner -->
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

                <!-- Problem Statement -->
                <div class="mb-3">
                    <h6 class="fw-bold small text-muted text-uppercase mb-1"><i class="bi bi-exclamation-circle text-warning me-1"></i> Client Challenge &amp; Problem</h6>
                    <p class="small text-muted p-3 rounded-3" style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);" id="previewProblem">-</p>
                </div>

                <!-- Engineering Solution -->
                <div class="mb-3">
                    <h6 class="fw-bold small text-muted text-uppercase mb-1"><i class="bi bi-gear-wide-connected text-primary me-1"></i> CodeX404 Engineering Solution</h6>
                    <p class="small text-muted p-3 rounded-3" style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);" id="previewSolution">-</p>
                </div>

                <!-- 3 Key Metric Cards -->
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
                <form method="POST" action="delete.php" id="deleteProjectForm">
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
    // =========================================================
    // Real-Time Filter & Search
    // =========================================================
    const searchInput = document.getElementById('projectSearch');
    const statusPillBtns = document.querySelectorAll('.filter-pill-btn');
    const categoryFilter = document.getElementById('categoryFilter');
    const rows = document.querySelectorAll('.project-row');
    const counterText = document.getElementById('tableCounterText');

    let currentStatus = 'all';
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
            filterRows();
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

    // =========================================================
    // Delete Modal Hydration
    // =========================================================
    document.querySelectorAll('.btn-delete-project').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id || '';
            const title = this.dataset.title || '';
            document.getElementById('deleteProjectTitle').textContent = title;
            document.getElementById('deleteProjectId').textContent = 'ID: ' + id;
            document.getElementById('deleteProjectInputId').value = id;
        });
    });

    // =========================================================
    // Theme Switcher (Combo, Dark, Light, Auto)
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
