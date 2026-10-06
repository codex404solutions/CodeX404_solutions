# CodeX404 Solutions — High-End CRM PRD

## 1. Purpose
Build a production-grade CRM that becomes the internal commercial operating system for CodeX404 Solutions.

It should manage:
```text
Lead
→ Qualification
→ Discovery
→ Opportunity
→ Proposal
→ Negotiation
→ Won/Lost
→ Client
→ Project
→ Invoice
→ Payment
→ Retainer
→ Renewal/Upsell
→ Referral
```

## 2. Product Goals
- Centralize sales data.
- Prevent lead leakage.
- Track every prospect interaction.
- Improve sales follow-up.
- Manage proposals and deals.
- Convert won deals into projects.
- Connect sales with delivery.
- Track financial status.
- Measure marketing performance.
- Automate repetitive operations.
- Provide role-specific dashboards.
- Maintain strict security and auditability.

## 3. Critical Multi-Role Requirement
A single user can have multiple active roles.

Examples:
- CEO + CTO
- CEO + Sales
- CTO + Developer
- Founder + Sales + Marketing

This is optional.

Never implement:
```text
users.role = one role
```

Use:
```text
users
roles
permissions
user_roles
role_permissions
```

## 4. Roles
Default:
- Super Admin
- CEO
- CTO
- COO
- Sales
- Sales Manager
- Business Development
- Marketing
- Marketing Manager
- Account Manager
- Project Manager
- Developer
- Senior Developer
- AI Engineer
- Designer
- QA
- Finance/Accounts
- HR
- Support
- Viewer

All roles and permissions must be configurable.

## 5. Modules
### Core
- Authentication
- Users
- Roles
- Permissions
- Dashboard
- Notifications
- Audit logs
- Settings

### CRM
- Leads
- Companies
- Contacts
- Sources
- Tags
- Activities
- Tasks
- Notes
- Communication timeline

### Sales
- Pipelines
- Stages
- Opportunities
- Discovery calls
- Proposals
- Quotations
- Contracts
- Forecast
- Win/loss

### Client/Delivery
- Clients
- Projects
- Project tasks
- Milestones
- Team assignments
- Time tracking
- Client communication

### Finance
- Invoices
- Payments
- Expenses
- Recurring retainers
- Financial status

### Marketing
- Campaigns
- Audiences
- UTM/source tracking
- Email templates
- Lead attribution

### Automation
- Triggers
- Conditions
- Actions
- Workflow runs
- Retry/error management

### Support
- Tickets
- Priorities
- Assignment
- SLA-ready fields
- Resolution

### Documents
- Proposals
- Contracts
- Project documents
- Client documents
- Private downloads

## 6. Lead Management

### Sources
- Website
- LinkedIn
- Email
- Referral
- Cold outreach
- Upwork
- Contra
- Agency partnership
- Event
- Manual
- API

### Lead fields
- ID
- name
- email
- phone
- job title
- company
- country
- timezone
- industry
- website
- LinkedIn
- source
- campaign
- service interest
- budget
- timeline
- problem
- score
- owner
- status
- tags
- notes
- created/updated metadata

### Statuses
New → Contacted → Qualified → Nurturing → Discovery Scheduled → Proposal Sent → Negotiation → Won/Lost/Disqualified.

## 7. Lead Scoring
Support configurable scoring rules.

Example:
- business email +10
- target country +10
- target service +10
- budget supplied +10
- decision-maker +15
- discovery booked +25
- invalid email -20

Never hard-code scores as permanent business policy.

## 8. Duplicate Detection
Detect likely duplicates by:
- email
- company domain
- normalized phone
- company + contact name

Provide:
- possible duplicate warning
- merge workflow
- audit trail
- field conflict resolution

Never silently delete duplicate records.

## 9. Companies
Fields:
- company name
- domain
- country
- industry
- employee range
- revenue range if supplied
- website
- LinkedIn
- owner
- status
- source
- tags
- notes
- contacts
- opportunities
- projects
- invoices

## 10. Contacts
Fields:
- name
- title
- email
- phone
- LinkedIn
- timezone
- company
- decision-maker status
- notes
- communication history

## 11. Activities
Types:
- call
- email
- meeting
- discovery
- demo
- follow-up
- WhatsApp/manual communication
- note
- task
- proposal event

Activities must support:
- owner
- date/time
- timezone
- related lead/contact/company/deal/project
- notes
- outcome
- next action

## 12. Opportunities
Fields:
- title
- company
- primary contact
- owner
- pipeline
- stage
- amount
- currency
- probability
- expected close date
- service
- source
- competitor
- next action
- lost reason
- notes

## 13. Pipelines
Support multiple pipelines:
- New Business
- Existing Client Expansion
- Agency Partnerships
- Custom pipelines

Each pipeline has configurable stages.

## 14. Discovery Calls
Support:
- scheduling
- timezone
- attendees
- agenda
- notes
- outcome
- next action
- recording URL
- follow-up task

## 15. Proposals
Lifecycle:
Draft → Internal Review → Sent → Viewed → Negotiation → Accepted/Rejected/Expired.

Version every sent proposal.

Accepted versions must be immutable history.

## 16. Contracts
Track:
- contract name
- client
- opportunity
- version
- status
- effective date
- expiry
- file
- signed date
- owner
- renewal reminder

Do not present contract templates as legal advice.

## 17. Client Conversion
Won deal:
```text
Opportunity Won
→ Convert/Select Company
→ Create Client
→ Create Project
→ Assign Team
→ Create Onboarding Tasks
```

Avoid duplicate companies/contacts.

## 18. Projects
Fields:
- client
- name
- type
- scope
- manager
- start
- target end
- budget
- health
- status
- risks
- blockers
- team

Statuses:
Planned, Active, On Hold, At Risk, Completed, Cancelled.

## 19. Project Tasks
Fields:
- title
- description
- project
- assignee
- priority
- status
- due date
- estimate
- actual time
- dependency
- comments
- attachments

Do not attempt to replace specialist engineering tools in V1.

## 20. Finance
Support:
- quotation
- invoice
- payment
- expense
- refund/adjustment
- recurring retainer
- overdue status

Use configurable currency and tax fields.

Use DECIMAL.

Never silently rewrite historical transactions.

## 21. Marketing
Campaign fields:
- name
- channel
- country
- industry
- audience
- budget
- start/end
- source
- UTM
- leads
- qualified leads
- opportunities
- conversions
- spend
- ROI where data is reliable

## 22. Automation
Use:
```text
Trigger
→ Conditions
→ Actions
```

Triggers:
- lead created
- stage changed
- task overdue
- proposal accepted
- deal won
- invoice overdue
- project created
- client inactive

Actions:
- assign owner
- create task
- send notification
- send email
- create project
- update field
- add tag
- webhook

## 23. Dashboards
### CEO
Pipeline, forecast, revenue, recurring revenue, won/lost, client health, project health, team overview.

### CTO
Technical workload, projects, blockers, delivery risk, developer allocation.

### Sales
New leads, follow-ups, pipeline, proposals, conversion, activity.

### Marketing
Campaigns, attribution, lead volume, CPL where supported, conversion.

### Developer
Assigned tasks, deadlines, project status, blockers.

### Finance
Receivables, overdue invoices, payments, expenses.

### Admin
Users, roles, permissions, audit, system health.

## 24. Reports
- Lead funnel
- Source performance
- Sales pipeline
- Win/loss
- Forecast
- Revenue
- Recurring revenue
- Client acquisition
- Marketing
- Team activities
- Project workload
- Project profitability where supported
- Invoice/payment
- Retention/renewal

## 25. Security
Mandatory:
- secure authentication
- password hashing
- session security
- RBAC
- record-level authorization
- CSRF
- XSS protection
- SQL injection prevention
- rate limiting
- secure documents
- audit logs
- API authentication
- secrets management

## 26. Acceptance
CRM is production-ready only when:
- multi-role access works
- CEO+CTO scenario works
- lead lifecycle works
- pipelines work
- proposals work
- client conversion works
- projects work
- financial history is safe
- automation is observable
- website integration is secure
- dashboards reflect permissions
- audit logs work
