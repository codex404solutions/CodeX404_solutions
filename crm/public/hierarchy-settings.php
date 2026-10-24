<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Executive Governance: Company Hierarchy, Authority Tiers & Approval Rules
 * RESTRICTED: Accessible strictly to Superadmin & Founder roles.
 */

namespace CRM;

use CRM\Services\ApprovalService;
use CRM\Services\AuditService;
use CRM\Services\RBACService;
use CRM\Services\UserService;

require_once __DIR__ . '/includes/bootstrap.php';

// Strict Role Guard: Only Superadmin and Founder
$currentUserRoles = array_map('strtolower', (array)($currentUser['roles'] ?? []));
$isAuthorizedExecutive = in_array('superadmin', $currentUserRoles, true) || in_array('founder', $currentUserRoles, true);

if (!$isAuthorizedExecutive) {
    $_SESSION['flash_message'] = 'Security Perimeter Violation: Access restricted to Superadmin and Founder executive clearances.';
    $_SESSION['flash_type'] = 'danger';
    header('Location: dashboard');
    exit;
}

$currentPage = 'hierarchy-settings';
$pageTitle = 'Executive Hierarchy & Approval Governance';
$pageSubtitle = 'Configure reporting chains, authority tiers, monetary approval thresholds, and inspect immutable audit logs';
$htmlTitle = 'Executive Hierarchy & Rules — CodeX404 Solutions CRM';

// Load Data
$allRules = ApprovalService::getAllRules();
$usersList = UserService::getAll();
$auditLogs = AuditService::getRecent(30);

// Key Metric Calculations
$activeRulesCount = count(array_filter($allRules, fn($r) => !empty($r['is_active'])));
$tieredUsersCount = count(array_filter($usersList, fn($u) => !empty($u['authority_tier']) && (int)$u['authority_tier'] < 3));
$totalAuditCount = count($auditLogs);

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- 1. EXECUTIVE KPI SUMMARY CARDS                           -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Company Hierarchy</span>
                <div class="p-2 rounded bg-warning-subtle text-warning"><i class="bi bi-diagram-3-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-white mb-1"><?= count($usersList) ?> Accounts</div>
            <div class="small text-muted"><span class="text-info"><?= $tieredUsersCount ?> Elevated</span> managers in hierarchy</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Approval Rules</span>
                <div class="p-2 rounded bg-primary-subtle text-primary"><i class="bi bi-sliders2-vertical"></i></div>
            </div>
            <div class="h3 fw-bold text-primary mb-1"><?= count($allRules) ?> Defined</div>
            <div class="small text-muted"><span class="text-success"><?= $activeRulesCount ?> Active</span> governance policies</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Self-Approval Block</span>
                <div class="p-2 rounded bg-danger-subtle text-danger"><i class="bi bi-shield-slash-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-danger mb-1">Enforced</div>
            <div class="small text-muted">Requesters cannot self-approve</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="p-3 p-md-4 rounded-3 h-100" style="background: rgba(15, 23, 42, 0.65); border: 1px solid rgba(56, 189, 248, 0.16);">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.05em;">Audit Log Records</span>
                <div class="p-2 rounded bg-success-subtle text-success"><i class="bi bi-file-earmark-lock-fill"></i></div>
            </div>
            <div class="h3 fw-bold text-success mb-1"><?= $totalAuditCount ?> Recorded</div>
            <div class="small text-muted">Immutable trail in MySQL</div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. MAIN TABS & ACTION BUTTONS                            -->
<!-- ======================================================== -->
<div class="crm-card p-4 mb-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <ul class="nav nav-pills" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-semibold" id="tab-hierarchy-btn" data-bs-toggle="pill" data-bs-target="#tab-hierarchy" type="button" role="tab">
                    <i class="bi bi-diagram-3 me-2 text-warning"></i>Reporting Hierarchy &amp; Tiers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="tab-rules-btn" data-bs-toggle="pill" data-bs-target="#tab-rules" type="button" role="tab">
                    <i class="bi bi-shield-check me-2 text-primary"></i>Approval Rules Table (<?= count($allRules) ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-semibold" id="tab-audit-btn" data-bs-toggle="pill" data-bs-target="#tab-audit" type="button" role="tab">
                    <i class="bi bi-clock-history me-2 text-info"></i>Audit Log Stream
                </button>
            </li>
        </ul>

        <div>
            <button class="btn btn-sm btn-primary fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#modalAddRule">
                <i class="bi bi-plus-circle me-1"></i> New Approval Policy
            </button>
        </div>
    </div>

    <div class="tab-content" id="settingsTabContent">
        <!-- ---------------------------------------------------- -->
        <!-- TAB 1: REPORTING HIERARCHY & AUTHORITY TIERS        -->
        <!-- ---------------------------------------------------- -->
        <div class="tab-pane fade show active" id="tab-hierarchy" role="tabpanel">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white fw-bold mb-1"><i class="bi bi-diagram-2-fill text-warning me-2"></i>Executive Chain of Command &amp; Approval Authority</h6>
                    <p class="text-muted small mb-0">Manage <code class="text-info">reports_to</code> reporting lines, authority tiers, and maximum monetary sign-off limits per team member.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Employee Profile</th>
                            <th>Current Roles</th>
                            <th>Reporting Line (Reports To)</th>
                            <th>Authority Tier</th>
                            <th>Approval Limit</th>
                            <th class="text-end">Configure</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usersList as $u): 
                            $uId = $u['id'] ?? '';
                            $uName = $u['name'] ?? 'User';
                            $uUser = $u['username'] ?? '';
                            $uRoles = (array)($u['roles'] ?? []);
                            $uReportsTo = $u['reports_to'] ?? '';
                            $uTier = (int)($u['authority_tier'] ?? RBACService::getAuthorityTier($uRoles));
                            $uLimit = (float)($u['approval_limit'] ?? 0.00);

                            // Lookup Manager Name
                            $managerName = '— Root (Executive / Alex Rivera)';
                            if ($uReportsTo) {
                                foreach ($usersList as $m) {
                                    if (($m['id'] ?? '') === $uReportsTo || ($m['username'] ?? '') === $uReportsTo) {
                                        $managerName = $m['name'] . ' (@' . $m['username'] . ')';
                                        break;
                                    }
                                }
                            }
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle avatar-sm bg-dark text-info border border-secondary border-opacity-50">
                                            <?= strtoupper(substr($uName, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-white"><?= htmlspecialchars($uName) ?></div>
                                            <div class="small text-muted mono">@<?= htmlspecialchars($uUser) ?> &bull; <?= htmlspecialchars($u['title'] ?? 'Staff') ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php foreach (array_slice($uRoles, 0, 3) as $r): ?>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.6rem;">
                                                <?= htmlspecialchars($r) ?>
                                            </span>
                                        <?php endforeach; ?>
                                        <?php if (count($uRoles) > 3): ?>
                                            <span class="badge bg-secondary-subtle text-muted" style="font-size: 0.6rem;">+<?= count($uRoles) - 3 ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($uReportsTo): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                            <i class="bi bi-arrow-up-right me-1"></i><?= htmlspecialchars($managerName) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-dark border border-secondary text-muted">
                                            <i class="bi bi-crown text-warning me-1"></i>Apex / Reports to Founder
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($uTier === 1): ?>
                                        <span class="badge text-white fw-bold" style="background: linear-gradient(135deg, #EF4444, #DC2626);">
                                            Tier 1: Supreme
                                        </span>
                                    <?php elseif ($uTier === 2): ?>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-semibold">
                                            Tier 2: Management
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle">
                                            Tier 3: Standard
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($uLimit >= 100000000 || $uTier === 1): ?>
                                        <span class="text-success fw-bold"><i class="bi bi-infinity me-1"></i>Unlimited</span>
                                    <?php else: ?>
                                        <span class="text-white fw-bold mono">$<?= number_format($uLimit, 2) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalEditHierarchy_<?= htmlspecialchars($uId) ?>">
                                        <i class="bi bi-gear me-1"></i> Edit Line
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Hierarchy Modal for User -->
                            <div class="modal fade" id="modalEditHierarchy_<?= htmlspecialchars($uId) ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border border-secondary">
                                        <form method="POST">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                                            <input type="hidden" name="action" value="update_hierarchy">
                                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($uId) ?>">
                                            <input type="hidden" name="return_url" value="hierarchy-settings">

                                            <div class="modal-header border-bottom border-secondary">
                                                <h6 class="modal-title fw-bold text-white">
                                                    <i class="bi bi-diagram-3 text-warning me-2"></i>Hierarchy &amp; Limits: <?= htmlspecialchars($uName) ?>
                                                </h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted">Direct Supervisor / Manager (<code class="text-info">reports_to</code>)</label>
                                                    <select name="reports_to" class="form-select bg-black text-white border-secondary">
                                                        <option value="">— None (Apex Leadership / Reports directly to Founder) —</option>
                                                        <?php foreach ($usersList as $mgr): 
                                                            if (($mgr['id'] ?? '') === $uId) continue;
                                                        ?>
                                                            <option value="<?= htmlspecialchars($mgr['id'] ?? '') ?>" <?= ($uReportsTo === ($mgr['id'] ?? '') || $uReportsTo === ($mgr['username'] ?? '')) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($mgr['name'] ?? '') ?> (@<?= htmlspecialchars($mgr['username'] ?? '') ?>) — <?= htmlspecialchars($mgr['title'] ?? 'Manager') ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label small text-muted">Authority Tier Level</label>
                                                    <select name="authority_tier" class="form-select bg-black text-white border-secondary">
                                                        <option value="1" <?= $uTier === 1 ? 'selected' : '' ?>>Tier 1: Supreme Authority (Superadmin, Founder)</option>
                                                        <option value="2" <?= $uTier === 2 ? 'selected' : '' ?>>Tier 2: Senior Management (CEO, CTO, COO, Sales Manager)</option>
                                                        <option value="3" <?= $uTier === 3 ? 'selected' : '' ?>>Tier 3: Standard Workforce Authority</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label small text-muted">Maximum Approval Limit ($ USD)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-black text-info border-secondary">$</span>
                                                        <input type="number" step="100" name="approval_limit" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars((string)$uLimit) ?>">
                                                    </div>
                                                    <div class="form-text text-muted small">Max monetary threshold this manager can authorize without higher executive escalation.</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top border-secondary">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-primary fw-bold px-3">Save Hierarchy Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 2: APPROVAL RULES TABLE                         -->
        <!-- ---------------------------------------------------- -->
        <div class="tab-pane fade" id="tab-rules" role="tabpanel">
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-white fw-bold mb-1"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Active Governance &amp; Threshold Rules</h6>
                    <p class="text-muted small mb-0">Read dynamically by <code class="text-info">ApprovalService</code>. Evaluates every outbound draft, price discount, and privilege elevation.</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Rule Identification</th>
                            <th>Category / Type</th>
                            <th>Threshold Amount</th>
                            <th>Required Approver Role</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allRules as $r): 
                            $rId = $r['id'] ?? '';
                            $rName = $r['rule_name'] ?? 'Policy';
                            $rType = $r['type'] ?? 'general';
                            $rThreshold = (float)($r['threshold'] ?? 0.00);
                            $rRole = $r['required_role'] ?? 'superadmin';
                            $rDesc = $r['description'] ?? '';
                            $rActive = !empty($r['is_active']);
                        ?>
                            <tr>
                                <td>
                                    <div class="fw-bold text-white"><?= htmlspecialchars($rName) ?></div>
                                    <div class="small text-muted mono" style="font-size: 0.72rem;"><?= htmlspecialchars($rDesc) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-white font-monospace text-uppercase" style="font-size: 0.68rem;">
                                        <?= htmlspecialchars($rType) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($rThreshold > 0): ?>
                                        <span class="text-warning fw-bold mono">$<?= number_format($rThreshold, 2) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-dark border border-secondary text-muted">All Values ($0+)</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase fw-semibold">
                                        <i class="bi bi-person-fill-lock me-1"></i><?= htmlspecialchars($rRole) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($rActive): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            <span class="agent-badge-pulse me-1" style="width: 5px; height: 5px;"></span>Active
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button class="btn btn-sm btn-outline-info px-2" data-bs-toggle="modal" data-bs-target="#modalEditRule_<?= htmlspecialchars($rId) ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form method="POST" onsubmit="return confirm('Are you sure you want to remove this approval policy?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                                            <input type="hidden" name="action" value="delete_approval_rule">
                                            <input type="hidden" name="rule_id" value="<?= htmlspecialchars($rId) ?>">
                                            <input type="hidden" name="return_url" value="hierarchy-settings">
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-2">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Rule Modal -->
                            <div class="modal fade" id="modalEditRule_<?= htmlspecialchars($rId) ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border border-secondary">
                                        <form method="POST">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                                            <input type="hidden" name="action" value="save_approval_rule">
                                            <input type="hidden" name="rule_id" value="<?= htmlspecialchars($rId) ?>">
                                            <input type="hidden" name="return_url" value="hierarchy-settings">

                                            <div class="modal-header border-bottom border-secondary">
                                                <h6 class="modal-title fw-bold text-white"><i class="bi bi-sliders text-info me-2"></i>Edit Approval Rule</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted">Rule Title</label>
                                                    <input type="text" name="rule_name" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($rName) ?>" required>
                                                </div>
                                                <div class="row g-2 mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label small text-muted">Action Type</label>
                                                        <select name="type" class="form-select bg-black text-white border-secondary">
                                                            <?php foreach (ApprovalService::TYPES as $tSlug => $tLabel): ?>
                                                                <option value="<?= htmlspecialchars($tSlug) ?>" <?= $rType === $tSlug ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($tLabel) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label small text-muted">Required Role</label>
                                                        <input type="text" name="required_role" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars($rRole) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted">Trigger Threshold ($ USD)</label>
                                                    <input type="number" step="0.01" name="threshold" class="form-control bg-black text-white border-secondary" value="<?= htmlspecialchars((string)$rThreshold) ?>">
                                                    <div class="form-text text-muted small">0.00 triggers on any value or non-monetary requests.</div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small text-muted">Policy Description</label>
                                                    <textarea name="description" class="form-control bg-black text-white border-secondary" rows="2"><?= htmlspecialchars($rDesc) ?></textarea>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="is_active" id="active_<?= htmlspecialchars($rId) ?>" value="1" <?= $rActive ? 'checked' : '' ?>>
                                                    <label class="form-check-label small text-white" for="active_<?= htmlspecialchars($rId) ?>">Rule Enforcement Active</label>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top border-secondary">
                                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-sm btn-primary fw-bold px-3">Save Policy</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ---------------------------------------------------- -->
        <!-- TAB 3: IMMUTABLE AUDIT LOG STREAM                   -->
        <!-- ---------------------------------------------------- -->
        <div class="tab-pane fade" id="tab-audit" role="tabpanel">
            <div class="mb-3">
                <h6 class="text-white fw-bold mb-1"><i class="bi bi-file-earmark-lock-fill text-info me-2"></i>Tamper-Evident System Audit Trail</h6>
                <p class="text-muted small mb-0">Live feed recorded in MySQL <code class="text-info">audit_logs</code>. Logs every approval decision, self-approval attempt, and hierarchy change.</p>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Action &amp; Resource</th>
                            <th>Actor / Account</th>
                            <th>Details &amp; Audit Payload</th>
                            <th>Client IP</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($auditLogs)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No audit records logged yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($auditLogs as $a): 
                                $aAction = $a['action'] ?? 'action';
                                $aRes = $a['resource_type'] ?? 'system';
                                $aUser = $a['username'] ?? 'system';
                                $aDetails = $a['details'] ?? '—';
                                $aIp = $a['ip_address'] ?? '127.0.0.1';
                                $aTime = $a['created_at'] ?? 'now';

                                $badgeClass = 'info';
                                if (str_contains($aAction, 'blocked')) $badgeClass = 'danger';
                                elseif (str_contains($aAction, 'granted') || str_contains($aAction, 'approved')) $badgeClass = 'success';
                                elseif (str_contains($aAction, 'rejected') || str_contains($aAction, 'deleted')) $badgeClass = 'warning';
                            ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-<?= htmlspecialchars($badgeClass) ?>-subtle text-<?= htmlspecialchars($badgeClass) ?> border border-<?= htmlspecialchars($badgeClass) ?>-subtle text-uppercase font-monospace" style="font-size: 0.65rem;">
                                            <?= htmlspecialchars($aAction) ?>
                                        </span>
                                        <div class="small text-muted mono" style="font-size: 0.72rem;"><?= htmlspecialchars($aRes) ?></div>
                                    </td>
                                    <td>
                                        <span class="text-white fw-bold small"><i class="bi bi-person-circle me-1 text-muted"></i><?= htmlspecialchars($aUser) ?></span>
                                    </td>
                                    <td>
                                        <div class="small text-white"><?= htmlspecialchars($aDetails) ?></div>
                                        <?php if (!empty($a['changes']) && is_array($a['changes'])): ?>
                                            <div class="p-1 rounded bg-black text-muted mono mt-1" style="font-size: 0.68rem;">
                                                <?= htmlspecialchars(json_encode($a['changes'], JSON_UNESCAPED_SLASHES)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-muted mono"><?= htmlspecialchars($aIp) ?></td>
                                    <td class="small text-muted mono"><?= htmlspecialchars(date('M j, Y g:i:s a', strtotime($aTime))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: ADD NEW APPROVAL RULE                             -->
<!-- ======================================================== -->
<div class="modal fade" id="modalAddRule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border border-secondary">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                <input type="hidden" name="action" value="save_approval_rule">
                <input type="hidden" name="rule_id" value="">
                <input type="hidden" name="return_url" value="hierarchy-settings">

                <div class="modal-header border-bottom border-secondary">
                    <h6 class="modal-title fw-bold text-white"><i class="bi bi-shield-plus text-primary me-2"></i>Create New Approval Policy</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Rule Policy Title</label>
                        <input type="text" name="rule_name" class="form-control bg-black text-white border-secondary" placeholder="e.g. High Value Retainer Scope Approval" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Action Type</label>
                            <select name="type" class="form-select bg-black text-white border-secondary">
                                <?php foreach (ApprovalService::TYPES as $tSlug => $tLabel): ?>
                                    <option value="<?= htmlspecialchars($tSlug) ?>">
                                        <?= htmlspecialchars($tLabel) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Required Role</label>
                            <select name="required_role" class="form-select bg-black text-white border-secondary">
                                <option value="superadmin">Super Administrator</option>
                                <option value="founder">Founder</option>
                                <option value="ceo">Chief Executive Officer</option>
                                <option value="cto">Chief Technology Officer</option>
                                <option value="coo">Chief Operating Officer</option>
                                <option value="sales_manager">Sales Manager</option>
                                <option value="marketing_manager">Marketing Manager</option>
                                <option value="finance">Finance &amp; Accounts</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Monetary Threshold ($ USD)</label>
                        <input type="number" step="0.01" name="threshold" class="form-control bg-black text-white border-secondary" value="0.00">
                        <div class="form-text text-muted small">Requests at or above this amount require this role to sign off.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Rule Description &amp; Scope</label>
                        <textarea name="description" class="form-control bg-black text-white border-secondary" rows="2" placeholder="Specify requirements, constraints, and audit conditions..."></textarea>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="new_rule_active" value="1" checked>
                        <label class="form-check-label small text-white" for="new_rule_active">Rule Immediately Enforced</label>
                    </div>
                </div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-3">Deploy Approval Policy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
