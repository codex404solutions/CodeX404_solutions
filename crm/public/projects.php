<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Client Delivery Projects & Milestone Gates
 */

namespace CRM;

use CRM\Services\CrmSecurity;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'projects';
$pageTitle = 'Client Delivery Projects & Milestone Gates';
$pageSubtitle = 'Delivery oversight, engineering sprint tracking, and milestone completion verification';
$htmlTitle = 'Client Delivery — CodeX404 Solutions CRM';

$deliveredCount = count(array_filter($projects, fn($p) => ($p['status'] ?? '') === 'delivered'));

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Action Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
            <i class="bi bi-rocket-takeoff-fill me-1"></i> <?= $activeProjectsCount ?> Active Client Deliveries
        </span>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
            <i class="bi bi-check-circle-fill me-1"></i> <?= $deliveredCount ?> Delivered
        </span>
        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2">
            <i class="bi bi-folder-check me-1"></i> <?= count($projects) ?> Total Projects In System
        </span>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalNewProject">
            <i class="bi bi-plus-circle me-1"></i> + New Project
        </button>
        <button class="btn btn-outline-secondary btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent">
            <i class="bi bi-robot text-info me-1"></i> Assign Agent
        </button>
    </div>
</div>

<!-- Client Deliveries Cards Grid -->
<div class="row g-4 mb-4">
    <?php if (empty($projects)): ?>
        <div class="col-12">
            <div class="crm-card p-5 text-center text-muted">
                <i class="bi bi-rocket-takeoff fs-1 d-block mb-3 text-primary opacity-50"></i>
                <h5>No active client delivery projects.</h5>
                <p class="small mb-3">Initialize a new project deliverable with engineering milestones and progress tracking.</p>
                <button class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalNewProject">
                    <i class="bi bi-plus-circle me-1"></i> + New Project Deliverable
                </button>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($projects as $proj): ?>
            <div class="col-12 col-xl-6">
                <div class="crm-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="fw-bold text-white mb-1"><?= htmlspecialchars($proj['name'] ?? 'Project') ?></h5>
                                <div class="text-muted small">
                                    <i class="bi bi-building me-1"></i>Client: <strong><?= htmlspecialchars($proj['client_name'] ?? ($proj['client'] ?? 'Client')) ?></strong>
                                    &bull; Budget: <strong class="text-success currency-val" data-usd="<?= (float)($proj['budget'] ?? 0) ?>">$<?= number_format((float)($proj['budget'] ?? 0), 0) ?></strong>
                                </div>
                            </div>
                            <span class="badge bg-<?= ($proj['status'] ?? '') === 'delivered' ? 'success' : (($proj['status'] ?? '') === 'in_progress' ? 'primary' : 'secondary') ?>-subtle text-<?= ($proj['status'] ?? '') === 'delivered' ? 'success' : (($proj['status'] ?? '') === 'in_progress' ? 'primary' : 'secondary') ?> border border-<?= ($proj['status'] ?? '') === 'delivered' ? 'success' : (($proj['status'] ?? '') === 'in_progress' ? 'primary' : 'secondary') ?>-subtle text-uppercase" style="font-size: 0.72rem;">
                                <?= htmlspecialchars(str_replace('_', ' ', $proj['status'] ?? 'planning')) ?>
                            </span>
                        </div>

                        <!-- Progress Bar -->
                        <div class="my-3">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Milestones Progress</span>
                                <span class="fw-bold text-white"><?= (int)($proj['progress'] ?? 0) ?>%</span>
                            </div>
                            <div class="progress" style="height: 8px; background: rgba(255, 255, 255, 0.08);">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= (int)($proj['progress'] ?? 0) ?>%"></div>
                            </div>
                        </div>

                        <!-- Milestone Checklist -->
                        <div class="p-3 rounded-3 mb-3" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.05);">
                            <div class="small fw-bold text-uppercase text-muted mb-2" style="font-size: 0.72rem;">
                                Engineering Milestones (Click checkbox to toggle)
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <?php
                                $milestones = $proj['milestones'] ?? [];
                                foreach ($milestones as $idx => $m):
                                    $isDone = !empty($m['done']) || !empty($m['completed']);
                                ?>
                                    <form method="POST" class="d-flex align-items-center justify-content-between">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="toggle_milestone">
                                        <input type="hidden" name="project_id" value="<?= CrmSecurity::escape($proj['id']) ?>">
                                        <input type="hidden" name="milestone_index" value="<?= $idx ?>">
                                        <input type="hidden" name="return_url" value="projects">

                                        <div class="form-check mb-0">
                                            <input class="form-check-input" type="checkbox" id="m_<?= CrmSecurity::escape($proj['id']) ?>_<?= $idx ?>" <?= $isDone ? 'checked' : '' ?> onchange="this.form.submit()">
                                            <label class="form-check-label small <?= $isDone ? 'text-decoration-line-through text-muted' : 'text-white' ?>" for="m_<?= CrmSecurity::escape($proj['id']) ?>_<?= $idx ?>">
                                                <?= htmlspecialchars($m['title'] ?? 'Milestone') ?>
                                            </label>
                                        </div>
                                        <?php if (!empty($m['target_date'])): ?>
                                            <span class="badge bg-dark border border-secondary text-muted" style="font-size: 0.65rem;"><?= htmlspecialchars($m['target_date']) ?></span>
                                        <?php endif; ?>
                                    </form>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Info & Actions -->
                    <div class="d-flex justify-content-between align-items-center text-muted small pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                        <div>
                            <i class="bi bi-person-badge me-1"></i> Lead: <strong><?= htmlspecialchars($proj['lead_engineer'] ?? ($proj['lead_agent'] ?? 'Delivery Lead')) ?></strong>
                            &bull; Target: <?= htmlspecialchars($proj['deadline'] ?? 'TBD') ?>
                        </div>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                            <input type="hidden" name="action" value="delete_project">
                            <input type="hidden" name="project_id" value="<?= CrmSecurity::escape($proj['id']) ?>">
                            <input type="hidden" name="return_url" value="projects">
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete Project">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
