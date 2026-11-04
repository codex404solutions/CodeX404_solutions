-- CodeX404 Solutions Schema Dump
-- Generated: 2026-11-04 09:20:42
-- Database: codex404_db

SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `activities` (
  `id` varchar(36) NOT NULL,
  `entity_type` varchar(50) NOT NULL,
  `entity_id` varchar(36) NOT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `notes` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `approval_rules` (
  `id` varchar(50) NOT NULL,
  `rule_name` varchar(150) NOT NULL,
  `type` varchar(50) NOT NULL,
  `threshold` decimal(15,2) NOT NULL DEFAULT 0.00,
  `required_role` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_approval_rules_type` (`type`),
  KEY `idx_approval_rules_active` (`is_active`),
  KEY `idx_approval_rules_required_role` (`required_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `approvals` (
  `id` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(15,2) DEFAULT 0.00,
  `status` varchar(30) DEFAULT 'pending',
  `requested_by` varchar(100) DEFAULT 'Agent',
  `requested_user_id` varchar(50) DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `rule_id` varchar(50) DEFAULT NULL,
  `required_role` varchar(50) DEFAULT NULL,
  `decision_notes` text DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_approvals_requested_user` (`requested_user_id`),
  KEY `idx_approvals_rule_id` (`rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `resource_type` varchar(50) NOT NULL,
  `resource_id` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_audit_user` (`user_id`,`action`),
  KEY `idx_audit_resource` (`resource_type`,`resource_id`),
  KEY `idx_audit_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `clients` (
  `id` varchar(36) NOT NULL,
  `company_id` varchar(36) NOT NULL,
  `status` enum('active','inactive','onboarding') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `crm_companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT 'general_contact',
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company` varchar(150) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'new',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `crm_companies` (
  `id` varchar(36) NOT NULL,
  `name` varchar(200) NOT NULL,
  `domain` varchar(150) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'USA',
  `size` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `crm_contacts` (
  `id` varchar(36) NOT NULL,
  `company_id` varchar(36) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `crm_contacts_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `crm_companies` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `crm_projects` (
  `id` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `client` varchar(200) NOT NULL,
  `budget` decimal(15,2) DEFAULT 0.00,
  `status` varchar(50) DEFAULT 'in_progress',
  `progress` int(11) DEFAULT 0,
  `lead_agent` varchar(100) DEFAULT 'Delivery Lead',
  `deadline` date DEFAULT NULL,
  `milestones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`milestones`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `currency_rates` (
  `id` varchar(20) NOT NULL,
  `rates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`rates`)),
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `leads` (
  `id` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'United States',
  `budget` varchar(100) DEFAULT NULL,
  `timeline` varchar(100) DEFAULT NULL,
  `needs` text DEFAULT NULL,
  `lead_score` int(11) DEFAULT 75,
  `status` varchar(50) DEFAULT 'new',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `migration` (`migration`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `opportunities` (
  `id` varchar(100) NOT NULL,
  `lead_id` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `company` varchar(200) NOT NULL,
  `value` decimal(15,2) DEFAULT 0.00,
  `stage` varchar(50) DEFAULT 'discovery',
  `assigned_to` varchar(100) DEFAULT 'Founder',
  `probability` int(11) DEFAULT 50,
  `close_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `paperclip_tasks` (
  `id` varchar(100) NOT NULL,
  `agent` varchar(100) NOT NULL,
  `agent_title` varchar(150) DEFAULT NULL,
  `task_type` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'completed',
  `priority` varchar(20) DEFAULT 'medium',
  `input_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`input_data`)),
  `output_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`output_data`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` varchar(36) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `portfolio_projects` (
  `id` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `category_label` varchar(100) NOT NULL,
  `project_type` varchar(50) NOT NULL DEFAULT 'client',
  `showcase_status` varchar(50) NOT NULL DEFAULT 'live_website',
  `badge_text` varchar(50) DEFAULT 'Live Production',
  `badge_type` varchar(50) DEFAULT 'live',
  `cover_image` varchar(255) DEFAULT NULL,
  `gallery` longtext DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `client_logo` varchar(255) DEFAULT NULL,
  `anonymized_name` varchar(255) DEFAULT NULL,
  `client_permission_status` varchar(50) NOT NULL DEFAULT 'approved',
  `client_permission_restrictions` longtext DEFAULT NULL,
  `internal_notes` text DEFAULT NULL,
  `mockup_host` varchar(255) DEFAULT NULL,
  `mockup_tag1` varchar(100) DEFAULT NULL,
  `mockup_tag2` varchar(100) DEFAULT NULL,
  `stat_1_val` varchar(50) DEFAULT NULL,
  `stat_1_lbl` varchar(100) DEFAULT NULL,
  `stat_2_val` varchar(50) DEFAULT NULL,
  `stat_2_lbl` varchar(100) DEFAULT NULL,
  `stat_3_val` varchar(50) DEFAULT NULL,
  `stat_3_lbl` varchar(100) DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `solution` text DEFAULT NULL,
  `features` longtext DEFAULT NULL,
  `team_role` text DEFAULT NULL,
  `metric` text DEFAULT NULL,
  `verified_results` text DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `demo_key` varchar(50) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `live_url` varchar(255) DEFAULT NULL,
  `case_study_url` varchar(255) DEFAULT NULL,
  `case_study_content` longtext DEFAULT NULL,
  `order_num` int(11) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_project_type` (`project_type`),
  KEY `idx_showcase_status` (`showcase_status`),
  KEY `idx_permission_status` (`client_permission_status`),
  KEY `idx_featured_order` (`is_featured`,`order_num`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` varchar(36) NOT NULL,
  `permission_id` varchar(36) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` varchar(36) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(50) DEFAULT 'primary',
  `is_system` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` varchar(36) NOT NULL,
  `role_id` varchar(36) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `reports_to` varchar(50) DEFAULT NULL,
  `authority_tier` int(11) DEFAULT 3,
  `approval_limit` decimal(15,2) DEFAULT 0.00,
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `custom_permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_permissions`)),
  `last_login` datetime DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` varchar(50) DEFAULT 'admin',
  `status` varchar(20) DEFAULT 'active',
  `access_scope` enum('both','admin_only','crm_only') NOT NULL DEFAULT 'crm_only',
  `approval_status` varchar(50) NOT NULL DEFAULT 'approved',
  `pending_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`pending_payload`)),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `timezone` varchar(100) DEFAULT 'America/New_York',
  `currency` varchar(10) DEFAULT 'USD',
  `last_ip` varchar(50) DEFAULT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`roles`)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `idx_users_username` (`username`),
  KEY `idx_users_access_scope` (`access_scope`),
  KEY `idx_users_approval_status` (`approval_status`),
  KEY `idx_users_reports_to` (`reports_to`),
  KEY `idx_users_authority_tier` (`authority_tier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
