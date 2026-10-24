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
