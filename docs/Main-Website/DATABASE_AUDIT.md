# CodeX404 Solutions — Database Architecture & Schema Audit (Corrected)

**Document:** DATABASE_AUDIT.md  
**Project:** CodeX404 Solutions Main Website Redesign  
**Audit Date:** 2026-11-18  

---

## 1. Database Connection & File Fallback Mechanism

- **PDO Connection Provider:** `website/config/database.php` configures PDO connection to `codex404_db` using credentials from `.env` via `Env.php`.
  - Disables emulated prepared statements (`PDO::ATTR_EMULATE_PREPARES => false`).
  - Sets error mode to exception (`PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`).
  - Catches `PDOException`, strips sensitive credentials matching regex patterns, and writes sanitized error messages to `storage/logs/errors.log`.
- **JSON Fallback:** `website/app/Services/ProjectService.php` checks if the database connection is available. If `Database::getConnection()` returns null or throws an exception, it reads `website/data/projects.json` from the filesystem.
  - *Correction Note:* This provides resilience against database connection drops on reads, but does not guarantee "100% uptime," which depends on overall web server and PHP runtime availability.
- **Local Daemon State:** During this audit, `Get-Process mysqld` indicated that the MySQL service is **not running** on the local host. Consequently, read calls in `ProjectService` currently execute against `website/data/projects.json`.

---

## 2. Monorepo Migration Files (`crm/database/migrations/`)

The following SQL migration files exist in `crm/database/migrations/`:
- `001_initial_schema.sql`: Initial CRM schema (`users`, `clients`, `projects`, `leads`, `activity_logs`).
- `002_user_profiling_and_rbac.sql`: Roles, permissions, and profiles.
- `003_access_scope_and_governance.sql`: Scopes, access tokens, and audit trails.
- `004_json_to_mysql_schema.sql`: Table `portfolio_projects`.
- `005_company_hierarchy_and_approval_rules.sql`: Departments and approvals.
- `006_portfolio_projects_upgrade.sql`: Extended columns for showcase status, demo keys, and project types on `portfolio_projects`.
- `FULL_DATABASE_SYNC.sql`: Consolidated script.
