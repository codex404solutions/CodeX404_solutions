<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Interactive Sales Pipeline (Kanban Board)
 * Multi-page architecture: Dedicated Pipeline & Deal Flow
 */

namespace CRM;

use CRM\Services\CrmSecurity;

$activePage = 'pipeline';
$pageTitle = 'Sales Pipeline & Kanban Deal Flow';
$pageHeading = 'Interactive Sales Pipeline & Deal Progression';
$pageSubheading = 'Track high-ticket B2B solutions across 6 stages with real-time multi-currency valuation';

require_once __DIR__ . '/includes/init.php';

$pipelineColumns = [
    'discovery' => ['title' => 'Discovery', 'color' => 'secondary', 'icon' => 'bi-search'],
    'scoping' => ['title' => 'Technical Scoping', 'color' => 'info', 'icon' => 'bi-code-slash'],
    'proposal' => ['title' => 'Proposal Sent', 'color' => 'warning', 'icon' => 'bi-file-earmark-text'],
    'negotiation' => ['title' => 'Negotiation', 'color' => 'primary', 'icon' => 'bi-chat-dots'],
    'closed_won' => ['title' => 'Closed Won', 'color' => 'success', 'icon' => 'bi-check-circle-fill'],
    'closed_lost' => ['title' => 'Closed Lost', 'color' => 'danger', 'icon' => 'bi-x-circle']
];

$totalPipelineVal = array_sum(array_column($opportunities ?? [], 'value'));

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
require_once __DIR__ . '/includes/topbar.php';
?>

<!-- Header & Quick Actions Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-kanban-fill text-success me-2"></i>Interactive Deal Progression Kanban</h4>
        <p class="text-muted small mb-0">Total Opportunities: <strong><?= count($opportunities ?? []) ?></strong> &bull; Total Pipeline: <strong class="text-success currency-val" data-usd="<?= (float)$totalPipelineVal ?>">$<?= number_format($totalPipelineVal, 0) ?></strong></p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-success-subtle text-success border border-success-subtle d-flex align-items-center px-3 py-2">
            Pipeline:&nbsp;<span class="currency-val" data-usd="<?= (float)$totalPipelineVal ?>">$<?= number_format($totalPipelineVal, 0) ?></span>
        </span>
        <button class="btn btn-success btn-sm fw-bold shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalNewDeal">
            <i class="bi bi-plus-circle"></i> + Add Deal
        </button>
    </div>
</div>

<!-- 6-Stage Kanban Board -->
<div class="kanban-board-container mb-4">
    <?php foreach ($pipelineColumns as $stageSlug => $colInfo):
        $stageDeals = array_filter($opportunities ?? [], fn($o) => ($o['stage'] ?? '') === $stageSlug);
        $colTotalVal = array_sum(array_column($stageDeals, 'value'));
    ?>
        <div class="kanban-col-item">
            <div class="kanban-col h-100">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <div class="fw-bold small text-<?= $colInfo['color'] ?>">
                        <i class="bi <?= $colInfo['icon'] ?> me-1"></i> <?= $colInfo['title'] ?>
                    </div>
                    <span class="badge bg-dark border border-secondary" style="font-size: 0.7rem;"><?= count($stageDeals) ?></span>
                </div>
                <div class="text-muted small mb-3 currency-val" data-usd="<?= (float)$colTotalVal ?>" style="font-size: 0.75rem;">
                    $<?= number_format($colTotalVal, 0) ?>
                </div>

                <!-- Deal Cards in this column -->
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
                                    <input type="hidden" name="return_page" value="pipeline">
                                    <select name="stage" class="form-select form-select-sm py-0 px-1 bg-dark text-white border-secondary" style="font-size: 0.68rem; width: auto;" onchange="this.form.submit()">
                                        <?php foreach ($pipelineColumns as $sKey => $sVal): ?>
                                            <option value="<?= $sKey ?>" <?= $sKey === $stageSlug ? 'selected' : '' ?>><?= $sVal['title'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>

                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this deal?');">
                                    <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                    <input type="hidden" name="action" value="delete_opportunity">
                                    <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                    <input type="hidden" name="return_page" value="pipeline">
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
    <?php endforeach; ?>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
