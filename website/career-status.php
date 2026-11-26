<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/config/Env.php';
Env::load(__DIR__ . '/.env');

use App\Careers\RecruitmentAuthService;
use App\Careers\RecruitmentSettingsService;

if (!RecruitmentSettingsService::getBool('enable_applicant_portal', true)) {
    http_response_code(503);
    exit('Applicant Portal is temporarily offline.');
}

// If already verified in session, go directly to Applicant Portal
if (RecruitmentAuthService::currentApplicant() !== null) {
    header('Location: ' . url('careers/candidate-portal'));
    exit;
}

$step = trim((string) ($_GET['step'] ?? 'request'));
$emailVal = trim((string) ($_SESSION['portal_pending_email'] ?? ($_GET['email'] ?? '')));
$infoMsg = '';
$errMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $errMsg = 'Security session expired. Please refresh and try again.';
    } else {
        $action = trim((string) ($_POST['portal_action'] ?? ''));

        if ($action === 'request_otp') {
            $emailVal = strtolower(trim((string) ($_POST['email'] ?? '')));
            if (!check_rate_limit('applicant_otp_req', 8, 300)) {
                $errMsg = 'Too many OTP requests. Please wait a few minutes.';
            } else {
                try {
                    $res = RecruitmentAuthService::requestApplicantOtp($emailVal, 'login');
                    $_SESSION['portal_pending_email'] = $emailVal;
                    $step = 'verify';
                    $infoMsg = $res['generic_message'];
                } catch (\Throwable $e) {
                    $errMsg = $e->getMessage();
                }
            }
        } elseif ($action === 'verify_otp') {
            $emailVal = strtolower(trim((string) ($_POST['email'] ?? $emailVal)));
            $otpVal = trim((string) ($_POST['otp_code'] ?? ''));
            $step = 'verify';
            if (!check_rate_limit('applicant_otp_verify', 12, 300)) {
                $errMsg = 'Too many failed verification attempts. Please try again later.';
            } else {
                try {
                    RecruitmentAuthService::verifyApplicantOtp($emailVal, $otpVal);
                    unset($_SESSION['portal_pending_email']);
                    header('Location: ' . url('careers/candidate-portal'));
                    exit;
                } catch (\Throwable $e) {
                    $errMsg = $e->getMessage();
                }
            }
        }
    }
}

$pageMeta = [
    'title' => 'Track Application Status — CodeX404 Solutions Applicant Portal',
    'description' => 'Verify your email with a single-use code to access your CodeX404 Solutions Applicant Portal and live hiring timeline.',
    'canonical' => url('careers/application-status'),
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top:calc(var(--nav-height,78px) + 4.5rem);padding-bottom:5rem;">
    <div class="container" style="max-width:560px;">
        <div class="careers-form-panel">
            <div class="section-tag" style="margin-bottom:1rem;">
                <span class="dot"></span>
                <span>Passwordless Email Verification</span>
            </div>

            <h1 class="subpage-section-title" style="font-size:1.75rem;margin-bottom:0.5rem;">
                Applicant <span class="text-amber">Status &amp; Portal</span>
            </h1>
            <p style="color:#CBD5E1;font-size:0.93rem;line-height:1.65;margin-bottom:1.35rem;">
                To protect candidate privacy, application statuses are accessible only after verifying ownership of the
                email address used on your application.
            </p>

            <?php if ($infoMsg !== ''): ?>
                <div class="careers-alert careers-alert-info"><?= htmlspecialchars($infoMsg) ?></div>
            <?php endif; ?>
            <?php if ($errMsg !== ''): ?>
                <div class="careers-alert careers-alert-error"><?= htmlspecialchars($errMsg) ?></div>
            <?php endif; ?>

            <?php if ($step !== 'verify'): ?>
                <form method="POST" action="<?= url('careers/application-status') ?>">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="portal_action" value="request_otp">
                    <div style="margin-bottom:1.1rem;">
                        <label class="careers-label" for="portalEmail">Email Address Used in Application <span
                                class="req-star">*</span></label>
                        <input type="email" id="portalEmail" name="email" class="careers-input" required
                            value="<?= htmlspecialchars($emailVal) ?>" placeholder="you@domain.com">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg"
                        style="width:100%;background:#0B5ED7;border-color:#0B5ED7;">
                        Send 6-Digit Verification Code
                    </button>
                </form>
            <?php else: ?>
                <form method="POST" action="<?= url('careers/application-status?step=verify') ?>">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="portal_action" value="verify_otp">
                    <div style="margin-bottom:1rem;">
                        <label class="careers-label" for="verifyEmail">Email Address</label>
                        <input type="email" id="verifyEmail" name="email" class="careers-input" required
                            value="<?= htmlspecialchars($emailVal) ?>">
                    </div>
                    <div style="margin-bottom:1.2rem;">
                        <label class="careers-label" for="otpCode">6-Digit One-Time Verification Code <span
                                class="req-star">*</span></label>
                        <input type="text" id="otpCode" name="otp_code" class="careers-input" required maxlength="6"
                            inputmode="numeric" pattern="[0-9]{6}" placeholder="Enter 6-digit code"
                            style="letter-spacing:0.25em;font-weight:700;text-align:center;font-size:1.15rem;">
                        <small class="careers-help">Code expires after 10 minutes and can be used once.</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg"
                        style="width:100%;background:#0B5ED7;border-color:#0B5ED7;">
                        Verify &amp; Open Applicant Portal
                    </button>
                </form>

                <form method="POST" action="<?= url('careers/application-status') ?>"
                    style="margin-top:0.9rem;text-align:center;">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="portal_action" value="request_otp">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($emailVal) ?>">
                    <button type="submit"
                        style="background:none;border:none;color:#22D3EE;font-size:0.86rem;cursor:pointer;text-decoration:underline;">
                        Resend verification code
                    </button>
                </form>
            <?php endif; ?>

            <div
                style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.08);text-align:center;font-size:0.84rem;color:#94A3B8;">
                Looking for new roles? <a href="<?= url('careers') ?>" style="color:#22D3EE;">Return to Careers
                    &rarr;</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>