-- CodeX404 Solutions CRM — Complete Database Schema
-- Multi-Role RBAC + Lead/Pipeline Management + Project Delivery

SET FOREIGN_KEY_CHECKS = 0;

-- 1. USERS & MULTI-ROLE RBAC
CREATE TABLE IF NOT EXISTS `users` (
    `id` VARCHAR(36) PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `roles` (
    `id` VARCHAR(36) PRIMARY KEY,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `permissions` (
    `id` VARCHAR(36) PRIMARY KEY,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `module` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `user_roles` (
    `user_id` VARCHAR(36) NOT NULL,
    `role_id` VARCHAR(36) NOT NULL,
    PRIMARY KEY (`user_id`, `role_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_permissions` (
    `role_id` VARCHAR(36) NOT NULL,
    `permission_id` VARCHAR(36) NOT NULL,
    PRIMARY KEY (`role_id`, `permission_id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. COMPANIES & CONTACTS
CREATE TABLE IF NOT EXISTS `crm_companies` (
    `id` VARCHAR(36) PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL,
    `domain` VARCHAR(150),
    `industry` VARCHAR(100),
    `country` VARCHAR(100) DEFAULT 'USA',
    `size` VARCHAR(50),
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `crm_contacts` (
    `id` VARCHAR(36) PRIMARY KEY,
    `company_id` VARCHAR(36) NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50),
    `job_title` VARCHAR(100),
    `is_primary` TINYINT(1) DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`company_id`) REFERENCES `crm_companies`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. LEADS & PIPELINE
CREATE TABLE IF NOT EXISTS `leads` (
    `id` VARCHAR(36) PRIMARY KEY,
    `type` VARCHAR(50) DEFAULT 'discovery_call',
    `source` VARCHAR(100) DEFAULT 'website',
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(50),
    `company_name` VARCHAR(200),
    `country` VARCHAR(100) DEFAULT 'USA',
    `job_title` VARCHAR(100),
    `service_interest` VARCHAR(100),
    `budget` VARCHAR(50),
    `timeline` VARCHAR(50),
    `problem_description` TEXT,
    `status` ENUM('new', 'researching', 'qualified', 'proposal_sent', 'won', 'lost', 'nurture') DEFAULT 'new',
    `lead_score` INT DEFAULT 0,
    `assigned_user_id` VARCHAR(36) NULL,
    `paperclip_issue_id` VARCHAR(100) NULL,
    `raw_payload` JSON NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`assigned_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. OPPORTUNITIES
CREATE TABLE IF NOT EXISTS `opportunities` (
    `id` VARCHAR(36) PRIMARY KEY,
    `lead_id` VARCHAR(36) NULL,
    `company_id` VARCHAR(36) NULL,
    `title` VARCHAR(200) NOT NULL,
    `value` DECIMAL(12,2) DEFAULT 0.00,
    `stage` ENUM('discovery', 'scoping', 'proposal', 'negotiation', 'closed_won', 'closed_lost') DEFAULT 'discovery',
    `probability` INT DEFAULT 20,
    `expected_close_date` DATE NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`lead_id`) REFERENCES `leads`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`company_id`) REFERENCES `crm_companies`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. PROJECTS & CLIENTS
CREATE TABLE IF NOT EXISTS `clients` (
    `id` VARCHAR(36) PRIMARY KEY,
    `company_id` VARCHAR(36) NOT NULL,
    `status` ENUM('active', 'inactive', 'onboarding') DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`company_id`) REFERENCES `crm_companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `crm_projects` (
    `id` VARCHAR(36) PRIMARY KEY,
    `client_id` VARCHAR(36) NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `status` ENUM('planning', 'in_progress', 'qa', 'delivered', 'retainer') DEFAULT 'planning',
    `budget` DECIMAL(12,2) DEFAULT 0.00,
    `paperclip_project_id` VARCHAR(100) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`client_id`) REFERENCES `clients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. ACTIVITIES & AUDIT LOGS
CREATE TABLE IF NOT EXISTS `activities` (
    `id` VARCHAR(36) PRIMARY KEY,
    `entity_type` VARCHAR(50) NOT NULL,
    `entity_id` VARCHAR(36) NOT NULL,
    `user_id` VARCHAR(36) NULL,
    `type` VARCHAR(50) NOT NULL,
    `notes` TEXT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `approvals` (
    `id` VARCHAR(36) PRIMARY KEY,
    `entity_type` ENUM('email_draft', 'social_post', 'proposal_discount', 'deployment') NOT NULL,
    `entity_id` VARCHAR(36) NOT NULL,
    `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    `requested_by` VARCHAR(100) NOT NULL,
    `approved_by` VARCHAR(36) NULL,
    `payload` JSON NOT NULL,
    `decision_notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `resolved_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;


-- CodeX404 Solutions CRM — User Profiling & Multi-Role RBAC Schema Upgrade
-- Adds full profile attributes, custom permission overrides, and comprehensive multi-role matrices

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Upgrade Users Table with Profiling Fields (if not already present)
ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `username` VARCHAR(100) NULL AFTER `name`,
    ADD COLUMN IF NOT EXISTS `phone` VARCHAR(50) NULL AFTER `username`,
    ADD COLUMN IF NOT EXISTS `title` VARCHAR(150) NULL AFTER `phone`,
    ADD COLUMN IF NOT EXISTS `department` VARCHAR(100) NULL AFTER `title`,
    ADD COLUMN IF NOT EXISTS `bio` TEXT NULL AFTER `department`,
    ADD COLUMN IF NOT EXISTS `avatar` VARCHAR(255) NULL AFTER `bio`,
    ADD COLUMN IF NOT EXISTS `custom_permissions` JSON NULL AFTER `avatar`,
    ADD COLUMN IF NOT EXISTS `last_login` DATETIME NULL AFTER `custom_permissions`;

-- Ensure username index exists
CREATE UNIQUE INDEX IF NOT EXISTS `idx_users_username` ON `users` (`username`);

-- 2. Ensure Roles Table has styling metadata
ALTER TABLE `roles`
    ADD COLUMN IF NOT EXISTS `color` VARCHAR(50) DEFAULT 'primary' AFTER `description`,
    ADD COLUMN IF NOT EXISTS `is_system` TINYINT(1) DEFAULT 0 AFTER `color`;

-- 3. Seed Comprehensive Role Catalog
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
('role_ai_engineer', 'ai_engineer', 'AI & ML Engineer', 'Paperclip autonomous agents, model routines, prompt pipelines, and agent swarm telemetry', 'purple', 1, NOW()),
('role_designer', 'designer', 'UI/UX Designer', 'Product design, user flows, UI assets, and showcase case studies', 'orange', 1, NOW()),
('role_qa', 'qa', 'QA & Security Engineer', 'System testing, security scanning, HITL verification gates, and quality telemetry', 'emerald', 1, NOW()),
('role_finance', 'finance', 'Finance & Accounts', 'Invoice management, multi-currency live rates, payment tracking, and budget reconciliation', 'success', 1, NOW()),
('role_hr', 'hr', 'Human Resources', 'Staff directory, internal onboarding, team profiling, and role coordination', 'secondary', 1, NOW()),
('role_support', 'support', 'Customer Support', 'Client inquiries, lead notes, project status inspection, and assistance', 'cyan', 1, NOW()),
('role_viewer', 'viewer', 'Read-Only Observer', 'Audit and read-only inspection of high-level dashboards and summaries', 'slate', 1, NOW())
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`), `color` = VALUES(`color`);

-- 4. Seed Granular Permissions Catalog
INSERT INTO `permissions` (`id`, `slug`, `module`, `description`, `created_at`) VALUES
('perm_leads_view', 'leads.view', 'leads', 'Browse inbound leads and discovery inquiries', NOW()),
('perm_leads_create', 'leads.create', 'leads', 'Ingest or manually register new prospective client', NOW()),
('perm_leads_edit', 'leads.edit', 'leads', 'Modify prospect details, qualification, and lead score', NOW()),
('perm_leads_delete', 'leads.delete', 'leads', 'Remove or disqualify lead records', NOW()),
('perm_leads_convert', 'leads.convert', 'leads', 'Convert qualified lead into an active sales opportunity', NOW()),
('perm_leads_assign', 'leads.assign', 'leads', 'Reassign leads to sales engineers and account executives', NOW()),

('perm_opp_view', 'opportunities.view', 'opportunities', 'Access sales pipeline and Kanban stages', NOW()),
('perm_opp_create', 'opportunities.create', 'opportunities', 'Open new commercial sales opportunity', NOW()),
('perm_opp_edit', 'opportunities.edit', 'opportunities', 'Update deal parameters, valuation, and expected close date', NOW()),
('perm_opp_advance', 'opportunities.advance', 'opportunities', 'Move deals across qualification to negotiation & closed stages', NOW()),
('perm_opp_delete', 'opportunities.delete', 'opportunities', 'Remove opportunity from sales pipeline', NOW()),
('perm_prop_create', 'proposals.create', 'opportunities', 'Draft quotes, contract scopes, and deliverables', NOW()),

('perm_proj_view', 'projects.view', 'projects', 'Access client deliverables and active engineering projects', NOW()),
('perm_proj_create', 'projects.create', 'projects', 'Initialize client deliverable workspace and milestones', NOW()),
('perm_proj_edit', 'projects.edit', 'projects', 'Modify milestones, team leads, and budget allocation', NOW()),
('perm_proj_delete', 'projects.delete', 'projects', 'Archive or remove project', NOW()),
('perm_mile_toggle', 'milestones.toggle', 'projects', 'Sign off on milestone completion and release delivery phases', NOW()),

('perm_appr_view', 'approvals.view', 'approvals', 'Inspect pending AI agent drafts and executive sign-off queue', NOW()),
('perm_appr_decide', 'approvals.decide', 'approvals', 'Authorize or reject high-impact agent actions and discounts', NOW()),
('perm_appr_create', 'approvals.create', 'approvals', 'Submit items into the HITL executive review queue', NOW()),

('perm_pc_view', 'paperclip.view', 'paperclip', 'Monitor Paperclip agent status, telemetry, and execution logs', NOW()),
('perm_pc_dispatch', 'paperclip.dispatch', 'paperclip', 'Delegate ad-hoc tasks to specialist AI routines', NOW()),
('perm_pc_execute', 'paperclip.execute', 'paperclip', 'Run autonomous sales research and draft routines', NOW()),

('perm_users_view', 'users.view', 'users', 'Browse user directory, member profiles, and role footprints', NOW()),
('perm_users_create', 'users.create', 'users', 'Provision new employee accounts and assign initial roles', NOW()),
('perm_users_edit', 'users.edit', 'users', 'Update profiles, assign multi-roles, and configure custom permissions', NOW()),
('perm_users_delete', 'users.delete', 'users', 'Deactivate or terminate user accounts', NOW()),
('perm_roles_manage', 'roles.manage', 'users', 'Create custom roles and configure permission matrices', NOW()),

('perm_fin_view', 'finance.view', 'finance', 'Access deal valuations, pipeline metrics, and project budgets', NOW()),
('perm_fin_rates', 'finance.rates', 'finance', 'Inspect and override live currency exchange conversions', NOW()),

('perm_set_view', 'settings.view', 'settings', 'Inspect architecture parameters, storage, and webhooks', NOW()),
('perm_set_edit', 'settings.edit', 'settings', 'Modify system configuration and API secret tokens', NOW()),

('perm_port_view', 'portfolio.view', 'portfolio', 'Browse showcase items, client sandboxes, and telemetry', NOW()),
('perm_port_edit', 'portfolio.edit', 'portfolio', 'Create, edit, and publish client deliverables and case studies', NOW())
ON DUPLICATE KEY UPDATE `description` = VALUES(`description`), `module` = VALUES(`module`);

SET FOREIGN_KEY_CHECKS = 1;


-- CodeX404 Solutions CRM — Portal Access Scope, Authority Tiers & Delegation Governance Migration
-- Migration: 003_access_scope_and_governance.sql

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Upgrade Users Table with Access Clearance & Approval Status Fields
ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `access_scope` ENUM('both', 'admin_only', 'crm_only') NOT NULL DEFAULT 'crm_only' AFTER `status`,
    ADD COLUMN IF NOT EXISTS `approval_status` VARCHAR(50) NOT NULL DEFAULT 'approved' AFTER `access_scope`,
    ADD COLUMN IF NOT EXISTS `pending_payload` JSON NULL AFTER `approval_status`;

-- Ensure indexing for rapid perimeter authentication lookups
CREATE INDEX IF NOT EXISTS `idx_users_access_scope` ON `users` (`access_scope`);
CREATE INDEX IF NOT EXISTS `idx_users_approval_status` ON `users` (`approval_status`);

-- 2. Seed Granular Delegation, Scope & HITL Approval Permissions
INSERT INTO `permissions` (`id`, `slug`, `module`, `description`, `created_at`) VALUES
('perm_users_scope', 'users.scope', 'users', 'Modify portal access clearance (Admin Only, CRM Only, Both)', NOW()),
('perm_users_delegate', 'users.delegate', 'users', 'Grant or revoke roles and assign elevated permissions', NOW()),
('perm_approvals_view', 'approvals.view', 'approvals', 'Inspect Executive HITL Approval Queue tickets', NOW()),
('perm_approvals_decide', 'approvals.decide', 'approvals', 'Authorize or reject privileged elevation tickets', NOW())
ON DUPLICATE KEY UPDATE `description` = VALUES(`description`);

-- 3. Link Permissions to Supreme & Management Roles
-- Helper role link insertions
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id FROM `roles` r, `permissions` p 
WHERE r.slug IN ('superadmin', 'founder') 
AND p.slug IN ('users.scope', 'users.delegate', 'approvals.view', 'approvals.decide');

INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id FROM `roles` r, `permissions` p 
WHERE r.slug IN ('ceo', 'cto', 'coo') 
AND p.slug IN ('users.scope', 'users.delegate', 'approvals.view');

INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id FROM `roles` r, `permissions` p 
WHERE r.slug = 'hr' 
AND p.slug IN ('users.scope', 'users.delegate');

-- 4. Backfill Initial Production & Seed Accounts
UPDATE `users` SET `access_scope` = 'both', `approval_status` = 'approved' 
WHERE `username` IN ('admin', 'elena.tech');

UPDATE `users` SET `access_scope` = 'crm_only', `approval_status` = 'approved' 
WHERE `username` IN ('marcus.sales', 'sophia.ai');

SET FOREIGN_KEY_CHECKS = 1;


-- ==============================================================================
-- CodeX404 Solutions — Complete MySQL Migration 004
-- Migrates JSON storage data to MySQL InnoDB with foreign keys, JSON columns & indexing
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Ensure Table Structure for users
CREATE TABLE IF NOT EXISTS `users` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(50) NULL,
    `title` VARCHAR(150) NULL,
    `department` VARCHAR(100) NULL,
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
    INDEX `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Ensure Table Structure for leads
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

-- 3. Ensure Table Structure for opportunities
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

-- 4. Ensure Table Structure for crm_projects
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

-- 5. Ensure Table Structure for approvals
CREATE TABLE IF NOT EXISTS `approvals` (
    `id` VARCHAR(100) NOT NULL PRIMARY KEY,
    `type` VARCHAR(50) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `status` VARCHAR(30) DEFAULT 'pending',
    `requested_by` VARCHAR(100) DEFAULT 'Agent',
    `approved_by` VARCHAR(100) NULL,
    `payload` JSON NULL,
    `decision_notes` TEXT NULL,
    `resolved_at` DATETIME NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_approvals_status` (`status`),
    INDEX `idx_approvals_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Ensure Table Structure for paperclip_tasks
CREATE TABLE IF NOT EXISTS `paperclip_tasks` (
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

-- 7. Ensure Table Structure for currency_rates
CREATE TABLE IF NOT EXISTS `currency_rates` (
    `id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `rates` JSON NOT NULL,
    `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;


-- CodeX404 Solutions CRM — Company Hierarchy, Authority Tiers & Approval Rules Migration
-- Migration: 005_company_hierarchy_and_approval_rules.sql

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Upgrade Users Table with Hierarchy (reports_to) and Authority Tier Overrides
ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `reports_to` VARCHAR(50) NULL AFTER `department`,
    ADD COLUMN IF NOT EXISTS `authority_tier` INT NULL DEFAULT 3 AFTER `reports_to`,
    ADD COLUMN IF NOT EXISTS `approval_limit` DECIMAL(15,2) NULL DEFAULT 0.00 AFTER `authority_tier`;

-- Create index and foreign key reference for organizational hierarchy reporting
CREATE INDEX IF NOT EXISTS `idx_users_reports_to` ON `users` (`reports_to`);
CREATE INDEX IF NOT EXISTS `idx_users_authority_tier` ON `users` (`authority_tier`);

-- 2. Create approval_rules Table
-- Governs approval requirement policies (type, monetary threshold, required role, description, and status)
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

-- 3. Create or Ensure audit_logs Table
-- Logs every approval action, privilege escalation, and rule modification with immutable record
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

-- 4. Upgrade Approvals Table to track amount/threshold, rule_id, and requester user id
ALTER TABLE `approvals`
    ADD COLUMN IF NOT EXISTS `amount` DECIMAL(15,2) NULL DEFAULT 0.00 AFTER `title`,
    ADD COLUMN IF NOT EXISTS `requested_user_id` VARCHAR(50) NULL AFTER `requested_by`,
    ADD COLUMN IF NOT EXISTS `rule_id` VARCHAR(50) NULL AFTER `payload`,
    ADD COLUMN IF NOT EXISTS `required_role` VARCHAR(50) NULL AFTER `rule_id`;

CREATE INDEX IF NOT EXISTS `idx_approvals_requested_user` ON `approvals` (`requested_user_id`);
CREATE INDEX IF NOT EXISTS `idx_approvals_rule_id` ON `approvals` (`rule_id`);

-- 5. Seed Core Approval Rules
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

-- 6. Seed Authority Tiers & Hierarchy for Established Accounts
-- Superadmin Alex Rivera: Supreme Tier 1 (Unlimited limit, Reports to None)
UPDATE `users` SET 
    `reports_to` = NULL, 
    `authority_tier` = 1, 
    `approval_limit` = 999999999.00 
WHERE `username` = 'admin';

-- Elena Rostova (CTO): Tier 1 / Tier 2 Executive (Reports to Alex Rivera)
UPDATE `users` SET 
    `reports_to` = 'admin', 
    `authority_tier` = 2, 
    `approval_limit` = 100000.00 
WHERE `username` = 'elena.tech';

-- Marcus Vance (Sales Manager): Tier 2 Management (Reports to Alex Rivera)
UPDATE `users` SET 
    `reports_to` = 'admin', 
    `authority_tier` = 2, 
    `approval_limit` = 25000.00 
WHERE `username` = 'marcus.sales';

-- Sophia Chen (AI Engineer): Tier 3 Standard Workforce (Reports to Elena Rostova)
UPDATE `users` SET 
    `reports_to` = 'usr_tech_elena', 
    `authority_tier` = 3, 
    `approval_limit` = 5000.00 
WHERE `username` = 'sophia.ai';

SET FOREIGN_KEY_CHECKS = 1;


