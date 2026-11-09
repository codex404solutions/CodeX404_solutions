-- ==============================================================================
-- CodeX404 Solutions — Complete Production MySQL Database Schema & Seed Data
-- Database: codex404_db (or your Hostinger database u274161808_codex404_db)
-- Clean importable script: idempotent, creates all tables with full relationships
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- -------------------------------------------------------------
-- 1. USERS & MULTI-ROLE RBAC TABLE
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(50) NULL,
    `title` VARCHAR(150) NULL,
    `department` VARCHAR(100) NULL,
    `reports_to` VARCHAR(50) NULL,
    `authority_tier` INT NULL DEFAULT 3,
    `approval_limit` DECIMAL(15,2) NULL DEFAULT 0.00,
    `bio` TEXT NULL,
    `avatar` VARCHAR(255) NULL,
    `role` VARCHAR(50) DEFAULT 'admin',
    `roles` JSON NULL,
    `custom_permissions` JSON NULL,
    `status` VARCHAR(20) DEFAULT 'active',
    `access_scope` ENUM('both', 'admin_only', 'crm_only') NOT NULL DEFAULT 'crm_only',
    `approval_status` VARCHAR(50) NOT NULL DEFAULT 'approved',
    `pending_payload` JSON NULL,
    `timezone` VARCHAR(100) DEFAULT 'America/New_York',
    `currency` VARCHAR(10) DEFAULT 'USD',
    `last_login` DATETIME NULL,
    `last_ip` VARCHAR(50) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_users_access_scope` (`access_scope`),
    INDEX `idx_users_approval_status` (`approval_status`),
    INDEX `idx_users_status` (`status`),
    INDEX `idx_users_reports_to` (`reports_to`),
    INDEX `idx_users_authority_tier` (`authority_tier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 2. ROLES CATALOG
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `roles` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `color` VARCHAR(50) DEFAULT 'primary',
    `is_system` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 3. PERMISSIONS CATALOG
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `permissions` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `module` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 4. JUNCTION TABLES: USER_ROLES & ROLE_PERMISSIONS
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_roles` (
    `user_id` VARCHAR(50) NOT NULL,
    `role_id` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    INDEX `idx_ur_user` (`user_id`),
    INDEX `idx_ur_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id` VARCHAR(50) NOT NULL,
    `permission_id` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    INDEX `idx_rp_role` (`role_id`),
    INDEX `idx_rp_permission` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 5. LEADS TABLE
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `leads` (
    `id` VARCHAR(100) NOT NULL PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `company_name` VARCHAR(200) NULL,
    `phone` VARCHAR(50) NULL,
    `country` VARCHAR(100) DEFAULT 'United States',
    `budget` VARCHAR(100) NULL,
    `timeline` VARCHAR(100) NULL,
    `needs` TEXT NULL,
    `lead_score` INT DEFAULT 75,
    `status` VARCHAR(50) DEFAULT 'new',
    `notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_leads_status` (`status`),
    INDEX `idx_leads_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 6. OPPORTUNITIES TABLE
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `opportunities` (
    `id` VARCHAR(100) NOT NULL PRIMARY KEY,
    `lead_id` VARCHAR(100) NULL,
    `title` VARCHAR(255) NOT NULL,
    `company` VARCHAR(200) NOT NULL,
    `value` DECIMAL(15,2) DEFAULT 0.00,
    `stage` VARCHAR(50) DEFAULT 'discovery',
    `assigned_to` VARCHAR(100) DEFAULT 'Founder',
    `probability` INT DEFAULT 50,
    `close_date` DATE NULL,
    `notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_opp_stage` (`stage`),
    INDEX `idx_opp_lead_id` (`lead_id`),
    INDEX `idx_opp_assigned` (`assigned_to`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 7. CLIENT PROJECTS TABLE
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_projects` (
    `id` VARCHAR(100) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `client` VARCHAR(200) NOT NULL,
    `budget` DECIMAL(15,2) DEFAULT 0.00,
    `status` VARCHAR(50) DEFAULT 'in_progress',
    `progress` INT DEFAULT 0,
    `lead_agent` VARCHAR(100) DEFAULT 'Delivery Lead',
    `deadline` DATE NULL,
    `milestones` JSON NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_projects_status` (`status`),
    INDEX `idx_projects_lead` (`lead_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 8. APPROVAL_RULES TABLE (GOVERNANCE POLICIES)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `approval_rules` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `rule_name` VARCHAR(150) NOT NULL,
    `type` VARCHAR(50) NOT NULL,
    `threshold` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `required_role` VARCHAR(50) NOT NULL,
    `description` TEXT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_by` VARCHAR(50) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_approval_rules_type` (`type`),
    INDEX `idx_approval_rules_active` (`is_active`),
    INDEX `idx_approval_rules_required_role` (`required_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 9. APPROVALS TABLE (HITL QUEUE TICKETS)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `approvals` (
    `id` VARCHAR(100) NOT NULL PRIMARY KEY,
    `type` VARCHAR(50) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `amount` DECIMAL(15,2) NULL DEFAULT 0.00,
    `status` VARCHAR(30) DEFAULT 'pending',
    `requested_by` VARCHAR(100) DEFAULT 'Agent',
    `requested_user_id` VARCHAR(50) NULL,
    `approved_by` VARCHAR(100) NULL,
    `payload` JSON NULL,
    `rule_id` VARCHAR(50) NULL,
    `required_role` VARCHAR(50) NULL,
    `decision_notes` TEXT NULL,
    `resolved_at` DATETIME NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_approvals_status` (`status`),
    INDEX `idx_approvals_type` (`type`),
    INDEX `idx_approvals_requested_user` (`requested_user_id`),
    INDEX `idx_approvals_rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 10. AUDIT_LOGS TABLE (IMMUTABLE AUDIT TRAIL)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `user_id` VARCHAR(50) NULL,
    `username` VARCHAR(100) NULL,
    `action` VARCHAR(100) NOT NULL,
    `resource_type` VARCHAR(50) NOT NULL,
    `resource_id` VARCHAR(100) NULL,
    `details` TEXT NULL,
    `changes` JSON NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_audit_user` (`user_id`, `action`),
    INDEX `idx_audit_resource` (`resource_type`, `resource_id`),
    INDEX `idx_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 11. CRM AUTONOMOUS TASKS
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `crm_tasks` (
    `id` VARCHAR(100) NOT NULL PRIMARY KEY,
    `agent` VARCHAR(100) NOT NULL,
    `agent_title` VARCHAR(150) NULL,
    `task_type` VARCHAR(100) NULL,
    `title` VARCHAR(255) NOT NULL,
    `status` VARCHAR(50) DEFAULT 'completed',
    `priority` VARCHAR(20) DEFAULT 'medium',
    `input_data` JSON NULL,
    `output_data` JSON NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `completed_at` DATETIME NULL,
    INDEX `idx_tasks_agent` (`agent`),
    INDEX `idx_tasks_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 12. CURRENCY EXCHANGE RATES TABLE
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `currency_rates` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `rates` JSON NOT NULL,
    `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- 13. SEED STANDARD ROLES
-- -------------------------------------------------------------
INSERT INTO `roles` (`id`, `slug`, `name`, `description`, `color`, `is_system`, `created_at`) VALUES
('role_superadmin', 'superadmin', 'Super Administrator', 'Unrestricted administrative access across all CRM & Website modules', 'danger', 1, NOW()),
('role_founder', 'founder', 'Founder', 'Executive oversight across revenue, engineering, finances, and company deliverables', 'primary', 1, NOW()),
('role_ceo', 'ceo', 'Chief Executive Officer', 'Executive leadership, broad pipeline, finance, approvals, and high-level strategy', 'info', 1, NOW()),
('role_cto', 'cto', 'Chief Technology Officer', 'Technical governance, delivery milestones, AI agents, and system architecture', 'purple', 1, NOW()),
('role_coo', 'coo', 'Chief Operating Officer', 'Operations management, resource dispatch, milestone tracking, and cross-team execution', 'indigo', 1, NOW()),
('role_sales_manager', 'sales_manager', 'Sales Manager', 'Full authority over sales pipeline, deal scoping, lead assignments, and proposal sign-offs', 'warning', 1, NOW()),
('role_sales', 'sales', 'Sales Executive', 'Assigned lead nurturing, discovery calls, pipeline progression, and quote creation', 'amber', 1, NOW()),
('role_bd', 'bd', 'Business Development', 'Prospecting, lead qualification, market research, and discovery scheduling', 'cyan', 1, NOW()),
('role_marketing_manager', 'marketing_manager', 'Marketing Manager', 'Lead attribution, campaign orchestration, marketing drafts, and content approvals', 'pink', 1, NOW()),
('role_marketing', 'marketing', 'Growth Marketer', 'Lead generation, social/email draft submissions, and campaign monitoring', 'rose', 1, NOW()),
('role_account_manager', 'account_manager', 'Account Manager', 'Client relationship maintenance, project deliverables tracking, and retainer renewals', 'teal', 1, NOW()),
('role_project_manager', 'project_manager', 'Project Manager', 'Sprint management, delivery schedules, client communications, and milestone tracking', 'emerald', 1, NOW()),
('role_lead_developer', 'lead_developer', 'Lead / Senior Engineer', 'Architecture review, code deployments, engineering milestone completion, and technical tasks', 'primary', 1, NOW()),
('role_developer', 'developer', 'Software Engineer', 'Assigned project deliverable development and technical task completion', 'blue', 1, NOW()),
('role_ai_engineer', 'ai_engineer', 'AI & ML Engineer', 'Autonomous AI operations, model routines, prompt pipelines, and telemetry', 'purple', 1, NOW()),
('role_designer', 'designer', 'UI/UX Designer', 'Product design, user flows, UI assets, and showcase case studies', 'orange', 1, NOW()),
('role_qa', 'qa', 'QA & Security Engineer', 'System testing, security scanning, HITL verification gates, and quality telemetry', 'emerald', 1, NOW()),
('role_finance', 'finance', 'Finance & Accounts', 'Invoice management, multi-currency live rates, payment tracking, and budget reconciliation', 'success', 1, NOW()),
('role_hr', 'hr', 'Human Resources', 'Staff directory, internal onboarding, team profiling, and role coordination', 'secondary', 1, NOW()),
('role_support', 'support', 'Customer Support', 'Client inquiries, lead notes, project status inspection, and assistance', 'cyan', 1, NOW()),
('role_viewer', 'viewer', 'Read-Only Observer', 'Audit and read-only inspection of high-level dashboards and summaries', 'slate', 1, NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `color` = VALUES(`color`);

-- -------------------------------------------------------------
-- 14. SEED CORE APPROVAL RULES
-- -------------------------------------------------------------
INSERT INTO `approval_rules` (`id`, `rule_name`, `type`, `threshold`, `required_role`, `description`, `is_active`, `created_by`) VALUES
('rule_discount_low', 'Standard Discount Approval', 'proposal_discount', 5000.00, 'sales_manager', 'Custom discounts up to $5,000 require Sales Manager sign-off', 1, 'admin'),
('rule_discount_high', 'Executive Pricing / High Discount Approval', 'proposal_discount', 20000.00, 'ceo', 'Discounts exceeding $20,000 require CEO or Founder authorization', 1, 'admin'),
('rule_project_budget', 'Project Scope & Budget Elevation', 'project_budget', 50000.00, 'coo', 'Project budget extensions or commitments > $50,000 require COO approval', 1, 'admin'),
('rule_email_outbound', 'Mass Outbound Email Campaign', 'email_draft', 0.00, 'marketing_manager', 'Outbound email sequences require Marketing Manager approval', 1, 'admin'),
('rule_social_broadcast', 'Brand Social Broadcast', 'social_post', 0.00, 'marketing_manager', 'Brand public broadcasts require Marketing Manager approval', 1, 'admin'),
('rule_prod_deploy', 'Production Core Deployment', 'deployment', 0.00, 'cto', 'Core server deployment and architecture commits require CTO approval', 1, 'admin'),
('rule_privilege_elevation', 'Superadmin Privilege Escalation Gate', 'privilege_elevation', 0.00, 'superadmin', 'Granting executive roles or cross-portal dual clearance requires Superadmin authorization', 1, 'admin'),
('rule_account_provision', 'Elevated Account Provisioning Gate', 'user_provisioning_elevation', 0.00, 'superadmin', 'Provisioning new administrative accounts requires Superadmin sign-off', 1, 'admin')
ON DUPLICATE KEY UPDATE 
    `rule_name` = VALUES(`rule_name`),
    `threshold` = VALUES(`threshold`),
    `required_role` = VALUES(`required_role`),
    `description` = VALUES(`description`);

-- -------------------------------------------------------------
-- 15. SEED INITIAL WORKFORCE WITH REPORTING HIERARCHY & TIERS
-- -------------------------------------------------------------
INSERT INTO `users` (
    `id`, `username`, `email`, `password_hash`, `name`, `phone`, `title`, 
    `department`, `reports_to`, `authority_tier`, `approval_limit`, `bio`, 
    `avatar`, `role`, `roles`, `custom_permissions`, `status`, `access_scope`, 
    `approval_status`, `timezone`, `currency`, `created_at`
) VALUES
('admin', 'admin', 'admin@codex404solutions.online', '$2y$10$q58y2Yv1JmmRkZ5bX/F./OwcNctXmogo0UHU86tHB/WjdpV1HsIXK', 'Alex Rivera', '+1 (415) 555-0140', 'Chief Executive Officer & Founder', 'Executive Leadership', NULL, 1, 999999999.00, 'Founder & Principal Systems Architect at CodeX404 Solutions.', 'assets/images/avatars/avatar_admin.jpg', 'superadmin', '["superadmin","founder","ceo","cto"]', '{"granted":[],"denied":[]}', 'active', 'both', 'approved', 'America/New_York', 'USD', NOW()),
('usr_tech_elena', 'elena.tech', 'elena.rostova@codex404solutions.online', '$2y$10$q58y2Yv1JmmRkZ5bX/F./OwcNctXmogo0UHU86tHB/WjdpV1HsIXK', 'Elena Rostova', '+1 (415) 555-0198', 'Chief Technology Officer', 'Engineering & Architecture', 'admin', 2, 100000.00, 'Full-stack distributed systems architect.', 'assets/images/avatars/avatar_cto.jpg', 'cto', '["cto","lead_developer","project_manager"]', '{"granted":[],"denied":[]}', 'active', 'both', 'approved', 'America/New_York', 'USD', NOW()),
('usr_sales_marcus', 'marcus.sales', 'marcus.vance@codex404solutions.online', '$2y$10$q58y2Yv1JmmRkZ5bX/F./OwcNctXmogo0UHU86tHB/WjdpV1HsIXK', 'Marcus Vance', '+1 (415) 555-0182', 'Sales Director & Account Lead', 'Revenue & Partnerships', 'admin', 2, 25000.00, 'Enterprise client partnerships lead.', 'assets/images/avatars/avatar_sales.jpg', 'sales_manager', '["sales_manager","sales","bd"]', '{"granted":[],"denied":[]}', 'active', 'crm_only', 'approved', 'America/New_York', 'USD', NOW()),
('usr_ai_sophia', 'sophia.ai', 'dr.sophia.chen@codex404solutions.online', '$2y$10$q58y2Yv1JmmRkZ5bX/F./OwcNctXmogo0UHU86tHB/WjdpV1HsIXK', 'Dr. Sophia Chen', '+1 (415) 555-0176', 'AI Research Lead & Agent Architect', 'Autonomous Intelligence', 'usr_tech_elena', 3, 5000.00, 'Autonomous multi-agent systems researcher.', 'assets/images/avatars/avatar_ai.jpg', 'ai_engineer', '["ai_engineer","developer"]', '{"granted":[],"denied":[]}', 'active', 'crm_only', 'approved', 'America/New_York', 'USD', NOW())
ON DUPLICATE KEY UPDATE 
    `password_hash` = VALUES(`password_hash`),
    `reports_to` = VALUES(`reports_to`),
    `authority_tier` = VALUES(`authority_tier`),
    `approval_limit` = VALUES(`approval_limit`),
    `access_scope` = VALUES(`access_scope`),
    `roles` = VALUES(`roles`);

-- Seed currency rates
INSERT INTO `currency_rates` (`id`, `rates`, `updated_at`)
VALUES ('rates', '{"USD":1.0,"INR":95.05,"EUR":0.89,"GBP":0.75,"AED":3.67,"CAD":1.36,"AUD":1.51,"SGD":1.31}', UNIX_TIMESTAMP())
ON DUPLICATE KEY UPDATE `rates` = VALUES(`rates`), `updated_at` = VALUES(`updated_at`);

SET FOREIGN_KEY_CHECKS = 1;
