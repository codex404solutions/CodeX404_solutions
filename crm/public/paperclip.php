<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Paperclip Autonomous Agent Swarm & Task Log
 */

namespace CRM;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'paperclip';
$pageTitle = 'Paperclip Autonomous Agent Swarm';
$pageSubtitle = 'Autonomous multi-agent company operations, specialist skills, and task dispatch';
$htmlTitle = 'Paperclip Agents — CodeX404 Solutions CRM';

require_once __DIR__ . '/includes/header.php';
?>

<!-- Network Status Banner -->
<div class="crm-card p-3 p-md-4 mb-4" style="background: linear-gradient(135deg, rgba(17, 24, 39, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%);">
    <div class="row align-items-center g-3">
        <div class="col-12 col-md-7">
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="agent-badge-pulse"></span>
                <span class="fw-bold text-info">PAPERCLIP 7-AGENT SPECIALIST NETWORK</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle">ONLINE</span>
            </div>
            <h4 class="fw-bold text-white mb-1">Autonomous Company Operations &amp; Task Engine</h4>
            <p class="text-muted small mb-0">Each agent operates within its domain skills and stages external actions into the Human-in-the-Loop approval queue.</p>
        </div>
        <div class="col-12 col-md-5 text-md-end">
            <button class="btn btn-info btn-sm fw-bold me-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent">
                <i class="bi bi-send-fill me-1"></i> Dispatch Custom Task
            </button>
            <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgentRoutines">
                <i class="bi bi-lightning-fill text-warning me-1"></i> 1-Click Routines
            </button>
        </div>
    </div>
</div>

<!-- 7 Agent Cards Grid -->
<div class="row g-3 mb-4">
    <?php foreach ($agents as $slug => $ag): ?>
        <div class="col-12 col-md-6 col-xl-4">
            <div class="agent-card p-3 p-xl-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.2); width: 38px; height: 38px;">
                                <i class="bi <?= htmlspecialchars($ag['icon'] ?? 'bi-robot') ?> text-info fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-white fs-6"><?= htmlspecialchars($ag['name'] ?? 'Agent') ?></div>
                                <small class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($ag['title'] ?? '') ?></small>
                            </div>
                        </div>
                        <span class="badge bg-dark border border-secondary text-uppercase" style="font-size: 0.65rem;">
                            <?= htmlspecialchars($ag['badge'] ?? 'Agent') ?>
                        </span>
                    </div>

                    <p class="text-muted small mt-2 mb-3" style="font-size: 0.82rem; min-height: 40px;">
                        <?= htmlspecialchars($ag['description'] ?? '') ?>
                    </p>

                    <!-- Skills Pills -->
                    <div class="d-flex gap-1 flex-wrap mb-3">
                        <?php foreach ($ag['skills'] ?? [] as $sk): ?>
                            <span class="badge bg-dark text-info border border-secondary" style="font-size: 0.68rem; font-family: 'JetBrains Mono', monospace;">
                                #<?= htmlspecialchars($sk) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <div class="d-flex align-items-center gap-1 small text-muted">
                        <span class="agent-badge-pulse"></span>
                        <span>Active (<?= htmlspecialchars($ag['reports_to'] ? strtoupper($ag['reports_to']) : 'Board') ?>)</span>
                    </div>
                    <button class="btn btn-xs btn-outline-info py-1 px-2" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent" data-agent-slug="<?= htmlspecialchars($slug) ?>">
                        <i class="bi bi-send me-1"></i> Dispatch
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Live Task Queue & Output History Table -->
<div class="crm-card p-3 p-md-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0"><i class="bi bi-list-task text-info me-2"></i>Live Paperclip Task Queue &amp; Output Log</h5>
        <span class="badge bg-dark border border-secondary text-muted"><?= count($paperclipTasks) ?> Tasks Logged</span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom mb-0">
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Agent</th>
                    <th>Title / Routine</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Timestamp</th>
                    <th class="text-end">Output Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($paperclipTasks)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No agent tasks in queue. Dispatch a task above!</td></tr>
                <?php else: ?>
                    <?php foreach ($paperclipTasks as $t): ?>
                        <tr>
                            <td class="mono small text-info"><?= htmlspecialchars($t['id'] ?? 'task') ?></td>
                            <td class="fw-bold text-white small"><?= htmlspecialchars($t['agent_title'] ?? ($t['agent'] ?? 'Agent')) ?></td>
                            <td>
                                <div class="fw-semibold text-white small"><?= htmlspecialchars($t['title'] ?? 'Task') ?></div>
                                <?php if (!empty($t['description'])): ?>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 280px;"><?= htmlspecialchars($t['description']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $pri = $t['priority'] ?? 'medium';
                                $priColor = $pri === 'urgent' ? 'danger' : ($pri === 'high' ? 'warning' : 'secondary');
                                ?>
                                <span class="badge bg-<?= $priColor ?>-subtle text-<?= $priColor ?> border border-<?= $priColor ?>-subtle text-uppercase" style="font-size: 0.65rem;"><?= htmlspecialchars($pri) ?></span>
                            </td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success-subtle text-uppercase" style="font-size: 0.65rem;">
                                    <i class="bi bi-check2 me-1"></i><?= htmlspecialchars($t['status'] ?? 'completed') ?>
                                </span>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars(date('M j, g:i a', strtotime($t['created_at'] ?? 'now'))) ?></td>
                            <td class="text-end">
                                <button class="btn btn-xs btn-outline-secondary py-1 px-2 btn-view-task-output" style="font-size: 0.72rem;" data-title="<?= htmlspecialchars($t['title'] ?? '') ?>" data-agent="<?= htmlspecialchars($t['agent_title'] ?? ($t['agent'] ?? '')) ?>" data-output="<?= htmlspecialchars(is_string($t['output'] ?? '') ? ($t['output'] ?? '') : json_encode($t['output'] ?? [], JSON_PRETTY_PRINT)) ?>">
                                    <i class="bi bi-eye"></i> View Result
                                </button>
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
