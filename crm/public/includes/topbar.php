<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Shared Topbar & Live Header
 * Starts <main> container with sticky flexbox column architecture
 */
?>

<!-- ======================================================== -->
<!-- MAIN CONTENT AREA (Flex Column for Sticky Footer)        -->
<!-- ======================================================== -->
<main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column flex-grow-1" style="min-height: 100vh; overflow-x: hidden;">

    <!-- Top Header & Status Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
        <div class="d-flex align-items-center gap-3">
            <!-- Mobile Hamburger -->
            <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-label="Toggle navigation">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div>
                <h1 class="h4 mb-0 fw-bold"><?= htmlspecialchars($pageHeading ?? 'Company CRM & Paperclip Command Center') ?></h1>
                <p class="text-muted small mb-0"><?= htmlspecialchars($pageSubheading ?? 'Autonomous multi-agent pipeline with Human-in-the-Loop governance') ?></p>
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
                            <span class="badge bg-secondary-subtle text-muted">CA$</span>
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
                </ul>
            </div>

            <!-- Theme Toggle Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1" id="bd-theme-crm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-circle-half theme-icon-active text-info"></i>
                    <span class="small d-none d-sm-inline" id="bd-theme-crm-text">Dark &amp; Light</span>
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
                <button class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center gap-1 px-3 py-1" type="button" id="quickActionsBtn" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">New</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="quickActionsBtn">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewLead"><i class="bi bi-person-plus-fill me-2 text-warning"></i> Add Inbound Lead</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewDeal"><i class="bi bi-kanban me-2 text-success"></i> Create Pipeline Deal</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewProject"><i class="bi bi-rocket-takeoff me-2 text-primary"></i> Initialize Project</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent"><i class="bi bi-cpu me-2 text-info"></i> Dispatch Paperclip Task</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Live Exchange Rates Marquee Ticker -->
    <div class="mb-4">
        <div class="fx-marquee-container d-flex align-items-center">
            <span class="badge bg-dark border border-secondary text-info me-2 text-uppercase" style="font-size: 0.65rem; padding: 2px 6px;">
                <span class="agent-badge-pulse me-1" style="width: 5px; height: 5px;"></span>Live FX Rates
            </span>
            <div class="fx-marquee-content">
                <?php foreach (($liveExchangeRates ?? []) as $curr => $rate): ?>
                    <span class="text-muted">
                        <strong class="text-white"><?= htmlspecialchars((string)$curr) ?></strong>: <?= number_format((float)$rate, 4) ?>
                    </span>
                <?php endforeach; ?>
                <!-- Duplicate for seamless infinite loop -->
                <?php foreach (($liveExchangeRates ?? []) as $curr => $rate): ?>
                    <span class="text-muted">
                        <strong class="text-white"><?= htmlspecialchars((string)$curr) ?></strong>: <?= number_format((float)$rate, 4) ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Flash Alert Messages -->
    <?php if (!empty($flashMessage)): ?>
        <div class="alert alert-<?= htmlspecialchars($flashType ?? 'success') ?> alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-info-circle-fill fs-5"></i>
            <div><?= htmlspecialchars($flashMessage) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
