<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Human-in-the-Loop (HITL) Decision Queue
 * Multi-page architecture: Dedicated Governance & Approvals
 */

namespace CRM;

use CRM\Services\CrmSecurity;

$activePage = 'approvals';
$pageTitle = 'Human-in-the-Loop (HITL) Approvals';
$pageHeading = 'Human-in-the-Loop Decision Governance';
$pageSubheading = 'Safety Gate: Zero autonomous outbound actions execute without explicit founder sign-off';

require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
require_once __DIR__ . '/includes/topbar.php';
?>

<!-- Header & Quick Actions Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="bi bi-shield-check text-warning me-2"></i>HITL Governance Queue &amp; Sign-Off Gate</h4>
        <p class="text-muted small mb-0">Autonomous agent actions (proposals, outreach, sensitive state mutations) require human authorization.</p>
    </div>
    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
        <?= count($pendingApprovals ?? []) ?> Pending Decisions
    </span>
</div>

<!-- Pending Items Grid -->
<div class="row g-4 mb-5">
    <?php if (empty($pendingApprovals)): ?>
        <div class="col-12">
            <div class="crm-card p-5 text-center text-muted">
                <i class="bi bi-shield-check text-success fs-1 mb-2"></i>
                <h5 class="text-white">All clear! No pending agent actions require approval.</h5>
                <p class="small mb-0">When agents generate outbound outreach, proposals, or system mutations, they stage here automatically.</p>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($pendingApprovals as $item): ?>
            <div class="col-12 col-xl-6">
                <div class="approval-box h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h5 class="fw-bold text-white mb-1"><?= htmlspecialchars($item['title'] ?? 'Draft Action') ?></h5>
                                <div class="small text-muted">
                                    Requested by: <strong class="text-info"><?= htmlspecialchars($item['requested_by'] ?? 'Autonomous Agent') ?></strong>
                                    &bull; Created: <?= htmlspecialchars(date('M j, g:i a', strtotime($item['created_at'] ?? 'now'))) ?>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark fw-bold text-uppercase" style="font-size: 0.7rem;">
                                <?= htmlspecialchars($item['type'] ?? 'draft') ?>
                            </span>
                        </div>

                        <!-- Pre-Formatted Payload Preview -->
                        <div class="p-3 rounded-3 my-3" style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.08);">
                            <?php
                            $payload = $item['payload'] ?? [];
                            if (isset($payload['to'], $payload['subject'], $payload['body'])):
                            ?>
                                <div class="small text-muted mb-1">To: <span class="text-white"><?= htmlspecialchars($payload['to']) ?></span></div>
                                <div class="small text-muted mb-2">Subject: <span class="text-white fw-bold"><?= htmlspecialchars($payload['subject']) ?></span></div>
                                <div class="small text-light p-2 rounded" style="background: rgba(255,255,255,0.03); white-space: pre-wrap; font-size: 0.84rem;"><?= htmlspecialchars($payload['body']) ?></div>
                            <?php else: ?>
                                <pre class="mb-0 text-light mono" style="font-size: 0.78rem; overflow-x: auto;"><?= htmlspecialchars(json_encode($payload, JSON_PRETTY_PRINT)) ?></pre>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Decision Form -->
                    <form method="POST" class="pt-2 border-top" style="border-color: rgba(245, 158, 11, 0.2) !important;">
                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                        <input type="hidden" name="action" value="approval_decision">
                        <input type="hidden" name="approval_id" value="<?= CrmSecurity::escape($item['id']) ?>">
                        <input type="hidden" name="return_page" value="approvals">

                        <div class="input-group input-group-sm mb-2">
                            <input type="text" name="decision_notes" class="form-control" placeholder="Optional review comment / adjustment notes...">
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" name="decision" value="reject" class="btn btn-sm btn-outline-danger px-3">
                                <i class="bi bi-x-circle me-1"></i> Reject Draft
                            </button>
                            <button type="submit" name="decision" value="approve" class="btn btn-sm btn-success px-4 fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> Sign-Off &amp; Approve
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Resolved Audit History Table -->
<div class="crm-card p-3 p-md-4 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-info"></i>Audit Trail: Resolved Approvals</h6>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Item Title</th>
                    <th>Type</th>
                    <th>Requested By</th>
                    <th>Decided By</th>
                    <th>Decision Status</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resolved = array_filter($allApprovals ?? [], fn($a) => ($a['status'] ?? '') !== 'pending');
                if (empty($resolved)):
                ?>
                    <tr><td colspan="6" class="text-center text-muted py-3">No resolved approvals recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach (array_slice($resolved, 0, 10) as $res): ?>
                        <tr>
                            <td class="fw-semibold text-white small"><?= htmlspecialchars($res['title'] ?? 'Action') ?></td>
                            <td class="small text-muted"><?= htmlspecialchars($res['type'] ?? '') ?></td>
                            <td class="small text-info"><?= htmlspecialchars($res['requested_by'] ?? 'Agent') ?></td>
                            <td class="small text-white"><?= htmlspecialchars($res['approved_by'] ?? ($res['rejected_by'] ?? 'Founder')) ?></td>
                            <td>
                                <span class="badge bg-<?= ($res['status'] ?? '') === 'approved' ? 'success' : 'danger' ?>-subtle text-<?= ($res['status'] ?? '') === 'approved' ? 'success' : 'danger' ?> border border-<?= ($res['status'] ?? '') === 'approved' ? 'success' : 'danger' ?>-subtle text-uppercase" style="font-size: 0.68rem;">
                                    <?= htmlspecialchars($res['status'] ?? '') ?>
                                </span>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars(date('M j, g:i a', strtotime($res['resolved_at'] ?? ($res['created_at'] ?? 'now')))) ?></td>
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
