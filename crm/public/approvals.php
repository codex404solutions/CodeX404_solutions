<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Human-in-the-Loop (HITL) Governance Queue
 */

namespace CRM;

use CRM\Services\CrmSecurity;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'approvals';
$pageTitle = 'Human-in-the-Loop (HITL) Approvals';
$pageSubtitle = 'Safety Guarantee: Zero autonomous outbound actions execute without explicit founder sign-off';
$htmlTitle = 'HITL Approvals — CodeX404 Solutions CRM';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Action Toolbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <?php if (count($pendingApprovals) > 0): ?>
            <span class="badge bg-danger text-white px-3 py-2 fw-bold">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= count($pendingApprovals) ?> Pending Decisions Require Attention
            </span>
        <?php else: ?>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                <i class="bi bi-shield-check me-1"></i> All Clear — No Pending Decisions
            </span>
        <?php endif; ?>
        <span class="badge bg-dark border border-secondary text-muted px-3 py-2">
            <i class="bi bi-clock-history me-1"></i> <?= count($allApprovals) ?> Total Historical Decisions
        </span>
    </div>
    <div>
        <span class="badge border text-info" style="background: rgba(56, 189, 248, 0.08); border-color: rgba(56, 189, 248, 0.25) !important;">
            <i class="bi bi-lock-fill me-1"></i> Executive Gate: Strict Non-Bypass
        </span>
    </div>
</div>

<!-- Pending Decisions Queue Cards Grid -->
<div class="row g-4 mb-5">
    <?php if (empty($pendingApprovals)): ?>
        <div class="col-12">
            <div class="crm-card p-5 text-center text-muted">
                <i class="bi bi-shield-check text-success fs-1 mb-3 d-block opacity-75"></i>
                <h5 class="text-white">All clear! No pending agent actions require approval.</h5>
                <p class="small mb-0">When autonomous agents generate outbound draft emails, proposals, or contract deliverables, they stage here for your review.</p>
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
                            <?php if ($item['type'] === 'privilege_elevation'): ?>
                                <span class="badge bg-danger text-white fw-bold text-uppercase" style="font-size: 0.7rem;">
                                    <i class="bi bi-shield-lock-fill me-1"></i>PRIVILEGE ELEVATION GATE
                                </span>
                            <?php elseif ($item['type'] === 'user_provisioning_elevation'): ?>
                                <span class="badge text-white fw-bold text-uppercase" style="font-size: 0.7rem; background: #8B5CF6;">
                                    <i class="bi bi-person-fill-lock me-1"></i>ELEVATED ACCOUNT GATE
                                </span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark fw-bold text-uppercase" style="font-size: 0.7rem;">
                                    <?= htmlspecialchars($item['type'] ?? 'draft') ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php 
                        $reqRole = $item['required_role'] ?? '';
                        $amount = (float)($item['amount'] ?? 0.00);
                        $isSelf = (!empty($item['requested_user_id']) && $item['requested_user_id'] === ($currentUser['id'] ?? ''))
                            || (!empty($item['requested_by']) && strtolower(trim((string)$item['requested_by'])) === strtolower(trim((string)($currentUser['username'] ?? ''))));
                        ?>
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                            <?php if ($reqRole): ?>
                                <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.68rem;">
                                    <i class="bi bi-person-fill-lock me-1"></i>Requires Role: <strong><?= htmlspecialchars(strtoupper($reqRole)) ?></strong>
                                </span>
                            <?php endif; ?>
                            <?php if ($amount > 0): ?>
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.68rem;">
                                    <i class="bi bi-cash-stack me-1"></i>Threshold: <strong>$<?= number_format($amount, 2) ?></strong>
                                </span>
                            <?php endif; ?>
                            <?php if ($isSelf): ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle" style="font-size: 0.68rem;">
                                    <i class="bi bi-shield-slash-fill me-1"></i>Self-Approval Blocked
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Pre-Formatted Payload Preview -->
                        <div class="p-3 rounded-3 my-3" style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.08);">
                            <?php
                            $payload = $item['payload'] ?? [];
                            if ($item['type'] === 'privilege_elevation'):
                            ?>
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-secondary border-opacity-25">
                                    <div class="small text-muted">Target Account:</div>
                                    <div class="text-white fw-bold small">
                                        <?= htmlspecialchars($payload['target_name'] ?? 'User') ?> 
                                        <span class="text-info mono">(@<?= htmlspecialchars($payload['target_username'] ?? '') ?>)</span>
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <div class="small text-muted mb-1" style="font-size: 0.72rem;">Current Scope:</div>
                                        <span class="badge bg-secondary-subtle text-muted text-uppercase" style="font-size: 0.72rem;">
                                            <?= htmlspecialchars(strtoupper(str_replace('_', ' ', (string)($payload['current_scope'] ?? 'crm_only')))) ?>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <div class="small text-info mb-1 fw-bold" style="font-size: 0.72rem;">Requested Scope:</div>
                                        <span class="badge bg-purple text-white text-uppercase fw-bold" style="background: #8B5CF6; font-size: 0.72rem;">
                                            <i class="bi bi-arrow-up-right-circle me-1"></i><?= htmlspecialchars(strtoupper(str_replace('_', ' ', (string)($payload['requested_scope'] ?? 'both')))) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="small text-muted mb-1" style="font-size: 0.72rem;">Requested Roles:</div>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <?php foreach ((array)($payload['requested_roles'] ?? []) as $r): ?>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;">
                                                <?= htmlspecialchars($r) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if (!empty($payload['reasons'])): ?>
                                    <div class="mt-2 pt-2 border-top border-secondary border-opacity-25">
                                        <div class="small text-warning fw-semibold mb-1" style="font-size: 0.72rem;">Escalation Reasons Requiring Executive Sign-Off:</div>
                                        <ul class="mb-0 ps-3 small text-danger" style="font-size: 0.76rem;">
                                            <?php foreach ((array)$payload['reasons'] as $rsn): ?>
                                                <li><?= htmlspecialchars($rsn) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                            <?php elseif ($item['type'] === 'user_provisioning_elevation'): ?>
                                <?php $uData = $payload['user_data'] ?? []; ?>
                                <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom border-secondary border-opacity-25">
                                    <div class="small text-muted">Proposed User:</div>
                                    <div class="text-white fw-bold small">
                                        <?= htmlspecialchars($uData['name'] ?? '') ?> 
                                        <span class="text-info mono">(<?= htmlspecialchars($uData['email'] ?? '') ?>)</span>
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <div class="small text-muted mb-1" style="font-size: 0.72rem;">Portal Clearance:</div>
                                        <span class="badge bg-primary text-white text-uppercase" style="font-size: 0.72rem;">
                                            <?= htmlspecialchars(strtoupper(str_replace('_', ' ', (string)($payload['target_scope'] ?? 'crm_only')))) ?>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <div class="small text-muted mb-1" style="font-size: 0.72rem;">Department / Title:</div>
                                        <div class="small text-white text-truncate"><?= htmlspecialchars($uData['department'] ?? 'Operations') ?> &bull; <?= htmlspecialchars($uData['title'] ?? 'Staff') ?></div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="small text-muted mb-1" style="font-size: 0.72rem;">Assigned Roles:</div>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <?php foreach ((array)($payload['target_roles'] ?? []) as $r): ?>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;">
                                                <?= htmlspecialchars($r) ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if (!empty($payload['reasons'])): ?>
                                    <div class="mt-2 pt-2 border-top border-secondary border-opacity-25">
                                        <div class="small text-warning fw-semibold mb-1" style="font-size: 0.72rem;">Executive Sign-Off Reasons:</div>
                                        <ul class="mb-0 ps-3 small text-danger" style="font-size: 0.76rem;">
                                            <?php foreach ((array)$payload['reasons'] as $rsn): ?>
                                                <li><?= htmlspecialchars($rsn) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                            <?php elseif (isset($payload['to'], $payload['subject'], $payload['body'])): ?>
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
                        <input type="hidden" name="return_url" value="approvals">

                        <div class="input-group input-group-sm mb-2">
                            <input type="text" name="decision_notes" class="form-control" placeholder="Optional review comment / authorization notes...">
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="submit" name="decision" value="reject" class="btn btn-sm btn-outline-danger px-3">
                                <i class="bi bi-x-circle me-1"></i> Reject
                            </button>
                            <button type="submit" name="decision" value="approve" class="btn btn-sm btn-success px-4 fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                <?= in_array($item['type'] ?? '', ['privilege_elevation', 'user_provisioning_elevation'], true) ? 'Authorize & Apply Privileges' : 'Sign-Off & Approve' ?>
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
                $resolved = array_filter($allApprovals, fn($a) => ($a['status'] ?? '') !== 'pending');
                if (empty($resolved)):
                ?>
                    <tr><td colspan="6" class="text-center text-muted py-3">No resolved approvals recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach (array_slice($resolved, 0, 15) as $res): ?>
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
