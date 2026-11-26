<?php
declare(strict_types=1);

use App\Careers\CareersDB;
use App\Careers\FormBuilderService;
use App\Careers\VacancyService;

$templates = FormBuilderService::listTemplates();
$jobs = VacancyService::listAdminVacancies();

$selectedJobId = (int)($_GET['job_id'] ?? 0);
$selectedTplId = (int)($_GET['template_id'] ?? 0);

$targetJob = $selectedJobId > 0 ? VacancyService::getById($selectedJobId) : null;
if ($targetJob) {
    // Ensure custom fields exist when inspecting a job form
    $fields = FormBuilderService::getFieldsByJob((int)$targetJob['id'], false);
    if (empty($fields)) {
        $fallbackTplId = (int)($targetJob['form_template_id'] ?? ($templates[0]['id'] ?? 1));
        FormBuilderService::ensureJobHasCustomFieldsFromTemplate((int)$targetJob['id'], $fallbackTplId);
        $fields = FormBuilderService::getFieldsByJob((int)$targetJob['id'], false);
    }
    $contextMode = 'job';
    $contextLabel = 'Per-Job Custom Form: ' . $targetJob['title'];
} else {
    if ($selectedTplId <= 0 && !empty($templates)) {
        $selectedTplId = (int)$templates[0]['id'];
    }
    $fields = $selectedTplId > 0 ? FormBuilderService::getFieldsByTemplate($selectedTplId, false) : [];
    $contextMode = 'template';
    $tplMatch = array_values(array_filter($templates, fn($t) => (int)$t['id'] === $selectedTplId));
    $contextLabel = 'Form Template: ' . ($tplMatch[0]['name'] ?? 'Default');
}

$editFieldId = (int)($_GET['edit_field'] ?? 0);
$editingField = null;
foreach ($fields as $f) {
    if ((int)$f['id'] === $editFieldId) {
        $editingField = $f;
        break;
    }
}
?>

<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm h-100" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-body">
                <label class="form-label small fw-bold text-uppercase text-info">1. Edit Reusable Form Template</label>
                <div class="d-flex flex-wrap gap-1 mb-3">
                    <?php foreach ($templates as $tpl): ?>
                        <?php $activeTpl = ($contextMode === 'template' && (int)$tpl['id'] === $selectedTplId); ?>
                        <a href="<?= admin_url('careers?tab=form-builder&template_id=' . (int)$tpl['id']) ?>"
                           class="btn btn-sm <?= $activeTpl ? 'btn-primary' : 'btn-outline-secondary' ?>">
                            <?= htmlspecialchars((string)$tpl['name']) ?> (<?= (int)$tpl['active_field_count'] ?>)
                        </a>
                    <?php endforeach; ?>
                </div>
                <form method="GET" class="d-flex gap-2 align-items-center">
                    <input type="hidden" name="tab" value="form-builder">
                    <select name="job_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="0">Or customize a specific Vacancy's form...</option>
                        <?php foreach ($jobs as $jb): ?>
                            <option value="<?= (int)$jb['id'] ?>" <?= $selectedJobId === (int)$jb['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars((string)$jb['title']) ?> <?= !empty($jb['use_custom_form']) ? '(Custom Active)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-body">
                <label class="form-label small fw-bold text-uppercase text-warning">Create New Reusable Form Template</label>
                <form method="POST" action="<?= admin_url('careers?tab=form-builder') ?>" class="row g-2">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="action" value="create_form_template">
                    <div class="col-md-4">
                        <input type="text" name="template_name" class="form-control form-control-sm" placeholder="Template name..." required>
                    </div>
                    <div class="col-md-3">
                        <select name="template_type" class="form-select form-select-sm">
                            <option value="custom">Custom</option>
                            <option value="marketing">Marketing</option>
                            <option value="sales">Sales</option>
                            <option value="internship">Internship</option>
                            <option value="fellowship">Fellowship</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="clone_from_id" class="form-select form-select-sm">
                            <option value="">Start blank</option>
                            <?php foreach ($templates as $tpl): ?>
                                <option value="<?= (int)$tpl['id'] ?>">Clone: <?= htmlspecialchars((string)$tpl['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning btn-sm w-100 text-dark fw-semibold">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Field List -->
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3" style="border-color:rgba(255,255,255,0.08) !important;">
                <h5 class="mb-0 fw-bold fs-6"><?= htmlspecialchars($contextLabel) ?></h5>
                <span class="badge bg-info-subtle text-info"><?= count($fields) ?> Fields</span>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" style="background:transparent;">
                    <thead>
                        <tr class="small text-muted">
                            <th>Order</th>
                            <th>Field Label &amp; Key</th>
                            <th>Type</th>
                            <th>Rules</th>
                            <th class="text-end">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fields as $f): ?>
                            <tr>
                                <td class="small text-muted">#<?= (int)$f['sort_order'] ?></td>
                                <td>
                                    <div class="fw-semibold small"><?= htmlspecialchars((string)$f['label']) ?></div>
                                    <div class="font-monospace text-info" style="font-size:0.72rem;"><?= htmlspecialchars((string)$f['field_key']) ?> &bull; <?= htmlspecialchars((string)$f['step_section']) ?></div>
                                </td>
                                <td class="small"><span class="badge bg-secondary-subtle text-light"><?= htmlspecialchars(CareersDB::FIELD_TYPES[$f['field_type']] ?? $f['field_type']) ?></span></td>
                                <td class="small">
                                    <?= !empty($f['is_required']) ? '<span class="badge bg-danger-subtle text-danger">Required</span>' : '<span class="badge bg-dark text-muted">Optional</span>' ?>
                                    <?= empty($f['is_enabled']) ? '<span class="badge bg-warning-subtle text-warning ms-1">Disabled</span>' : '' ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="<?= admin_url('careers?tab=form-builder&' . ($contextMode === 'job' ? 'job_id=' . $selectedJobId : 'template_id=' . $selectedTplId) . '&edit_field=' . (int)$f['id']) ?>" class="btn btn-outline-info btn-sm"><i class="bi bi-pencil"></i></a>
                                        <?php if (empty($f['is_system_core'])): ?>
                                            <form method="POST" action="<?= admin_url('careers?tab=form-builder') ?>" class="d-inline" onsubmit="return confirm('Remove this custom field?');">
                                                <?= csrf_input_field() ?>
                                                <input type="hidden" name="action" value="delete_form_field">
                                                <input type="hidden" name="field_id" value="<?= (int)$f['id'] ?>">
                                                <?php if ($contextMode === 'job'): ?>
                                                    <input type="hidden" name="job_opening_id" value="<?= $selectedJobId ?>">
                                                <?php else: ?>
                                                    <input type="hidden" name="template_id" value="<?= $selectedTplId ?>">
                                                <?php endif; ?>
                                                <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add / Edit Field Editor -->
    <div class="col-12 col-xl-5">
        <?php
        $ef = $editingField ?: [
            'id' => 0, 'field_key' => '', 'label' => '', 'field_type' => 'short_text',
            'placeholder' => '', 'help_text' => '', 'options' => [], 'validation_rules' => [],
            'is_required' => 1, 'is_enabled' => 1, 'step_section' => 'Role Questions', 'width_col' => 'full',
            'sort_order' => (count($fields) + 1) * 10,
        ];
        ?>
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.78);border:1px solid rgba(34,211,238,0.28) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">
                <?= $editingField ? 'Edit Field: ' . htmlspecialchars((string)$ef['label']) : 'Add New Dynamic Field' ?>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= admin_url('careers?tab=form-builder') ?>" class="row g-2">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="action" value="save_form_field">
                    <input type="hidden" name="id" value="<?= (int)$ef['id'] ?>">
                    <?php if ($contextMode === 'job'): ?>
                        <input type="hidden" name="job_opening_id" value="<?= $selectedJobId ?>">
                    <?php else: ?>
                        <input type="hidden" name="template_id" value="<?= $selectedTplId ?>">
                    <?php endif; ?>

                    <div class="col-md-7">
                        <label class="form-label small fw-semibold">Field Label *</label>
                        <input type="text" name="label" class="form-control form-control-sm" value="<?= htmlspecialchars((string)$ef['label']) ?>" required placeholder="e.g., Portfolio Link">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">Field Type *</label>
                        <select name="field_type" class="form-select form-select-sm">
                            <?php foreach (CareersDB::FIELD_TYPES as $tKey => $tLabel): ?>
                                <option value="<?= $tKey ?>" <?= $ef['field_type'] === $tKey ? 'selected' : '' ?>><?= htmlspecialchars($tLabel) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Machine Key</label>
                        <input type="text" name="field_key" class="form-control form-control-sm font-monospace" value="<?= htmlspecialchars((string)$ef['field_key']) ?>" placeholder="auto from label">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Section Group</label>
                        <input type="text" name="step_section" class="form-control form-control-sm" value="<?= htmlspecialchars((string)$ef['step_section']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Placeholder</label>
                        <input type="text" name="placeholder" class="form-control form-control-sm" value="<?= htmlspecialchars((string)($ef['placeholder'] ?? '')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Width</label>
                        <select name="width_col" class="form-select form-select-sm">
                            <option value="full" <?= ($ef['width_col'] ?? 'full') === 'full' ? 'selected' : '' ?>>Full</option>
                            <option value="half" <?= ($ef['width_col'] ?? '') === 'half' ? 'selected' : '' ?>>Half</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Order</label>
                        <input type="number" name="sort_order" class="form-control form-control-sm" value="<?= (int)$ef['sort_order'] ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Help Text</label>
                        <input type="text" name="help_text" class="form-control form-control-sm" value="<?= htmlspecialchars((string)($ef['help_text'] ?? '')) ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label small">Options (one per line — for Dropdown, Radio, Checkboxes)</label>
                        <textarea name="options_raw" rows="3" class="form-control form-control-sm font-monospace" placeholder="Option A&#10;Option B"><?= htmlspecialchars(implode("\n", (array)($ef['options'] ?? []))) ?></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Min Len</label>
                        <input type="number" name="min_length" class="form-control form-control-sm" value="<?= htmlspecialchars((string)($ef['validation_rules']['min_length'] ?? '')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Max Len</label>
                        <input type="number" name="max_length" class="form-control form-control-sm" value="<?= htmlspecialchars((string)($ef['validation_rules']['max_length'] ?? '')) ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end pb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_required" id="fReq" value="1" <?= !empty($ef['is_required']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="fReq">Required</label>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end pb-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_enabled" id="fEn" value="1" <?= !empty($ef['is_enabled']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="fEn">Enabled</label>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <?php if ($editingField): ?>
                            <a href="<?= admin_url('careers?tab=form-builder&' . ($contextMode === 'job' ? 'job_id=' . $selectedJobId : 'template_id=' . $selectedTplId)) ?>" class="btn btn-outline-secondary btn-sm">Cancel Edit</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-sm px-3" style="background:#0B5ED7;border-color:#0B5ED7;">Save Field</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
