# CodeX404 Solutions — Careers & Recruitment Verification Guide

## 1. Automated Verification Suite
Run the comprehensive CLI integration & security test harness directly against live MySQL `codex404_db`:
```powershell
php C:/Users/mnouk/.gemini/antigravity/brain/eb06ca9d-9df2-4eb5-a2be-e4707e03156a/scratch/test_careers_e2e.php
```
(Or copy `test_careers_e2e.php` to a CI runner step pointing at a staging MySQL database.)

## 2. Covered Test Scenarios
### Recruitment & Admin Scenarios
1. MySQL schema & seed integrity across all 20 tables.
2. Admin RBAC matrix: `Super Admin` vs `Recruiter` vs `Viewer` read-only enforcement.
3. Vacancy Draft -> Admin Preview -> Schedule auto-publish -> Public Published visibility -> Close hiding from public listings -> Duplicate.
4. Form Builder: create reusable template, clone fields, customize per-job fields covering all 11 field types (`short_text`, `long_text`, `email`, `phone`, `number`, `dropdown`, `radio`, `checkbox`, `file`, `date`, `url`).
5. Dynamic submission validation: invalid email/number/choice/missing required fields rejected; invalid `.exe` disguised as `.pdf` blocked by magic-byte inspection.
6. Public Vacancy application & General Talent Pool submission persisted transactionally in MySQL (`applications`, `candidate_profiles`, `application_answers`, `application_status_history`).
7. Duplicate submission protection on active vacancy.
8. Pipeline stage transition + internal note privacy + interview scheduling + email dispatch logs + CSV export formula injection protection.

### Applicant Portal Security & Functional Scenarios
1. OTP issuance hashes code (`password_hash`) with expiration and cooldown enforcement.
2. Wrong OTP increments attempt counter; expired/reused OTP rejected.
3. Successful OTP verification creates SHA-256 hashed session token and portal access.
4. Applicant A cannot access, download CV from, message on, or withdraw Applicant B's application (IDOR prevention).
5. Applicant timeline excludes `recruiter_notes` and `internal_note` columns.
6. Withdrawal updates status, logs history, and creates confirmation email log.
7. Contact/notification preference update and privacy data-deletion request persisted cleanly.

## 3. Manual / Browser QA Checklist
- Visit `/careers`: confirm Hero, Why Join Us, 5 category filters + All Positions, active job cards, and General Talent Pool section render cleanly on Desktop and Mobile without overflow.
- Visit `/careers/marketing-growth-associate`: confirm share links and dynamic form submit cleanly.
- Visit `/careers/application-status` and `/careers/candidate-portal`: verify OTP flow and timeline layout.
- Visit `/admin/careers`: verify all 8 sub-navigation tabs load cleanly with zero PHP warnings.
