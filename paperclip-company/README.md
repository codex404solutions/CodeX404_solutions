# CodeX404 Solutions — Paperclip Company

A portable Agent Companies package for operating CodeX404 Solutions as a human-governed AI-augmented custom web development agency.

## Operating model

The company uses a hub-and-pipeline model. The CEO/Founder is the Board and final decision-maker. The Chief of Staff coordinates work. Leads flow through discovery, scoping, build, QA/security, and deployment. Outbound client messages, social posts, discounts, payments, and production deployments require explicit human approval.

## Org chart

- **CEO / Founder** (`ceo`) — strategy, budget, final approvals
  - **Chief of Staff** (`chief-of-staff`) — priorities, delegation, operating cadence
    - **Lead Researcher** (`lead-researcher`) — prospect research and qualification
    - **Sales Engineer** (`sales-engineer`) — discovery, proposals, technical scoping
    - **Technical Lead** (`technical-lead`) — architecture and implementation
    - **QA & Security Lead** (`qa-security`) — testing, accessibility, security gates
    - **Delivery & Client Ops Lead** (`delivery-lead`) — deployment, handoff, support

## Starter project

`projects/us-client-web-apps/` contains the reusable delivery pipeline and tasks for discovery, scoping, build, QA, and deployment.

## Import

From the Paperclip repository or installed CLI:

```bash
paperclipai company import --from ./paperclip-company
```

During import, choose the runtime adapter available on your host (`claude_local` or `codex_local`). Do not put API keys in this package. Configure secrets in Paperclip's secret manager after import.

## Safety boundaries

This package does not authorize agents to send email, publish social posts, approve discounts, charge clients, or deploy production code without human approval. Use Paperclip's connection permissions, approval stages, per-agent budgets, private client projects, and authenticated private deployment mode.

## References

- [CodeX404 Solutions](https://codex404solutions.online/)
- [Paperclip](https://github.com/paperclipai/paperclip)
- [Agent Companies specification](https://agentcompanies.io/specification)

Generated for CodeX404 Solutions from the Paperclip company package format.
