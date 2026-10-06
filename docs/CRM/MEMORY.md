# CodeX404 Solutions — CRM Project Memory

## Product
High-end internal CRM for CodeX404 Solutions.

Domain:
`crm.codex404solutions.online`

Main website:
`codex404solutions.online`

## Critical Architecture
Main website and CRM are separate applications.

Website:
- public
- marketing
- lead capture

CRM:
- private
- authenticated
- sales
- delivery
- finance
- marketing
- operations

## Critical Multi-Role Rule
One user can have multiple roles.

Examples:
- CEO + CTO
- CEO + Sales
- CTO + Developer
- Founder + Sales + Marketing

This is optional.

Never create a one-role-per-user system.

## Authorization
Use:
- users
- roles
- permissions
- user_roles
- role_permissions
- policies/scopes

Permissions, not role names, should control access.

## Roles
Super Admin, CEO, CTO, COO, Sales, Sales Manager, Business Development, Marketing, Marketing Manager, Account Manager, Project Manager, Developer, Senior Developer, AI Engineer, Designer, QA, Finance/Accounts, HR, Support, Viewer.

## Core Journey
Lead → Qualification → Discovery → Opportunity → Proposal → Negotiation → Won/Lost → Client → Project → Invoice → Payment → Retainer → Renewal/Upsell → Referral.

## Core Modules
Authentication, RBAC, dashboard, leads, companies, contacts, activities, tasks, opportunities, pipelines, discovery calls, proposals, contracts, clients, projects, project tasks, time tracking, invoices, payments, expenses, retainers, marketing, automation, support, documents, reports and audit logs.

## Security
Secure sessions, password hashing, CSRF, XSS protection, SQL injection prevention, rate limiting, IDOR protection, private files, audit logs, secure APIs and secrets management.

## Product Direction
The CRM should eventually become the internal operating system connecting:
- marketing
- sales
- delivery
- finance
- customer success
- automation
- future SaaS products

## Design
Premium SaaS-style interface using CodeX404 brand colors:
Midnight/Navy + Electric Blue + Cyan + Violet.

## Future Integrations
- website
- email
- calendar
- WhatsApp provider
- payments
- accounting
- project tools
- analytics
- AI assistants

Keep integrations modular.
