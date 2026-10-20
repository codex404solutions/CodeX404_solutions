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
