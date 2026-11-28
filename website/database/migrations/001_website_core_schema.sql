-- ============================================================================
-- CodeX404 Solutions — Core Website MySQL Baseline Schema
-- Migration: 001_website_core_schema.sql
-- Target DB: codex404_db (MySQL 8.x / MariaDB 10.4+)
-- Idempotent baseline for fresh production setups (users, RBAC, contacts, portfolio)
-- ============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Workforce & Admin Users
CREATE TABLE IF NOT EXISTS `users` (
    `id` VARCHAR(50) NOT NULL,
    `username` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `title` VARCHAR(150) DEFAULT NULL,
    `department` VARCHAR(100) DEFAULT NULL,
    `reports_to` VARCHAR(50) DEFAULT NULL,
    `authority_tier` INT DEFAULT 3,
    `approval_limit` DECIMAL(15,2) DEFAULT 0.00,
    `bio` TEXT DEFAULT NULL,
    `avatar` VARCHAR(255) DEFAULT NULL,
    `custom_permissions` LONGTEXT DEFAULT NULL,
    `last_login` DATETIME DEFAULT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `role` VARCHAR(50) DEFAULT 'admin',
    `status` VARCHAR(20) DEFAULT 'active',
    `access_scope` ENUM('both','admin_only','crm_only') NOT NULL DEFAULT 'crm_only',
    `approval_status` VARCHAR(50) NOT NULL DEFAULT 'approved',
    `pending_payload` LONGTEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `timezone` VARCHAR(100) DEFAULT 'Asia/Kolkata',
    `currency` VARCHAR(10) DEFAULT 'INR',
    `last_ip` VARCHAR(50) DEFAULT NULL,
    `roles` LONGTEXT DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `idx_users_username` (`username`),
    KEY `idx_users_access_scope` (`access_scope`),
    KEY `idx_users_approval_status` (`approval_status`),
    KEY `idx_users_reports_to` (`reports_to`),
    KEY `idx_users_authority_tier` (`authority_tier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Roles Catalog
CREATE TABLE IF NOT EXISTS `roles` (
    `id` VARCHAR(36) NOT NULL,
    `slug` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `color` VARCHAR(50) DEFAULT 'primary',
    `is_system` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Granular Permissions Catalog
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` VARCHAR(36) NOT NULL,
    `slug` VARCHAR(100) NOT NULL,
    `module` VARCHAR(50) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. User <-> Role Assignments
CREATE TABLE IF NOT EXISTS `user_roles` (
    `user_id` VARCHAR(50) NOT NULL,
    `role_id` VARCHAR(36) NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    KEY `role_id` (`role_id`),
    CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Role <-> Permission Assignments
CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id` VARCHAR(36) NOT NULL,
    `permission_id` VARCHAR(36) NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    KEY `permission_id` (`permission_id`),
    CONSTRAINT `fk_role_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_role_permissions_perm` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Website Contact & Discovery Inquiries (extended by 009_website_schema_alignment.sql)
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `type` VARCHAR(50) DEFAULT 'general_contact',
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50) DEFAULT NULL,
    `company` VARCHAR(150) DEFAULT NULL,
    `subject` VARCHAR(255) DEFAULT NULL,
    `message` TEXT NOT NULL,
    `ip_address` VARCHAR(50) DEFAULT NULL,
    `status` VARCHAR(20) DEFAULT 'new',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Portfolio & Client Deliverables
CREATE TABLE IF NOT EXISTS `portfolio_projects` (
    `id` VARCHAR(100) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `category_label` VARCHAR(100) NOT NULL,
    `project_type` VARCHAR(50) NOT NULL DEFAULT 'client',
    `showcase_status` VARCHAR(50) NOT NULL DEFAULT 'live_website',
    `badge_text` VARCHAR(50) DEFAULT 'Live Production',
    `badge_type` VARCHAR(50) DEFAULT 'live',
    `cover_image` VARCHAR(255) DEFAULT NULL,
    `gallery` LONGTEXT DEFAULT NULL,
    `client_name` VARCHAR(255) DEFAULT NULL,
    `client_logo` VARCHAR(255) DEFAULT NULL,
    `anonymized_name` VARCHAR(255) DEFAULT NULL,
    `client_permission_status` VARCHAR(50) NOT NULL DEFAULT 'approved',
    `client_permission_restrictions` LONGTEXT DEFAULT NULL,
    `internal_notes` TEXT DEFAULT NULL,
    `mockup_host` VARCHAR(255) DEFAULT NULL,
    `mockup_tag1` VARCHAR(100) DEFAULT NULL,
    `mockup_tag2` VARCHAR(100) DEFAULT NULL,
    `stat_1_val` VARCHAR(50) DEFAULT NULL,
    `stat_1_lbl` VARCHAR(100) DEFAULT NULL,
    `stat_2_val` VARCHAR(50) DEFAULT NULL,
    `stat_2_lbl` VARCHAR(100) DEFAULT NULL,
    `stat_3_val` VARCHAR(50) DEFAULT NULL,
    `stat_3_lbl` VARCHAR(100) DEFAULT NULL,
    `problem` TEXT DEFAULT NULL,
    `solution` TEXT DEFAULT NULL,
    `features` LONGTEXT DEFAULT NULL,
    `team_role` TEXT DEFAULT NULL,
    `metric` TEXT DEFAULT NULL,
    `verified_results` TEXT DEFAULT NULL,
    `tags` LONGTEXT DEFAULT NULL,
    `demo_key` VARCHAR(50) DEFAULT NULL,
    `demo_url` VARCHAR(255) DEFAULT NULL,
    `video_url` VARCHAR(255) DEFAULT NULL,
    `live_url` VARCHAR(255) DEFAULT NULL,
    `case_study_url` VARCHAR(255) DEFAULT NULL,
    `case_study_content` LONGTEXT DEFAULT NULL,
    `order_num` INT DEFAULT 0,
    `active` TINYINT(1) DEFAULT 1,
    `status` VARCHAR(20) NOT NULL DEFAULT 'published',
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_project_type` (`project_type`),
    KEY `idx_showcase_status` (`showcase_status`),
    KEY `idx_permission_status` (`client_permission_status`),
    KEY `idx_featured_order` (`is_featured`, `order_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Seed System Roles
INSERT INTO `roles` (`id`, `slug`, `name`, `description`, `color`, `is_system`, `created_at`) VALUES
('role_superadmin', 'superadmin', 'Super Administrator', 'Unrestricted administrative access across all Website modules', 'danger', 1, NOW()),
('role_founder', 'founder', 'Founder', 'Executive oversight across revenue, engineering, operations, and deliverables', 'primary', 1, NOW()),
('role_ceo', 'ceo', 'Chief Executive Officer', 'Executive leadership, approvals, strategy, and full platform governance', 'info', 1, NOW()),
('role_cto', 'cto', 'Chief Technology Officer', 'Technical governance, delivery milestones, AI agents, and system architecture', 'purple', 1, NOW()),
('role_coo', 'coo', 'Chief Operating Officer', 'Operations management, resource dispatch, and cross-team execution', 'indigo', 1, NOW()),
('role_sales_manager', 'sales_manager', 'Sales Manager', 'Authority over sales inquiries, deal scoping, and proposal follow-ups', 'warning', 1, NOW()),
('role_sales', 'sales', 'Sales Executive', 'Inbound inquiry follow-up and discovery scheduling', 'amber', 1, NOW()),
('role_bd', 'bd', 'Business Development', 'Prospecting, inquiry triage, and discovery scheduling', 'cyan', 1, NOW()),
('role_marketing_manager', 'marketing_manager', 'Marketing Manager', 'Lead attribution, showcase publishing, and campaign oversight', 'pink', 1, NOW()),
('role_marketing', 'marketing', 'Growth Marketer', 'Lead generation and campaign monitoring', 'rose', 1, NOW()),
('role_account_manager', 'account_manager', 'Account Manager', 'Client relationship maintenance and deliverables tracking', 'teal', 1, NOW()),
('role_project_manager', 'project_manager', 'Project Manager', 'Delivery schedules, client communications, and showcase updates', 'emerald', 1, NOW()),
('role_lead_developer', 'lead_developer', 'Lead / Senior Engineer', 'Architecture review, deployments, and technical deliverables', 'primary', 1, NOW()),
('role_developer', 'developer', 'Software Engineer', 'Deliverable development and technical task execution', 'blue', 1, NOW()),
('role_ai_engineer', 'ai_engineer', 'AI & ML Engineer', 'AI automation workflows and platform telemetry', 'purple', 1, NOW()),
('role_designer', 'designer', 'UI/UX Designer', 'Product design, UI assets, and portfolio case studies', 'orange', 1, NOW()),
('role_qa', 'qa', 'QA & Security Engineer', 'System testing, security verification gates, and quality telemetry', 'emerald', 1, NOW()),
('role_finance', 'finance', 'Finance & Accounts', 'Budget reconciliation and commercial oversight', 'success', 1, NOW()),
('role_hr', 'hr', 'Human Resources', 'Staff directory, recruitment workflows, and role coordination', 'secondary', 1, NOW()),
('role_support', 'support', 'Customer Support', 'Client inquiries and assistance follow-up', 'cyan', 1, NOW()),
('role_recruiter', 'recruiter', 'Recruitment Manager', 'Manage vacancies, review applications, build forms, schedule interviews, and email candidates', 'cyan', 1, NOW()),
('role_viewer', 'viewer', 'Read-Only Observer', 'Audit and read-only inspection of high-level dashboards and summaries', 'slate', 1, NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `color` = VALUES(`color`);

-- 9. Seed Website Core Permissions (careers.* seeded by 007/CareersSeeder; inquiries.* seeded by 009)
INSERT INTO `permissions` (`id`, `slug`, `module`, `description`, `created_at`) VALUES
('perm_port_view', 'portfolio.view', 'portfolio', 'Browse showcase items, client sandboxes, and telemetry', NOW()),
('perm_port_edit', 'portfolio.edit', 'portfolio', 'Create, edit, and publish client deliverables and case studies', NOW()),
('perm_users_view', 'users.view', 'users', 'Browse user directory, member profiles, and role footprints', NOW()),
('perm_users_create', 'users.create', 'users', 'Provision new employee accounts and assign initial roles', NOW()),
('perm_users_edit', 'users.edit', 'users', 'Update profiles, assign multi-roles, and configure custom permissions', NOW()),
('perm_users_delete', 'users.delete', 'users', 'Deactivate or terminate user accounts', NOW()),
('perm_users_scope', 'users.scope', 'users', 'Modify portal access clearance (Admin Only, CRM Only, Both)', NOW()),
('perm_users_delegate', 'users.delegate', 'users', 'Grant or revoke roles and assign elevated permissions', NOW()),
('perm_roles_manage', 'roles.manage', 'users', 'Create custom roles and configure permission matrices', NOW()),
('perm_appr_view', 'approvals.view', 'approvals', 'Inspect Executive HITL Approval Queue tickets', NOW()),
('perm_appr_decide', 'approvals.decide', 'approvals', 'Authorize or reject privileged elevation tickets', NOW()),
('perm_appr_create', 'approvals.create', 'approvals', 'Submit items into the HITL executive review queue', NOW()),
('perm_set_view', 'settings.view', 'settings', 'Inspect architecture parameters, storage, and telemetry', NOW()),
('perm_set_edit', 'settings.edit', 'settings', 'Modify system configuration and run database migrations', NOW())
ON DUPLICATE KEY UPDATE `module` = VALUES(`module`), `description` = VALUES(`description`);

-- 10. Seed Baseline Role -> Permission Assignments
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `roles` r
JOIN `permissions` p ON p.slug IN (
    'portfolio.view', 'portfolio.edit',
    'users.view', 'users.create', 'users.edit', 'users.delete', 'users.scope', 'users.delegate', 'roles.manage',
    'approvals.view', 'approvals.decide', 'approvals.create',
    'settings.view', 'settings.edit'
)
WHERE r.slug IN ('superadmin', 'founder', 'ceo');

INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `roles` r
JOIN `permissions` p ON p.slug IN (
    'portfolio.view', 'portfolio.edit',
    'users.view', 'users.scope', 'users.delegate',
    'approvals.view', 'settings.view'
)
WHERE r.slug IN ('cto', 'coo');

INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `roles` r
JOIN `permissions` p ON p.slug IN ('users.view', 'users.scope', 'users.delegate')
WHERE r.slug = 'hr';

INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `roles` r
JOIN `permissions` p ON p.slug IN ('portfolio.view', 'settings.view')
WHERE r.slug IN ('lead_developer', 'qa', 'viewer');

SET FOREIGN_KEY_CHECKS = 1;
