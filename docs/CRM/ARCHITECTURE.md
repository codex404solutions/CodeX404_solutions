# CodeX404 Solutions — CRM Architecture

## 1. Product Boundary
CRM is a separate application:
`crm.codex404solutions.online`

Main website:
`codex404solutions.online`

The website sends qualified form submissions into the CRM through an authenticated server-to-server integration.

## 2. Recommended Architecture
Start as a modular monolith.

```text
Browser
 ↓
UI
 ↓
Controller / API
 ↓
Policy + Validation
 ↓
Service Layer
 ↓
Repository
 ↓
Database
```

Supporting systems:
```text
Queue/Jobs
Notifications
Email
File Storage
Integrations
Audit
Reporting
```

Do not start with microservices unless scale actually requires them.

## 3. Technology
Recommended for the CRM:
- FastAPI/Python or PHP 8.2+
- PostgreSQL preferred for a new CRM
- React or server-rendered UI
- REST API
- background jobs
- Redis-compatible queue if needed
- object storage for documents

If Hostinger constraints require PHP/MySQL, keep the same logical architecture and security model.

## 4. Database Core
```text
users
roles
permissions
user_roles
role_permissions

companies
contacts
leads
lead_sources
tags
lead_tags

pipelines
pipeline_stages
opportunities

activities
tasks
notes

discovery_calls
proposals
proposal_versions
contracts

clients
projects
project_members
project_tasks
milestones
time_entries

invoices
invoice_items
payments
expenses
retainers

campaigns
campaign_members
utm_attribution

tickets
ticket_messages

automations
automation_triggers
automation_conditions
automation_actions
automation_runs

documents
notifications
audit_logs
settings
```

## 5. Multi-Role Authorization

### Data model
```text
users
  |
  +-- user_roles -- roles
                    |
                    +-- role_permissions -- permissions
```

A user can have zero, one or many roles.

Example:
```text
User: Noukhez
Roles:
- CEO
- CTO
- Developer
```

Effective permissions are calculated from all active assigned roles.

### Important
Do not create:
```text
users.role_id
```
as the sole authorization source.

Use many-to-many user/role relationships.

## 6. Permission Model
Permissions should be granular:
```text
lead.view
lead.create
lead.edit
lead.delete
lead.assign
lead.export

deal.view
deal.create
deal.edit
deal.stage_change
deal.export

invoice.view
invoice.create
invoice.edit
invoice.payment_record
invoice.refund
```

Each permission can be mapped to multiple roles.

## 7. Scope Model
Permissions should support scope:
- all records
- team
- department
- owned
- assigned
- project
- company
- self

Example:
Sales:
- leads assigned to self

Sales Manager:
- team leads

CEO:
- all business data

Developer:
- assigned projects/tasks

Finance:
- invoices/payments but not private HR data.

## 8. API Architecture

### Website lead endpoint
```http
POST /api/v1/leads
```

Payload example:
```json
{
  "name": "Example Person",
  "email": "person@example.com",
  "company": "Example Co",
  "country": "USA",
  "service": "AI Automation",
  "problem": "Manual reporting"
}
```

Use:
- server-side validation
- signed requests/API credentials
- idempotency
- rate limiting
- request timeout
- safe retry
- structured errors
- audit logs

Never expose API secrets in frontend JavaScript.

## 9. Service Layer
Examples:
- LeadService
- CompanyService
- ContactService
- OpportunityService
- ProposalService
- ClientConversionService
- ProjectService
- InvoiceService
- PaymentService
- AutomationService
- ReportService

Services enforce business rules.

## 10. Repository Layer
Repositories contain database operations.

Examples:
- LeadRepository
- CompanyRepository
- OpportunityRepository
- InvoiceRepository

Controllers should not contain long SQL queries.

## 11. Event Architecture
Useful events:
- LeadCreated
- LeadAssigned
- OpportunityStageChanged
- ProposalSent
- ProposalAccepted
- DealWon
- ClientCreated
- ProjectCreated
- InvoiceCreated
- PaymentReceived
- InvoiceOverdue

Events can trigger notifications/automation.

## 12. Background Jobs
Use jobs for:
- emails
- reminders
- workflow execution
- report generation
- webhook retry
- invoice reminders
- scheduled notifications

Every job needs:
- status
- attempts
- timestamps
- error information
- retry policy

## 13. File Architecture
Private documents should not be directly exposed.

```text
Upload
 ↓
Validation
 ↓
Private Storage
 ↓
DB Metadata
 ↓
Authorized Download Endpoint
```

Validate:
- extension
- MIME
- content
- size

## 14. Audit Architecture
Audit:
- who
- what
- record
- old value where appropriate
- new value where appropriate
- timestamp
- IP/device metadata only when justified

Never log secrets.

## 15. Search
Start with database search.
As volume grows, introduce a dedicated search engine only if required.

Search:
- leads
- contacts
- companies
- deals
- projects
- documents

## 16. Reporting
Reports should query read-optimized views/queries where necessary.

Do not allow arbitrary unrestricted SQL from users.

## 17. Deployment
```text
Development
 ↓
Tests
 ↓
Staging
 ↓
Production
```

Production:
- HTTPS
- secrets
- backups
- monitoring
- error tracking
- scheduled jobs
- database migrations

## 18. Scalability
Start modular monolith.
Separate only when:
- workload justifies it
- deployment independence is required
- a component has clear boundaries

Potential future services:
- notifications
- automation
- reporting
- search
- integrations
