# CodeX404 Solutions — Careers & Applicant Portal Security Architecture

## 1. Authentication & Authorization (RBAC)
- **Admin Dashboard (`/admin/careers`)**: Guarded by `require_admin_auth()` (persistent account lockout, IP binding, 30-min idle / 8-hour absolute timeout, Strict SameSite session cookies).
- **Backend RBAC Enforcement**: Every admin route and POST handler checks `RecruitmentAuthService::requirePermission(...)` backed by MySQL `roles`, `permissions`, and `role_permissions`:
  - `Super Admin` (`superadmin`/`founder`/`ceo`): Full access including RBAC and settings.
  - `Recruiter` (`recruiter`/`hr`): Vacancies, forms, pipeline transitions, interviews, emails, CSV/CV exports.
  - `Viewer` (`viewer`): Strict read-only access to overview and application views; rejected (`HTTP 403`) on all mutations, exports, and CV downloads.
- **Applicant Portal**: Passwordless authentication using 6-digit CSPRNG OTP (`random_int`), hashed via `password_hash()`, single-use (`consumed_at`), 10-minute expiration, max 5 failed verification attempts, resend cooldown enforcement, and HTTP-only session tokens hashed with SHA-256 in `applicant_sessions`.

## 2. File Upload & Private Storage Security
- Resumes and attachment fields are stored under `website/storage/careers/resumes/YYYY-MM/` with random 24-hex prefixes.
- `website/storage/careers/.htaccess` enforces `Require all denied` / `Deny from all` so no resume can ever be fetched by guessing a URL.
- Uploads verify allowed extension (`pdf,doc,docx`), size cap, `finfo` MIME type, AND file magic signatures (`%PDF-` for PDF, `PK\x03\x04` for DOCX).
- Downloads pass exclusively through authenticated streaming controllers (`admin/careers?tab=resume` with `careers.candidates.export`, or `career-resume.php` verifying `candidate_id` ownership).

## 3. Injection, CSRF, XSS & Spam Controls
- **SQL Injection**: 100% PDO prepared statements with `PDO::ATTR_EMULATE_PREPARES => false`.
- **CSRF**: `verify_csrf_token()` enforced on every public, portal, and admin POST endpoint.
- **XSS**: Context-aware `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')` on all rendered HTML and form previews.
- **CSV Injection**: `CareersDB::csvCell()` prepends `'` to cells starting with `=`, `+`, `-`, `@`, tab, or CR.
- **Cross-Applicant Isolation (IDOR)**: Every Applicant Portal query binds `WHERE candidate_id = ?` from the server-verified session.
- **OTP & Email Privacy**: Plaintext OTPs are never stored in DB or written to `email_logs.body_preview`.
- **Spam / Flood Defense**: Persistent IP + session rate limiting (`check_rate_limit`) and hidden honeypot inputs on application forms.
