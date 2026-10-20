<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Application Entrypoint & Dashboard
 */

namespace CRM;

use CRM\Services\StorageService;
use CRM\Services\LeadService;
use CRM\Services\OpportunityService;
use CRM\Services\ApprovalService;
use CRM\Services\RBACService;
use CRM\Services\AuthService;
use CRM\Services\CrmSecurity;

$crmRoot = dirname(__DIR__);
require_once $crmRoot . '/app/Services/StorageService.php';
require_once $crmRoot . '/app/Services/LeadService.php';
require_once $crmRoot . '/app/Services/OpportunityService.php';
require_once $crmRoot . '/app/Services/ApprovalService.php';
require_once $crmRoot . '/app/Services/RBACService.php';
require_once $crmRoot . '/app/Services/AuthService.php';
require_once $crmRoot . '/app/Services/CrmSecurity.php';

StorageService::init($crmRoot . '/storage');
AuthService::startSession();
$currentUser = AuthService::user();
if ($currentUser === null) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? 'dashboard';
$leads = LeadService::getAll();
$opportunities = OpportunityService::getAll();
$pendingApprovals = ApprovalService::getPending();

// Approval is a governance decision only. Publishing/sending requires a later,
// explicitly configured and separately confirmed delivery action.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approval_id'], $_POST['decision'])) {
    if (!CrmSecurity::verifyCsrf($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid CSRF token.');
    }
    if (!RBACService::hasPermission($currentUser['roles'], 'approvals.decide')) {
        http_response_code(403);
        exit('You are not authorized to decide approvals.');
    }
    $approvalId = trim((string)$_POST['approval_id']);
    $decision = trim((string)$_POST['decision']);
    if ($decision === 'approve') {
        ApprovalService::approve($approvalId, $currentUser['name']);
    } elseif ($decision === 'reject') {
        ApprovalService::reject($approvalId, $currentUser['name']);
    } else {
        http_response_code(422);
        exit('Unknown approval decision.');
    }
    header('Location: index.php?msg=approval_updated');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeX404 Solutions — Company CRM & Command Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0B0F19;
            --panel: #111827;
            --border: rgba(56, 189, 248, 0.2);
            --cyan: #38BDF8;
            --green: #10B981;
            --yellow: #F59E0B;
            --purple: #818CF8;
            --text: #F8FAFC;
            --muted: #94A3B8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; min-height: 100vh; }

        /* Sidebar */
        aside { width: 260px; background: var(--panel); border-right: 1px solid var(--border); padding: 1.5rem; display: flex; flex-direction: column; gap: 2rem; }
        .logo { font-size: 1.25rem; font-weight: 800; color: #FFF; display: flex; align-items: center; gap: 0.5rem; }
        .logo span { color: var(--cyan); }
        .user-badge { background: rgba(56, 189, 248, 0.1); border: 1px solid var(--border); padding: 0.75rem; border-radius: 8px; font-size: 0.85rem; }
        .user-roles { display: flex; gap: 0.35rem; flex-wrap: wrap; margin-top: 0.5rem; }
        .role-pill { background: var(--cyan); color: #000; font-size: 0.65rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; text-transform: uppercase; }
        nav { display: flex; flex-direction: column; gap: 0.5rem; }
        nav a { color: var(--muted); text-decoration: none; padding: 0.65rem 0.85rem; border-radius: 6px; font-size: 0.9rem; font-weight: 600; display: flex; justify-content: space-between; }
        nav a:hover, nav a.active { background: rgba(56, 189, 248, 0.15); color: #FFF; }

        /* Main Content */
        main { flex: 1; padding: 2.5rem; overflow-y: auto; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        h1 { font-size: 1.75rem; font-weight: 800; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2.5rem; }
        .card { background: var(--panel); border: 1px solid var(--border); border-radius: 12px; padding: 1.5rem; }
        .card-num { font-size: 2rem; font-weight: 800; color: #FFF; margin-top: 0.5rem; }

        /* Tables */
        .section-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; margin-top: 0.5rem; }
        th { padding: 0.75rem 1rem; color: var(--muted); border-bottom: 1px solid var(--border); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .badge-new { background: rgba(56, 189, 248, 0.2); color: var(--cyan); }
        .badge-won { background: rgba(16, 185, 129, 0.2); color: var(--green); }
        .badge-pending { background: rgba(245, 158, 11, 0.2); color: var(--yellow); }

        /* Approvals */
        .approval-card { background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 8px; padding: 1rem; margin-bottom: 1rem; }
        .btn { padding: 0.4rem 0.8rem; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer; border: none; }
        .btn-green { background: var(--green); color: #000; }
        .btn-red { background: #EF4444; color: #FFF; }
    </style>
</head>
<body>
    <aside>
        <div class="logo">CodeX404 <span>CRM</span></div>
        <div class="user-badge">
            <strong><?= htmlspecialchars($currentUser['name']) ?></strong>
            <div class="user-roles">
                <?php foreach ($currentUser['roles'] as $role): ?>
                    <span class="role-pill"><?= htmlspecialchars($role) ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <nav>
            <a href="index.php" class="active">Dashboard <span>📊</span></a>
            <a href="index.php#leads">Leads (<?= count($leads) ?>) <span>🎯</span></a>
            <a href="index.php#pipeline">Pipeline (<?= count($opportunities) ?>) <span>💼</span></a>
            <a href="index.php#approvals">Approval Queue (<?= count($pendingApprovals) ?>) <span>🛡️</span></a>
            <a href="../website/discovery-call.php" target="_blank">Live Test Form <span>↗</span></a>
        </nav>
    </aside>

    <main>
        <header>
            <div>
                <h1>Executive Command Center</h1>
                <p style="color: var(--muted); font-size: 0.9rem;">Multi-role governance & AI agent delivery control</p>
            </div>
        </header>

        <div class="stats-grid">
            <div class="card">
                <div style="color: var(--muted); font-size: 0.85rem;">Total Inbound Leads</div>
                <div class="card-num"><?= count($leads) ?></div>
            </div>
            <div class="card">
                <div style="color: var(--muted); font-size: 0.85rem;">Active Pipeline Value</div>
                <div class="card-num" style="color: var(--green);">$<?= number_format(array_sum(array_column($opportunities, 'value')), 0) ?></div>
            </div>
            <div class="card">
                <div style="color: var(--muted); font-size: 0.85rem;">Pending Human Approvals</div>
                <div class="card-num" style="color: var(--yellow);"><?= count($pendingApprovals) ?></div>
            </div>
        </div>

        <!-- Approvals Queue -->
        <section id="approvals" style="margin-bottom: 3rem;">
            <div class="section-title">
                <h2>Pending Approvals (Human-in-the-Loop)</h2>
                <span style="font-size: 0.85rem; color: var(--muted);">No autonomous outbound actions occur without approval</span>
            </div>
            <?php if (empty($pendingApprovals)): ?>
                <div class="card" style="color: var(--muted);">No pending actions waiting for approval. All agent workflows clear.</div>
            <?php else: ?>
                <?php foreach ($pendingApprovals as $item): ?>
                    <div class="approval-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <strong><?= htmlspecialchars($item['title'] ?? 'Draft Action') ?></strong>
                            <span class="badge badge-pending"><?= htmlspecialchars($item['type'] ?? '') ?></span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 0.75rem;">Requested by: <strong><?= htmlspecialchars($item['requested_by'] ?? 'Agent') ?></strong></p>
                        <pre style="background: rgba(0,0,0,0.5); padding: 0.75rem; border-radius: 6px; font-family: 'JetBrains Mono'; font-size: 0.8rem; margin-bottom: 0.75rem; overflow-x: auto;"><?= htmlspecialchars(json_encode($item['payload'], JSON_PRETTY_PRINT)) ?></pre>
                        <form method="POST" style="display: flex; gap: 0.5rem;">
                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape(CrmSecurity::csrfToken()) ?>">
                            <input type="hidden" name="approval_id" value="<?= CrmSecurity::escape($item['id']) ?>">
                            <button type="submit" name="decision" value="approve" class="btn btn-green">✓ Approve Draft</button>
                            <button type="submit" name="decision" value="reject" class="btn btn-red">✕ Reject Draft</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <!-- Leads Table -->
        <section id="leads">
            <div class="section-title">
                <h2>Inbound Leads</h2>
            </div>
            <div class="card" style="padding: 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Prospect</th>
                            <th>Company</th>
                            <th>Country</th>
                            <th>Budget</th>
                            <th>Score</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leads)): ?>
                            <tr><td colspan="6" style="text-align: center; color: var(--muted);">No leads captured yet. Submissions from discovery-call.php will appear here instantly.</td></tr>
                        <?php else: ?>
                            <?php foreach ($leads as $l): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($l['name'] ?? '') ?></strong><br><small style="color: var(--muted);"><?= htmlspecialchars($l['email'] ?? '') ?></small></td>
                                    <td><?= htmlspecialchars($l['company_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($l['country'] ?? 'USA') ?></td>
                                    <td><?= htmlspecialchars($l['budget'] ?? 'Flexible') ?></td>
                                    <td><strong style="color: var(--cyan);"><?= htmlspecialchars((string)($l['lead_score'] ?? 0)) ?>/100</strong></td>
                                    <td><span class="badge badge-new"><?= htmlspecialchars($l['status'] ?? 'new') ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
