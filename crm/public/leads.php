<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Inbound Leads & Prospect Intelligence
 */

namespace CRM;

use CRM\Services\CrmSecurity;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'leads';
$pageTitle = 'Inbound Leads & Qualification Engine';
$pageSubtitle = 'Automated AI lead scoring optimized for high-value US & global enterprise buyers';
$htmlTitle = 'Inbound Leads — CodeX404 Solutions CRM';

$highScoreLeadsCount = count(array_filter($leads, fn($l) => (int)($l['lead_score'] ?? 0) >= 80));

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Action Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
            <i class="bi bi-person-lines-fill me-1"></i> <?= $totalLeads ?> Total Leads
        </span>
        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
            <i class="bi bi-shield-check me-1"></i> <?= $activeLeads ?> Active Inflow
        </span>
        <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2">
            <i class="bi bi-lightning-charge me-1"></i> <?= $highScoreLeadsCount ?> High Priority (Score 80+)
        </span>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-warning btn-sm fw-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalNewLead">
            <i class="bi bi-person-plus-fill me-1"></i> + Add New Lead
        </button>
        <button class="btn btn-outline-secondary btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent">
            <i class="bi bi-robot text-info me-1"></i> Dispatch Agent to Leads
        </button>
    </div>
</div>

<!-- Main Inbound Leads Table -->
<div class="crm-card p-0 overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-custom mb-0 align-middle">
            <thead>
                <tr>
                    <th>Prospect &amp; Company</th>
                    <th>Contact Details</th>
                    <th>Budget &amp; Timeline</th>
                    <th>AI Score</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leads)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-warning opacity-50"></i>
                            No inbound leads found in storage.<br>
                            Click <strong>'+ Add New Lead'</strong> or share your public discovery form to start capturing prospects.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($leads as $l): ?>
                        <tr>
                            <td>
                                <div class="fw-bold text-white fs-6"><?= htmlspecialchars($l['name'] ?? 'Prospect') ?></div>
                                <div class="small text-muted">
                                    <i class="bi bi-building me-1"></i><?= htmlspecialchars($l['company_name'] ?? 'N/A') ?> 
                                    &bull; <span class="badge bg-dark border border-secondary"><?= htmlspecialchars($l['country'] ?? 'USA') ?></span>
                                    <?php if (!empty($l['service_interest'])): ?>
                                        &bull; <span class="text-info"><?= htmlspecialchars($l['service_interest']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($l['problem_description'])): ?>
                                    <div class="small text-muted mt-1 text-truncate" style="max-width: 320px;" title="<?= htmlspecialchars($l['problem_description']) ?>">
                                        <i class="bi bi-chat-left-quote me-1"></i><?= htmlspecialchars($l['problem_description']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small text-white">
                                    <a href="mailto:<?= htmlspecialchars($l['email'] ?? '') ?>" class="text-info text-decoration-none">
                                        <i class="bi bi-envelope me-1 text-muted"></i><?= htmlspecialchars($l['email'] ?? 'N/A') ?>
                                    </a>
                                </div>
                                <?php if (!empty($l['phone'])): ?>
                                    <div class="small text-muted">
                                        <a href="tel:<?= htmlspecialchars($l['phone']) ?>" class="text-muted text-decoration-none">
                                            <i class="bi bi-telephone me-1 text-muted"></i><?= htmlspecialchars($l['phone']) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small fw-semibold text-white currency-budget" data-raw-budget="<?= htmlspecialchars($l['budget'] ?? 'Flexible') ?>">
                                    <?= htmlspecialchars($l['budget'] ?? 'Flexible') ?>
                                </div>
                                <div class="small text-muted">
                                    <i class="bi bi-calendar-event me-1"></i><?= htmlspecialchars($l['timeline'] ?? '1-3 months') ?>
                                </div>
                            </td>
                            <td>
                                <?php
                                $score = (int)($l['lead_score'] ?? 0);
                                $scoreClass = $score >= 80 ? 'score-high' : ($score >= 60 ? 'score-med' : 'score-low');
                                ?>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="score-pill <?= $scoreClass ?>"><?= $score ?>/100</span>
                                </div>
                            </td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                    <input type="hidden" name="action" value="update_lead_status">
                                    <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                    <input type="hidden" name="return_url" value="leads">
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
                                        <input type="hidden" name="return_url" value="pipeline">
                                        <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2" title="Convert to Deal Opportunity &amp; View Pipeline">
                                            <i class="bi bi-briefcase-fill"></i> Convert
                                        </button>
                                    </form>

                                    <!-- Dispatch to Agent -->
                                    <button class="btn btn-sm btn-outline-info py-1 px-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent" data-lead-id="<?= htmlspecialchars($l['id']) ?>" data-lead-company="<?= htmlspecialchars($l['company_name'] ?? '') ?>" title="Dispatch Agent Routine">
                                        <i class="bi bi-robot"></i> Agent
                                    </button>

                                    <!-- Delete -->
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Remove this lead permanently from CRM?');">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="delete_lead">
                                        <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                        <input type="hidden" name="return_url" value="leads">
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
