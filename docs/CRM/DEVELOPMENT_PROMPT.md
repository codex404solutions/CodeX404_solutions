# MASTER DEVELOPMENT PROMPT — CODEX404 HIGH-END CRM

You are the senior product architect, database architect, security engineer, backend engineer, frontend engineer, UX designer and QA engineer.

## STEP 1 — READ DOCUMENTATION
Before writing code, read:
1. PRD.md
2. ARCHITECTURE.md
3. RULES.md
4. DESIGN.md
5. TASKS.md
6. MEMORY.md

These are the project source of truth.

## STEP 2 — UNDERSTAND PRODUCT BOUNDARY
The CRM is Phase 2.

Main website:
`codex404solutions.online`

CRM:
`crm.codex404solutions.online`

The website will be completed first.

The CRM must be a separate authenticated application.

## STEP 3 — MOST IMPORTANT REQUIREMENT: MULTI-ROLE

A single user can have multiple active roles.

Examples:
- CEO + CTO
- CEO + Sales
- CTO + Developer
- Founder + Sales + Marketing

Do NOT create a single role column as the authorization model.

Use:
```text
users
roles
permissions
user_roles
role_permissions
```

Effective permissions are the combined permissions of all active roles.

Example:
```text
User
├── CEO
└── CTO

Effective permissions
├── CEO permissions
└── CTO permissions
```

The user does not need separate accounts.

## STEP 4 — PERMISSION-FIRST DESIGN
Do not scatter:
```text
if role == "CEO"
```
throughout code.

Use:
```text
authorize("deal.view")
authorize("invoice.view")
authorize("project.edit")
```

Roles are collections of permissions.

Support scopes:
- all
- team
- department
- owned
- assigned
- project
- company
- self

## STEP 5 — BUILD THE COMPLETE CRM

Implement:
- Authentication
- Users
- Roles
- Permissions
- Dashboards
- Leads
- Companies
- Contacts
- Sources
- Tags
- Activities
- Tasks
- Notes
- Timeline
- Pipelines
- Opportunities
- Discovery calls
- Proposals
- Quotations
- Contracts
- Clients
- Projects
- Project tasks
- Milestones
- Team assignment
- Time tracking
- Invoices
- Payments
- Expenses
- Retainers
- Marketing
- Campaigns
- Automation
- Support tickets
- Documents
- Notifications
- Reports
- Audit logs
- Settings

## STEP 6 — LEAD LIFECYCLE
Implement:
```text
New
→ Contacted
→ Qualified
→ Nurturing
→ Discovery Scheduled
→ Proposal Sent
→ Negotiation
→ Won/Lost
```

Require:
- source
- owner
- status
- history

Support duplicate detection and controlled merging.

## STEP 7 — WEBSITE INTEGRATION
Create:
```http
POST /api/v1/leads
```

The main website can send a lead.

The API must:
- authenticate the request
- validate payload
- rate-limit
- prevent replay/duplicates using idempotency
- create/merge lead safely
- assign owner if rules exist
- record source/campaign
- write audit event
- return safe response

Never put CRM API credentials in browser code.

## STEP 8 — SALES PIPELINES
Support configurable pipelines.

Examples:
- New Business
- Existing Client Expansion
- Agency Partnerships

Stages must be configurable.

Stage changes:
- validate authorization
- write history
- trigger optional automation
- update forecast

## STEP 9 — DISCOVERY
Support:
- scheduling
- timezone
- participants
- agenda
- notes
- outcome
- next action
- follow-up tasks

## STEP 10 — PROPOSALS
Workflow:
```text
Draft
→ Internal Review
→ Sent
→ Viewed
→ Negotiation
→ Accepted / Rejected / Expired
```

Version all sent proposals.

Never overwrite accepted historical versions.

## STEP 11 — CLIENT CONVERSION
When a deal becomes Won:
```text
Won Deal
→ Company/Contact validation
→ Client
→ Project
→ Team
→ Onboarding tasks
```

Prevent duplicate clients.

## STEP 12 — PROJECT DELIVERY
Support:
- project manager
- members
- tasks
- milestones
- deadlines
- time
- health
- risks
- blockers
- documents

Developers should see only records authorized by policy.

## STEP 13 — FINANCE
Implement:
- quotes
- invoices
- invoice items
- payments
- expenses
- retainers
- overdue status
- refunds/adjustments

Use DECIMAL.

Never delete/overwrite historical financial events without a trace.

## STEP 14 — MARKETING
Track:
- campaigns
- channels
- country
- industry
- source
- UTM
- leads
- qualified leads
- opportunities
- conversions
- spend
- ROI where supported by reliable data

## STEP 15 — AUTOMATION ENGINE
Implement:
```text
Trigger
→ Conditions
→ Actions
```

Triggers:
- lead created
- lead status changed
- deal stage changed
- proposal accepted
- deal won
- invoice overdue
- task overdue
- project created
- client inactive

Actions:
- assign
- create task
- send email
- notify
- update field
- add tag
- create project
- webhook

Every run needs:
- ID
- status
- start/end
- attempts
- error
- retry policy

Prevent infinite loops.

## STEP 16 — ROLE DASHBOARDS

### CEO
- pipeline
- forecast
- revenue
- recurring revenue
- client health
- project health
- team

### CTO
- projects
- technical workload
- developer allocation
- blockers
- technical risk

### Sales
- leads
- follow-ups
- pipeline
- proposals
- conversion

### Marketing
- campaigns
- attribution
- conversion

### Developer
- assigned work
- deadlines
- blockers

### Finance
- invoices
- payments
- overdue
- expenses

### Multi-role
For CEO+CTO:
- combine permitted dashboards
- do not require a second account
- avoid duplicate widgets
- allow customization where useful

## STEP 17 — SECURITY
Mandatory:
- password hashing
- secure sessions
- session regeneration
- CSRF
- XSS protection
- SQL injection protection
- server-side validation
- RBAC
- record-level authorization
- IDOR prevention
- rate limiting
- secure private files
- API authentication
- audit logs
- secret management
- safe errors

## STEP 18 — DATABASE
Use normalized relational schema.

Every important table should have appropriate:
- primary key
- foreign keys
- indexes
- unique constraints
- timestamps
- created_by
- updated_by
- status

Use transactions for multi-step workflows.

## STEP 19 — UI
Create a premium SaaS CRM:
- global search
- command/quick actions
- role-aware dashboard
- tables
- kanban
- timeline
- calendar
- filters
- saved views
- detail panels
- notifications
- responsive design

## STEP 20 — TESTING
Create tests for:
- authentication
- role assignment
- multi-role permissions
- CEO+CTO
- Sales restrictions
- Developer restrictions
- record ownership
- IDOR
- CSRF
- XSS
- SQL injection
- API authentication
- idempotency
- financial integrity
- automation failures
- document access

## STEP 21 — DEVELOPMENT ORDER
Implement in this order:
1. Foundation
2. Database
3. Authentication
4. RBAC
5. CRM core
6. Sales
7. Client conversion
8. Projects
9. Finance
10. Marketing
11. Automation
12. Website integration
13. Reports
14. Security hardening
15. QA
16. Production deployment

## FINAL RULE
Do not deliver a visual prototype pretending to be a CRM.

Build a real working system with:
database + backend + API + permissions + validation + UI + audit + tests.

The CRM must be maintainable as a modular monolith and ready for future integrations and SaaS evolution.
