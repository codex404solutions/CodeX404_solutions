# CodeX404 Solutions — High-End CRM Design System

## 1. Product Feel
The CRM should feel like an internal operating system for a modern technology company.

Characteristics:
- premium
- focused
- data-rich
- fast
- calm
- professional
- keyboard-friendly

Avoid a cluttered “old ERP” appearance.

## 2. Brand
Use:
- Midnight #07111F
- Deep Navy #0B1F3A
- Electric Blue #2563EB
- Cyan #22D3EE
- Violet #7C3AED
- White #FFFFFF
- Slate #94A3B8
- Light #F8FAFC

## 3. Layout
```text
┌─────────────────────────────────────────────────────────┐
│ Global Search | Quick Add | Notifications | User       │
├───────────────┬─────────────────────────────────────────┤
│ Dashboard     │ Breadcrumb                              │
│ Leads         │ Page title + primary action              │
│ Companies     │ Filters                                  │
│ Contacts      │ Table/Kanban/Timeline                    │
│ Deals         │                                           │
│ Activities    │                                           │
│ Proposals     │                                           │
│ Clients       │                                           │
│ Projects      │                                           │
│ Finance       │                                           │
│ Marketing     │                                           │
│ Automation    │                                           │
│ Reports       │                                           │
│ Settings      │                                           │
└───────────────┴─────────────────────────────────────────┘
```

## 4. Global Search
Search across:
- leads
- contacts
- companies
- opportunities
- clients
- projects

Results should show type and relevant context.

## 5. Quick Actions
Global:
- New Lead
- New Company
- New Contact
- New Deal
- Schedule Activity
- New Task
- New Proposal
- New Client
- New Project

## 6. Role-Aware Dashboard

### CEO
Widgets:
- pipeline
- forecast
- revenue
- recurring revenue
- active clients
- project health
- sales activity
- alerts

### CTO
- project health
- technical workload
- developer allocation
- blockers
- deadlines
- risk

### Sales
- new leads
- follow-ups
- pipeline
- proposal status
- conversion

### Marketing
- campaigns
- lead sources
- attribution
- conversion

### Developer
- assigned tasks
- due soon
- blockers
- project activity

### Finance
- outstanding
- overdue
- payments
- expenses

### Multi-role
For CEO+CTO:
- combine authorized widgets
- avoid duplicate widgets
- prioritize the most relevant actions
- optionally allow dashboard customization

## 7. Lead Page
Top:
- name
- company
- status
- score
- owner
- primary CTA

Sections:
- profile
- company
- timeline
- activities
- notes
- opportunities
- proposals
- files
- tasks

## 8. Pipeline
Kanban columns:
New → Contacted → Qualified → Discovery → Proposal → Negotiation → Won/Lost.

Cards show:
- company
- contact
- value
- probability
- owner
- next action
- close date

Drag-and-drop stage movement must trigger server-side authorization and audit.

## 9. Opportunity
Show:
- value
- currency
- probability
- weighted value
- close date
- stage
- owner
- next action
- history

## 10. Timeline
Chronological:
- calls
- emails
- meetings
- notes
- tasks
- stage changes
- proposal events
- payment events where permitted

## 11. Projects
Project header:
- status
- health
- manager
- client
- dates
- budget

Tabs:
- Overview
- Tasks
- Team
- Milestones
- Time
- Files
- Activity
- Finance if authorized

## 12. Finance
Finance tables should be highly readable.

Status:
- Draft
- Sent
- Partially Paid
- Paid
- Overdue
- Cancelled

Do not rely only on color.

## 13. Notifications
Categories:
- assigned lead
- overdue task
- proposal activity
- payment
- automation failure
- project blocker
- mention

## 14. Tables
Support:
- search
- filter
- sorting
- pagination
- saved views
- column visibility
- bulk actions only where safe
- export only with permission

## 15. Accessibility
Target WCAG 2.2 AA-oriented:
- keyboard
- focus
- contrast
- semantic labels
- accessible tables
- accessible dialogs
- screen-reader context
- reduced motion

## 16. Responsive
Desktop:
- sidebar
- data tables

Tablet:
- collapsible sidebar

Mobile:
- cards
- stacked details
- horizontal scroll only when unavoidable
- touch targets
- sticky primary actions where useful
