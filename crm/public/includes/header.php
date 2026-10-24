<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Unified Header & Layout Shell
 */

$currentPage = $currentPage ?? 'dashboard';
$pageTitle = $pageTitle ?? 'Company CRM & Paperclip Command Center';
$pageSubtitle = $pageSubtitle ?? 'Autonomous multi-agent pipeline with Human-in-the-Loop governance';
$htmlTitle = $htmlTitle ?? ($pageTitle . ' — CodeX404 Solutions CRM');
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($htmlTitle) ?></title>

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_crm_theme');
            let theme = storedTheme ? storedTheme : 'combo';
            const effective = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effective);
        })();
        window.CODEX_EXCHANGE_RATES = <?= json_encode($liveExchangeRates ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        window.CODEX_CURRENCIES = <?= json_encode(\CRM\Services\CurrencyService::CURRENCIES, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo/favicon-16x16.png">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CRM Console CSS (Browser-Cached) -->
    <link rel="stylesheet" href="css/crm.css?v=<?= file_exists(dirname(__DIR__) . '/css/crm.css') ? filemtime(dirname(__DIR__) . '/css/crm.css') : time() ?>">
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ======================================================== -->
        <!-- DESKTOP EXECUTIVE SIDEBAR NAVIGATION                    -->
        <!-- ======================================================== -->
        <aside class="col-12 col-lg-2 d-none d-lg-block crm-sidebar p-0">
            <div class="crm-sidebar-inner p-3 position-sticky top-0" style="max-height: 100vh; overflow-y: auto;">
                <!-- Brand with Original Logo -->
                <div class="mb-2 px-1 pt-1 text-center">
                    <a href="dashboard" class="d-block text-decoration-none">
                        <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" class="img-fluid" style="max-height: 32px; object-fit: contain;">
                    </a>
                    <div class="mt-1 d-flex align-items-center justify-content-center gap-1">
                        <span class="badge border text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.08em; background: #0F172A; color: #38BDF8; border-color: rgba(56, 189, 248, 0.3) !important;">CRM &amp; AGENT OS</span>
                    </div>
                </div>

                <!-- User Status Card with Multi-Role Footprint -->
                <div class="p-2 mb-2 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <a href="profile" class="d-flex align-items-center gap-2 text-decoration-none" title="Open My Account Profile">
                            <span class="agent-badge-pulse" title="Active Session" style="width: 6px; height: 6px;"></span>
                            <span class="fw-bold small text-white text-truncate" style="font-size: 0.78rem; max-width: 120px;"><?= htmlspecialchars($currentUser['name']) ?></span>
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <a href="profile" class="text-info small text-decoration-none" title="Full Profiling" style="font-size: 0.75rem;"><i class="bi bi-person-badge"></i></a>
                            <a href="logout" class="text-danger small text-decoration-none ms-1" title="Sign Out" style="font-size: 0.75rem;"><i class="bi bi-box-arrow-left"></i></a>
                        </div>
                    </div>
                    <div class="d-flex gap-1 flex-wrap">
                        <?php 
                        $userRolesList = (array)($currentUser['roles'] ?? ['admin']);
                        $displayRoles = array_slice($userRolesList, 0, 3);
                        foreach ($displayRoles as $r): 
                            $rInfo = $allRoles[strtolower($r)] ?? null;
                            $badgeColor = $rInfo['color'] ?? 'info';
                        ?>
                            <span class="badge bg-<?= htmlspecialchars($badgeColor) ?>-subtle text-<?= htmlspecialchars($badgeColor) ?> border border-<?= htmlspecialchars($badgeColor) ?>-subtle text-uppercase" style="font-size: 0.55rem; padding: 0.2em 0.4em;"><?= htmlspecialchars($r) ?></span>
                        <?php endforeach; ?>
                        <?php if (count($userRolesList) > 3): ?>
                            <a href="profile" class="badge bg-secondary-subtle text-muted text-decoration-none" style="font-size: 0.55rem;">+<?= count($userRolesList) - 3 ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Navigation Section Title -->
                <div class="crm-sidebar-section-title">Navigation</div>

                <!-- Multi-Page Navigation Links -->
                <nav class="nav flex-column mb-2" id="crmSidebarNav">
                    <a href="dashboard" class="crm-nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                        <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Dashboard</span>
                        <span class="badge rounded-pill bg-dark border border-secondary text-muted" style="font-size: 0.62rem;">Top</span>
                    </a>
                    <a href="leads" class="crm-nav-link <?= $currentPage === 'leads' ? 'active' : '' ?>">
                        <span><i class="bi bi-person-lines-fill me-2 text-warning"></i> Inbound Leads</span>
                        <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.62rem;"><?= $totalLeads ?></span>
                    </a>
                    <a href="pipeline" class="crm-nav-link <?= $currentPage === 'pipeline' ? 'active' : '' ?>">
                        <span><i class="bi bi-kanban-fill me-2 text-success"></i> Sales Pipeline</span>
                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle" style="font-size: 0.62rem;"><?= count($opportunities) ?></span>
                    </a>
                    <a href="projects" class="crm-nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">
                        <span><i class="bi bi-rocket-takeoff-fill me-2 text-primary"></i> Client Delivery</span>
                        <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 0.62rem;"><?= count($projects) ?></span>
                    </a>
                    <a href="paperclip" class="crm-nav-link <?= $currentPage === 'paperclip' ? 'active' : '' ?>">
                        <span><i class="bi bi-robot me-2 text-info"></i> Paperclip Agents</span>
                        <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle" style="font-size: 0.62rem;"><?= count($agents) ?></span>
                    </a>
                    <a href="approvals" class="crm-nav-link <?= $currentPage === 'approvals' ? 'active' : '' ?>">
                        <span><i class="bi bi-shield-check me-2 text-warning"></i> HITL Approvals</span>
                        <?php if (count($pendingApprovals) > 0): ?>
                            <span class="badge rounded-pill bg-danger text-white" style="font-size: 0.62rem;"><?= count($pendingApprovals) ?></span>
                        <?php else: ?>
                            <span class="badge rounded-pill bg-secondary text-white" style="font-size: 0.62rem;">0</span>
                        <?php endif; ?>
                    </a>
                    <a href="users" class="crm-nav-link <?= $currentPage === 'users' ? 'active' : '' ?>">
                        <span><i class="bi bi-people-fill me-2 text-info"></i> Users &amp; Roles</span>
                        <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle" style="font-size: 0.62rem;"><?= $totalWorkforceCount ?? 4 ?></span>
                    </a>
                    <a href="settings" class="crm-nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
                        <span><i class="bi bi-sliders me-2 text-secondary"></i> System &amp; API</span>
                        <span class="badge rounded-pill bg-dark border border-secondary text-muted" style="font-size: 0.62rem;">API</span>
                    </a>
                </nav>

                <!-- Platform Bridges Title -->
                <div class="crm-sidebar-section-title">Platform Bridges</div>

                <div class="d-flex gap-1 mb-2">
                    <?php 
                    $hasAdminClearance = in_array($currentUser['access_scope'] ?? 'crm_only', ['both', 'admin_only'], true);
                    ?>
                    <?php if ($hasAdminClearance): ?>
                        <a href="../website/admin/" target="_blank" class="crm-sidebar-link flex-fill text-center justify-content-center py-1" style="font-size: 0.72rem;" title="Access Website Admin CMS (Authorized)">
                            <i class="bi bi-shield-lock me-1 text-info"></i> Admin
                        </a>
                    <?php else: ?>
                        <span class="crm-sidebar-link flex-fill text-center justify-content-center py-1 text-muted opacity-50" style="font-size: 0.72rem; cursor: not-allowed;" title="Restricted: Your account is CRM-Only. Dual or Admin clearance required to access Website Admin.">
                            <i class="bi bi-lock-fill me-1 text-secondary"></i> Admin
                        </span>
                    <?php endif; ?>
                    <a href="../website/discovery-call" target="_blank" class="crm-sidebar-link flex-fill text-center justify-content-center py-1" style="font-size: 0.72rem;">
                        <i class="bi bi-lightning-charge me-1 text-warning"></i> Intake
                    </a>
                </div>
            </div>
        </aside>

        <!-- ======================================================== -->
        <!-- MAIN CONTENT AREA                                        -->
        <!-- ======================================================== -->
        <main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column" style="min-height: 100vh; overflow-x: hidden;">

            <!-- Top Header & Status Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <div class="d-flex align-items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h1 class="h4 mb-0 fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($pageSubtitle) ?></p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Paperclip Engine Status Badge -->
                    <div class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34D399;">
                        <span class="agent-badge-pulse"></span>
                        <span class="fw-semibold">Paperclip Engine: <?= htmlspecialchars($paperclipConn['mode'] ?? 'Local Runtime') ?></span>
                    </div>

                    <!-- Real-Time Live Currency Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1" id="bd-currency-crm" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Switch Currency in Real Time">
                            <span class="currency-flag-active" id="bd-currency-flag">🇺🇸</span>
                            <span class="fw-bold small" id="bd-currency-code">USD</span>
                            <span class="badge bg-dark border border-secondary text-info px-1 py-0" id="bd-currency-symbol" style="font-size: 0.65rem;">$</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-currency-crm" style="min-width: 250px;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center">
                                <span class="small text-uppercase fw-bold text-muted">Real-Time Currency</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">
                                    <span class="agent-badge-pulse me-1" style="width: 6px; height: 6px;"></span>Live Rates
                                </span>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="USD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇺🇸</span>
                                        <span><strong>USD</strong> &bull; US Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">$</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="INR">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇮🇳</span>
                                        <span><strong>INR</strong> &bull; Indian Rupee</span>
                                    </span>
                                    <span class="badge bg-warning-subtle text-warning">₹</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="EUR">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇪🇺</span>
                                        <span><strong>EUR</strong> &bull; Euro</span>
                                    </span>
                                    <span class="badge bg-info-subtle text-info">€</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="GBP">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇬🇧</span>
                                        <span><strong>GBP</strong> &bull; British Pound</span>
                                    </span>
                                    <span class="badge bg-primary-subtle text-primary">£</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="AED">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇦🇪</span>
                                        <span><strong>AED</strong> &bull; UAE Dirham</span>
                                    </span>
                                    <span class="badge bg-success-subtle text-success">د.إ</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="CAD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇨🇦</span>
                                        <span><strong>CAD</strong> &bull; Canadian Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">C$</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="AUD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇦🇺</span>
                                        <span><strong>AUD</strong> &bull; Australian Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">A$</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="SGD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇸🇬</span>
                                        <span><strong>SGD</strong> &bull; Singapore Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">S$</span>
                                </button>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li class="px-3 py-1">
                                <small class="text-muted" style="font-size: 0.68rem;" id="crm-currency-ticker">
                                    1 USD = ₹<?= number_format((float)($liveExchangeRates['INR'] ?? 95.05), 2) ?> &bull; €<?= number_format((float)($liveExchangeRates['EUR'] ?? 0.89), 2) ?> &bull; £<?= number_format((float)($liveExchangeRates['GBP'] ?? 0.75), 2) ?>
                                </small>
                            </li>
                        </ul>
                    </div>

                    <!-- Bootstrap Theme Toggle Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1" id="bd-theme-crm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-circle-half theme-icon-active text-primary"></i>
                            <span class="small d-none d-md-inline" id="bd-theme-crm-text">Dark &amp; Light</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-crm">
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

                    <!-- Quick Action Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-info btn-sm dropdown-toggle fw-bold text-dark px-3" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-plus-lg me-1"></i> Quick Action
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewLead"><i class="bi bi-person-plus me-2 text-warning"></i> Add Inbound Lead</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewDeal"><i class="bi bi-cash-stack me-2 text-success"></i> Add Pipeline Deal</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewProject"><i class="bi bi-rocket me-2 text-primary"></i> Create Client Project</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="users"><i class="bi bi-person-plus-fill me-2 text-info"></i> Provision Team User</a></li>
                            <li><a class="dropdown-item" href="profile"><i class="bi bi-person-badge me-2 text-primary"></i> My Full Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent"><i class="bi bi-robot me-2 text-info"></i> Dispatch Paperclip Agent</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Real-Time FX & Intelligence Marquee Scroller Ticker -->
            <div class="crm-marquee-wrap">
                <div class="crm-marquee-badge">
                    <span class="agent-badge-pulse" style="width: 6px; height: 6px;"></span>
                    <span>Live Intelligence</span>
                </div>
                <div class="crm-marquee-viewport">
                    <div class="crm-marquee-track">
                        <!-- Set 1 -->
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-exchange text-warning"></i>
                            <span>1 USD = <strong>₹<?= number_format((float)($liveExchangeRates['INR'] ?? 95.05), 2) ?> INR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-euro text-info"></i>
                            <span>1 USD = <strong>€<?= number_format((float)($liveExchangeRates['EUR'] ?? 0.89), 2) ?> EUR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-pound text-primary"></i>
                            <span>1 USD = <strong>£<?= number_format((float)($liveExchangeRates['GBP'] ?? 0.75), 2) ?> GBP</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-cash-stack text-success"></i>
                            <span>1 USD = <strong>د.إ<?= number_format((float)($liveExchangeRates['AED'] ?? 3.67), 2) ?> AED</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-robot text-info"></i>
                            <span>Paperclip Swarm: <strong>7/7 Autonomous Agents Armed</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                            <span>Pipeline Value: <strong class="currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-shield-check text-warning"></i>
                            <span>HITL Queue: <strong><?= count($pendingApprovals) ?> Pending Decisions</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                            <span>Lead Velocity: <strong><?= $totalLeads ?> Total &bull; <?= $activeLeads ?> Active Inbound</strong></span>
                            <span class="sep">&bull;</span>
                        </div>

                        <!-- Set 2 (Duplicate for Infinite Smooth Loop) -->
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-exchange text-warning"></i>
                            <span>1 USD = <strong>₹<?= number_format((float)($liveExchangeRates['INR'] ?? 95.05), 2) ?> INR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-euro text-info"></i>
                            <span>1 USD = <strong>€<?= number_format((float)($liveExchangeRates['EUR'] ?? 0.89), 2) ?> EUR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-pound text-primary"></i>
                            <span>1 USD = <strong>£<?= number_format((float)($liveExchangeRates['GBP'] ?? 0.75), 2) ?> GBP</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-cash-stack text-success"></i>
                            <span>1 USD = <strong>د.إ<?= number_format((float)($liveExchangeRates['AED'] ?? 3.67), 2) ?> AED</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-robot text-info"></i>
                            <span>Paperclip Swarm: <strong>7/7 Autonomous Agents Armed</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                            <span>Pipeline Value: <strong class="currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-shield-check text-warning"></i>
                            <span>HITL Queue: <strong><?= count($pendingApprovals) ?> Pending Decisions</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                            <span>Lead Velocity: <strong><?= $totalLeads ?> Total &bull; <?= $activeLeads ?> Active Inbound</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            <?php if ($flashMessage): ?>
                <div class="alert alert-<?= htmlspecialchars($flashType) ?> alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div><?= htmlspecialchars($flashMessage) ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
