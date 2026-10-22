<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Inbound Leads Management
 * Multi-page architecture: Dedicated Leads Directory & Scoring
 */

namespace CRM;

use CRM\Services\CrmSecurity;

$activePage = 'leads';
$pageTitle = 'Inbound Leads & Qualification Engine';
$pageHeading = 'Inbound Leads & Qualification Pipeline';
$pageSubheading = 'Automated US tier-1 buyer lead scoring and qualification pipeline';

require_once __DIR__ . '/includes/init.php';

$filterStatus = strtolower(trim((string)($_GET['status'] ?? 'all')));
$searchQuery = trim((string)($_GET['q'] ?? ''));

$filteredLeads = $leads;
if ($filterStatus !== 'all' && $filterStatus !== '') {
    $filteredLeads = array_filter($filteredLeads, fn($l) => ($l['status'] ?? '') === $filterStatus);
}
if ($searchQuery !== '') {
    $qLower = strtolower($searchQuery);
    $filteredLeads = array_filter($filteredLeads, function ($l) use ($qLower) {
        return str_contains(strtolower($l['name'] ?? ''), $qLower)
            || str_contains(strtolower($l['company_name'] ?? ''), $qLower)
            || str_contains(strtolower($l['email'] ?? ''), $qLower)
            || str_contains(strtolower($l['service_interest'] ?? ''), $qLower);
    });
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
require_once __DIR__ . '/includes/topbar.php';
?>

<!-- Header & Quick Actions Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-person-lines-fill text-warning me-2"></i>Inbound Prospects &amp; Ingestion Pipeline</h4>
        <p class="text-muted small mb-0">Total Inbound: <strong><?= $totalLeads ?></strong> &bull; Showing: <strong><?= count($filteredLeads) ?></strong> prospects</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-warning btn-sm fw-bold shadow-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalNewLead">
            <i class="bi bi-person-plus-fill"></i> + Add Inbound Lead
        </button>
    </div>
</div>

<!-- Search & Status Filter Bar -->
<div class="crm-card p-3 mb-4">
    <div class="row g-2 align-items-center">
        <!-- Search Input -->
        <div class="col-12 col-md-5">
            <form method="GET" action="leads" class="input-group input-group-sm">
                <?php if ($filterStatus !== 'all'): ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($filterStatus) ?>">
                <?php endif; ?>
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control" placeholder="Search by prospect, company, email..." value="<?= htmlspecialchars($searchQuery) ?>">
                <?php if ($searchQuery !== ''): ?>
                    <a href="leads<?= $filterStatus !== 'all' ? '?status=' . urlencode($filterStatus) : '' ?>" class="btn btn-outline-secondary">Clear</a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <!-- Filter Status Pills -->
        <div class="col-12 col-md-7">
            <div class="d-flex gap-1 flex-wrap justify-content-md-end">
                <a href="leads<?= $searchQuery !== '' ? '?q=' . urlencode($searchQuery) : '' ?>" class="btn btn-xs <?= $filterStatus === 'all' ? 'btn-warning' : 'btn-outline-secondary' ?>" style="font-size: 0.75rem; border-radius: 20px;">
                    All (<?= $totalLeads ?>)
                </a>
                <a href="leads?status=new<?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : '' ?>" class="btn btn-xs <?= $filterStatus === 'new' ? 'btn-warning' : 'btn-outline-secondary' ?>" style="font-size: 0.75rem; border-radius: 20px;">
                    New
                </a>
                <a href="leads?status=qualified<?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : '' ?>" class="btn btn-xs <?= $filterStatus === 'qualified' ? 'btn-warning' : 'btn-outline-secondary' ?>" style="font-size: 0.75rem; border-radius: 20px;">
                    Qualified
                </a>
                <a href="leads?status=contacted<?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : '' ?>" class="btn btn-xs <?= $filterStatus === 'contacted' ? 'btn-warning' : 'btn-outline-secondary' ?>" style="font-size: 0.75rem; border-radius: 20px;">
                    Contacted
                </a>
                <a href="leads?status=proposal_sent<?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : '' ?>" class="btn btn-xs <?= $filterStatus === 'proposal_sent' ? 'btn-warning' : 'btn-outline-secondary' ?>" style="font-size: 0.75rem; border-radius: 20px;">
                    Proposal Sent
                </a>
                <a href="leads?status=closed<?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : '' ?>" class="btn btn-xs <?= $filterStatus === 'closed' ? 'btn-warning' : 'btn-outline-secondary' ?>" style="font-size: 0.75rem; border-radius: 20px;">
                    Closed
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Leads Data Table -->
<div class="crm-card p-0 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-custom mb-0 align-middle">
            <thead>
                <tr>
                    <th>Prospect &amp; Company</th>
                    <th>Contact Details</th>
                    <th>Budget &amp; Timeline</th>
                    <th>US Score</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($filteredLeads)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            No inbound leads found matching criteria.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($filteredLeads as $l): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-white fs-6"><?= htmlspecialchars($l['name'] ?? 'Prospect') ?></div>
                                <div class="small text-muted">
                                    <i class="bi bi-building me-1"></i><?= htmlspecialchars($l['company_name'] ?? 'N/A') ?> 
                                    &bull; <span class="badge bg-dark border border-secondary"><?= htmlspecialchars($l['country'] ?? 'USA') ?></span>
                                </div>
                                <?php if (!empty($l['service_interest'])): ?>
                                    <div class="small text-info mt-1" style="font-size: 0.75rem;"><i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($l['service_interest']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small text-white"><i class="bi bi-envelope me-1 text-muted"></i><?= htmlspecialchars($l['email'] ?? 'N/A') ?></div>
                                <?php if (!empty($l['phone'])): ?>
                                    <div class="small text-muted"><i class="bi bi-telephone me-1 text-muted"></i><?= htmlspecialchars($l['phone']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small fw-semibold text-white currency-budget" data-raw-budget="<?= htmlspecialchars($l['budget'] ?? 'Flexible') ?>"><?= htmlspecialchars($l['budget'] ?? 'Flexible') ?></div>
                                <div class="small text-muted"><?= htmlspecialchars($l['timeline'] ?? '1-3 months') ?></div>
                            </td>
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
                                    <input type="hidden" name="action" value="update_lead_status">
                                    <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                    <input type="hidden" name="return_page" value="leads">
                                    <select name="status" class="form-select form-select-sm py-1 px-2 border-secondary bg-dark text-white" style="font-size: 0.75rem; width: auto;" onchange="this.form.submit()">
                                        <?php
                                        $statuses = ['new' => 'New', 'contacted' => 'Contacted', 'qualified' => 'Qualified', 'proposal_sent' => 'Proposal Sent', 'closed' => 'Closed'];
                                        foreach ($statuses as $k => $label):
                                        ?>
                                            <option value="<?= $k ?>" <?= ($l['status'] ?? '') === $k ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <!-- Convert to Deal -->
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="convert_lead">
                                        <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                        <input type="hidden" name="return_page" value="leads">
                                        <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2" title="Convert to Deal Opportunity">
                                            <i class="bi bi-briefcase-fill"></i> Convert
                                        </button>
                                    </form>

                                    <!-- Dispatch to Agent -->
                                    <button class="btn btn-sm btn-outline-info py-1 px-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent" data-lead-id="<?= htmlspecialchars($l['id']) ?>" data-lead-company="<?= htmlspecialchars($l['company_name'] ?? '') ?>" title="Dispatch Agent Routine">
                                        <i class="bi bi-robot"></i> Agent
                                    </button>

                                    <!-- Delete -->
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Remove this lead?');">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="delete_lead">
                                        <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                        <input type="hidden" name="return_page" value="leads">
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
