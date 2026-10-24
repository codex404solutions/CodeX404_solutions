<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Dual-Mode Interactive Sales Pipeline
 * Mode 1: Horizontal Agile Kanban Board
 * Mode 2: Vertical Revenue Funnel & Deal Velocity Waterfall
 */

namespace CRM;

use CRM\Services\CrmSecurity;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'pipeline';
$pageTitle = 'Sales Pipeline & Deal Velocity';
$pageSubtitle = 'Dual-mode B2B pipeline: horizontal stage progression board & vertical conversion funnel';
$htmlTitle = 'Sales Pipeline — CodeX404 Solutions CRM';

// -----------------------------------------------------------------------------
// Pipeline Stage Architecture & Data Setup
// -----------------------------------------------------------------------------
$pipelineStages = [
    'discovery' => [
        'order' => 1,
        'title' => 'Discovery',
        'subtitle' => 'Initial inquiry & technical requirements mapping',
        'color' => 'secondary',
        'badge_class' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
        'icon' => 'bi-search',
        'default_prob' => 20,
        'next_stage' => 'scoping',
        'next_label' => 'Technical Scoping'
    ],
    'scoping' => [
        'order' => 2,
        'title' => 'Technical Scoping',
        'subtitle' => 'Architecture blueprint, feasibility analysis & stack selection',
        'color' => 'info',
        'badge_class' => 'bg-info-subtle text-info border border-info-subtle',
        'icon' => 'bi-code-slash',
        'default_prob' => 40,
        'next_stage' => 'proposal',
        'next_label' => 'Proposal Sent'
    ],
    'proposal' => [
        'order' => 3,
        'title' => 'Proposal Sent',
        'subtitle' => 'Formal proposal, milestones & commercial estimate delivered',
        'color' => 'warning',
        'badge_class' => 'bg-warning-subtle text-warning border border-warning-subtle',
        'icon' => 'bi-file-earmark-text',
        'default_prob' => 60,
        'next_stage' => 'negotiation',
        'next_label' => 'Negotiation'
    ],
    'negotiation' => [
        'order' => 4,
        'title' => 'Negotiation',
        'subtitle' => 'SLA finalization, security compliance & master agreement review',
        'color' => 'primary',
        'badge_class' => 'bg-primary-subtle text-primary border border-primary-subtle',
        'icon' => 'bi-chat-dots',
        'default_prob' => 80,
        'next_stage' => 'closed_won',
        'next_label' => 'Closed Won'
    ],
    'closed_won' => [
        'order' => 5,
        'title' => 'Closed Won',
        'subtitle' => 'Contract executed, initial deposit received & delivery kickoff',
        'color' => 'success',
        'badge_class' => 'bg-success-subtle text-success border border-success-subtle',
        'icon' => 'bi-check-circle-fill',
        'default_prob' => 100,
        'next_stage' => null,
        'next_label' => null
    ],
    'closed_lost' => [
        'order' => 6,
        'title' => 'Closed Lost',
        'subtitle' => 'Postponed, disqualified, or lost to competitor / budget constraints',
        'color' => 'danger',
        'badge_class' => 'bg-danger-subtle text-danger border border-danger-subtle',
        'icon' => 'bi-x-circle',
        'default_prob' => 0,
        'next_stage' => null,
        'next_label' => null
    ]
];

// Pipeline Metrics Calculation
$totalDealsCount = count($opportunities);
$activeDeals = array_filter($opportunities, fn($o) => !in_array($o['stage'] ?? '', ['closed_won', 'closed_lost'], true));
$activePipelineVal = (float)array_sum(array_column($activeDeals, 'value'));
$closedWonDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'closed_won');
$closedWonVal = (float)array_sum(array_column($closedWonDeals, 'value'));
$closedLostDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'closed_lost');

// Probability-weighted forecast (Confidence-adjusted value)
$weightedForecastVal = 0.0;
foreach ($activeDeals as $d) {
    $val = (float)($d['value'] ?? 0);
    $prob = (float)($d['probability'] ?? ($pipelineStages[$d['stage'] ?? 'discovery']['default_prob'] ?? 20));
    $weightedForecastVal += ($val * ($prob / 100.0));
}

// Average deal size across pipeline
$avgDealSize = $totalDealsCount > 0 ? (array_sum(array_column($opportunities, 'value')) / $totalDealsCount) : 0;

// Win rate percentage
$totalClosedCount = count($closedWonDeals) + count($closedLostDeals);
$winRatePct = $totalClosedCount > 0 ? (int)round((count($closedWonDeals) / $totalClosedCount) * 100) : 100;

// Distinct Specialists for filter
$allSpecialists = array_values(array_unique(array_filter(array_column($opportunities, 'assigned_to'))));
sort($allSpecialists);

require_once __DIR__ . '/includes/header.php';
?>

<!-- ========================================================================= -->
<!-- 1. EXECUTIVE KPI SUMMARY METRICS STRIP                                    -->
<!-- ========================================================================= -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(16, 185, 129, 0.25);">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="small text-muted text-uppercase fw-semibold" style="font-size: 0.72rem;">Active Pipeline</span>
                <i class="bi bi-graph-up-arrow text-success fs-5"></i>
            </div>
            <div class="h4 fw-bold text-success mb-1 currency-val" data-usd="<?= $activePipelineVal ?>">
                $<?= number_format($activePipelineVal, 0) ?>
            </div>
            <div class="small text-muted" style="font-size: 0.75rem;">
                <span class="text-white fw-semibold"><?= count($activeDeals) ?></span> active proposals in flight
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(56, 189, 248, 0.25);">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="small text-muted text-uppercase fw-semibold" style="font-size: 0.72rem;">Weighted Forecast</span>
                <i class="bi bi-bullseye text-info fs-5"></i>
            </div>
            <div class="h4 fw-bold text-info mb-1 currency-val" data-usd="<?= $weightedForecastVal ?>">
                $<?= number_format($weightedForecastVal, 0) ?>
            </div>
            <div class="small text-muted" style="font-size: 0.75rem;">
                Probability-adjusted expected yield
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(245, 158, 11, 0.25);">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="small text-muted text-uppercase fw-semibold" style="font-size: 0.72rem;">Closed Won</span>
                <i class="bi bi-trophy-fill text-warning fs-5"></i>
            </div>
            <div class="h4 fw-bold text-warning mb-1 currency-val" data-usd="<?= $closedWonVal ?>">
                $<?= number_format($closedWonVal, 0) ?>
            </div>
            <div class="small text-muted" style="font-size: 0.75rem;">
                <span class="text-white fw-semibold"><?= count($closedWonDeals) ?></span> signed client contracts
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="p-3 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(148, 163, 184, 0.25);">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="small text-muted text-uppercase fw-semibold" style="font-size: 0.72rem;">Conversion &amp; Deal Size</span>
                <i class="bi bi-pie-chart text-secondary fs-5"></i>
            </div>
            <div class="h4 fw-bold text-white mb-1">
                <?= $winRatePct ?>% <span class="fs-6 fw-normal text-muted">Win</span>
            </div>
            <div class="small text-muted" style="font-size: 0.75rem;">
                Avg deal: <span class="text-white fw-semibold currency-val" data-usd="<?= $avgDealSize ?>">$<?= number_format($avgDealSize, 0) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 2. ACTION TOOLBAR & DUAL-MODE TOGGLE                                      -->
<!-- ========================================================================= -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <!-- Left: Dual Mode Segmented Pill -->
    <div class="d-flex align-items-center gap-2">
        <div class="pipeline-mode-switcher shadow-sm">
            <button type="button" class="pipeline-mode-btn active" id="btnModeKanban" onclick="switchPipelineMode('kanban')" title="Horizontal Agile Kanban Board">
                <i class="bi bi-kanban"></i> <span>Kanban Board</span>
            </button>
            <button type="button" class="pipeline-mode-btn" id="btnModeFunnel" onclick="switchPipelineMode('funnel')" title="Vertical Revenue Funnel & Velocity List">
                <i class="bi bi-funnel"></i> <span>Vertical Funnel</span>
            </button>
        </div>
        <span class="badge bg-dark border border-secondary text-muted small d-none d-md-inline-block" id="dealCountIndicator">
            <?= $totalDealsCount ?> Deals Total
        </span>
    </div>

    <!-- Right: New Deal & Leads Bridge Actions -->
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-success btn-sm fw-bold px-3 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNewDeal">
            <i class="bi bi-plus-circle me-1"></i> + New Deal
        </button>
        <a href="leads" class="btn btn-outline-warning btn-sm px-3 py-2">
            <i class="bi bi-person-lines-fill me-1"></i> Convert Leads
        </a>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 3. REAL-TIME SEARCH & STAGE FILTER BAR                                    -->
<!-- ========================================================================= -->
<div class="row g-2 mb-4 align-items-center">
    <div class="col-12 col-md-5">
        <div class="input-group">
            <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="pipelineSearchInput" placeholder="Filter deals by title, company, or specialist...">
        </div>
    </div>
    <div class="col-6 col-md-3">
        <select class="form-select" id="pipelineStageFilter">
            <option value="all">All Stages (<?= $totalDealsCount ?>)</option>
            <?php foreach ($pipelineStages as $sSlug => $sData): 
                $countInStage = count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $sSlug));
            ?>
                <option value="<?= htmlspecialchars($sSlug) ?>"><?= htmlspecialchars($sData['title']) ?> (<?= $countInStage ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-6 col-md-2">
        <select class="form-select" id="pipelineSpecialistFilter">
            <option value="all">All Specialists</option>
            <?php foreach ($allSpecialists as $sp): ?>
                <option value="<?= htmlspecialchars($sp) ?>"><?= htmlspecialchars($sp) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12 col-md-2 d-flex justify-content-end align-items-center">
        <span class="small text-muted" id="filterStatusText">Showing <?= $totalDealsCount ?> deals</span>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 4. MODE 1: HORIZONTAL AGILE KANBAN BOARD                                  -->
<!-- ========================================================================= -->
<div id="pipelineKanbanView" class="pipeline-view-pane mb-4">
    <div class="kanban-board-container">
        <?php foreach ($pipelineStages as $stageSlug => $stageInfo):
            $stageDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $stageSlug);
            $stageSubtotal = array_sum(array_column($stageDeals, 'value'));
        ?>
            <div class="kanban-col-item" data-stage-col="<?= htmlspecialchars($stageSlug) ?>">
                <div class="kanban-col h-100 d-flex flex-column">
                    <!-- Column Header -->
                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                        <div class="fw-bold small text-<?= htmlspecialchars($stageInfo['color']) ?>">
                            <i class="bi <?= htmlspecialchars($stageInfo['icon']) ?> me-1"></i> <?= htmlspecialchars($stageInfo['title']) ?>
                        </div>
                        <span class="badge bg-dark border border-secondary col-deal-badge" style="font-size: 0.7rem;"><?= count($stageDeals) ?></span>
                    </div>

                    <!-- Stage Subtotal Value -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small currency-val fw-semibold" data-usd="<?= (float)$stageSubtotal ?>" style="font-size: 0.78rem;">
                            $<?= number_format($stageSubtotal, 0) ?>
                        </span>
                        <span class="text-muted" style="font-size: 0.68rem;">Base: <?= $stageInfo['default_prob'] ?>%</span>
                    </div>

                    <!-- Deals in this column -->
                    <div class="flex-grow-1 stage-cards-container">
                        <?php if (empty($stageDeals)): ?>
                            <div class="text-muted text-center py-4 small empty-column-msg" style="opacity: 0.5;">
                                <i class="bi bi-inbox d-block fs-4 mb-1"></i>
                                No deals in <?= htmlspecialchars($stageInfo['title']) ?>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($stageDeals as $deal): 
                            $dVal = (float)($deal['value'] ?? 0);
                            $dProb = (int)($deal['probability'] ?? $stageInfo['default_prob']);
                            $dExpVal = $dVal * ($dProb / 100.0);
                            $company = $deal['company'] ?? ($deal['client_name'] ?? 'Client');
                            $specialist = $deal['assigned_to'] ?? 'Technical Lead';
                            $closeDate = !empty($deal['close_date']) ? date('M j, Y', strtotime($deal['close_date'])) : (!empty($deal['expected_close_date']) ? date('M j, Y', strtotime($deal['expected_close_date'])) : null);
                        ?>
                            <div class="kanban-deal-card deal-entity" 
                                 data-id="<?= htmlspecialchars($deal['id'] ?? '') ?>"
                                 data-title="<?= htmlspecialchars(strtolower($deal['title'] ?? '')) ?>"
                                 data-company="<?= htmlspecialchars(strtolower($company)) ?>"
                                 data-specialist="<?= htmlspecialchars(strtolower($specialist)) ?>"
                                 data-stage="<?= htmlspecialchars($stageSlug) ?>">
                                
                                <div class="fw-bold text-white small mb-1"><?= htmlspecialchars($deal['title'] ?? 'Custom Project') ?></div>
                                <div class="small text-muted mb-2 d-flex align-items-center gap-1">
                                    <i class="bi bi-building" style="font-size: 0.7rem;"></i> <?= htmlspecialchars($company) ?>
                                </div>

                                <!-- Value & Probability -->
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-success currency-val" data-usd="<?= $dVal ?>" style="font-size: 0.95rem;">
                                        $<?= number_format($dVal, 0) ?>
                                    </span>
                                    <span class="badge bg-dark border border-secondary small" style="font-size: 0.65rem;">
                                        <?= $dProb ?>% Win
                                    </span>
                                </div>

                                <!-- Mini Progress Bar -->
                                <div class="progress mb-2" style="height: 4px; background: rgba(255, 255, 255, 0.1);">
                                    <div class="progress-bar bg-<?= htmlspecialchars($stageInfo['color']) ?>" role="progressbar" style="width: <?= $dProb ?>%"></div>
                                </div>

                                <!-- Meta: Specialist & Close Date -->
                                <div class="d-flex justify-content-between align-items-center text-muted mb-3" style="font-size: 0.72rem;">
                                    <span><i class="bi bi-person me-1"></i><?= htmlspecialchars($specialist) ?></span>
                                    <?php if ($closeDate): ?>
                                        <span title="Expected Close"><i class="bi bi-calendar-event me-1"></i><?= $closeDate ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Notes Snippet if available -->
                                <?php if (!empty($deal['notes'])): ?>
                                    <div class="p-1.5 rounded bg-black-subtle text-muted small mb-2 text-truncate" style="font-size: 0.68rem;" title="<?= htmlspecialchars($deal['notes']) ?>">
                                        <i class="bi bi-chat-left-text me-1"></i><?= htmlspecialchars($deal['notes']) ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Stage Switcher, Quick Advance & Delete -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                    <div class="d-flex align-items-center gap-1">
                                        <!-- Quick 1-click Advance Button if next stage exists -->
                                        <?php if (!empty($stageInfo['next_stage'])): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                <input type="hidden" name="action" value="advance_opportunity">
                                                <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                                <input type="hidden" name="stage" value="<?= CrmSecurity::escape($stageInfo['next_stage']) ?>">
                                                <input type="hidden" name="return_url" value="pipeline">
                                                <button type="submit" class="btn btn-outline-<?= htmlspecialchars($stageInfo['color']) ?> btn-xs py-0 px-1" style="font-size: 0.65rem;" title="Quick advance to <?= htmlspecialchars($stageInfo['next_label']) ?>">
                                                    Advance <i class="bi bi-arrow-right"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <!-- Direct Stage Selector Dropdown -->
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                            <input type="hidden" name="action" value="advance_opportunity">
                                            <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                            <input type="hidden" name="return_url" value="pipeline">
                                            <select name="stage" class="form-select form-select-sm py-0 px-1 bg-dark text-white border-secondary" style="font-size: 0.68rem; width: auto;" onchange="this.form.submit()">
                                                <?php foreach ($pipelineStages as $sKey => $sVal): ?>
                                                    <option value="<?= $sKey ?>" <?= $sKey === $stageSlug ? 'selected' : '' ?>><?= $sVal['title'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </div>

                                    <!-- Delete Deal Button -->
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
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 5. MODE 2: VERTICAL REVENUE FUNNEL & DEAL VELOCITY WATERFALL              -->
<!-- ========================================================================= -->
<div id="pipelineFunnelView" class="pipeline-view-pane mb-4" style="display: none;">
    <!-- Visual Funnel Distribution Bar -->
    <div class="p-3 rounded-3 mb-4" style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(56, 189, 248, 0.2);">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="small fw-semibold text-white"><i class="bi bi-funnel-fill text-info me-1"></i> Conversion Velocity Funnel</span>
            <span class="small text-muted" style="font-size: 0.75rem;">Distribution across 6 sales stages</span>
        </div>
        <div class="progress" style="height: 10px; background: rgba(255, 255, 255, 0.05); border-radius: 6px; overflow: hidden;">
            <?php foreach ($pipelineStages as $sSlug => $sData): 
                $countInStage = count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $sSlug));
                $pctShare = $totalDealsCount > 0 ? ($countInStage / $totalDealsCount) * 100 : 0;
                if ($pctShare > 0):
            ?>
                <div class="progress-bar bg-<?= htmlspecialchars($sData['color']) ?>" 
                     role="progressbar" 
                     style="width: <?= $pctShare ?>%" 
                     title="<?= htmlspecialchars($sData['title']) ?>: <?= $countInStage ?> deals (<?= round($pctShare) ?>%)">
                </div>
            <?php endif; endforeach; ?>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-2 pt-2 border-top border-secondary-subtle gap-2" style="font-size: 0.72rem;">
            <?php foreach ($pipelineStages as $sSlug => $sData): 
                $countInStage = count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $sSlug));
            ?>
                <div class="d-flex align-items-center gap-1">
                    <span class="badge bg-<?= htmlspecialchars($sData['color']) ?>" style="width: 8px; height: 8px; padding: 0; border-radius: 50%;"></span>
                    <span class="text-muted"><?= htmlspecialchars($sData['title']) ?>:</span>
                    <span class="text-white fw-bold"><?= $countInStage ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Vertical Waterfall Stage Accordion/Cards -->
    <div class="funnel-waterfall-wrapper">
        <?php foreach ($pipelineStages as $stageSlug => $stageInfo):
            $stageDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $stageSlug);
            $stageSubtotal = array_sum(array_column($stageDeals, 'value'));
            $shareOfPipeline = $activePipelineVal > 0 && !in_array($stageSlug, ['closed_won', 'closed_lost'], true) 
                ? round(($stageSubtotal / $activePipelineVal) * 100) 
                : null;
        ?>
            <div class="funnel-stage-card" data-stage-group="<?= htmlspecialchars($stageSlug) ?>">
                <!-- Stage Header -->
                <div class="funnel-stage-header" onclick="toggleFunnelStage('<?= htmlspecialchars($stageSlug) ?>')">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold bg-dark border border-<?= htmlspecialchars($stageInfo['color']) ?>" style="width: 32px; height: 32px; color: var(--bs-<?= htmlspecialchars($stageInfo['color']) ?>); font-size: 0.85rem;">
                            <?= $stageInfo['order'] ?>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="fw-bold text-white mb-0"><?= htmlspecialchars($stageInfo['title']) ?></h6>
                                <span class="badge <?= htmlspecialchars($stageInfo['badge_class']) ?>" style="font-size: 0.65rem;">
                                    <?= $stageInfo['default_prob'] ?>% Benchmark
                                </span>
                                <span class="badge bg-dark border border-secondary text-muted col-deal-badge" style="font-size: 0.65rem;">
                                    <?= count($stageDeals) ?> deals
                                </span>
                            </div>
                            <div class="text-muted small" style="font-size: 0.73rem;">
                                <?= htmlspecialchars($stageInfo['subtitle']) ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-4">
                        <div class="text-end">
                            <div class="fw-bold text-success currency-val" data-usd="<?= (float)$stageSubtotal ?>" style="font-size: 1rem;">
                                $<?= number_format($stageSubtotal, 0) ?>
                            </div>
                            <?php if ($shareOfPipeline !== null): ?>
                                <div class="text-muted small" style="font-size: 0.7rem;"><?= $shareOfPipeline ?>% of active pipeline</div>
                            <?php else: ?>
                                <div class="text-muted small" style="font-size: 0.7rem;">Terminal Stage</div>
                            <?php endif; ?>
                        </div>
                        <i class="bi bi-chevron-down text-muted transition-transform" id="chevron-<?= htmlspecialchars($stageSlug) ?>"></i>
                    </div>
                </div>

                <!-- Stage Deals Body -->
                <div class="funnel-stage-body" id="stage-body-<?= htmlspecialchars($stageSlug) ?>">
                    <?php if (empty($stageDeals)): ?>
                        <div class="p-3 text-muted text-center small empty-funnel-msg" style="opacity: 0.5;">
                            No deals currently in <?= htmlspecialchars($stageInfo['title']) ?> stage.
                        </div>
                    <?php else: ?>
                        <?php foreach ($stageDeals as $deal): 
                            $dVal = (float)($deal['value'] ?? 0);
                            $dProb = (int)($deal['probability'] ?? $stageInfo['default_prob']);
                            $dExpVal = $dVal * ($dProb / 100.0);
                            $company = $deal['company'] ?? ($deal['client_name'] ?? 'Client');
                            $specialist = $deal['assigned_to'] ?? 'Technical Lead';
                            $closeDate = !empty($deal['close_date']) ? date('M j, Y', strtotime($deal['close_date'])) : (!empty($deal['expected_close_date']) ? date('M j, Y', strtotime($deal['expected_close_date'])) : 'TBD');
                        ?>
                            <div class="funnel-deal-row deal-entity" 
                                 data-id="<?= htmlspecialchars($deal['id'] ?? '') ?>"
                                 data-title="<?= htmlspecialchars(strtolower($deal['title'] ?? '')) ?>"
                                 data-company="<?= htmlspecialchars(strtolower($company)) ?>"
                                 data-specialist="<?= htmlspecialchars(strtolower($specialist)) ?>"
                                 data-stage="<?= htmlspecialchars($stageSlug) ?>">
                                
                                <div class="row align-items-center g-3">
                                    <!-- Col 1: Deal Title & Client -->
                                    <div class="col-12 col-md-4">
                                        <div class="fw-bold text-white mb-0.5"><?= htmlspecialchars($deal['title'] ?? 'Opportunity') ?></div>
                                        <div class="small text-muted d-flex align-items-center gap-1">
                                            <i class="bi bi-building text-info" style="font-size: 0.72rem;"></i> <?= htmlspecialchars($company) ?>
                                        </div>
                                        <?php if (!empty($deal['notes'])): ?>
                                            <div class="text-muted small text-truncate mt-1" style="font-size: 0.72rem;" title="<?= htmlspecialchars($deal['notes']) ?>">
                                                <i class="bi bi-chat-left-text text-muted me-1"></i><?= htmlspecialchars($deal['notes']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Col 2: Deal Value & Expected Forecast -->
                                    <div class="col-6 col-md-2">
                                        <div class="small text-muted" style="font-size: 0.7rem;">Contract Value</div>
                                        <div class="fw-bold text-success currency-val" data-usd="<?= $dVal ?>" style="font-size: 0.95rem;">
                                            $<?= number_format($dVal, 0) ?>
                                        </div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">
                                            Yield: <span class="currency-val" data-usd="<?= $dExpVal ?>">$<?= number_format($dExpVal, 0) ?></span>
                                        </div>
                                    </div>

                                    <!-- Col 3: Probability & Close Date -->
                                    <div class="col-6 col-md-2">
                                        <div class="d-flex justify-content-between align-items-center small mb-1" style="font-size: 0.72rem;">
                                            <span class="text-muted">Win Probability</span>
                                            <span class="fw-bold text-white"><?= $dProb ?>%</span>
                                        </div>
                                        <div class="progress mb-1" style="height: 5px; background: rgba(255, 255, 255, 0.1);">
                                            <div class="progress-bar bg-<?= htmlspecialchars($stageInfo['color']) ?>" role="progressbar" style="width: <?= $dProb ?>%"></div>
                                        </div>
                                        <div class="small text-muted" style="font-size: 0.7rem;">
                                            <i class="bi bi-calendar-event me-1"></i><?= $closeDate ?>
                                        </div>
                                    </div>

                                    <!-- Col 4: Specialist -->
                                    <div class="col-6 col-md-2">
                                        <div class="small text-muted" style="font-size: 0.7rem;">Assigned Specialist</div>
                                        <div class="small text-white fw-semibold d-flex align-items-center gap-1">
                                            <i class="bi bi-person-badge text-info"></i> <?= htmlspecialchars($specialist) ?>
                                        </div>
                                    </div>

                                    <!-- Col 5: Actions -->
                                    <div class="col-6 col-md-2 d-flex justify-content-end align-items-center gap-1.5">
                                        <?php if (!empty($stageInfo['next_stage'])): ?>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                <input type="hidden" name="action" value="advance_opportunity">
                                                <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                                <input type="hidden" name="stage" value="<?= CrmSecurity::escape($stageInfo['next_stage']) ?>">
                                                <input type="hidden" name="return_url" value="pipeline">
                                                <button type="submit" class="btn btn-outline-<?= htmlspecialchars($stageInfo['color']) ?> btn-sm py-1 px-2" style="font-size: 0.72rem;" title="Advance to <?= htmlspecialchars($stageInfo['next_label']) ?>">
                                                    Advance <i class="bi bi-arrow-right"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                            <input type="hidden" name="action" value="advance_opportunity">
                                            <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                            <input type="hidden" name="return_url" value="pipeline">
                                            <select name="stage" class="form-select form-select-sm py-1 px-1 bg-dark text-white border-secondary" style="font-size: 0.7rem; width: auto;" onchange="this.form.submit()">
                                                <?php foreach ($pipelineStages as $sKey => $sVal): ?>
                                                    <option value="<?= $sKey ?>" <?= $sKey === $stageSlug ? 'selected' : '' ?>><?= $sVal['title'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>

                                        <form method="POST" class="d-inline" onsubmit="return confirm('Remove this deal from pipeline?');">
                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                            <input type="hidden" name="action" value="delete_opportunity">
                                            <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                            <input type="hidden" name="return_url" value="pipeline">
                                            <button type="submit" class="btn btn-link text-danger p-0 ms-1" title="Delete Deal">
                                                <i class="bi bi-trash" style="font-size: 0.85rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ========================================================================= -->
<!-- 6. CLIENT-SIDE INTERACTIVITY & MODE SWITCHER SCRIPT                       -->
<!-- ========================================================================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const STORAGE_KEY = 'codex404_pipeline_view_mode';

    // 1. Mode Switcher
    window.switchPipelineMode = function(mode) {
        const btnKanban = document.getElementById('btnModeKanban');
        const btnFunnel = document.getElementById('btnModeFunnel');
        const viewKanban = document.getElementById('pipelineKanbanView');
        const viewFunnel = document.getElementById('pipelineFunnelView');

        if (mode === 'funnel') {
            btnKanban.classList.remove('active');
            btnFunnel.classList.add('active');
            viewKanban.style.display = 'none';
            viewFunnel.style.display = 'block';
            localStorage.setItem(STORAGE_KEY, 'funnel');
        } else {
            btnFunnel.classList.remove('active');
            btnKanban.classList.add('active');
            viewFunnel.style.display = 'none';
            viewKanban.style.display = 'block';
            localStorage.setItem(STORAGE_KEY, 'kanban');
        }
    };

    // Restore saved mode or default to kanban
    const savedMode = localStorage.getItem(STORAGE_KEY) || 'kanban';
    switchPipelineMode(savedMode);

    // 2. Funnel Stage Accordion Toggle
    window.toggleFunnelStage = function(stageSlug) {
        const body = document.getElementById(`stage-body-${stageSlug}`);
        const chevron = document.getElementById(`chevron-${stageSlug}`);
        if (!body) return;

        if (body.style.display === 'none') {
            body.style.display = 'block';
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        } else {
            body.style.display = 'none';
            if (chevron) chevron.style.transform = 'rotate(-90deg)';
        }
    };

    // 3. Dynamic Live Filtering (Search, Stage, Specialist)
    const searchInput = document.getElementById('pipelineSearchInput');
    const stageFilter = document.getElementById('pipelineStageFilter');
    const specialistFilter = document.getElementById('pipelineSpecialistFilter');
    const filterStatusText = document.getElementById('filterStatusText');

    function applyPipelineFilters() {
        const query = (searchInput.value || '').toLowerCase().trim();
        const selStage = stageFilter.value;
        const selSpecialist = specialistFilter.value;

        const allEntities = document.querySelectorAll('.deal-entity');
        let visibleCount = 0;

        allEntities.forEach(el => {
            const title = el.dataset.title || '';
            const company = el.dataset.company || '';
            const specialist = el.dataset.specialist || '';
            const stage = el.dataset.stage || '';

            const matchesQuery = !query || title.includes(query) || company.includes(query) || specialist.includes(query);
            const matchesStage = (selStage === 'all') || (stage === selStage);
            const matchesSpecialist = (selSpecialist === 'all') || (specialist === selSpecialist.toLowerCase());

            if (matchesQuery && matchesStage && matchesSpecialist) {
                el.style.display = '';
                // Only count unique items once (divide by 2 since each deal appears in both views)
                visibleCount++;
            } else {
                el.style.display = 'none';
            }
        });

        // Update count indicator
        const uniqueVisible = Math.round(visibleCount / 2);
        if (filterStatusText) {
            filterStatusText.textContent = `Showing ${uniqueVisible} deals`;
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyPipelineFilters);
    if (stageFilter) stageFilter.addEventListener('change', applyPipelineFilters);
    if (specialistFilter) specialistFilter.addEventListener('change', applyPipelineFilters);
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
