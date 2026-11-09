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
('role_ai_engineer', 'ai_engineer', 'AI & ML Engineer', 'Autonomous AI operations, model routines, prompt pipelines, and telemetry', 'purple', 1, NOW()),
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
