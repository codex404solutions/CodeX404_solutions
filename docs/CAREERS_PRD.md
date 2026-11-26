# CodeX404 Solutions — Careers, Recruitment & Applicant Portal PRD

## 1. Objective & Scope
Provide a database-driven, full-lifecycle **Careers & Recruitment Management System** and **Passwordless Applicant Portal** integrated cleanly into the CodeX404 Solutions PHP/MySQL website (`website/`) on the `dev` branch.

## 2. User Personas
- **Prospective Candidates**: Browse active open positions (`/careers`), filter by category/keyword, inspect shareable vacancy specifications (`/careers/{slug}`), submit dynamic role-tailored applications or General Talent Pool profiles.
- **Verified Applicants**: Authenticate passwordlessly via single-use Email OTP (`/careers/application-status`), review their applications inside `/careers/candidate-portal`, inspect live stage timelines, view interview details, download their own uploaded resume, communicate with recruiters, withdraw active applications, or request personal data deletion.
- **Recruitment Managers & Super Admins (`/admin/careers`)**: Publish/schedule/close/duplicate vacancies, visually configure reusable templates and per-job dynamic application forms (11 field types), triage candidates across the 9-stage pipeline, schedule interviews, maintain private notes and public messages, export filtered CSV reports, customize email templates, inspect audit logs, and enforce RBAC (`Super Admin`, `Recruiter`, `Viewer`).

## 3. Core Public Flows
1. **Careers Landing (`/careers`)**:
   - Hero (`"Build Your Career. Create What's Next."`), Why Join Us (authentic engineering/growth culture, zero invented stats), Open Positions grid (`All Positions`, `Marketing`, `Sales & Business Development`, `Internship`, `Fellowship`, `Engineering & Technology`), and General Talent Pool form with clear non-guarantee notice.
2. **Vacancy Detail (`/careers/{slug}`)**:
   - Shareable URL (e.g., `/careers/marketing-growth-associate`), full position overview, responsibilities, qualifications, skills, compensation, deadline, social sharing links, and embedded Dynamic Application Engine.
   - `?preview=1` strictly gated behind authenticated admin session.
3. **Applicant Portal (`/careers/application-status` & `/careers/candidate-portal`)**:
   - Email OTP verification -> authenticated dashboard -> per-application status timeline, interview schedule, candidate-recruiter messaging, resume download, contact/notification preferences, withdrawal, and GDPR/privacy deletion request.

## 4. Pipeline Status Model
`new` -> `under_review` -> `shortlisted` -> `interview_scheduled` -> `selected` -> `offer_sent` -> `hired`, plus terminal/exit states `rejected` and `withdrawn`.
