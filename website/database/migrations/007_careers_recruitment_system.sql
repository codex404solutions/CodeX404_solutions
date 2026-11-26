-- ============================================================================
-- CodeX404 Solutions — Careers, Recruitment & Applicant Portal System
-- Migration: 007_careers_recruitment_system.sql
-- Target DB: codex404_db (MySQL 8.x / MariaDB 10.4+)
-- ============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Job Categories
CREATE TABLE IF NOT EXISTS `job_categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(80) NOT NULL,
    `name` VARCHAR(120) NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_job_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Application Form Templates
CREATE TABLE IF NOT EXISTS `application_form_templates` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(80) NOT NULL,
    `name` VARCHAR(120) NOT NULL,
    `template_type` ENUM('default','marketing','sales','internship','fellowship','custom') NOT NULL DEFAULT 'custom',
    `description` VARCHAR(255) DEFAULT NULL,
    `is_system` TINYINT(1) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_by` VARCHAR(50) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_form_templates_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Job Openings / Vacancies
CREATE TABLE IF NOT EXISTS `job_openings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(140) NOT NULL,
    `title` VARCHAR(180) NOT NULL,
    `category_id` INT UNSIGNED NOT NULL,
    `department` VARCHAR(120) NOT NULL,
    `employment_type` VARCHAR(80) NOT NULL DEFAULT 'Full-Time',
    `work_mode` ENUM('Remote','Hybrid','On-Site') NOT NULL DEFAULT 'Remote',
    `location` VARCHAR(150) NOT NULL DEFAULT 'Remote',
    `experience_level` VARCHAR(100) NOT NULL DEFAULT 'Mid-Level',
    `experience_min_years` DECIMAL(4,1) NOT NULL DEFAULT 0.0,
    `compensation_type` VARCHAR(80) NOT NULL DEFAULT 'Salary',
    `salary_display` VARCHAR(140) DEFAULT NULL,
    `salary_min` DECIMAL(12,2) DEFAULT NULL,
    `salary_max` DECIMAL(12,2) DEFAULT NULL,
    `salary_currency` VARCHAR(10) NOT NULL DEFAULT 'INR',
    `vacancies_count` INT UNSIGNED DEFAULT 1,
    `working_hours` VARCHAR(150) DEFAULT NULL,
    `overview` TEXT NOT NULL,
    `about_position` MEDIUMTEXT NOT NULL,
    `responsibilities` MEDIUMTEXT NOT NULL,
    `qualifications` MEDIUMTEXT NOT NULL,
    `skills` MEDIUMTEXT NOT NULL,
    `employment_conditions` TEXT DEFAULT NULL,
    `status` ENUM('draft','scheduled','published','closed','archived') NOT NULL DEFAULT 'draft',
    `scheduled_publish_at` DATETIME DEFAULT NULL,
    `published_at` DATETIME DEFAULT NULL,
    `application_deadline` DATE DEFAULT NULL,
    `form_template_id` INT UNSIGNED DEFAULT NULL,
    `use_custom_form` TINYINT(1) NOT NULL DEFAULT 0,
    `featured` TINYINT(1) NOT NULL DEFAULT 0,
    `seo_title` VARCHAR(180) DEFAULT NULL,
    `seo_description` VARCHAR(320) DEFAULT NULL,
    `created_by` VARCHAR(50) DEFAULT NULL,
    `updated_by` VARCHAR(50) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_job_openings_slug` (`slug`),
    KEY `idx_job_openings_status_pub` (`status`, `published_at`),
    KEY `idx_job_openings_category` (`category_id`),
    KEY `idx_job_openings_deadline` (`application_deadline`),
    CONSTRAINT `fk_job_openings_category` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_job_openings_template` FOREIGN KEY (`form_template_id`) REFERENCES `application_form_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Application Form Fields (for Templates & Per-Job Custom Forms)
CREATE TABLE IF NOT EXISTS `application_form_fields` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `template_id` INT UNSIGNED DEFAULT NULL,
    `job_opening_id` INT UNSIGNED DEFAULT NULL,
    `field_key` VARCHAR(90) NOT NULL,
    `label` VARCHAR(160) NOT NULL,
    `field_type` ENUM('short_text','long_text','email','phone','number','dropdown','radio','checkbox','file','date','url') NOT NULL DEFAULT 'short_text',
    `placeholder` VARCHAR(200) DEFAULT NULL,
    `help_text` VARCHAR(255) DEFAULT NULL,
    `default_value` VARCHAR(255) DEFAULT NULL,
    `options_json` TEXT DEFAULT NULL,
    `validation_rules_json` TEXT DEFAULT NULL,
    `is_required` TINYINT(1) NOT NULL DEFAULT 0,
    `is_enabled` TINYINT(1) NOT NULL DEFAULT 1,
    `is_system_core` TINYINT(1) NOT NULL DEFAULT 0,
    `step_section` VARCHAR(80) NOT NULL DEFAULT 'Application Details',
    `width_col` ENUM('full','half') NOT NULL DEFAULT 'full',
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_form_fields_template` (`template_id`, `is_enabled`, `sort_order`),
    KEY `idx_form_fields_job` (`job_opening_id`, `is_enabled`, `sort_order`),
    CONSTRAINT `fk_form_fields_template` FOREIGN KEY (`template_id`) REFERENCES `application_form_templates` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_form_fields_job` FOREIGN KEY (`job_opening_id`) REFERENCES `job_openings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Candidate Profiles
CREATE TABLE IF NOT EXISTS `candidate_profiles` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `full_name` VARCHAR(160) NOT NULL,
    `email` VARCHAR(254) NOT NULL,
    `phone` VARCHAR(40) DEFAULT NULL,
    `country` VARCHAR(100) DEFAULT NULL,
    `city` VARCHAR(100) DEFAULT NULL,
    `employment_status` VARCHAR(100) DEFAULT NULL,
    `current_role_title` VARCHAR(150) DEFAULT NULL,
    `years_of_experience` DECIMAL(4,1) DEFAULT NULL,
    `skills_summary` TEXT DEFAULT NULL,
    `linkedin_url` VARCHAR(255) DEFAULT NULL,
    `portfolio_url` VARCHAR(255) DEFAULT NULL,
    `github_url` VARCHAR(255) DEFAULT NULL,
    `primary_resume_path` VARCHAR(255) DEFAULT NULL,
    `tags_json` TEXT DEFAULT NULL,
    `source_channel` VARCHAR(80) NOT NULL DEFAULT 'website_careers',
    `status_flag` ENUM('active','talent_pool','blacklisted') NOT NULL DEFAULT 'active',
    `notify_status_updates` TINYINT(1) NOT NULL DEFAULT 1,
    `notify_interview_updates` TINYINT(1) NOT NULL DEFAULT 1,
    `notify_general_updates` TINYINT(1) NOT NULL DEFAULT 1,
    `deletion_requested_at` DATETIME DEFAULT NULL,
    `deletion_request_reason` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_candidate_profiles_email` (`email`),
    KEY `idx_candidate_status_flag` (`status_flag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Applications
CREATE TABLE IF NOT EXISTS `applications` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `reference_code` VARCHAR(32) NOT NULL,
    `job_opening_id` INT UNSIGNED DEFAULT NULL,
    `candidate_id` INT UNSIGNED NOT NULL,
    `application_type` ENUM('vacancy','general_talent_pool') NOT NULL DEFAULT 'vacancy',
    `status` ENUM('new','under_review','shortlisted','interview_scheduled','selected','offer_sent','hired','rejected','withdrawn') NOT NULL DEFAULT 'new',
    `priority` ENUM('normal','high','urgent') NOT NULL DEFAULT 'normal',
    `rating` TINYINT UNSIGNED DEFAULT NULL,
    `resume_path` VARCHAR(255) DEFAULT NULL,
    `resume_original_name` VARCHAR(255) DEFAULT NULL,
    `resume_mime` VARCHAR(120) DEFAULT NULL,
    `resume_size_bytes` INT UNSIGNED DEFAULT NULL,
    `cover_summary` TEXT DEFAULT NULL,
    `answers_snapshot_json` LONGTEXT DEFAULT NULL,
    `consent_privacy` TINYINT(1) NOT NULL DEFAULT 0,
    `consent_accuracy` TINYINT(1) NOT NULL DEFAULT 0,
    `assigned_recruiter_id` VARCHAR(50) DEFAULT NULL,
    `source_ip_hash` CHAR(64) DEFAULT NULL,
    `submitted_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `withdrawn_at` DATETIME DEFAULT NULL,
    `withdrawal_reason` TEXT DEFAULT NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_applications_ref` (`reference_code`),
    KEY `idx_applications_job_status` (`job_opening_id`, `status`),
    KEY `idx_applications_candidate` (`candidate_id`, `submitted_at`),
    KEY `idx_applications_status_date` (`status`, `submitted_at`),
    KEY `idx_applications_recruiter` (`assigned_recruiter_id`),
    CONSTRAINT `fk_applications_job` FOREIGN KEY (`job_opening_id`) REFERENCES `job_openings` (`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_applications_candidate` FOREIGN KEY (`candidate_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Dynamic Application Field Answers
CREATE TABLE IF NOT EXISTS `application_answers` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED NOT NULL,
    `field_id` INT UNSIGNED DEFAULT NULL,
    `field_key` VARCHAR(90) NOT NULL,
    `field_label` VARCHAR(160) NOT NULL,
    `field_type` VARCHAR(32) NOT NULL,
    `answer_text` LONGTEXT DEFAULT NULL,
    `answer_json` LONGTEXT DEFAULT NULL,
    `file_path` VARCHAR(255) DEFAULT NULL,
    `file_original_name` VARCHAR(255) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_app_answers_app` (`application_id`),
    KEY `idx_app_answers_key` (`field_key`),
    CONSTRAINT `fk_app_answers_application` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_app_answers_field` FOREIGN KEY (`field_id`) REFERENCES `application_form_fields` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Application Status History (Audit & Candidate Timeline)
CREATE TABLE IF NOT EXISTS `application_status_history` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED NOT NULL,
    `from_status` VARCHAR(40) DEFAULT NULL,
    `to_status` VARCHAR(40) NOT NULL,
    `changed_by_type` ENUM('admin','applicant','system') NOT NULL DEFAULT 'system',
    `changed_by_id` VARCHAR(64) DEFAULT NULL,
    `changed_by_name` VARCHAR(150) DEFAULT NULL,
    `public_note` VARCHAR(500) DEFAULT NULL,
    `internal_note` TEXT DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_status_history_app` (`application_id`, `created_at`),
    CONSTRAINT `fk_status_history_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Recruiter Assignments
CREATE TABLE IF NOT EXISTS `recruiter_assignments` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED NOT NULL,
    `recruiter_user_id` VARCHAR(50) NOT NULL,
    `assigned_by` VARCHAR(50) DEFAULT NULL,
    `is_primary` TINYINT(1) NOT NULL DEFAULT 1,
    `assigned_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_app_recruiter` (`application_id`, `recruiter_user_id`),
    CONSTRAINT `fk_recruiter_assign_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Internal Private Recruiter Notes
CREATE TABLE IF NOT EXISTS `recruiter_notes` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED DEFAULT NULL,
    `candidate_id` INT UNSIGNED NOT NULL,
    `author_user_id` VARCHAR(50) DEFAULT NULL,
    `author_name` VARCHAR(150) NOT NULL,
    `note_text` TEXT NOT NULL,
    `is_pinned` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_recruiter_notes_app` (`application_id`),
    KEY `idx_recruiter_notes_cand` (`candidate_id`),
    CONSTRAINT `fk_recruiter_notes_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_recruiter_notes_cand` FOREIGN KEY (`candidate_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Public Candidate-Recruiter Messages (Visible in Applicant Portal)
CREATE TABLE IF NOT EXISTS `candidate_messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED NOT NULL,
    `candidate_id` INT UNSIGNED NOT NULL,
    `sender_type` ENUM('recruiter','candidate','system') NOT NULL DEFAULT 'recruiter',
    `sender_id` VARCHAR(64) DEFAULT NULL,
    `sender_name` VARCHAR(150) NOT NULL,
    `subject` VARCHAR(180) DEFAULT NULL,
    `message_body` TEXT NOT NULL,
    `is_read_by_candidate` TINYINT(1) NOT NULL DEFAULT 0,
    `is_read_by_recruiter` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_candidate_messages_app` (`application_id`, `created_at`),
    KEY `idx_candidate_messages_cand` (`candidate_id`, `is_read_by_candidate`),
    CONSTRAINT `fk_candidate_messages_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_candidate_messages_cand` FOREIGN KEY (`candidate_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Interview Schedules
CREATE TABLE IF NOT EXISTS `interview_schedules` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `application_id` INT UNSIGNED NOT NULL,
    `candidate_id` INT UNSIGNED NOT NULL,
    `scheduled_by` VARCHAR(50) DEFAULT NULL,
    `interviewer_name` VARCHAR(150) NOT NULL,
    `interviewer_email` VARCHAR(254) DEFAULT NULL,
    `interview_round` VARCHAR(120) NOT NULL DEFAULT 'Initial Screening',
    `interview_mode` ENUM('video','phone','onsite','technical_panel') NOT NULL DEFAULT 'video',
    `scheduled_at` DATETIME NOT NULL,
    `duration_minutes` INT UNSIGNED NOT NULL DEFAULT 45,
    `timezone` VARCHAR(80) NOT NULL DEFAULT 'Asia/Kolkata',
    `meeting_link` VARCHAR(255) DEFAULT NULL,
    `location_address` VARCHAR(255) DEFAULT NULL,
    `instructions` TEXT DEFAULT NULL,
    `status` ENUM('scheduled','rescheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_interviews_app` (`application_id`, `scheduled_at`),
    KEY `idx_interviews_cand` (`candidate_id`, `status`),
    CONSTRAINT `fk_interviews_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_interviews_cand` FOREIGN KEY (`candidate_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Editable Email Templates
CREATE TABLE IF NOT EXISTS `email_templates` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `template_key` VARCHAR(80) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `category` VARCHAR(60) NOT NULL DEFAULT 'recruitment',
    `subject` VARCHAR(220) NOT NULL,
    `body_html` MEDIUMTEXT NOT NULL,
    `body_text` MEDIUMTEXT NOT NULL,
    `variables_help` VARCHAR(255) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `updated_by` VARCHAR(50) DEFAULT NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_email_templates_key` (`template_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Email Delivery Logs
CREATE TABLE IF NOT EXISTS `email_logs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `template_key` VARCHAR(80) DEFAULT NULL,
    `application_id` INT UNSIGNED DEFAULT NULL,
    `candidate_id` INT UNSIGNED DEFAULT NULL,
    `recipient_email` VARCHAR(254) NOT NULL,
    `recipient_name` VARCHAR(160) DEFAULT NULL,
    `subject` VARCHAR(220) NOT NULL,
    `body_preview` TEXT DEFAULT NULL,
    `transport` ENUM('smtp','php_mail','local_log') NOT NULL DEFAULT 'local_log',
    `status` ENUM('sent','simulated_local','failed') NOT NULL DEFAULT 'simulated_local',
    `error_message` TEXT DEFAULT NULL,
    `sent_by` VARCHAR(50) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_email_logs_recipient` (`recipient_email`, `created_at`),
    KEY `idx_email_logs_app` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Recruitment Settings
CREATE TABLE IF NOT EXISTS `recruitment_settings` (
    `setting_key` VARCHAR(100) NOT NULL,
    `setting_value` TEXT DEFAULT NULL,
    `setting_group` VARCHAR(60) NOT NULL DEFAULT 'general',
    `description` VARCHAR(255) DEFAULT NULL,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 16. Recruitment Activity & Audit Logs
CREATE TABLE IF NOT EXISTS `recruitment_activity_logs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `actor_type` ENUM('admin','applicant','system') NOT NULL DEFAULT 'system',
    `actor_id` VARCHAR(64) DEFAULT NULL,
    `actor_name` VARCHAR(150) DEFAULT NULL,
    `action` VARCHAR(100) NOT NULL,
    `entity_type` VARCHAR(60) NOT NULL,
    `entity_id` VARCHAR(64) DEFAULT NULL,
    `summary` VARCHAR(255) NOT NULL,
    `metadata_json` TEXT DEFAULT NULL,
    `ip_hash` CHAR(64) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_recruit_logs_entity` (`entity_type`, `entity_id`),
    KEY `idx_recruit_logs_action` (`action`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 17. Applicant Portal Accounts (Passwordless OTP Identity)
CREATE TABLE IF NOT EXISTS `applicant_accounts` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `candidate_id` INT UNSIGNED NOT NULL,
    `email` VARCHAR(254) NOT NULL,
    `status` ENUM('active','locked','deletion_requested') NOT NULL DEFAULT 'active',
    `last_login_at` DATETIME DEFAULT NULL,
    `last_login_ip_hash` CHAR(64) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_applicant_accounts_email` (`email`),
    UNIQUE KEY `uk_applicant_accounts_cand` (`candidate_id`),
    CONSTRAINT `fk_applicant_accounts_cand` FOREIGN KEY (`candidate_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 18. Applicant OTP Verifications (HMAC/bcrypt hashed, never plain text)
CREATE TABLE IF NOT EXISTS `applicant_otp_verifications` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(254) NOT NULL,
    `otp_hash` VARCHAR(255) NOT NULL,
    `purpose` ENUM('login','status_lookup') NOT NULL DEFAULT 'login',
    `attempt_count` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `max_attempts` TINYINT UNSIGNED NOT NULL DEFAULT 5,
    `expires_at` DATETIME NOT NULL,
    `consumed_at` DATETIME DEFAULT NULL,
    `ip_hash` CHAR(64) DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_applicant_otp_email_exp` (`email`, `expires_at`, `consumed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 19. Applicant Portal Sessions
CREATE TABLE IF NOT EXISTS `applicant_sessions` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `applicant_account_id` INT UNSIGNED NOT NULL,
    `token_hash` CHAR(64) NOT NULL,
    `ip_hash` CHAR(64) DEFAULT NULL,
    `user_agent_hash` CHAR(64) DEFAULT NULL,
    `expires_at` DATETIME NOT NULL,
    `last_seen_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `revoked_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_applicant_sessions_token` (`token_hash`),
    KEY `idx_applicant_sessions_account` (`applicant_account_id`, `expires_at`),
    CONSTRAINT `fk_applicant_sessions_acc` FOREIGN KEY (`applicant_account_id`) REFERENCES `applicant_accounts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 20. Applicant Notifications
CREATE TABLE IF NOT EXISTS `applicant_notifications` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `candidate_id` INT UNSIGNED NOT NULL,
    `application_id` INT UNSIGNED DEFAULT NULL,
    `type` VARCHAR(60) NOT NULL DEFAULT 'status_update',
    `title` VARCHAR(180) NOT NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `read_at` DATETIME DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_applicant_notif_cand` (`candidate_id`, `is_read`, `created_at`),
    CONSTRAINT `fk_applicant_notif_cand` FOREIGN KEY (`candidate_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_applicant_notif_app` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
