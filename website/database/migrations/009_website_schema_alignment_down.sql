-- Down migration for 009_website_schema_alignment.sql
ALTER TABLE `contact_messages`
    DROP INDEX `idx_contact_category`,
    DROP INDEX `idx_contact_status`,
    DROP INDEX `idx_contact_created`,
    DROP INDEX `idx_contact_ref`,
    DROP COLUMN `reference_code`,
    DROP COLUMN `inquiry_category`,
    DROP COLUMN `division`,
    DROP COLUMN `service_interest`,
    DROP COLUMN `engagement_model`,
    DROP COLUMN `partnership_type`,
    DROP COLUMN `partner_role`,
    DROP COLUMN `inquiry_area`,
    DROP COLUMN `country`,
    DROP COLUMN `website`,
    DROP COLUMN `budget`,
    DROP COLUMN `timeline`,
    DROP COLUMN `updated_at`;

ALTER TABLE `users`
    ADD UNIQUE KEY `idx_users_username` (`username`);

DELETE rp FROM `role_permissions` rp
INNER JOIN `permissions` p ON p.id = rp.permission_id
WHERE p.module = 'inquiries';

DELETE FROM `permissions` WHERE `module` = 'inquiries';
