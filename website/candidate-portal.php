<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/config/Env.php';
Env::load(__DIR__ . '/.env');

use App\Careers\ApplicationService;
use App\Careers\CareersDB;
use App\Careers\RecruitmentAuthService;

if (($_GET['action'] ?? '') === 'logout') {
    RecruitmentAuthService::logoutApplicant();
    header('Location: ' . url('careers/application-status'));
    exit;
}

$applicant = RecruitmentAuthService::requireApplicantAuth();
$candidateId = (int)$applicant['id'];
$candidateName = (string)$applicant['full_name'];
$candidateEmail = (string)$applicant['email'];

$view = trim((string)($_GET['view'] ?? 'overview'));
$ref = trim((string)($_GET['ref'] ?? ''));

$flashSuccess = '';
$flashError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $flashError = 'Security token expired. Please refresh and try again.';
    } else {
        $postAction = trim((string)($_POST['portal_post_action'] ?? ''));
        try {
            switch ($postAction) {
                case 'withdraw':
                    ApplicationService::withdrawApplication(
                        $candidateId,
                        $candidateName,
                        $candidateEmail,
                        (int)($_POST['application_id'] ?? 0),
                        (string)($_POST['withdrawal_reason'] ?? '')
                    );
                    $flashSuccess = 'Your application has been withdrawn cleanly.';
                    break;
                case 'reply_message':
                    ApplicationService::addApplicantReplyMessage($candidateId, $candidateName, (int)($_POST['application_id'] ?? 0), (string)($_POST['message_body'] ?? ''));
                    $flashSuccess = 'Message sent to the CodeX404 recruitment team.';
                    break;
                case 'update_preferences':
                    ApplicationService::updateApplicantPreferences($candidateId, $candidateName, $_POST);
                    $applicant = RecruitmentAuthService::currentApplicant() ?? $applicant;
                    $flashSuccess = 'Contact details and notification preferences updated.';
                    break;
                case 'mark_notifications_read':
                    ApplicationService::markAllNotificationsRead($candidateId);
                    $flashSuccess = 'All notifications marked as read.';
                    break;
                case 'request_deletion':
                    ApplicationService::requestDataDeletion($candidateId, $candidateName, (string)($_POST['deletion_reason'] ?? ''));
                    $flashSuccess = 'Your data deletion request has been logged for our compliance team.';
                    break;
            }
        } catch (\Throwable $e) {
            $flashError = $e->getMessage();
        }
    }
}

$dashboard = ApplicationService::getApplicantDashboardData($candidateId);
$selectedApp = ($view === 'detail' && $ref !== '') ? ApplicationService::getApplicantApplicationByRef($candidateId, $ref) : null;

$pageMeta = [
    'title'       => 'Applicant Portal — CodeX404 Solutions Careers',
    'description' => 'Review your active CodeX404 job applications, status timeline, interview schedule, and recruiter messages.',
    'canonical'   => url('careers/candidate-portal'),
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top:calc(var(--nav-height,78px) + 3rem);padding-bottom:5rem;">
    <div class="container">
        <!-- Portal Top Bar -->
        <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:1rem;margin-bottom:2rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(255,255,255,0.09);">
            <div>
                <div class="careers-hero-eyebrow" style="margin-bottom:0.5rem;"><span>Verified Applicant Portal</span></div>
                <h1 style="font-size:1.75rem;color:#fff;font-weight:800;margin:0;">
                    Welcome, <span class="careers-amber-accent"><?= htmlspecialchars($candidateName) ?></span>
                </h1>
                <div style="font-size:0.86rem;color:#94A3B8;margin-top:0.25rem;">
                    Signed in as <?= htmlspecialchars($candidateEmail) ?> &bull; Unread notifications: <strong style="color:#22D3EE;"><?= $dashboard['unread_count'] ?></strong>
                </div>
            </div>

            <div style="display:flex;gap:0.6rem;flex-wrap:wrap;">
                <a href="<?= url('careers/candidate-portal') ?>" class="careers-filter-btn <?= $view === 'overview' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= url('careers/candidate-portal/applications') ?>" class="careers-filter-btn <?= $view === 'applications' ? 'active' : '' ?>">My Applications (<?= count($dashboard['applications']) ?>)</a>
                <a href="<?= url('careers') ?>#open-positions" class="careers-filter-btn">Browse Open Jobs</a>
                <a href="<?= url('careers/candidate-portal?action=logout') ?>" class="careers-filter-btn" style="border-color:rgba(239,68,68,0.35);color:#FCA5A5;">Sign Out</a>
            </div>
        </div>

        <?php if ($flashSuccess !== ''): ?>
            <div class="careers-alert careers-alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
        <?php endif; ?>
        <?php if ($flashError !== ''): ?>
            <div class="careers-alert careers-alert-error"><?= htmlspecialchars($flashError) ?></div>
        <?php endif; ?>

        <?php if ($view === 'detail'): ?>
            <?php if (!$selectedApp): ?>
                <div class="careers-alert careers-alert-error">Application record not found for your account.</div>
            <?php else: ?>
                <?php
                $stMeta = CareersDB::PIPELINE_STATUSES[$selectedApp['status']] ?? ['label' => $selectedApp['status'], 'step' => 0];
                $currentStep = (int)$stMeta['step'];
                $orderedSteps = [
                    1 => 'Submitted',
                    2 => 'Under Review',
                    3 => 'Shortlisted',
                    4 => 'Interview',
                    5 => 'Selected',
                    6 => 'Offer Sent',
                    7 => 'Hired',
                ];
                ?>
                <div style="margin-bottom:1.25rem;">
                    <a href="<?= url('careers/candidate-portal/applications') ?>" style="color:#22D3EE;text-decoration:none;font-size:0.9rem;">&larr; Back to My Applications</a>
                </div>

                <div class="careers-detail-panel" style="margin-bottom:1.75rem;">
                    <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:start;gap:1rem;">
                        <div>
                            <div class="careers-badge careers-badge-amber" style="margin-bottom:0.5rem;">Ref: <?= htmlspecialchars((string)$selectedApp['reference_code']) ?></div>
                            <h2 style="color:#fff;font-size:1.55rem;margin-bottom:0.35rem;"><?= htmlspecialchars((string)$selectedApp['job_title']) ?></h2>
                            <div style="color:#94A3B8;font-size:0.88rem;">
                                Current Stage: <strong style="color:#22D3EE;"><?= htmlspecialchars($stMeta['label']) ?></strong> &bull; Submitted <?= date('M j, Y H:i', strtotime((string)$selectedApp['submitted_at'])) ?>
                            </div>
                        </div>

                        <div style="display:flex;gap:0.65rem;flex-wrap:wrap;">
                            <?php if (!empty($selectedApp['resume_path'])): ?>
                                <a href="<?= url('careers/resume/' . (int)$selectedApp['id']) ?>" class="btn btn-secondary btn-sm">Download Submitted Resume</a>
                            <?php endif; ?>
                            <?php if (!in_array($selectedApp['status'], ['hired', 'withdrawn'], true)): ?>
                                <button type="button" class="btn btn-sm" style="background:rgba(239,68,68,0.16);border:1px solid rgba(239,68,68,0.4);color:#FCA5A5;"
                                        onclick="document.getElementById('withdrawBox').style.display='block';">
                                    Withdraw Application
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!in_array($selectedApp['status'], ['rejected', 'withdrawn'], true)): ?>
                        <div class="portal-progress-steps">
                            <?php foreach ($orderedSteps as $stepNum => $stepLabel): ?>
                                <?php
                                $cls = '';
                                if ($currentStep === $stepNum) {
                                    $cls = 'current';
                                } elseif ($currentStep > $stepNum) {
                                    $cls = 'done';
                                }
                                ?>
                                <div class="portal-step-pill <?= $cls ?>"><?= htmlspecialchars($stepLabel) ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div id="withdrawBox" style="display:none;margin-top:1rem;padding:1rem;border-radius:12px;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.3);">
                        <form method="POST" action="<?= url('careers/candidate-portal/applications/' . urlencode((string)$selectedApp['reference_code'])) ?>">
                            <?= csrf_input_field() ?>
                            <input type="hidden" name="portal_post_action" value="withdraw">
                            <input type="hidden" name="application_id" value="<?= (int)$selectedApp['id'] ?>">
                            <label class="careers-label">Optional reason for withdrawing</label>
                            <input type="text" name="withdrawal_reason" class="careers-input" style="margin-bottom:0.75rem;" placeholder="e.g., Accepted another opportunity">
                            <button type="submit" class="btn btn-sm" style="background:#DC2626;color:#fff;border:none;">Confirm Withdrawal</button>
                        </form>
                    </div>
                </div>

                <div class="careers-detail-layout">
                    <div class="careers-detail-panel">
                        <h3 style="color:#fff;font-size:1.15rem;margin-bottom:1rem;">Status Timeline</h3>
                        <div class="portal-timeline">
                            <?php foreach ($selectedApp['history'] as $h): ?>
                                <?php $hLabel = CareersDB::PIPELINE_STATUSES[$h['to_status']]['label'] ?? $h['to_status']; ?>
                                <div class="portal-timeline-item">
                                    <div style="font-weight:700;color:#fff;font-size:0.94rem;"><?= htmlspecialchars($hLabel) ?></div>
                                    <?php if (!empty($h['public_note'])): ?>
                                        <div style="color:#CBD5E1;font-size:0.86rem;margin-top:0.25rem;"><?= htmlspecialchars((string)$h['public_note']) ?></div>
                                    <?php endif; ?>
                                    <div style="color:#94A3B8;font-size:0.75rem;margin-top:0.25rem;"><?= htmlspecialchars((string)$h['created_at']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (!empty($selectedApp['interviews'])): ?>
                            <h3 style="color:#fff;font-size:1.15rem;margin:1.75rem 0 1rem;">Interview Schedule</h3>
                            <?php foreach ($selectedApp['interviews'] as $intv): ?>
                                <div class="careers-card" style="margin-bottom:0.85rem;border-color:rgba(34,211,238,0.3);">
                                    <div style="font-weight:700;color:#FF8C00;margin-bottom:0.35rem;"><?= htmlspecialchars((string)$intv['interview_round']) ?> (<?= ucfirst((string)$intv['status']) ?>)</div>
                                    <div style="font-size:0.9rem;color:#fff;"><?= htmlspecialchars((string)$intv['scheduled_at']) ?> (<?= htmlspecialchars((string)$intv['timezone']) ?>) &bull; <?= (int)$intv['duration_minutes'] ?> mins</div>
                                    <div style="font-size:0.85rem;color:#CBD5E1;">Interviewer: <?= htmlspecialchars((string)$intv['interviewer_name']) ?></div>
                                    <?php if (!empty($intv['meeting_link'])): ?>
                                        <div style="margin-top:0.45rem;"><a href="<?= htmlspecialchars((string)$intv['meeting_link']) ?>" target="_blank" rel="noopener noreferrer" style="color:#22D3EE;">Join Meeting Link &rarr;</a></div>
                                    <?php endif; ?>
                                    <?php if (!empty($intv['instructions'])): ?>
                                        <p style="font-size:0.84rem;color:#94A3B8;margin:0.5rem 0 0;"><?= nl2br(htmlspecialchars((string)$intv['instructions'])) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="careers-form-panel">
                        <h3 style="color:#fff;font-size:1.15rem;margin-bottom:1rem;">Messages with Recruitment Team</h3>
                        <?php if (empty($selectedApp['messages'])): ?>
                            <p style="color:#94A3B8;font-size:0.88rem;margin-bottom:1rem;">No messages yet. If you need to share an update or reschedule question, send a note below.</p>
                        <?php else: ?>
                            <div style="display:flex;flex-direction:column;gap:0.7rem;margin-bottom:1.1rem;">
                                <?php foreach ($selectedApp['messages'] as $msg): ?>
                                    <div style="padding:0.8rem;border-radius:10px;background:<?= $msg['sender_type'] === 'recruiter' ? 'rgba(11,94,215,0.16)' : 'rgba(255,255,255,0.04)' ?>;border:1px solid rgba(255,255,255,0.09);">
                                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;color:#94A3B8;margin-bottom:0.25rem;">
                                            <strong style="color:#fff;"><?= htmlspecialchars((string)$msg['sender_name']) ?></strong>
                                            <span><?= htmlspecialchars((string)$msg['created_at']) ?></span>
                                        </div>
                                        <div style="font-size:0.9rem;color:#E2E8F0;white-space:pre-line;"><?= htmlspecialchars((string)$msg['message_body']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?= url('careers/candidate-portal/applications/' . urlencode((string)$selectedApp['reference_code'])) ?>">
                            <?= csrf_input_field() ?>
                            <input type="hidden" name="portal_post_action" value="reply_message">
                            <input type="hidden" name="application_id" value="<?= (int)$selectedApp['id'] ?>">
                            <textarea name="message_body" rows="3" class="careers-input careers-textarea" placeholder="Write a message to our recruitment team..." required style="margin-bottom:0.75rem;"></textarea>
                            <button type="submit" class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">Send Message</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <!-- OVERVIEW OR APPLICATIONS LIST -->
            <div class="careers-detail-layout">
                <div style="display:flex;flex-direction:column;gap:1.5rem;">
                    <div class="careers-detail-panel">
                        <h2 style="color:#fff;font-size:1.25rem;margin-bottom:1rem;">Your Applications</h2>
                        <?php if (empty($dashboard['applications'])): ?>
                            <p style="color:#94A3B8;">No applications submitted yet.</p>
                        <?php else: ?>
                            <div style="display:flex;flex-direction:column;gap:0.9rem;">
                                <?php foreach ($dashboard['applications'] as $app): ?>
                                    <?php $stMeta = CareersDB::PIPELINE_STATUSES[$app['status']] ?? ['label' => $app['status']]; ?>
                                    <div class="careers-card" style="padding:1.15rem;">
                                        <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:0.75rem;">
                                            <div>
                                                <div class="careers-badge careers-badge-amber" style="margin-bottom:0.4rem;"><?= htmlspecialchars((string)$app['reference_code']) ?></div>
                                                <h3 style="color:#fff;font-size:1.08rem;margin:0;"><?= htmlspecialchars((string)$app['job_title']) ?></h3>
                                                <div style="font-size:0.82rem;color:#94A3B8;margin-top:0.25rem;">
                                                    Status: <strong style="color:#22D3EE;"><?= htmlspecialchars($stMeta['label']) ?></strong> &bull; Applied <?= date('M j, Y', strtotime((string)$app['submitted_at'])) ?>
                                                </div>
                                            </div>
                                            <a href="<?= url('careers/candidate-portal/applications/' . urlencode((string)$app['reference_code'])) ?>" class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">
                                                Timeline &amp; Details &rarr;
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($dashboard['interviews'])): ?>
                        <div class="careers-detail-panel">
                            <h2 style="color:#fff;font-size:1.2rem;margin-bottom:1rem;">Upcoming Interviews</h2>
                            <?php foreach ($dashboard['interviews'] as $intv): ?>
                                <div class="careers-card" style="margin-bottom:0.75rem;border-color:rgba(34,211,238,0.35);">
                                    <div style="font-weight:700;color:#FF8C00;"><?= htmlspecialchars((string)$intv['interview_round']) ?> — <?= htmlspecialchars((string)$intv['job_title']) ?></div>
                                    <div style="color:#fff;font-size:0.92rem;margin-top:0.25rem;"><?= htmlspecialchars((string)$intv['scheduled_at']) ?> (<?= htmlspecialchars((string)$intv['timezone']) ?>)</div>
                                    <?php if (!empty($intv['meeting_link'])): ?>
                                        <a href="<?= htmlspecialchars((string)$intv['meeting_link']) ?>" target="_blank" rel="noopener noreferrer" style="color:#22D3EE;font-size:0.85rem;">Join Interview &rarr;</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Notifications + Profile/Prefs + Privacy Deletion -->
                <div style="display:flex;flex-direction:column;gap:1.5rem;">
                    <div class="careers-form-panel">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.85rem;">
                            <h3 style="color:#fff;font-size:1.1rem;margin:0;">Notifications</h3>
                            <?php if ($dashboard['unread_count'] > 0): ?>
                                <form method="POST" action="<?= url('careers/candidate-portal') ?>">
                                    <?= csrf_input_field() ?>
                                    <input type="hidden" name="portal_post_action" value="mark_notifications_read">
                                    <button type="submit" style="background:none;border:none;color:#22D3EE;font-size:0.8rem;cursor:pointer;">Mark all read</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <?php if (empty($dashboard['notifications'])): ?>
                            <p style="color:#94A3B8;font-size:0.88rem;margin:0;">No notifications yet.</p>
                        <?php else: ?>
                            <div style="display:flex;flex-direction:column;gap:0.6rem;">
                                <?php foreach (array_slice($dashboard['notifications'], 0, 5) as $nf): ?>
                                    <div style="padding:0.7rem;border-radius:10px;background:rgba(255,255,255,0.03);border:1px solid <?= empty($nf['is_read']) ? 'rgba(34,211,238,0.4)' : 'rgba(255,255,255,0.07)' ?>;">
                                        <div style="font-weight:600;color:#fff;font-size:0.86rem;"><?= htmlspecialchars((string)$nf['title']) ?></div>
                                        <div style="color:#CBD5E1;font-size:0.82rem;margin-top:0.2rem;"><?= htmlspecialchars((string)$nf['message']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="careers-form-panel">
                        <h3 style="color:#fff;font-size:1.1rem;margin-bottom:0.85rem;">Contact &amp; Notification Preferences</h3>
                        <form method="POST" action="<?= url('careers/candidate-portal') ?>">
                            <?= csrf_input_field() ?>
                            <input type="hidden" name="portal_post_action" value="update_preferences">
                            <div style="margin-bottom:0.75rem;">
                                <label class="careers-label">Phone</label>
                                <input type="text" name="phone" class="careers-input" value="<?= htmlspecialchars((string)($applicant['phone'] ?? '')) ?>">
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;margin-bottom:0.85rem;">
                                <div>
                                    <label class="careers-label">City</label>
                                    <input type="text" name="city" class="careers-input" value="<?= htmlspecialchars((string)($applicant['city'] ?? '')) ?>">
                                </div>
                                <div>
                                    <label class="careers-label">Country</label>
                                    <input type="text" name="country" class="careers-input" value="<?= htmlspecialchars((string)($applicant['country'] ?? '')) ?>">
                                </div>
                            </div>
                            <label class="careers-choice-item" style="margin-bottom:0.45rem;">
                                <input type="checkbox" name="notify_status_updates" value="1" <?= !empty($applicant['notify_status_updates']) ? 'checked' : '' ?>>
                                <span>Email me when my application stage changes</span>
                            </label>
                            <label class="careers-choice-item" style="margin-bottom:1rem;">
                                <input type="checkbox" name="notify_interview_updates" value="1" <?= !empty($applicant['notify_interview_updates']) ? 'checked' : '' ?>>
                                <span>Email me interview schedules &amp; updates</span>
                            </label>
                            <button type="submit" class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">Save Preferences</button>
                        </form>
                    </div>

                    <div class="careers-form-panel" style="border-color:rgba(239,68,68,0.22);">
                        <h3 style="color:#fff;font-size:1rem;margin-bottom:0.45rem;">Privacy &amp; Data Deletion Request</h3>
                        <p style="font-size:0.82rem;color:#94A3B8;margin-bottom:0.75rem;">Need your candidate records deleted after completion of recruitment?</p>
                        <?php if (!empty($applicant['deletion_requested_at'])): ?>
                            <div class="careers-alert careers-alert-info" style="margin-bottom:0;">Deletion request logged on <?= htmlspecialchars((string)$applicant['deletion_requested_at']) ?>.</div>
                        <?php else: ?>
                            <form method="POST" action="<?= url('careers/candidate-portal') ?>" onsubmit="return confirm('Submit a formal data deletion request for your candidate profile?');">
                                <?= csrf_input_field() ?>
                                <input type="hidden" name="portal_post_action" value="request_deletion">
                                <input type="text" name="deletion_reason" class="careers-input" style="margin-bottom:0.65rem;" placeholder="Optional reason...">
                                <button type="submit" class="btn btn-sm" style="background:rgba(239,68,68,0.14);border:1px solid rgba(239,68,68,0.35);color:#FCA5A5;">Request Data Deletion</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
