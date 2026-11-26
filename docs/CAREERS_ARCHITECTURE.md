# CodeX404 Solutions — Careers System Architecture

## 1. Technology Stack & Integration
- **Runtime**: PHP 8.2+, Apache `mod_rewrite` (`.htaccess`), MySQL (`codex404_db`) via PDO (`PDO::ATTR_EMULATE_PREPARES => false`).
- **Namespace**: PSR-4 autoloaded `App\Careers\*` under `website/app/Careers/`.
- **Admin Integration**: Integrated directly into `website/admin/` (`auth.php`, `includes/header.php`, `careers.php`, `careers_views/*.php`), utilizing unified `users`, `roles`, `permissions`, and `role_permissions` tables.

## 2. Service Layer Modules (`website/app/Careers/`)
| Module | Responsibility |
| :--- | :--- |
| `CareersDB.php` | PDO connection facade, status/field enums, slugify, reference code generator (`CX-YYYY-XXXXXX` / `CX-TP-XXXXXX`), HMAC IP hashing, CSV formula escaping |
| `VacancyService.php` | Scheduled vacancy auto-publishing (`syncScheduledVacancies`), public category/keyword filtering, admin CRUD, duplication |
| `FormBuilderService.php` | Reusable form template CRUD, per-job field overrides, 11 field types (`short_text`, `long_text`, `email`, `phone`, `number`, `dropdown`, `radio`, `checkbox`, `file`, `date`, `url`), server-side validation, HTML section renderer |
| `FormValidationException.php` | Typed exception carrying field-level validation errors without discarding form state |
| `FileStorageService.php` | Private document ingestion (`website/storage/careers/resumes/YYYY-MM/`), magic-byte & `finfo` verification, traversal prevention, authorized streaming download |
| `ApplicationService.php` | Duplicate protection, candidate profile upsert, transactional application/answer/history writes, pipeline updates, bulk status actions, CSV export, interviews, notes/messages, and Applicant Portal actions |
| `RecruitmentAuthService.php` | Admin RBAC (`Super Admin`, `Recruiter`, `Viewer`) over MySQL + custom permission overrides, and passwordless Email OTP issuance/verification/session management for applicants |
| `RecruitmentEmailService.php` | Template placeholder engine (`{{candidate_name}}`, `{{job_title}}`, `{{application_id}}`, `{{company_name}}`, `{{interview_date}}`, `{{recruiter_name}}`, `{{portal_url}}`, `{{otp_code}}`), STARTTLS/SSL SMTP socket transport, PHP `mail()` fallback, local log simulation, and DB `email_logs` persistence |
| `RecruitmentSettingsService.php` | Typed DB-backed settings (`recruitment_settings`) |
| `ActivityLogService.php` | Unified `recruitment_activity_logs` audit trail and `applicant_notifications` writer |

## 3. URL Routing (`website/.htaccess`)
- `/careers` -> `website/careers.php`
- `/careers/application-status` -> `website/career-status.php`
- `/careers/candidate-portal` -> `website/candidate-portal.php`
- `/careers/candidate-portal/applications` -> `website/candidate-portal.php?view=applications`
- `/careers/candidate-portal/applications/{ref}` -> `website/candidate-portal.php?view=detail&ref={ref}`
- `/careers/resume/{id}` -> `website/career-resume.php?application_id={id}`
- `/careers/{slug}` -> `website/career-detail.php?slug={slug}`
- `/admin/careers` -> `website/admin/careers.php`
