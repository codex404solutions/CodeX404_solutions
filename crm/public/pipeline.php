<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Interactive Sales Pipeline (Kanban)
 */

namespace CRM;

use CRM\Services\CrmSecurity;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'pipeline';
$pageTitle = 'Interactive Sales Pipeline (Kanban)';
$pageSubtitle = 'Track B2B web development proposals, contract velocity, and multi-stage deal progression';
$htmlTitle = 'Sales Pipeline — CodeX404 Solutions CRM';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Action Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="badge bg-success-subtle text-success border border-success-subtle d-flex align-items-center px-3 py-2">
            <i class="bi bi-graph-up-arrow me-1"></i> Active Pipeline:&nbsp;<span class="fw-bold currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></span>
        </span>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
            <i class="bi bi-kanban me-1"></i> <?= count($opportunities) ?> Deals Tracked
        </span>
        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
            <i class="bi bi-trophy-fill me-1"></i> Closed Won:&nbsp;<span class="fw-bold currency-val" data-usd="<?= (float)$closedWonValue ?>">$<?= number_format($closedWonValue, 0) ?></span>
        </span>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-success btn-sm fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalNewDeal">
            <i class="bi bi-plus-circle me-1"></i> + New Deal
        </button>
        <a href="leads" class="btn btn-outline-warning btn-sm px-3 py-2">
            <i class="bi bi-person-lines-fill me-1"></i> Convert Leads
        </a>
    </div>
</div>

<!-- Responsive Kanban Columns Container (Scroll-Snap on mobile, Grid on desktop) -->
<div class="kanban-board-container mb-4">
    <?php
    $pipelineColumns = [
        'discovery' => ['title' => 'Discovery', 'color' => 'secondary', 'icon' => 'bi-search'],
        'scoping' => ['title' => 'Technical Scoping', 'color' => 'info', 'icon' => 'bi-code-slash'],
        'proposal' => ['title' => 'Proposal Sent', 'color' => 'warning', 'icon' => 'bi-file-earmark-text'],
        'negotiation' => ['title' => 'Negotiation', 'color' => 'primary', 'icon' => 'bi-chat-dots'],
        'closed_won' => ['title' => 'Closed Won', 'color' => 'success', 'icon' => 'bi-check-circle-fill'],
        'closed_lost' => ['title' => 'Closed Lost', 'color' => 'danger', 'icon' => 'bi-x-circle']
    ];

    foreach ($pipelineColumns as $stageSlug => $colInfo):
        $stageDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $stageSlug);
        $colTotalVal = array_sum(array_column($stageDeals, 'value'));
    ?>
        <div class="kanban-col-item">
            <div class="kanban-col h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <div class="fw-bold small text-<?= $colInfo['color'] ?>">
                        <i class="bi <?= $colInfo['icon'] ?> me-1"></i> <?= $colInfo['title'] ?>
                    </div>
                    <span class="badge bg-dark border border-secondary" style="font-size: 0.7rem;"><?= count($stageDeals) ?></span>
                </div>
                <div class="text-muted small mb-3 currency-val fw-semibold" data-usd="<?= (float)$colTotalVal ?>" style="font-size: 0.78rem;">
                    $<?= number_format($colTotalVal, 0) ?>
                </div>

                <!-- Deal Cards in this column -->
                <div class="flex-grow-1">
                    <?php if (empty($stageDeals)): ?>
                        <div class="text-muted text-center py-4 small" style="opacity: 0.5;">No deals in <?= $colInfo['title'] ?></div>
                    <?php else: ?>
                        <?php foreach ($stageDeals as $deal): ?>
                            <div class="kanban-deal-card">
                                <div class="fw-bold text-white small mb-1"><?= htmlspecialchars($deal['title'] ?? 'Deal') ?></div>
                                <div class="small text-muted mb-2"><?= htmlspecialchars($deal['company'] ?? ($deal['client_name'] ?? 'Client')) ?></div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-success currency-val" data-usd="<?= (float)($deal['value'] ?? 0) ?>" style="font-size: 0.95rem;">$<?= number_format((float)($deal['value'] ?? 0), 0) ?></span>
                                    <span class="badge bg-dark border border-secondary small" style="font-size: 0.65rem;"><?= (int)($deal['probability'] ?? 50) ?>% Win</span>
                                </div>
                                <div class="small text-muted mb-3" style="font-size: 0.72rem;">
                                    <i class="bi bi-person me-1"></i><?= htmlspecialchars($deal['assigned_to'] ?? 'Technical Lead') ?>
                                </div>

                                <!-- Stage Switcher Dropdown & Delete -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="advance_opportunity">
                                        <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                        <input type="hidden" name="return_url" value="pipeline">
                                        <select name="stage" class="form-select form-select-sm py-0 px-1 bg-dark text-white border-secondary" style="font-size: 0.68rem; width: auto;" onchange="this.form.submit()">
                                            <?php foreach ($pipelineColumns as $sKey => $sVal): ?>
                                                <option value="<?= $sKey ?>" <?= $sKey === $stageSlug ? 'selected' : '' ?>><?= $sVal['title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>

                                    <form method="POST" class="d-inline" onsubmit="return confirm('Remove this deal from pipeline?');">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="delete_opportunity">
                                        <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                        <input type="hidden" name="return_url" value="pipeline">
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Delete Deal">
                                            <i class="bi bi-trash" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
