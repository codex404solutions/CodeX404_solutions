<?php
declare(strict_types=1);

use App\Careers\RecruitmentEmailService;

$templates = RecruitmentEmailService::listTemplates();
$logs = RecruitmentEmailService::listLogs(60);
$editTplId = (int)($_GET['edit_tpl'] ?? 0);
$editingTpl = null;
foreach ($templates as $tpl) {
    if ((int)$tpl['id'] === $editTplId) {
        $editingTpl = $tpl;
        break;
    }
}
?>

<div class="row g-4">
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm mb-4" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">
                Editable Recruitment Email Templates
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($templates as $tpl): ?>
                    <div class="list-group-item bg-transparent text-light border-secondary-subtle d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold small"><?= htmlspecialchars((string)$tpl['name']) ?></div>
                            <div class="font-monospace text-info" style="font-size:0.72rem;"><?= htmlspecialchars((string)$tpl['template_key']) ?> &bull; <?= !empty($tpl['is_active']) ? 'Active' : 'Disabled' ?></div>
                            <div class="small text-muted"><?= htmlspecialchars((string)$tpl['subject']) ?></div>
                        </div>
                        <a href="<?= admin_url('careers?tab=emails&edit_tpl=' . (int)$tpl['id']) ?>" class="btn btn-outline-info btn-sm">Edit</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <?php if ($editingTpl): ?>
            <div class="card border-0 shadow-sm mb-4" style="background:rgba(15,23,42,0.78);border:1px solid rgba(11,94,215,0.4) !important;">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-warning" style="border-color:rgba(255,255,255,0.08) !important;">
                    Editing: <?= htmlspecialchars((string)$editingTpl['name']) ?>
                </div>
                <div class="card-body">
                    <div class="alert alert-dark small py-2 mb-3">
                        Supported Variables: <code class="text-info"><?= htmlspecialchars((string)$editingTpl['variables_help']) ?></code>
                    </div>
                    <form method="POST" action="<?= admin_url('careers?tab=emails') ?>">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="update_email_template">
                        <input type="hidden" name="template_id" value="<?= (int)$editingTpl['id'] ?>">

                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Subject Line *</label>
                            <input type="text" name="subject" class="form-control form-control-sm" value="<?= htmlspecialchars((string)$editingTpl['subject']) ?>" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">HTML Body *</label>
                            <textarea name="body_html" rows="6" class="form-control form-control-sm font-monospace" required><?= htmlspecialchars((string)$editingTpl['body_html']) ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Plain Text Body *</label>
                            <textarea name="body_text" rows="4" class="form-control form-control-sm font-monospace" required><?= htmlspecialchars((string)$editingTpl['body_text']) ?></textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="tplActive" value="1" <?= !empty($editingTpl['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="tplActive">Template Enabled</label>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= admin_url('careers?tab=emails') ?>" class="btn btn-outline-secondary btn-sm">Close</a>
                            <button type="submit" class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">Save Template</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Email Dispatch Logs</div>
            <div class="table-responsive" style="max-height:460px;">
                <table class="table table-dark table-sm table-hover align-middle mb-0" style="background:transparent;">
                    <thead>
                        <tr class="small text-muted">
                            <th>Recipient</th>
                            <th>Subject</th>
                            <th>Status / Transport</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logs)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No email logs recorded yet.</td></tr>
                        <?php else: ?>
                            <?php foreach ($logs as $lg): ?>
                                <tr class="small">
                                    <td>
                                        <div class="text-white"><?= htmlspecialchars((string)$lg['recipient_email']) ?></div>
                                        <div class="font-monospace text-muted" style="font-size:0.7rem;"><?= htmlspecialchars((string)($lg['template_key'] ?? 'custom')) ?></div>
                                    </td>
                                    <td><?= htmlspecialchars((string)$lg['subject']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $lg['status'] === 'sent' ? 'success' : ($lg['status'] === 'failed' ? 'danger' : 'info') ?>-subtle text-<?= $lg['status'] === 'sent' ? 'success' : ($lg['status'] === 'failed' ? 'danger' : 'info') ?>">
                                            <?= htmlspecialchars((string)$lg['status']) ?> (<?= htmlspecialchars((string)$lg['transport']) ?>)
                                        </span>
                                    </td>
                                    <td class="text-muted"><?= htmlspecialchars((string)$lg['created_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
