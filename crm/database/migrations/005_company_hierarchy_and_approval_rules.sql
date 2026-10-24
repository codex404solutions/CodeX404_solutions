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
