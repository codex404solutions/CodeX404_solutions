<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Executive Command Center (Dashboard)
 * Autonomous multi-agent pipeline with Human-in-the-Loop governance
 */

namespace CRM;

use CRM\Services\CrmSecurity;

require_once __DIR__ . '/includes/bootstrap.php';

// Support ?page= query parameter routing as an alias to clean multi-pages
if (isset($_GET['page'])) {
    $pageMap = [
        'leads' => 'leads.php',
        'pipeline' => 'pipeline.php',
        'projects' => 'projects.php',
        'approvals' => 'approvals.php',
        'settings' => 'settings.php',
    ];
    $reqPage = strtolower(trim((string)$_GET['page']));
    if (isset($pageMap[$reqPage])) {
        require_once __DIR__ . '/' . $pageMap[$reqPage];
        exit;
    }
}

$currentPage = 'dashboard';
$pageTitle = 'Company CRM & Executive Command Center';
$pageSubtitle = 'Enterprise sales pipeline with Human-in-the-Loop governance';
$htmlTitle = 'Executive Dashboard — CodeX404 Solutions CRM';

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- FUTURISTIC ANIMATED NEURAL NETWORK SVG BANNER            -->
<!-- ======================================================== -->
<section class="crm-hero-banner">
    <svg class="crm-banner-svg-canvas" viewBox="0 0 650 320" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <defs>
            <linearGradient id="crmNeuralGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#38BDF8" stop-opacity="0.85"/>
                <stop offset="50%" stop-color="#818CF8" stop-opacity="0.6"/>
                <stop offset="100%" stop-color="#C084FC" stop-opacity="0.2"/>
            </linearGradient>
            <linearGradient id="crmNeuralGrad2" x1="100%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#F472B6" stop-opacity="0.75"/>
                <stop offset="100%" stop-color="#38BDF8" stop-opacity="0.2"/>
            </linearGradient>
            <filter id="crmGlow" x="-20%" y="-20%" width="140%" height="140%">
                <feGaussianBlur stdDeviation="7" result="blur" />
                <feComposite in="SourceGraphic" in2="blur" operator="over" />
            </filter>
            <pattern id="crmHexGrid" width="36" height="36" patternUnits="userSpaceOnUse">
                <path d="M 36 0 L 0 0 0 36" fill="none" stroke="rgba(56, 189, 248, 0.08)" stroke-width="1"/>
                <circle cx="36" cy="0" r="1.5" fill="rgba(56, 189, 248, 0.2)"/>
            </pattern>
        </defs>

        <rect width="650" height="320" fill="url(#crmHexGrid)" />
        <circle cx="480" cy="110" r="130" fill="rgba(56, 189, 248, 0.12)" filter="url(#crmGlow)"/>
        <circle cx="340" cy="210" r="110" fill="rgba(129, 140, 248, 0.1)" filter="url(#crmGlow)"/>

        <!-- Synaptic Data Axons -->
        <g class="svg-synapse-path" stroke="url(#crmNeuralGrad1)" stroke-width="2" fill="none">
            <path d="M 140 260 L 240 180 L 360 180 L 440 100 L 600 100" />
            <path d="M 200 300 L 300 220 L 420 220 L 500 150 L 620 150" stroke="url(#crmNeuralGrad2)" stroke-width="1.5" />
            <path d="M 280 40 L 380 90 L 510 90 L 570 50 L 640 50" />
        </g>

        <!-- Synaptic Nodes (7 Agents Representation) -->
        <g class="svg-synapse-node">
            <circle cx="240" cy="180" r="5" fill="#38BDF8" filter="url(#crmGlow)"/>
            <circle cx="360" cy="180" r="4.5" fill="#818CF8"/>
            <circle cx="440" cy="100" r="6" fill="#C084FC" filter="url(#crmGlow)"/>
            <circle cx="600" cy="100" r="5" fill="#F472B6"/>
            <circle cx="500" cy="150" r="4.5" fill="#38BDF8"/>
            <circle cx="380" cy="90" r="5" fill="#10B981"/>
            <circle cx="300" cy="220" r="4" fill="#FBBF24"/>
        </g>

        <!-- Rotating Synaptic Shield Ring -->
        <g class="svg-orbit-ring" stroke="rgba(56, 189, 248, 0.22)" stroke-width="1.5" fill="none" stroke-dasharray="14 10">
            <circle cx="350" cy="170" r="80" />
            <circle cx="350" cy="170" r="120" stroke="rgba(192, 132, 252, 0.18)" stroke-dasharray="18 12"/>
        </g>

        <!-- Core Quantum Agent Node -->
        <g style="animation: crmNodePulse 4s ease-in-out infinite;">
            <polygon points="490,90 535,65 580,90 535,115" fill="rgba(56, 189, 248, 0.25)" stroke="#38BDF8" stroke-width="1.5"/>
            <polygon points="490,90 535,115 535,160 490,135" fill="rgba(129, 140, 248, 0.3)" stroke="#818CF8" stroke-width="1.5"/>
            <polygon points="535,115 580,90 580,135 535,160" fill="rgba(192, 132, 252, 0.35)" stroke="#C084FC" stroke-width="1.5"/>
            <circle cx="535, 115" r="4" fill="#FFFFFF" filter="url(#crmGlow)"/>
        </g>
    </svg>

    <div class="crm-banner-content">
        <div class="crm-banner-pill">
            <span class="agent-badge-pulse"></span>
            <span>Executive Operations &bull; Real-Time</span>
        </div>
        <h1 class="crm-banner-title">
            Autonomous Pipeline &amp; <br>
            <span class="text-gradient-rainbow">Executive Command OS</span>
        </h1>
        <p class="crm-banner-desc">
            Enterprise multi-agent pipeline with real-time multi-currency FX conversions, automated lead scoring, automated sales discovery, and strict Human-in-the-Loop decision governance.
        </p>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <button type="button" class="btn btn-info btn-sm fw-bold text-dark px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNewLead" style="border-radius: 10px;">
                <i class="bi bi-person-plus-fill"></i>
                <span>New Inbound Lead</span>
            </button>
            <button type="button" class="btn btn-success btn-sm fw-bold px-3 py-2 shadow-sm d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalNewDeal" style="border-radius: 10px;">
                <i class="bi bi-plus-circle-fill"></i>
                <span>New Pipeline Deal</span>
            </button>
            <a href="leads" class="btn btn-outline-warning btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 10px;">
                <i class="bi bi-person-lines-fill"></i>
                <span>Manage Leads &rarr;</span>
            </a>
            <a href="pipeline" class="btn btn-outline-success btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 10px;">
                <i class="bi bi-kanban"></i>
                <span>Sales Kanban &rarr;</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="badge bg-dark border border-secondary text-info px-2 py-1">
                <i class="bi bi-activity me-1"></i>Real-Time Lead Ingestion
            </span>
            <span class="badge bg-dark border border-secondary text-success px-2 py-1">
                <i class="bi bi-currency-exchange me-1"></i>Live Multi-Currency FX
            </span>
            <span class="badge bg-dark border border-secondary text-warning px-2 py-1">
                <i class="bi bi-shield-check me-1"></i>HITL Governance: Active
            </span>
        </div>
    </div>
</section>

<!-- ======================================================== -->
<!-- 4 TOP KPI METRIC CARDS WITH DIRECT PAGE SHORTCUTS       -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <a href="leads" class="text-decoration-none">
            <div class="crm-card metric-card p-3 p-xl-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Inbound Leads</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">CRM Inflow</span>
                </div>
                <div class="fs-2 fw-bold text-gradient-amber"><?= $totalLeads ?></div>
                <div class="small text-muted mt-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-shield-check text-success"></i> <?= $activeLeads ?> active qualified</span>
                    <i class="bi bi-arrow-right text-warning"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="pipeline" class="text-decoration-none">
            <div class="crm-card metric-card p-3 p-xl-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Active Pipeline</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle"><?= count($activePipelineDeals) ?> Deals</span>
                </div>
                <div class="fs-2 fw-bold text-success currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></div>
                <div class="small text-muted mt-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-trophy text-warning"></i> <span class="currency-val" data-usd="<?= (float)$closedWonValue ?>">$<?= number_format($closedWonValue, 0) ?></span> won</span>
                    <i class="bi bi-arrow-right text-success"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="projects" class="text-decoration-none">
            <div class="crm-card metric-card p-3 p-xl-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Client Delivery</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Active Sprints</span>
                </div>
                <div class="fs-2 fw-bold text-gradient-purple"><?= $activeProjectsCount ?></div>
                <div class="small text-muted mt-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-kanban text-info"></i> <?= count($projects) ?> client accounts</span>
                    <i class="bi bi-arrow-right text-primary"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="approvals" class="text-decoration-none">
            <div class="crm-card metric-card p-3 p-xl-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted small fw-bold text-uppercase">HITL Queue</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle">Governance</span>
                </div>
                <div class="fs-2 fw-bold text-gradient-cyan"><?= count($pendingApprovals) ?></div>
                <div class="small text-muted mt-2 d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-shield-exclamation text-warning"></i> <?= count($pendingApprovals) ?> pending sign-offs</span>
                    <i class="bi bi-arrow-right text-info"></i>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ======================================================== -->
<!-- PIPELINE STAGE DISTRIBUTION & FUNNEL                    -->
<!-- ======================================================== -->
<div class="crm-card p-3 p-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="fw-bold mb-1"><i class="bi bi-funnel text-info me-2"></i>Sales Funnel Velocity &amp; Pipeline Distribution</h6>
            <p class="text-muted small mb-0">Total combined pipeline value: <strong><span class="currency-val" data-usd="<?= (float)($pipelineValue + $closedWonValue) ?>">$<?= number_format($pipelineValue + $closedWonValue, 0) ?></span> <span class="currency-label-code">USD</span></strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="pipeline" class="btn btn-sm btn-outline-success">
                <i class="bi bi-kanban me-1"></i> Open Pipeline Kanban &rarr;
            </a>
            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalNewDeal">
                <i class="bi bi-plus-circle me-1"></i> New Deal
            </button>
        </div>
    </div>
    <div class="progress" style="height: 18px; background-color: rgba(255, 255, 255, 0.05);">
        <?php
        $stagesCount = [
            'discovery' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'discovery')),
            'scoping' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'scoping')),
            'proposal' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'proposal')),
            'negotiation' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'negotiation')),
            'closed_won' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'closed_won'))
        ];
        $totalOpportunitiesCount = max(count($opportunities), 1);
        $pctDiscovery = round(($stagesCount['discovery'] / $totalOpportunitiesCount) * 100);
        $pctScoping = round(($stagesCount['scoping'] / $totalOpportunitiesCount) * 100);
        $pctProposal = round(($stagesCount['proposal'] / $totalOpportunitiesCount) * 100);
        $pctNegotiation = round(($stagesCount['negotiation'] / $totalOpportunitiesCount) * 100);
        $pctWon = round(($stagesCount['closed_won'] / $totalOpportunitiesCount) * 100);
        ?>
        <div class="progress-bar bg-secondary" style="width: <?= $pctDiscovery ?>%" title="Discovery: <?= $stagesCount['discovery'] ?>">Discovery (<?= $stagesCount['discovery'] ?>)</div>
        <div class="progress-bar bg-info" style="width: <?= $pctScoping ?>%" title="Scoping: <?= $stagesCount['scoping'] ?>">Scoping (<?= $stagesCount['scoping'] ?>)</div>
        <div class="progress-bar bg-warning" style="width: <?= $pctProposal ?>%" title="Proposal: <?= $stagesCount['proposal'] ?>">Proposal (<?= $stagesCount['proposal'] ?>)</div>
        <div class="progress-bar bg-primary" style="width: <?= $pctNegotiation ?>%" title="Negotiation: <?= $stagesCount['negotiation'] ?>">Negotiation (<?= $stagesCount['negotiation'] ?>)</div>
        <div class="progress-bar bg-success" style="width: <?= $pctWon ?>%" title="Won: <?= $stagesCount['closed_won'] ?>">Won (<?= $stagesCount['closed_won'] ?>)</div>
    </div>
</div>

<!-- ======================================================== -->
<!-- SPLIT GRID: RECENT LEADS & ACTIVE PIPELINE FEEDS        -->
<!-- ======================================================== -->
<div class="row g-4 mb-4">
    <!-- Recent Leads Feed -->
    <div class="col-12 col-xl-6">
        <div class="crm-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-warning me-2"></i>Recent Inbound Leads</h6>
                <a href="leads" class="small text-info text-decoration-none fw-semibold">View All Leads (<?= $totalLeads ?>) &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Prospect</th>
                            <th>Budget</th>
                            <th>Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leads)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No inbound leads captured yet.</td></tr>
                        <?php else: ?>
                            <?php foreach (array_slice($leads, 0, 4) as $l): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white"><?= htmlspecialchars($l['name'] ?? 'Prospect') ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($l['company_name'] ?? 'N/A') ?> &bull; <?= htmlspecialchars($l['country'] ?? 'USA') ?></small>
                                    </td>
                                    <td class="small text-white currency-budget" data-raw-budget="<?= htmlspecialchars($l['budget'] ?? 'Flexible') ?>"><?= htmlspecialchars($l['budget'] ?? 'Flexible') ?></td>
                                    <td>
                                        <?php
                                        $score = (int)($l['lead_score'] ?? 0);
                                        $scoreClass = $score >= 80 ? 'score-high' : ($score >= 60 ? 'score-med' : 'score-low');
                                        ?>
                                        <span class="score-pill <?= $scoreClass ?>"><?= $score ?>/100</span>
                                    </td>
                                    <td>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                            <input type="hidden" name="action" value="convert_lead">
                                            <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                            <input type="hidden" name="return_url" value="dashboard">
                                            <button type="submit" class="btn btn-xs btn-outline-success py-1 px-2" style="font-size: 0.72rem;" title="Convert to Deal">
                                                <i class="bi bi-arrow-right-circle"></i> Convert
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Deals Feed -->
    <div class="col-12 col-xl-6">
        <div class="crm-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-briefcase text-success me-2"></i>Active Deals in Progress</h6>
                <a href="pipeline" class="small text-info text-decoration-none fw-semibold">Open Kanban Pipeline &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Opportunity</th>
                            <th>Value</th>
                            <th>Stage</th>
                            <th>Assigned</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($opportunities)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No deals currently active.</td></tr>
                        <?php else: ?>
                            <?php foreach (array_slice($opportunities, 0, 4) as $opp): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-white"><?= htmlspecialchars($opp['title'] ?? 'Deal') ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($opp['company'] ?? ($opp['client_name'] ?? 'Client')) ?></small>
                                    </td>
                                    <td class="fw-bold text-success currency-val" data-usd="<?= (float)($opp['value'] ?? 0) ?>">$<?= number_format((float)($opp['value'] ?? 0), 0) ?></td>
                                    <td>
                                        <span class="badge bg-dark border border-secondary text-capitalize" style="font-size: 0.7rem;">
                                            <?= htmlspecialchars(str_replace('_', ' ', $opp['stage'] ?? 'discovery')) ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted"><?= htmlspecialchars($opp['assigned_to'] ?? 'Sales Engineer') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
