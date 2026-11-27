-- Migration 008: Admin Portal Audit Logs
CREATE TABLE IF NOT EXISTS `admin_audit_logs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `actor_id` VARCHAR(64) NULL,
    `actor_username` VARCHAR(100) NULL,
    `action` VARCHAR(100) NOT NULL,
    `entity_type` VARCHAR(64) NOT NULL,
    `entity_id` VARCHAR(64) NULL,
    `summary` VARCHAR(255) NOT NULL,
    `metadata_json` LONGTEXT NULL,
    `ip_address` VARCHAR(64) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_admin_audit_action` (`action`),
    KEY `idx_admin_audit_entity` (`entity_type`, `entity_id`),
    KEY `idx_admin_audit_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
