---
trigger: always_on
---

## CodeX404 Solutions: Project Rules

Stack: PHP, XAMPP, MySQL (phpMyAdmin). Project root: CodeX404_solutions/, CRM in crm/.

### Workflow (follow in this order)
1. Before editing, use graphify (`graphify query "<question>"`) to find the
   relevant files and relationships. Do not read many raw files first.
2. Act as the Agents Orchestrator: pick only the 3-5 agents needed for this
   task, tell me which ones and why (one line each), then work in those roles.
3. Make the change.
4. Run a Code Reviewer / Reality Checker pass before finishing.
5. After modifying code, run `graphify update .`

### Database
- MySQL only. Do not add new JSON file storage.
- Use PDO with prepared statements.
- Credentials stay in .env (never hardcoded, never committed).
- Schema changes go in numbered SQL migration files
  (e.g. crm/database/migrations/001_users.sql).
- Existing JSON data in crm/storage/data is legacy. Keep it as a backup until
  I confirm the MySQL migration works.
- Passwords must stay hashed. Never store or log plain text.

### Default agent routing
- Roles, permissions, login: Identity & Access Engineer, Backend Architect,
  Application Security Engineer
- Database schema, queries, indexes, JSON-to-MySQL migration:
  Database Optimizer, Backend Architect
- CRM UI / CSS: UI Designer, UX Architect
- Final check: Code Reviewer, Reality Checker
- Small fixes: Minimal Change Engineer (smallest possible diff, no scope creep)

### General
- Do not change files unrelated to the task.
- Explain what changed and which files were touched.
- Skip the agent selection step for trivial questions.