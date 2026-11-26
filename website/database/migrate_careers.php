<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Idempotent Migration & Seed Runner for Careers & Recruitment System
 */

$root = dirname(__DIR__, 2);
require_once $root . '/website/config/Env.php';
Env::load($root . '/website/.env');
require_once $root . '/website/config/database.php';

$pdo = Database::getConnection();
if (!$pdo) {
    fwrite(STDERR, "ERROR: Unable to connect to MySQL database.\n");
    exit(1);
}

$migrationName = '007_careers_recruitment_system.sql';
$sqlPath = __DIR__ . '/migrations/' . $migrationName;
if (!is_file($sqlPath)) {
    fwrite(STDERR, "ERROR: Missing SQL file: {$sqlPath}\n");
    exit(1);
}

$rawSql = (string)file_get_contents($sqlPath);
$cleanLines = [];
foreach (preg_split('/\R/', $rawSql) ?: [] as $line) {
    $trimmed = ltrim($line);
    if (str_starts_with($trimmed, '--')) {
        continue;
    }
    $cleanLines[] = $line;
}
$sql = implode("\n", $cleanLines);
$statements = array_filter(
    array_map('trim', explode(';', $sql)),
    fn(string $stmt): bool => $stmt !== ''
);

foreach ($statements as $stmt) {
    $pdo->exec($stmt);
}

// 1. Seed Categories (matching required public filter tabs)
$categories = [
    ['slug' => 'marketing', 'name' => 'Marketing', 'description' => 'Growth marketing, SEO/AEO, digital acquisition & brand strategy roles.', 'sort_order' => 1],
    ['slug' => 'sales-business-development', 'name' => 'Sales & Business Development', 'description' => 'B2B consulting, partner outreach, discovery and client growth roles.', 'sort_order' => 2],
    ['slug' => 'internship', 'name' => 'Internship', 'description' => 'Structured hands-on internships across engineering, product, and growth.', 'sort_order' => 3],
    ['slug' => 'fellowship', 'name' => 'Fellowship', 'description' => 'Applied engineering & AI research fellowships with mentor oversight.', 'sort_order' => 4],
    ['slug' => 'engineering-technology', 'name' => 'Engineering & Technology', 'description' => 'Software engineering, AI systems, automation architecture & QA roles.', 'sort_order' => 5],
];

$catStmt = $pdo->prepare("
    INSERT INTO `job_categories` (`slug`, `name`, `description`, `sort_order`, `is_active`)
    VALUES (:slug, :name, :desc, :sort, 1)
    ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `sort_order` = VALUES(`sort_order`)
");
foreach ($categories as $cat) {
    $catStmt->execute([
        ':slug' => $cat['slug'],
        ':name' => $cat['name'],
        ':desc' => $cat['description'],
        ':sort' => $cat['sort_order'],
    ]);
}

$catMap = [];
foreach ($pdo->query("SELECT id, slug FROM job_categories")->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $catMap[$row['slug']] = (int)$row['id'];
}

// 2. Seed Application Form Templates
$templates = [
    ['slug' => 'default', 'name' => 'Default Standard Form', 'template_type' => 'default', 'description' => 'Standard 15-field CodeX404 recruitment form adaptable to any vacancy.', 'is_system' => 1],
    ['slug' => 'marketing', 'name' => 'Marketing & Growth Template', 'template_type' => 'marketing', 'description' => 'Includes campaign experience, analytics proficiency, and content/growth portfolio.', 'is_system' => 1],
    ['slug' => 'sales', 'name' => 'Sales & Business Development Template', 'template_type' => 'sales', 'description' => 'Includes B2B pipeline metrics, commission comfort, and pitch readiness.', 'is_system' => 1],
    ['slug' => 'internship', 'name' => 'Internship Template', 'template_type' => 'internship', 'description' => 'Includes university status, academic stream, weekly availability, and project links.', 'is_system' => 1],
    ['slug' => 'fellowship', 'name' => 'Fellowship Template', 'template_type' => 'fellowship', 'description' => 'Includes technical statement of interest, GitHub/work samples, and cohort commitment.', 'is_system' => 1],
    ['slug' => 'custom', 'name' => 'Blank Custom Template', 'template_type' => 'custom', 'description' => 'Minimal starter fields ready for bespoke vacancy customization.', 'is_system' => 1],
];

$tplStmt = $pdo->prepare("
    INSERT INTO `application_form_templates` (`slug`, `name`, `template_type`, `description`, `is_system`, `is_active`, `created_by`)
    VALUES (:slug, :name, :type, :desc, :sys, 1, 'admin')
    ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `template_type` = VALUES(`template_type`)
");
foreach ($templates as $tpl) {
    $tplStmt->execute([
        ':slug' => $tpl['slug'],
        ':name' => $tpl['name'],
        ':type' => $tpl['template_type'],
        ':desc' => $tpl['description'],
        ':sys'  => $tpl['is_system'],
    ]);
}

$tplMap = [];
foreach ($pdo->query("SELECT id, slug FROM application_form_templates")->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $tplMap[$row['slug']] = (int)$row['id'];
}

// 3. Seed Form Fields per Template (Idempotent: only insert if template has 0 fields)
$defaultCoreFields = [
    ['full_name', 'Full Name', 'short_text', 'e.g., Aarav Sharma', 'Legal name used in official correspondence.', null, ['min_length' => 2, 'max_length' => 140], 1, 1, 'Personal Details', 'half'],
    ['email', 'Email Address', 'email', 'you@domain.com', 'Status updates and applicant portal verification OTPs are sent here.', null, ['max_length' => 254], 1, 1, 'Personal Details', 'half'],
    ['phone', 'Phone Number', 'phone', '+91 98765 43210', 'Include country code for scheduling calls.', null, ['max_length' => 30], 1, 1, 'Personal Details', 'half'],
    ['country', 'Country', 'short_text', 'e.g., India', null, null, ['max_length' => 100], 1, 1, 'Location & Availability', 'half'],
    ['city', 'City', 'short_text', 'e.g., Bengaluru', null, null, ['max_length' => 100], 1, 1, 'Location & Availability', 'half'],
    ['current_employment_status', 'Current Employment Status', 'dropdown', null, null, ['Employed Full-Time', 'Employed Part-Time', 'Freelancer / Consultant', 'Student / Recent Graduate', 'Between Roles / Immediately Available'], null, 1, 0, 'Experience & Links', 'half'],
    ['years_of_experience', 'Years of Experience', 'number', 'e.g., 2.5', 'Enter total relevant experience in years (0 for freshers/interns).', null, ['min' => 0, 'max' => 50], 1, 0, 'Experience & Links', 'half'],
    ['linkedin_url', 'LinkedIn Profile URL', 'url', 'https://linkedin.com/in/your-profile', null, null, null, 0, 0, 'Experience & Links', 'half'],
    ['portfolio_github_url', 'Portfolio / GitHub / Work Links', 'url', 'https://github.com/username or https://portfolio.site', null, null, null, 0, 0, 'Experience & Links', 'half'],
    ['resume_cv', 'Resume / CV Upload (PDF/DOC/DOCX)', 'file', null, 'Maximum file size 5 MB. Stored privately for recruitment review only.', null, ['allowed_exts' => ['pdf','doc','docx'], 'max_mb' => 5], 1, 1, 'Documents & Readiness', 'full'],
    ['expected_compensation', 'Expected Salary / Compensation', 'short_text', 'e.g., INR 6-8 LPA or Monthly Stipend', null, null, ['max_length' => 120], 0, 0, 'Documents & Readiness', 'half'],
    ['notice_period_availability', 'Notice Period / Availability', 'dropdown', null, null, ['Immediate', 'Within 15 Days', '30 Days', '60 Days', 'Flexible / Part-Time Cohort'], null, 1, 0, 'Documents & Readiness', 'half'],
    ['why_join_codex404', 'Why do you want to join CodeX404 Solutions?', 'long_text', 'Share what draws you to our engineering, automation, or growth work...', null, null, ['min_length' => 30, 'max_length' => 3000], 1, 0, 'Motivation & Declaration', 'full'],
    ['relevant_experience_summary', 'Summary of Relevant Experience', 'long_text', 'Highlight measurable projects, systems built, or campaigns led.', null, null, ['min_length' => 20, 'max_length' => 3000], 1, 0, 'Motivation & Declaration', 'full'],
    ['agreement_checkboxes', 'Candidate Agreements & Consent', 'checkbox', null, 'Both confirmations are required to process your application.', ['I agree to the CodeX404 Privacy Policy and recruitment data processing terms.', 'I confirm that all information and documents submitted are accurate and my own work.'], ['require_all' => true], 1, 1, 'Motivation & Declaration', 'full'],
];

$templateExtras = [
    'marketing' => [
        ['primary_marketing_channels', 'Primary Marketing Channels Managed', 'checkbox', null, 'Select all channels where you have hands-on campaign execution experience.', ['SEO / Technical Content', 'Google Ads (PPC)', 'Meta / LinkedIn Paid Social', 'Email Lifecycle & CRM', 'AEO / AI Search Optimization'], null, 1, 0, 'Role Assessment', 'full'],
        ['campaign_case_highlight', 'Best Campaign or Funnel Metric Achieved', 'long_text', 'Briefly describe strategy, audience, spend scale, and outcome...', null, null, ['max_length' => 2000], 1, 0, 'Role Assessment', 'full'],
    ],
    'sales' => [
        ['b2b_sales_track_record', 'B2B Discovery & Closing Experience', 'long_text', 'Describe your experience pitching software/services, qualifying leads, and closing deals.', null, null, ['max_length' => 2000], 1, 0, 'Role Assessment', 'full'],
        ['commission_structure_comfort', 'Are you comfortable with performance-linked incentives alongside base pay?', 'radio', null, null, ['Yes, comfortable with base + performance commission', 'Prefer fixed compensation only', 'Open to discussing structure'], null, 1, 0, 'Role Assessment', 'full'],
    ],
    'internship' => [
        ['academic_institution', 'College / University & Degree Program', 'short_text', 'e.g., B.Tech Computer Science — 3rd Year', null, null, ['max_length' => 160], 1, 0, 'Academic & Cohort Info', 'half'],
        ['weekly_hours_available', 'Hours Available Per Week', 'number', 'e.g., 25', null, null, ['min' => 10, 'max' => 45], 1, 0, 'Academic & Cohort Info', 'half'],
        ['earliest_start_date', 'Earliest Available Start Date', 'date', null, null, null, null, 1, 0, 'Academic & Cohort Info', 'half'],
    ],
    'fellowship' => [
        ['fellowship_focus_track', 'Preferred Fellowship Track', 'radio', null, null, ['Full-Stack Systems Architecture', 'Applied AI & RAG Automation', 'Product Growth & Revenue Ops'], null, 1, 0, 'Fellowship Assessment', 'full'],
        ['technical_statement', 'Technical Statement of Interest & Build Goal', 'long_text', 'Explain one technical system you want to architect or improve during the fellowship.', null, null, ['min_length' => 50, 'max_length' => 3000], 1, 0, 'Fellowship Assessment', 'full'],
    ],
    'custom' => [],
];

$checkTplFieldsStmt = $pdo->prepare("SELECT COUNT(*) FROM application_form_fields WHERE template_id = ?");
$insertFieldStmt = $pdo->prepare("
    INSERT INTO `application_form_fields`
        (`template_id`, `job_opening_id`, `field_key`, `label`, `field_type`, `placeholder`, `help_text`, `options_json`, `validation_rules_json`, `is_required`, `is_enabled`, `is_system_core`, `step_section`, `width_col`, `sort_order`)
    VALUES
        (:tpl_id, NULL, :key, :label, :type, :ph, :help, :opts, :rules, :req, 1, :core, :sec, :col, :sort)
");

foreach ($tplMap as $slug => $tplId) {
    $checkTplFieldsStmt->execute([$tplId]);
    if ((int)$checkTplFieldsStmt->fetchColumn() > 0) {
        continue;
    }

    if ($slug === 'custom') {
        $fieldsToSeed = array_values(array_filter(
            $defaultCoreFields,
            fn(array $f): bool => in_array($f[0], ['full_name', 'email', 'phone', 'resume_cv', 'why_join_codex404', 'agreement_checkboxes'], true)
        ));
    } else {
        $fieldsToSeed = array_merge($defaultCoreFields, $templateExtras[$slug] ?? []);
    }

    $order = 10;
    foreach ($fieldsToSeed as $f) {
        $insertFieldStmt->execute([
            ':tpl_id' => $tplId,
            ':key'    => $f[0],
            ':label'  => $f[1],
            ':type'   => $f[2],
            ':ph'     => $f[3],
            ':help'   => $f[4],
            ':opts'   => $f[5] !== null ? json_encode($f[5], JSON_UNESCAPED_UNICODE) : null,
            ':rules'  => $f[6] !== null ? json_encode($f[6], JSON_UNESCAPED_UNICODE) : null,
            ':req'    => $f[7],
            ':core'   => $f[8],
            ':sec'    => $f[9],
            ':col'    => $f[10],
            ':sort'   => $order,
        ]);
        $order += 10;
    }
}

// 4. Seed RBAC Roles & Permissions for Recruitment
$pdo->exec("
    INSERT INTO `roles` (`id`, `slug`, `name`, `description`, `color`, `is_system`)
    VALUES ('role_recruiter', 'recruiter', 'Recruitment Manager', 'Manage vacancies, review applications, build application forms, schedule interviews, and email candidates.', 'cyan', 1)
    ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`)
");

$careersPermissions = [
    ['perm_careers_view', 'careers.view', 'careers', 'View Recruitment overview metrics and published job openings'],
    ['perm_careers_jobs', 'careers.jobs.manage', 'careers', 'Create, edit, publish, schedule, close, duplicate, and archive job vacancies'],
    ['perm_careers_apps_view', 'careers.applications.view', 'careers', 'View candidate applications, timelines, and status details'],
    ['perm_careers_apps_mgr', 'careers.applications.manage', 'careers', 'Change application status, assign recruiters, add notes, and message candidates'],
    ['perm_careers_interviews', 'careers.interviews.manage', 'careers', 'Schedule, reschedule, and update candidate interviews'],
    ['perm_careers_forms', 'careers.forms.manage', 'careers', 'Create and modify dynamic application form templates and job-specific fields'],
    ['perm_careers_emails', 'careers.emails.manage', 'careers', 'Edit recruitment email templates and inspect email delivery logs'],
    ['perm_careers_export', 'careers.candidates.export', 'careers', 'Download candidate resumes/CVs and export application CSV reports'],
    ['perm_careers_settings', 'careers.settings.manage', 'careers', 'Configure recruitment workflow settings, upload policies, and portal options'],
    ['perm_careers_logs', 'careers.logs.view', 'careers', 'View recruitment audit trail and activity logs'],
];

$permStmt = $pdo->prepare("
    INSERT INTO `permissions` (`id`, `slug`, `module`, `description`)
    VALUES (:id, :slug, :module, :desc)
    ON DUPLICATE KEY UPDATE `description` = VALUES(`description`)
");
foreach ($careersPermissions as $p) {
    $permStmt->execute([':id' => $p[0], ':slug' => $p[1], ':module' => $p[2], ':desc' => $p[3]]);
}

$rolePermMap = [
    'role_superadmin' => array_column($careersPermissions, 0),
    'role_founder'    => array_column($careersPermissions, 0),
    'role_ceo'        => array_column($careersPermissions, 0),
    'role_cto'        => ['perm_careers_view', 'perm_careers_jobs', 'perm_careers_apps_view', 'perm_careers_apps_mgr', 'perm_careers_interviews', 'perm_careers_forms', 'perm_careers_export', 'perm_careers_logs'],
    'role_recruiter'  => ['perm_careers_view', 'perm_careers_jobs', 'perm_careers_apps_view', 'perm_careers_apps_mgr', 'perm_careers_interviews', 'perm_careers_forms', 'perm_careers_emails', 'perm_careers_export', 'perm_careers_logs'],
    'role_hr'         => ['perm_careers_view', 'perm_careers_jobs', 'perm_careers_apps_view', 'perm_careers_apps_mgr', 'perm_careers_interviews', 'perm_careers_forms', 'perm_careers_emails', 'perm_careers_export', 'perm_careers_logs'],
    'role_viewer'     => ['perm_careers_view', 'perm_careers_apps_view'],
];

$rpStmt = $pdo->prepare("INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`) VALUES (?, ?)");
foreach ($rolePermMap as $roleId => $permIds) {
    $existsRole = $pdo->prepare("SELECT COUNT(*) FROM roles WHERE id = ?");
    $existsRole->execute([$roleId]);
    if ((int)$existsRole->fetchColumn() === 0) {
        continue;
    }
    foreach ($permIds as $pid) {
        $rpStmt->execute([$roleId, $pid]);
    }
}

// 5. Seed Editable Email Templates
$emailTemplates = [
    [
        'key' => 'application_confirmation',
        'name' => 'Application Confirmation (Candidate)',
        'subject' => 'Application Received: {{job_title}} [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>Thank you for applying for <strong>{{job_title}}</strong> at {{company_name}}.</p><p>Your application reference number is <strong>{{application_id}}</strong>. Our recruitment team reviews every submission carefully and will update you as your application progresses.</p><p>You can track live progress anytime at our Applicant Portal: <a href="{{portal_url}}">{{portal_url}}</a></p><p>Best regards,<br>{{recruiter_name}}<br>{{company_name}}</p>',
        'body_text' => "Hello {{candidate_name}},\n\nThank you for applying for {{job_title}} at {{company_name}}.\nReference ID: {{application_id}}\nTrack live status anytime: {{portal_url}}\n\nBest regards,\n{{recruiter_name}}\n{{company_name}}",
    ],
    [
        'key' => 'admin_new_application_alert',
        'name' => 'New Application Alert (Admin / Recruiter)',
        'subject' => 'New Candidate Application: {{job_title}} — {{candidate_name}} [{{application_id}}]',
        'body_html' => '<p>A new application has been submitted on {{company_name}} Careers.</p><ul><li><strong>Reference:</strong> {{application_id}}</li><li><strong>Position:</strong> {{job_title}}</li><li><strong>Candidate:</strong> {{candidate_name}}</li></ul><p>Review application in Admin Dashboard: <a href="{{portal_url}}">{{portal_url}}</a></p>',
        'body_text' => "New application received:\nReference: {{application_id}}\nPosition: {{job_title}}\nCandidate: {{candidate_name}}\nReview in Admin Dashboard: {{portal_url}}",
    ],
    [
        'key' => 'status_under_review',
        'name' => 'Status Update: Under Review / Shortlisted',
        'subject' => 'Update on Your {{job_title}} Application [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>Your application (<strong>{{application_id}}</strong>) for <strong>{{job_title}}</strong> has progressed in our review pipeline.</p><p>Log in to the Applicant Portal to view your updated timeline and any recruiter notes: <a href="{{portal_url}}">{{portal_url}}</a></p><p>Regards,<br>{{recruiter_name}}<br>{{company_name}}</p>',
        'body_text' => "Hello {{candidate_name}},\n\nYour application {{application_id}} for {{job_title}} has been updated in our review pipeline.\nCheck your Applicant Portal: {{portal_url}}\n\nRegards,\n{{recruiter_name}}",
    ],
    [
        'key' => 'interview_scheduled',
        'name' => 'Interview Invitation',
        'subject' => 'Interview Scheduled: {{job_title}} [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>We would like to invite you to an interview for <strong>{{job_title}}</strong> ({{application_id}}).</p><p><strong>Scheduled Date & Time:</strong> {{interview_date}}<br><strong>Assigned Coordinator:</strong> {{recruiter_name}}</p><p>Full meeting details, format, and preparation notes are available in your Applicant Portal: <a href="{{portal_url}}">{{portal_url}}</a></p><p>Best regards,<br>{{company_name}} Recruitment</p>',
        'body_text' => "Hello {{candidate_name}},\n\nYour interview for {{job_title}} ({{application_id}}) is scheduled for {{interview_date}}.\nCoordinator: {{recruiter_name}}\nView full instructions in the Applicant Portal: {{portal_url}}",
    ],
    [
        'key' => 'offer_selected',
        'name' => 'Selection / Offer Communication',
        'subject' => 'Good News Regarding {{job_title}} [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>Congratulations! Your application (<strong>{{application_id}}</strong>) for <strong>{{job_title}}</strong> has moved to the selection / offer stage at {{company_name}}.</p><p>{{recruiter_name}} will coordinate next steps with you directly. You can also review details inside the Applicant Portal: <a href="{{portal_url}}">{{portal_url}}</a></p><p>Warm regards,<br>{{company_name}}</p>',
        'body_text' => "Hello {{candidate_name}},\n\nCongratulations! Your application {{application_id}} for {{job_title}} has reached the selection/offer stage.\n{{recruiter_name}} will reach out with next steps.\nPortal: {{portal_url}}",
    ],
    [
        'key' => 'application_rejected',
        'name' => 'Application Decision (Not Moving Forward)',
        'subject' => 'Update on {{job_title}} [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>Thank you for taking the time to apply for <strong>{{job_title}}</strong> ({{application_id}}) with {{company_name}}.</p><p>After careful evaluation, we are unable to move forward with your candidacy for this specific opening at this time. We appreciate your interest and encourage you to keep an eye on future opportunities.</p><p>Wishing you every success,<br>{{recruiter_name}}<br>{{company_name}}</p>',
        'body_text' => "Hello {{candidate_name}},\n\nThank you for applying for {{job_title}} ({{application_id}}) at {{company_name}}.\nAfter careful review, we are unable to proceed with this specific role at this time.\n\nBest wishes,\n{{recruiter_name}}",
    ],
    [
        'key' => 'applicant_portal_otp',
        'name' => 'Applicant Portal Verification OTP',
        'subject' => 'Your CodeX404 Applicant Portal Verification Code',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>Use the one-time verification code below to access your {{company_name}} Applicant Portal:</p><p style="font-size:24px;font-weight:700;letter-spacing:4px;color:#0B5ED7;">{{otp_code}}</p><p>This code expires in 10 minutes and can only be used once. If you did not request access, you may ignore this email.</p>',
        'body_text' => "Hello {{candidate_name}},\n\nYour CodeX404 Applicant Portal verification code is: {{otp_code}}\nThis code expires in 10 minutes and is single-use.",
    ],
    [
        'key' => 'application_withdrawn',
        'name' => 'Application Withdrawal Confirmation',
        'subject' => 'Application Withdrawn: {{job_title}} [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>This confirms that your application (<strong>{{application_id}}</strong>) for <strong>{{job_title}}</strong> has been withdrawn per your request.</p><p>Thank you for considering {{company_name}}.</p>',
        'body_text' => "Hello {{candidate_name}},\n\nYour application {{application_id}} for {{job_title}} has been withdrawn per your request.",
    ],
    [
        'key' => 'recruiter_candidate_message',
        'name' => 'New Message From Recruitment Team',
        'subject' => 'New Message on {{job_title}} [{{application_id}}] — {{company_name}}',
        'body_html' => '<p>Hello {{candidate_name}},</p><p>{{recruiter_name}} sent you an update regarding <strong>{{job_title}}</strong> ({{application_id}}).</p><p>Sign in to the Applicant Portal to read the message: <a href="{{portal_url}}">{{portal_url}}</a></p>',
        'body_text' => "Hello {{candidate_name}},\n\n{{recruiter_name}} posted a message on your application {{application_id}} ({{job_title}}).\nRead it here: {{portal_url}}",
    ],
];

$tplEmailStmt = $pdo->prepare("
    INSERT INTO `email_templates` (`template_key`, `name`, `category`, `subject`, `body_html`, `body_text`, `variables_help`, `is_active`, `updated_by`)
    VALUES (:key, :name, 'recruitment', :subj, :html, :txt, '{{candidate_name}}, {{job_title}}, {{application_id}}, {{company_name}}, {{interview_date}}, {{recruiter_name}}, {{portal_url}}, {{otp_code}}', 1, 'admin')
    ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `variables_help` = VALUES(`variables_help`)
");
foreach ($emailTemplates as $et) {
    $tplEmailStmt->execute([
        ':key'  => $et['key'],
        ':name' => $et['name'],
        ':subj' => $et['subject'],
        ':html' => $et['body_html'],
        ':txt'  => $et['body_text'],
    ]);
}

// 6. Seed Default Recruitment Settings
$settings = [
    ['company_name', 'CodeX404 Solutions', 'general', 'Display name used across Careers pages and emails'],
    ['hr_notification_email', 'info@codex404solutions.com', 'notifications', 'Admin inbox notified on new candidate submissions'],
    ['sender_name', 'CodeX404 Recruitment Team', 'notifications', 'Email sender display name'],
    ['sender_email', 'info@codex404solutions.com', 'notifications', 'Email sender address'],
    ['max_resume_mb', '5', 'uploads', 'Maximum resume upload size in megabytes'],
    ['allowed_resume_exts', 'pdf,doc,docx', 'uploads', 'Allowed comma-separated document extensions'],
    ['otp_expiry_minutes', '10', 'applicant_portal', 'OTP validity lifetime in minutes'],
    ['otp_resend_cooldown_seconds', '60', 'applicant_portal', 'Cooldown in seconds between OTP email sends'],
    ['applicant_session_hours', '12', 'applicant_portal', 'Applicant Portal session duration in hours'],
    ['allow_general_applications', '1', 'general', 'Enable or disable the General Talent Pool application route'],
    ['enable_applicant_portal', '1', 'applicant_portal', 'Enable passwordless Applicant Portal access'],
];

$setStmt = $pdo->prepare("
    INSERT IGNORE INTO `recruitment_settings` (`setting_key`, `setting_value`, `setting_group`, `description`)
    VALUES (?, ?, ?, ?)
");
foreach ($settings as $s) {
    $setStmt->execute($s);
}

// 7. Seed Initial Open Vacancies (if empty) so public Careers & Marketing Growth Associate URL work out of the box
$existingJobs = (int)$pdo->query("SELECT COUNT(*) FROM job_openings")->fetchColumn();
if ($existingJobs === 0) {
    $jobStmt = $pdo->prepare("
        INSERT INTO `job_openings` (
            `slug`, `title`, `category_id`, `department`, `employment_type`, `work_mode`, `location`,
            `experience_level`, `experience_min_years`, `compensation_type`, `salary_display`, `salary_currency`,
            `vacancies_count`, `working_hours`, `overview`, `about_position`, `responsibilities`, `qualifications`,
            `skills`, `employment_conditions`, `status`, `published_at`, `application_deadline`, `form_template_id`,
            `use_custom_form`, `featured`, `created_by`, `updated_by`
        ) VALUES (
            :slug, :title, :cat_id, :dept, :emp_type, :work_mode, :location,
            :exp_lvl, :exp_min, :comp_type, :sal_disp, 'INR',
            :vacancies, :hours, :overview, :about, :resp, :qual,
            :skills, :cond, 'published', NOW(), :deadline, :tpl_id,
            0, :featured, 'admin', 'admin'
        )
    ");

    $jobStmt->execute([
        ':slug' => 'marketing-growth-associate',
        ':title' => 'Marketing & Growth Associate',
        ':cat_id' => $catMap['marketing'] ?? 1,
        ':dept' => 'GROW Division',
        ':emp_type' => 'Full-Time',
        ':work_mode' => 'Remote',
        ':location' => 'Remote (India)',
        ':exp_lvl' => '1–3 Years',
        ':exp_min' => 1.0,
        ':comp_type' => 'Salary + Performance Bonus',
        ':sal_disp' => 'Competitive Fixed + Growth Bonus',
        ':vacancies' => 2,
        ':hours' => 'Flexible Core Overlap (10:00 AM – 6:30 PM IST)',
        ':overview' => 'Own search visibility, B2B demand generation, and measurable conversion funnels across CodeX404 client and internal initiatives.',
        ':about' => "CodeX404 Solutions is hiring a Marketing & Growth Associate to execute structured technical SEO, Answer Engine Optimization (AEO/GEO), targeted campaign landing pages, and outbound content workflows.\n\nYou will collaborate directly with founders and product engineers rather than layers of account management.",
        ':resp' => "- Plan and execute technical SEO, AEO, and content authority roadmaps.\n- Manage Google Ads and LinkedIn acquisition experiments with strict ROAS tracking.\n- Audit landing page conversion paths and coordinate CRO improvements with frontend engineers.\n- Prepare weekly performance briefs grounded in analytics rather than vanity metrics.",
        ':qual' => "- Proven experience running B2B digital growth, SEO, or paid acquisition campaigns.\n- Strong analytical rigor with GA4, Search Console, and funnel attribution.\n- Clear, structured English writing for technical and business audiences.",
        ':skills' => "Technical SEO, Google Ads, GA4 Attribution, Conversion Copywriting, B2B Demand Gen, Funnel CRO",
        ':cond' => 'Direct mentor feedback, transparent milestone expectations, and performance reviews tied to real client pipeline.',
        ':deadline' => date('Y-m-d', strtotime('+60 days')),
        ':tpl_id' => $tplMap['marketing'] ?? ($tplMap['default'] ?? 1),
        ':featured' => 1,
    ]);

    $jobStmt->execute([
        ':slug' => 'full-stack-php-systems-engineer',
        ':title' => 'Full-Stack PHP & Automation Systems Engineer',
        ':cat_id' => $catMap['engineering-technology'] ?? 5,
        ':dept' => 'BUILD & AUTOMATE Division',
        ':emp_type' => 'Full-Time',
        ':work_mode' => 'Remote',
        ':location' => 'Remote (India)',
        ':exp_lvl' => '2–4 Years',
        ':exp_min' => 2.0,
        ':comp_type' => 'Salary',
        ':sal_disp' => 'Competitive Industry Compensation',
        ':vacancies' => 1,
        ':hours' => 'Flexible Core Overlap (10:30 AM – 7:00 PM IST)',
        ':overview' => 'Architect production PHP 8.2/MySQL business platforms, clean REST APIs, and reliable AI/webhook automations with zero unnecessary bloat.',
        ':about' => "Join our core engineering group to design and ship client portals, CRM workflows, and backend integrations.\n\nYou will own database schema design, prepared-statement queries, security hardening, and automated verification directly with leadership.",
        ':resp' => "- Build clean modular PHP 8.x backend services and relational MySQL schemas.\n- Implement secure authentication, RBAC boundaries, and external webhook/API integrations.\n- Write thorough verification tests and maintain crisp architectural documentation.\n- Participate in peer code reviews and production reliability improvements.",
        ':qual' => "- Solid command of PHP 8+, PDO/MySQL query design, and modern JavaScript.\n- Practical understanding of OWASP security controls (CSRF, XSS, RBAC, safe uploads).\n- Bias toward simple, maintainable code over premature abstractions.",
        ':skills' => "PHP 8.2+, MySQL / PDO, JavaScript, REST APIs, Security Hardening, Git Workflows",
        ':cond' => 'Remote-first autonomy, clean engineering specifications, and direct ownership of shipped software.',
        ':deadline' => date('Y-m-d', strtotime('+75 days')),
        ':tpl_id' => $tplMap['default'] ?? 1,
        ':featured' => 1,
    ]);
}

// 8. Record Migration in `migrations` table (if not present)
$chkMig = $pdo->prepare("SELECT COUNT(*) FROM `migrations` WHERE `migration` = ?");
$chkMig->execute([$migrationName]);
if ((int)$chkMig->fetchColumn() === 0) {
    $maxBatch = (int)$pdo->query("SELECT COALESCE(MAX(batch), 0) FROM `migrations`")->fetchColumn();
    $insMig = $pdo->prepare("INSERT INTO `migrations` (`migration`, `batch`) VALUES (?, ?)");
    $insMig->execute([$migrationName, $maxBatch + 1]);
}

echo "OK: Migration {$migrationName} and seeds applied cleanly.\n";
