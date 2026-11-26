# CodeX404 Solutions — Careers Routes & Endpoints Reference

## Public Routes
| Method | Route | Handler | Purpose |
| :--- | :--- | :--- | :--- |
| `GET` | `/careers` | `website/careers.php` | Hero, Values, Open Positions (with `?category=` & `?q=`), General Talent Pool form |
| `POST` | `/careers` | `website/careers.php` | General Talent Pool application submission (`form_mode=general_talent_pool`) |
| `GET` | `/careers/{slug}` | `website/career-detail.php` | Shareable vacancy page (`?preview=1` requires active Admin auth) |
| `POST` | `/careers/{slug}` | `website/career-detail.php` | Vacancy application submission with dynamic 11-type field validation & private upload |
| `GET/POST` | `/careers/application-status` | `website/career-status.php` | Passwordless Email OTP request & 6-digit verification step |
| `GET/POST` | `/careers/candidate-portal` | `website/candidate-portal.php` | Authenticated Applicant Dashboard, notifications, preferences, data deletion request |
| `GET` | `/careers/candidate-portal/applications` | `website/candidate-portal.php?view=applications` | List of authenticated candidate's applications |
| `GET/POST` | `/careers/candidate-portal/applications/{ref}` | `website/candidate-portal.php?view=detail&ref={ref}` | Application status timeline, interviews, withdraw action, candidate-recruiter reply thread |
| `GET` | `/careers/resume/{appId}` | `website/career-resume.php` | Authenticated owner-only private CV download |

## Admin Routes (`/admin/careers`)
| Method | URL / Query | Permission Required | Purpose |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin/careers?tab=overview` | `careers.view` | Live KPI counters, recent submissions, audit feed |
| `GET/POST` | `/admin/careers?tab=jobs` | `careers.view` / `careers.jobs.manage` | Vacancy CRUD, draft/schedule/publish/close/archive, duplicate, category creation |
| `GET/POST` | `/admin/careers?tab=applications` | `careers.applications.view` / `.manage` | Search, filter, sort, paginate, bulk pipeline transitions |
| `GET/POST` | `/admin/careers?tab=candidate-detail&id={id}` | `careers.applications.view` / `.manage` / `careers.interviews.manage` | Full answers review, stage transition, recruiter assignment, private notes, public messages, interview scheduling |
| `GET/POST` | `/admin/careers?tab=form-builder` | `careers.forms.manage` | Reusable template manager & per-job custom field builder |
| `GET/POST` | `/admin/careers?tab=emails` | `careers.emails.manage` | Edit notification templates & inspect delivery logs |
| `GET/POST` | `/admin/careers?tab=recruiters` | `careers.view` / `careers.settings.manage` | Staff role matrix & `Super Admin` / `Recruiter` / `Viewer` role assignment |
| `GET/POST` | `/admin/careers?tab=settings` | `careers.settings.manage` | Upload limits, OTP settings, sender details, general pool & portal toggles |
| `GET` | `/admin/careers?tab=logs` | `careers.logs.view` | Recruitment audit log feed |
| `GET` | `/admin/careers?tab=export` | `careers.candidates.export` | Filtered CSV download |
| `GET` | `/admin/careers?tab=resume&app_id={id}` | `careers.candidates.export` | Authenticated recruiter CV/attachment stream download |
