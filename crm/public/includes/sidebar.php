<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Shared Navigation Sidebar
 * Multi-page navigation for Desktop (<aside>) and Mobile (Offcanvas)
 */

$currentPage = $activePage ?? 'dashboard';
?>

<!-- ======================================================== -->
<!-- SIDEBAR NAVIGATION (Desktop)                             -->
<!-- ======================================================== -->
<aside class="col-12 col-lg-2 d-none d-lg-block crm-sidebar p-3 position-sticky top-0" style="height: 100vh; overflow-y: auto;">
    <!-- Brand with Original Logo -->
    <div class="mb-4 px-2 pt-2 text-center">
        <a href="dashboard" class="d-block text-decoration-none">
            <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" class="img-fluid" style="max-height: 48px; object-fit: contain;">
        </a>
        <div class="text-uppercase fw-bold mt-2" style="font-size: 0.65rem; letter-spacing: 0.12em; color: var(--cx-cyan);">
            Executive CRM &bull; Agent OS
        </div>
    </div>

    <!-- User Status Card -->
    <div class="p-2 mb-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
        <div class="d-flex align-items-center justify-content-between mb-1">
            <span class="fw-bold small text-white"><?= htmlspecialchars($currentUser['name'] ?? 'Admin') ?></span>
            <span class="agent-badge-pulse" title="Active Session"></span>
        </div>
        <div class="d-flex gap-1 flex-wrap">
            <?php foreach (($currentUser['roles'] ?? ['admin']) as $r): ?>
                <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;"><?= htmlspecialchars($r) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Multi-Page Navigation Links -->
    <nav class="nav flex-column mb-4" id="crmSidebarNav">
        <a href="dashboard" class="crm-nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
            <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Dashboard</span>
            <span class="badge rounded-pill bg-dark border border-secondary text-muted">Overview</span>
        </a>
        <a href="leads" class="crm-nav-link <?= $currentPage === 'leads' ? 'active' : '' ?>">
            <span><i class="bi bi-person-lines-fill me-2 text-warning"></i> Inbound Leads</span>
            <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"><?= $totalLeads ?? 0 ?></span>
        </a>
        <a href="pipeline" class="crm-nav-link <?= $currentPage === 'pipeline' ? 'active' : '' ?>">
            <span><i class="bi bi-kanban-fill me-2 text-success"></i> Sales Pipeline</span>
            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"><?= isset($opportunities) ? count($opportunities) : 0 ?></span>
        </a>
        <a href="projects" class="crm-nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">
            <span><i class="bi bi-rocket-takeoff-fill me-2 text-primary"></i> Client Delivery</span>
            <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle"><?= isset($projects) ? count($projects) : 0 ?></span>
        </a>
        <a href="paperclip" class="crm-nav-link <?= in_array($currentPage, ['paperclip', 'agents'], true) ? 'active' : '' ?>">
            <span><i class="bi bi-robot me-2 text-info"></i> Paperclip Agents</span>
            <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle"><?= isset($agents) ? count($agents) : 7 ?></span>
        </a>
        <a href="approvals" class="crm-nav-link <?= $currentPage === 'approvals' ? 'active' : '' ?>">
            <span><i class="bi bi-shield-check me-2 text-warning"></i> HITL Approvals</span>
            <?php $pendingCount = isset($pendingApprovals) ? count($pendingApprovals) : 0; ?>
            <?php if ($pendingCount > 0): ?>
                <span class="badge rounded-pill bg-danger text-white"><?= $pendingCount ?></span>
            <?php else: ?>
                <span class="badge rounded-pill bg-secondary text-white">0</span>
            <?php endif; ?>
        </a>
        <a href="settings" class="crm-nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
            <span><i class="bi bi-sliders me-2 text-secondary"></i> System &amp; API</span>
            <span class="badge rounded-pill bg-dark border border-secondary text-muted">Webhooks</span>
        </a>
    </nav>

    <hr style="border-color: rgba(255, 255, 255, 0.1);">

    <!-- Quick External Links -->
    <div class="px-2">
        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Platform Portals</small>
        <div class="d-grid gap-1 mt-2">
            <a href="../website/admin/" target="_blank" class="btn btn-sm btn-outline-secondary text-start d-flex justify-content-between align-items-center" style="font-size: 0.78rem;">
                <span><i class="bi bi-grid-1x2 me-1 text-info"></i> Portfolio Admin</span>
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <a href="../website/discovery-call" target="_blank" class="btn btn-sm btn-outline-secondary text-start d-flex justify-content-between align-items-center" style="font-size: 0.78rem;">
                <span><i class="bi bi-lightning-charge me-1 text-warning"></i> Public Lead Intake</span>
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <a href="../website/" target="_blank" class="btn btn-sm btn-outline-secondary text-start d-flex justify-content-between align-items-center" style="font-size: 0.78rem;">
                <span><i class="bi bi-globe me-1 text-primary"></i> CodeX404 Front</span>
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <a href="logout" class="btn btn-sm btn-outline-danger text-start mt-2" style="font-size: 0.8rem;">
                <i class="bi bi-box-arrow-left me-1"></i> Sign Out
            </a>
        </div>
    </div>
</aside>

<!-- ======================================================== -->
<!-- MOBILE OFFCANVAS SIDEBAR                                 -->
<!-- ======================================================== -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <div class="d-flex align-items-center gap-2">
            <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" style="max-height: 32px; object-fit: contain;">
            <span class="small text-uppercase fw-bold text-info">CRM &bull; AGENTS</span>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <div class="p-2 mb-3 rounded-3" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="fw-bold small text-white"><?= htmlspecialchars($currentUser['name'] ?? 'Admin') ?></div>
            <div class="small text-muted"><?= htmlspecialchars($currentUser['email'] ?? '') ?></div>
        </div>
        <nav class="nav flex-column mb-3" id="mobileNavLinks">
            <a href="dashboard" class="crm-nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>"><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Dashboard</a>
            <a href="leads" class="crm-nav-link <?= $currentPage === 'leads' ? 'active' : '' ?>"><i class="bi bi-person-lines-fill me-2 text-warning"></i> Inbound Leads (<?= $totalLeads ?? 0 ?>)</a>
            <a href="pipeline" class="crm-nav-link <?= $currentPage === 'pipeline' ? 'active' : '' ?>"><i class="bi bi-kanban-fill me-2 text-success"></i> Pipeline Deals</a>
            <a href="projects" class="crm-nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>"><i class="bi bi-rocket-takeoff-fill me-2 text-primary"></i> Client Projects</a>
            <a href="paperclip" class="crm-nav-link <?= in_array($currentPage, ['paperclip', 'agents'], true) ? 'active' : '' ?>"><i class="bi bi-robot me-2 text-info"></i> Paperclip Agents</a>
            <a href="approvals" class="crm-nav-link <?= $currentPage === 'approvals' ? 'active' : '' ?>"><i class="bi bi-shield-check me-2 text-warning"></i> Approvals (<?= isset($pendingApprovals) ? count($pendingApprovals) : 0 ?>)</a>
            <a href="settings" class="crm-nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>"><i class="bi bi-sliders me-2 text-secondary"></i> System &amp; API</a>
        </nav>
        <hr class="border-secondary">
        <div class="d-grid gap-1">
            <a href="../website/admin/" target="_blank" class="btn btn-sm btn-outline-info text-start"><i class="bi bi-shield-lock me-1"></i> Website Admin</a>
            <a href="../website/discovery-call" target="_blank" class="btn btn-sm btn-outline-warning text-start"><i class="bi bi-lightning-charge me-1"></i> Lead Intake</a>
            <a href="logout" class="btn btn-sm btn-outline-danger text-start mt-2"><i class="bi bi-box-arrow-left me-1"></i> Sign Out</a>
        </div>
    </div>
</div>
