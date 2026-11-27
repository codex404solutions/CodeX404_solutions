-- Migration 009: Align codex404_db strictly with Website schema
-- 1) Upgrade contact_messages to store all 4 Contact categories, Discovery Call, and Chatbot fields
-- 2) Remove redundant index on users
-- 3) Remove unused CRM-only permissions (finance, leads, opportunities, paperclip, projects)
-- 4) Add website inquiries permissions (inquiries.view, inquiries.manage)
-- 5) Clean seeded dummy contact test rows

ALTER TABLE `contact_messages`
    ADD COLUMN `reference_code` VARCHAR(64) NULL AFTER `type`,
    ADD COLUMN `inquiry_category` VARCHAR(32) NOT NULL DEFAULT 'project' AFTER `reference_code`,
    ADD COLUMN `division` VARCHAR(20) NULL AFTER `inquiry_category`,
    ADD COLUMN `service_interest` VARCHAR(120) NULL AFTER `division`,
    ADD COLUMN `engagement_model` VARCHAR(80) NULL AFTER `service_interest`,
    ADD COLUMN `partnership_type` VARCHAR(80) NULL AFTER `engagement_model`,
    ADD COLUMN `partner_role` VARCHAR(100) NULL AFTER `partnership_type`,
    ADD COLUMN `inquiry_area` VARCHAR(80) NULL AFTER `partner_role`,
    ADD COLUMN `country` VARCHAR(100) NULL AFTER `company`,
    ADD COLUMN `website` VARCHAR(255) NULL AFTER `country`,
    ADD COLUMN `budget` VARCHAR(60) NULL AFTER `website`,
    ADD COLUMN `timeline` VARCHAR(60) NULL AFTER `budget`,
    ADD COLUMN `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`,
    ADD KEY `idx_contact_category` (`inquiry_category`),
    ADD KEY `idx_contact_status` (`status`),
    ADD KEY `idx_contact_created` (`created_at`),
    ADD KEY `idx_contact_ref` (`reference_code`);

-- Drop redundant duplicate unique index on users.username
ALTER TABLE `users`
    DROP INDEX `idx_users_username`;

-- Remove dead CRM-only permission mappings & permissions not used anywhere in website/
DELETE rp FROM `role_permissions` rp
INNER JOIN `permissions` p ON p.id = rp.permission_id
WHERE p.module IN ('finance', 'leads', 'opportunities', 'paperclip', 'projects');

DELETE FROM `permissions`
WHERE `module` IN ('finance', 'leads', 'opportunities', 'paperclip', 'projects');

-- Add website Inquiries permissions
INSERT INTO `permissions` (`id`, `slug`, `module`, `description`)
VALUES
    ('perm_inquiries_view', 'inquiries.view', 'inquiries', 'View website contact and discovery call inquiries'),
    ('perm_inquiries_manage', 'inquiries.manage', 'inquiries', 'Update inquiry status and remove spam entries')
ON DUPLICATE KEY UPDATE
    `module` = VALUES(`module`),
    `description` = VALUES(`description`);

-- Grant inquiry permissions to relevant management / outreach roles
INSERT IGNORE INTO `role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `roles` r
JOIN `permissions` p ON p.slug IN ('inquiries.view', 'inquiries.manage')
WHERE LOWER(r.slug) IN ('superadmin', 'founder', 'ceo', 'cto', 'coo', 'sales_manager', 'bd', 'support');

-- Remove seeded dummy contact rows from initial build
DELETE FROM `contact_messages`
WHERE `email` = 'sarah.connor@cyberdyne.example' AND `ip_address` IS NULL;
