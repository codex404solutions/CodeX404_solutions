<?php
declare(strict_types=1);

use App\Careers\RecruitmentSettingsService;

$settingsDetailed = RecruitmentSettingsService::getAllDetailed();
?>

<div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
    <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">
        Recruitment System &amp; Applicant Portal Settings
    </div>
    <div class="card-body">
        <form method="POST" action="<?= admin_url('careers?tab=settings') ?>" class="row g-3">
            <?= csrf_input_field() ?>
            <input type="hidden" name="action" value="save_recruitment_settings">

            <?php foreach ($settingsDetailed as $k => $row): ?>
                <?php if (in_array($k, ['allow_general_applications', 'enable_applicant_portal'], true)): ?>
                    <div class="col-md-6">
                        <div class="form-check form-switch p-3 rounded-2" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);">
                            <input class="form-check-input ms-0 me-2" type="checkbox" name="settings[<?= htmlspecialchars($k) ?>]" id="set_<?= htmlspecialchars($k) ?>" value="1" <?= $row['setting_value'] === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold small" for="set_<?= htmlspecialchars($k) ?>"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $k))) ?></label>
                            <div class="text-muted mt-1" style="font-size:0.75rem;"><?= htmlspecialchars((string)$row['description']) ?></div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold"><?= htmlspecialchars(ucwords(str_replace('_', ' ', $k))) ?></label>
                        <input type="text" name="settings[<?= htmlspecialchars($k) ?>]" class="form-control form-control-sm" value="<?= htmlspecialchars((string)$row['setting_value']) ?>">
                        <small class="text-muted"><?= htmlspecialchars((string)$row['description']) ?></small>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-primary px-4" style="background:#0B5ED7;border-color:#0B5ED7;">Save Recruitment Settings</button>
            </div>
        </form>
    </div>
</div>
