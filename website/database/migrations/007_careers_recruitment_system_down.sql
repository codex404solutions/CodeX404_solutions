-- ============================================================================
-- CodeX404 Solutions — Careers, Recruitment & Applicant Portal System
-- Rollback Migration: 007_careers_recruitment_system_down.sql
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `applicant_notifications`;
DROP TABLE IF EXISTS `applicant_sessions`;
DROP TABLE IF EXISTS `applicant_otp_verifications`;
DROP TABLE IF EXISTS `applicant_accounts`;
DROP TABLE IF EXISTS `recruitment_activity_logs`;
DROP TABLE IF EXISTS `recruitment_settings`;
DROP TABLE IF EXISTS `email_logs`;
DROP TABLE IF EXISTS `email_templates`;
DROP TABLE IF EXISTS `interview_schedules`;
DROP TABLE IF EXISTS `candidate_messages`;
DROP TABLE IF EXISTS `recruiter_notes`;
DROP TABLE IF EXISTS `recruiter_assignments`;
DROP TABLE IF EXISTS `application_status_history`;
DROP TABLE IF EXISTS `application_answers`;
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `candidate_profiles`;
DROP TABLE IF EXISTS `application_form_fields`;
DROP TABLE IF EXISTS `job_openings`;
DROP TABLE IF EXISTS `application_form_templates`;
DROP TABLE IF EXISTS `job_categories`;

DELETE FROM `role_permissions` WHERE `permission_id` LIKE 'perm_careers_%';
DELETE FROM `permissions` WHERE `id` LIKE 'perm_careers_%';
DELETE FROM `roles` WHERE `id` = 'role_recruiter';
DELETE FROM `migrations` WHERE `migration` = '007_careers_recruitment_system.sql';

SET FOREIGN_KEY_CHECKS = 1;
