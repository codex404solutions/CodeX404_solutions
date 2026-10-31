-- ==============================================================================
-- CodeX404 Solutions — Database Migration 006
-- Portfolio Projects Upgrade: Project Types, Showcase Status, Client Permissions,
-- Media Galleries, Detailed Case Studies, and Verified Business Outcomes
-- ==============================================================================

ALTER TABLE `portfolio_projects`
    ADD COLUMN `project_type` VARCHAR(50) NOT NULL DEFAULT 'client' AFTER `category_label`,
    ADD COLUMN `showcase_status` VARCHAR(50) NOT NULL DEFAULT 'live_website' AFTER `project_type`,
    ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'published' AFTER `active`,
    ADD COLUMN `is_featured` TINYINT(1) NOT NULL DEFAULT 0 AFTER `status`,
    ADD COLUMN `cover_image` VARCHAR(255) NULL AFTER `badge_type`,
    ADD COLUMN `gallery` LONGTEXT NULL AFTER `cover_image`,
    ADD COLUMN `client_name` VARCHAR(255) NULL AFTER `gallery`,
    ADD COLUMN `client_logo` VARCHAR(255) NULL AFTER `client_name`,
    ADD COLUMN `anonymized_name` VARCHAR(255) NULL AFTER `client_logo`,
    ADD COLUMN `client_permission_status` VARCHAR(50) NOT NULL DEFAULT 'approved' AFTER `anonymized_name`,
    ADD COLUMN `client_permission_restrictions` LONGTEXT NULL AFTER `client_permission_status`,
    ADD COLUMN `internal_notes` TEXT NULL AFTER `client_permission_restrictions`,
    ADD COLUMN `features` LONGTEXT NULL AFTER `solution`,
    ADD COLUMN `team_role` TEXT NULL AFTER `features`,
    ADD COLUMN `verified_results` TEXT NULL AFTER `metric`,
    ADD COLUMN `demo_url` VARCHAR(255) NULL AFTER `demo_key`,
    ADD COLUMN `video_url` VARCHAR(255) NULL AFTER `demo_url`,
    ADD COLUMN `case_study_content` LONGTEXT NULL AFTER `case_study_url`;

-- Optional indexes for fast portfolio queries
ALTER TABLE `portfolio_projects`
    ADD INDEX `idx_project_type` (`project_type`),
    ADD INDEX `idx_showcase_status` (`showcase_status`),
    ADD INDEX `idx_permission_status` (`client_permission_status`),
    ADD INDEX `idx_featured_order` (`is_featured`, `order_num`);

