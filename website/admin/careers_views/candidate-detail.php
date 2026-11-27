<?php
declare(strict_types=1);

use App\Careers\ApplicationService;
use App\Careers\CareersDB;
use App\Careers\RecruitmentAuthService;

$appId = (int)($_GET['id'] ?? 0);
$app = $appId > 0 ? ApplicationService::getApplicationDetail($appId) : null;
if (!$app) {
    echo '<div class="alert alert-danger">Application record not found.</div>';
    echo '<a href="' . admin_url('careers?tab=applications') . '" class="btn btn-outline-light btn-sm">Back to Applications</a>';
    return;
}

$canManage = current_admin_can('careers.applications.manage');
$canInterview = current_admin_can('careers.interviews.manage');
$canExport = current_admin_can('careers.candidates.export');
$staffUsers = RecruitmentAuthService::listAdminUsers();
$stMeta = CareersDB::PIPELINE_STATUSES[$app['status']] ?? ['label' => $app['status'], 'badge' => 'secondary'];
$tagsArr = !empty($app['tags_json']) ? json_decode((string)$app['tags_json'], true) : [];
$tagsCsv = is_array($tagsArr) ? implode(', ', $tagsArr) : '';
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <a href="<?= admin_url('careers?tab=applications') ?>" class="text-info text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> All Applications</a>
        <h4 class="fw-bold mb-0 mt-1">
            <?= htmlspecialchars((string)$app['full_name']) ?>
            <span class="badge bg-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?>-subtle text-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?> ms-2 fs-6"><?= htmlspecialchars($stMeta['label']) ?></span>
        </h4>
        <div class="small text-muted font-monospace">
            Ref: <?= htmlspecialchars((string)$app['reference_code']) ?> &bull; Applied for: <strong class="text-white"><?= htmlspecialchars((string)$app['job_title']) ?></strong> &bull; Submitted: <?= htmlspecialchars((string)$app['submitted_at']) ?>
        </div>
    </div>

    <div class="d-flex gap-2">
        <?php if ($canExport && !empty($app['resume_path'])): ?>
            <a href="<?= admin_url('careers?tab=resume&app_id=' . (int)$app['id']) ?>" class="btn btn-outline-info btn-sm">
                <i class="bi bi-file-earmark-arrow-down me-1"></i> Download Resume / CV
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($app['deletion_requested_at'])): ?>
    <div class="alert alert-danger mb-4">
        <i class="bi bi-exclamation-octagon-fill me-2"></i>
        <strong>Data Deletion Request Pending:</strong> Requested at <?= htmlspecialchars((string)$app['deletion_requested_at']) ?> — Reason: <?= htmlspecialchars((string)($app['deletion_request_reason'] ?? 'N/A')) ?>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- LEFT COLUMN: Profile + Answers + Interviews + Messages -->
    <div class="col-12 col-xl-7 d-flex flex-column gap-4">
        <!-- Candidate Contact Overview -->
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Candidate Profile</div>
            <div class="card-body row g-3 small">
                <div class="col-md-6"><span class="text-muted d-block">Email</span><strong><?= htmlspecialchars((string)$app['email']) ?></strong></div>
                <div class="col-md-6"><span class="text-muted d-block">Phone</span><strong><?= htmlspecialchars((string)($app['phone'] ?: '—')) ?></strong></div>
                <div class="col-md-6"><span class="text-muted d-block">Location</span><strong><?= htmlspecialchars(trim(($app['city'] ?? '') . ', ' . ($app['country'] ?? ''), ', ') ?: '—') ?></strong></div>
                <div class="col-md-6"><span class="text-muted d-block">Experience / Employment</span><strong><?= htmlspecialchars((string)($app['years_of_experience'] !== null ? $app['years_of_experience'] . ' yrs' : '—')) ?> &bull; <?= htmlspecialchars((string)($app['employment_status'] ?: '—')) ?></strong></div>
                <?php if (!empty($app['linkedin_url'])): ?>
                    <div class="col-md-6"><span class="text-muted d-block">LinkedIn</span><a href="<?= htmlspecialchars((string)$app['linkedin_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-info text-break"><?= htmlspecialchars((string)$app['linkedin_url']) ?></a></div>
                <?php endif; ?>
                <?php if (!empty($app['portfolio_url'])): ?>
                    <div class="col-md-6"><span class="text-muted d-block">Portfolio / GitHub</span><a href="<?= htmlspecialchars((string)$app['portfolio_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-info text-break"><?= htmlspecialchars((string)$app['portfolio_url']) ?></a></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Submitted Dynamic Form Answers -->
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Application Form Responses</div>
            <div class="card-body d-flex flex-column gap-3">
                <?php foreach ($app['answers'] as $ans): ?>
                    <div class="p-2 rounded-2" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.05);">
                        <div class="small text-muted mb-1"><?= htmlspecialchars((string)$ans['field_label']) ?></div>
                        <?php if ($ans['field_type'] === 'file' && !empty($ans['file_path'])): ?>
                            <?php if ($canExport): ?>
                                <a href="<?= admin_url('careers?tab=resume&app_id=' . (int)$app['id'] . '&answer_id=' . (int)$ans['id']) ?>" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-paperclip me-1"></i> <?= htmlspecialchars((string)$ans['file_original_name']) ?>
                                </a>
                            <?php else: ?>
                                <span class="text-muted small"><?= htmlspecialchars((string)$ans['file_original_name']) ?> (Download restricted)</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="text-white small" style="white-space:pre-line;"><?= htmlspecialchars((string)($ans['answer_text'] !== '' ? $ans['answer_text'] : '—')) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Interviews -->
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Interview Schedules</div>
            <div class="card-body">
                <?php if (!empty($app['interviews'])): ?>
                    <div class="d-flex flex-column gap-2 mb-4">
                        <?php foreach ($app['interviews'] as $intv): ?>
                            <div class="p-3 rounded-2" style="background:rgba(11,94,215,0.08);border:1px solid rgba(11,94,215,0.28);">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars((string)$intv['interview_round']) ?> <span class="badge bg-info-subtle text-info ms-1"><?= strtoupper(htmlspecialchars((string)$intv['status'])) ?></span></div>
                                        <div class="small text-light-emphasis mt-1"><i class="bi bi-calendar3 me-1"></i> <?= htmlspecialchars((string)$intv['scheduled_at']) ?> (<?= htmlspecialchars((string)$intv['timezone']) ?>) &bull; <?= (int)$intv['duration_minutes'] ?> mins &bull; <?= ucfirst(str_replace('_', ' ', (string)$intv['interview_mode'])) ?></div>
                                        <div class="small text-muted">Interviewer: <?= htmlspecialchars((string)$intv['interviewer_name']) ?></div>
                                        <?php if (!empty($intv['meeting_link'])): ?>
                                            <div class="small mt-1"><a href="<?= htmlspecialchars((string)$intv['meeting_link']) ?>" target="_blank" rel="noopener noreferrer" class="text-info"><?= htmlspecialchars((string)$intv['meeting_link']) ?></a></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($canInterview): ?>
                                        <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>" class="d-flex gap-1">
                                            <?= csrf_input_field() ?>
                                            <input type="hidden" name="action" value="update_interview_status">
                                            <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">
                                            <input type="hidden" name="interview_id" value="<?= (int)$intv['id'] ?>">
                                            <select name="interview_status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                                                <?php foreach (['scheduled', 'rescheduled', 'completed', 'cancelled'] as $is): ?>
                                                    <option value="<?= $is ?>" <?= $intv['status'] === $is ? 'selected' : '' ?>><?= ucfirst($is) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($canInterview): ?>
                    <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>" class="row g-2">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="schedule_interview">
                        <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">
                        <div class="col-md-6">
                            <label class="form-label small">Interview Round</label>
                            <input type="text" name="interview_round" class="form-control form-control-sm" value="Technical &amp; Culture Interview" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Mode</label>
                            <select name="interview_mode" class="form-select form-select-sm">
                                <option value="video">Video Call</option>
                                <option value="phone">Phone Screen</option>
                                <option value="technical_panel">Technical Panel</option>
                                <option value="onsite">On-Site</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small">Date &amp; Time *</label>
                            <input type="datetime-local" name="scheduled_at" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small">Duration (min)</label>
                            <input type="number" name="duration_minutes" class="form-control form-control-sm" value="45" min="15" max="240">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Timezone</label>
                            <input type="text" name="timezone" class="form-control form-control-sm" value="Asia/Kolkata">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Interviewer Name *</label>
                            <input type="text" name="interviewer_name" class="form-control form-control-sm" value="<?= htmlspecialchars($actorName) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Meeting Link / Location</label>
                            <input type="text" name="meeting_link" class="form-control form-control-sm" placeholder="https://meet.google.com/...">
                        </div>
                        <div class="col-12">
                            <label class="form-label small">Preparation Instructions for Candidate</label>
                            <textarea name="instructions" rows="2" class="form-control form-control-sm" placeholder="Shown inside Applicant Portal & invitation email..."></textarea>
                        </div>
                        <div class="col-12 text-end mt-2">
                            <button type="submit" class="btn btn-sm btn-cx-primary"><i class="bi bi-calendar-plus me-1"></i> Schedule Interview &amp; Notify Candidate</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Candidate Public Messages (Visible in Portal) -->
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Candidate Communication Thread (Visible in Portal)</div>
            <div class="card-body">
                <?php if (empty($app['messages'])): ?>
                    <p class="small text-muted">No messages exchanged yet.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2 mb-3">
                        <?php foreach ($app['messages'] as $msg): ?>
                            <div class="p-2 rounded-2" style="background:<?= $msg['sender_type'] === 'recruiter' ? 'rgba(11,94,215,0.12)' : 'rgba(255,255,255,0.04)' ?>;border:1px solid rgba(255,255,255,0.08);">
                                <div class="d-flex justify-content-between small mb-1">
                                    <strong class="text-white"><?= htmlspecialchars((string)$msg['sender_name']) ?> (<?= ucfirst($msg['sender_type']) ?>)</strong>
                                    <span class="text-muted"><?= htmlspecialchars((string)$msg['created_at']) ?></span>
                                </div>
                                <div class="small text-light" style="white-space:pre-line;"><?= htmlspecialchars((string)$msg['message_body']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($canManage): ?>
                    <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="send_candidate_message">
                        <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">
                        <input type="text" name="subject" class="form-control form-control-sm mb-2" placeholder="Message subject...">
                        <textarea name="message_body" rows="2" class="form-control form-control-sm mb-2" placeholder="Send a message to candidate portal + email..." required></textarea>
                        <button type="submit" class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">Send Message to Candidate</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Pipeline Transition, Assignment, Tags, Private Notes, History -->
    <div class="col-12 col-xl-5 d-flex flex-column gap-4">
        <?php if ($canManage): ?>
            <!-- Pipeline Stage Transition -->
            <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.75);border:1px solid rgba(255,181,71,0.28) !important;">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-warning" style="border-color:rgba(255,255,255,0.08) !important;">Pipeline Stage Control</div>
                <div class="card-body">
                    <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="update_application_status">
                        <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">

                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Update Stage</label>
                            <select name="status" class="form-select form-select-sm">
                                <?php foreach (CareersDB::PIPELINE_STATUSES as $stKey => $stInfo): ?>
                                    <option value="<?= $stKey ?>" <?= $app['status'] === $stKey ? 'selected' : '' ?>><?= htmlspecialchars($stInfo['label']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Public Candidate Note (shown in Applicant Portal)</label>
                            <textarea name="public_note" rows="2" class="form-control form-control-sm" placeholder="Optional feedback or timeline update..."></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Internal Staff Note (private)</label>
                            <textarea name="internal_note" rows="2" class="form-control form-control-sm" placeholder="Private evaluation context..."></textarea>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="send_email" id="sendStatusEmail" value="1" checked>
                            <label class="form-check-label small" for="sendStatusEmail">Notify candidate by email</label>
                        </div>
                        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold text-dark">Update Pipeline Stage</button>
                    </form>
                </div>
            </div>

            <!-- Recruiter Assignment & Candidate Tags -->
            <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Assignment &amp; Classification</div>
                <div class="card-body">
                    <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>" class="mb-3">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="assign_recruiter">
                        <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">
                        <label class="form-label small">Assigned Recruiter / Reviewer</label>
                        <div class="input-group input-group-sm">
                            <select name="recruiter_user_id" class="form-select">
                                <option value="">Unassigned</option>
                                <?php foreach ($staffUsers as $su): ?>
                                    <option value="<?= htmlspecialchars((string)$su['id']) ?>" <?= ($app['assigned_recruiter_id'] ?? '') === $su['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars((string)$su['name']) ?> (<?= htmlspecialchars((string)$su['role']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-outline-info">Assign</button>
                        </div>
                    </form>

                    <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="update_candidate_tags">
                        <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">
                        <input type="hidden" name="candidate_id" value="<?= (int)$app['candidate_id'] ?>">
                        <label class="form-label small">Candidate Tags (comma-separated)</label>
                        <input type="text" name="tags_csv" class="form-control form-control-sm mb-2" value="<?= htmlspecialchars($tagsCsv) ?>" placeholder="e.g., strong-php, immediate, top-5">
                        <label class="form-label small">Candidate Flag</label>
                        <select name="status_flag" class="form-select form-select-sm mb-2">
                            <option value="active" <?= ($app['status_flag'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active Candidate</option>
                            <option value="talent_pool" <?= ($app['status_flag'] ?? '') === 'talent_pool' ? 'selected' : '' ?>>General Talent Pool</option>
                            <option value="blacklisted" <?= ($app['status_flag'] ?? '') === 'blacklisted' ? 'selected' : '' ?>>Restricted / Blacklisted</option>
                        </select>
                        <button type="submit" class="btn btn-outline-secondary btn-sm w-100">Save Classification</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Private Recruiter Notes -->
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Private Recruiter Notes (Hidden from Applicant)</div>
            <div class="card-body">
                <?php if ($canManage): ?>
                    <form method="POST" action="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>" class="mb-3">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="add_recruiter_note">
                        <input type="hidden" name="application_id" value="<?= (int)$app['id'] ?>">
                        <input type="hidden" name="candidate_id" value="<?= (int)$app['candidate_id'] ?>">
                        <textarea name="note_text" rows="2" class="form-control form-control-sm mb-2" placeholder="Write private evaluation note..." required></textarea>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_pinned" id="pinNote" value="1">
                                <label class="form-check-label small" for="pinNote">Pin note</label>
                            </div>
                            <button type="submit" class="btn btn-outline-warning btn-sm">Add Private Note</button>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if (empty($app['notes'])): ?>
                    <p class="small text-muted mb-0">No internal notes recorded.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($app['notes'] as $note): ?>
                            <div class="p-2 rounded-2" style="background:rgba(255,181,71,0.06);border:1px solid rgba(255,181,71,0.18);">
                                <div class="d-flex justify-content-between small mb-1">
                                    <strong class="text-warning"><?= !empty($note['is_pinned']) ? '<i class="bi bi-pin-fill me-1"></i>' : '' ?><?= htmlspecialchars((string)$note['author_name']) ?></strong>
                                    <span class="text-muted"><?= htmlspecialchars((string)$note['created_at']) ?></span>
                                </div>
                                <div class="small text-light" style="white-space:pre-line;"><?= htmlspecialchars((string)$note['note_text']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status Audit History -->
        <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom py-3 fw-bold small text-uppercase text-info" style="border-color:rgba(255,255,255,0.08) !important;">Pipeline Timeline History</div>
            <div class="card-body d-flex flex-column gap-2">
                <?php foreach ($app['history'] as $h): ?>
                    <div class="border-start border-primary ps-2 py-1 small" style="border-width:2px !important;">
                        <div class="fw-semibold text-white">
                            <?= htmlspecialchars((string)(CareersDB::PIPELINE_STATUSES[$h['to_status']]['label'] ?? $h['to_status'])) ?>
                            <span class="text-muted fw-normal">by <?= htmlspecialchars((string)($h['changed_by_name'] ?? $h['changed_by_type'])) ?></span>
                        </div>
                        <?php if (!empty($h['public_note'])): ?>
                            <div class="text-info">Public: <?= htmlspecialchars((string)$h['public_note']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($h['internal_note'])): ?>
                            <div class="text-warning">Internal: <?= htmlspecialchars((string)$h['internal_note']) ?></div>
                        <?php endif; ?>
                        <div class="text-muted" style="font-size:0.72rem;"><?= htmlspecialchars((string)$h['created_at']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
