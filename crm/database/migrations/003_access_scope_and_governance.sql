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
