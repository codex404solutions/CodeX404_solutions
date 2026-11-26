# CodeX404 Solutions — Careers & Recruitment Database Schema

## 1. Migrations
- **Forward Migration**: `website/database/migrations/007_careers_recruitment_system.sql`
- **Rollback Migration**: `website/database/migrations/007_careers_recruitment_system_down.sql`
- **Idempotent Runner & Seed Script**: `php website/database/migrate_careers.php`

## 2. Tables Overview (20 Tables)
1. `job_categories` — Public filter categories (`Marketing`, `Sales & Business Development`, `Internship`, `Fellowship`, `Engineering & Technology`).
2. `application_form_templates` — Reusable templates (`Default`, `Marketing`, `Sales`, `Internship`, `Fellowship`, `Custom`).
3. `job_openings` — Vacancies (`slug`, metadata, descriptions, `status`, `scheduled_publish_at`, `application_deadline`, `form_template_id`, `use_custom_form`).
4. `application_form_fields` — Dynamic form field definitions (`template_id` OR `job_opening_id`, 11 supported types, `options_json`, `validation_rules_json`, `sort_order`).
5. `candidate_profiles` — Canonical applicant records keyed uniquely by `email`, storing contact metadata, notification toggles, tags, pool status, and deletion request timestamps.
6. `applications` — Submissions linked to `candidate_profiles` and optional `job_openings` (`NULL` for `general_talent_pool`), unique `reference_code`, pipeline `status`, private `resume_path`, `answers_snapshot_json`.
7. `application_answers` — Normalized per-field answers + optional uploaded file attachments.
8. `application_status_history` — Immutable pipeline progression timeline (separates `public_note` from `internal_note`).
9. `recruiter_assignments` — Recruiter-to-application ownership mapping.
10. `recruiter_notes` — Private staff-only evaluation notes (`is_pinned`). Never exposed to Applicant Portal queries.
11. `candidate_messages` — Bidirectional recruiter <-> candidate messages shown inside both Admin and Applicant Portal.
12. `interview_schedules` — Interview round, mode (`video|phone|onsite|technical_panel`), date/time, timezone, interviewer details, meeting URL, and instructions.
13. `email_templates` — Editable subject, HTML, and plain-text templates with token substitution.
14. `email_logs` — Audit history of all sent/simulated/failed emails (`otp_code` redacted from `body_preview`).
15. `recruitment_settings` — Key/value platform settings (upload limits, OTP TTL, cooldowns, sender details, feature toggles).
16. `recruitment_activity_logs` — Security & administrative audit trail across vacancies, applications, RBAC, forms, settings, and portal logins.
17. `applicant_accounts` — Passwordless Applicant Portal identities linked 1:1 with `candidate_profiles`.
18. `applicant_otp_verifications` — Single-use OTP records storing bcrypt `otp_hash`, `attempt_count`, `expires_at`, and `consumed_at`.
19. `applicant_sessions` — Active portal sessions storing SHA-256 `token_hash` (never raw cookie token) with `expires_at` and `revoked_at`.
20. `applicant_notifications` — In-portal alert inbox per candidate with read/unread tracking.
