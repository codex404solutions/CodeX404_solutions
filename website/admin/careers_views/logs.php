<?php
declare(strict_types=1);

use App\Careers\ActivityLogService;

$logs = ActivityLogService::listRecent(150);
?>

<div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
    <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">
        Recruitment Audit &amp; Activity Logs
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-sm table-hover align-middle mb-0" style="background:transparent;">
            <thead>
                <tr class="small text-muted">
                    <th>Timestamp</th>
                    <th>Actor</th>
                    <th>Action</th>
                    <th>Entity</th>
                    <th>Summary</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No recruitment activity recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($logs as $lg): ?>
                        <tr class="small">
                            <td class="text-muted font-monospace"><?= htmlspecialchars((string)$lg['created_at']) ?></td>
                            <td>
                                <span class="badge bg-<?= $lg['actor_type'] === 'admin' ? 'warning' : ($lg['actor_type'] === 'applicant' ? 'info' : 'secondary') ?>-subtle text-<?= $lg['actor_type'] === 'admin' ? 'warning' : ($lg['actor_type'] === 'applicant' ? 'info' : 'light') ?> me-1"><?= htmlspecialchars((string)$lg['actor_type']) ?></span>
                                <?= htmlspecialchars((string)($lg['actor_name'] ?? 'System')) ?>
                            </td>
                            <td class="font-monospace text-info"><?= htmlspecialchars((string)$lg['action']) ?></td>
                            <td class="text-muted"><?= htmlspecialchars((string)$lg['entity_type']) ?> <?= $lg['entity_id'] ? '#' . htmlspecialchars((string)$lg['entity_id']) : '' ?></td>
                            <td class="text-white"><?= htmlspecialchars((string)$lg['summary']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
