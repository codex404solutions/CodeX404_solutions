# CodeX404 Business OS — Documentation Package v2.0

This package is the professional product, architecture, security, data, design, and delivery specification for the internal CodeX404 Business OS.

## Core architecture

- **Dolibarr ERP/CRM** is the authoritative system for native business records.
- **CodeX404 extensions** add only verified CodeX404-specific capabilities.
- **Global Client Hunter** discovers and analyses international business candidates in a separate pre-CRM workspace.
- Only reviewed and approved candidates are synchronized into Dolibarr.
- Management dashboards use real, permission-filtered data and appropriate graphs/charts.
- The existing public website remains isolated from Business OS deployment.

## Document index and reading order

| File | Purpose |
|---|---|
| `docs/Business-OS/MEMORY.md` | Durable project context, known facts, constraints, and unresolved decisions |
| `docs/Business-OS/PRD.md` | Product scope, requirement IDs, workflows, international Client Hunter requirements, analytics, acceptance criteria |
| `docs/Business-OS/ARCHITECTURE.md` | System boundaries, deployment topology, data flows, extension architecture, integration and reporting design |
| `docs/Business-OS/DATABASE.md` | Data ownership, logical ER model, custom data candidates, international data conventions, retention and backup |
| `docs/Business-OS/SECURITY.md` | Threat model, permissions, webhook, crawler/SSRF, privacy, AI and release controls |
| `docs/Business-OS/RULES.md` | Mandatory engineering, repository, product, CRM, finance, AI, and analytics rules |
| `docs/Business-OS/DESIGN.md` | UI shell, brand, role dashboards, chart selection, accessibility, internationalisation |
| `docs/Business-OS/TASKS.md` | Dependency graph, implementation phases, gates, risks, release checklist |
| `docs/Business-OS/DEVELOPMENT_PROMPT.md` | Detailed instruction set for coding agents and developers |
| `docs/Business-OS/prompt.md` | Short Antigravity bootstrap prompt; instructs the agent to start with Phase 0 only |

## Diagrams and visual specifications included

The Markdown documents contain Mermaid diagrams for:
- Business lifecycle and CRM states.
- System context and logical architecture.
- Deployment topology.
- Global Client Hunter pipeline.
- Candidate-to-Dolibarr synchronization.
- Website lead webhook sequence.
- Logical discovery data ER diagram.
- Analytics data flow.
- Phase dependency graph.
- Illustrative lead trend, lead-source composition, and funnel charts.

Charts containing sample values are explicitly marked illustrative and must never be used as production data.

## Critical implementation rule

**Start with Phase 0 only.** Inspect the current repository, public website, hosting plan, Dolibarr compatibility, licence, source-provider policy, and existing lead webhook. Do not install or deploy Dolibarr, change DNS, modify the public website, run production migrations, or alter `main` before the owner approves the audit findings.

## External technical references

- Dolibarr repository: https://github.com/Dolibarr/dolibarr
- Developer documentation: https://wiki.dolibarr.org/index.php/Developer_documentation
- Module development: https://wiki.dolibarr.org/index.php/Module_development
- APIs, hooks and triggers: https://www.dolibarr.org/presentation-api.php

Review the exact selected Dolibarr release's documentation and licence before implementation.
