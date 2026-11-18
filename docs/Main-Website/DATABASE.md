# CodeX404 Solutions — Database Design Specification

**Status:** Proposed logical data model. The existing database must be inspected before any schema changes.

---

## 1. Database principles

- Reuse the existing database unless there is a justified reason to migrate.
- Do not create tables that duplicate existing functionality.
- Keep public content separate from private enquiries and administrative records.
- Store only data required for business operations.
- Use migrations and backups.
- Use consistent timestamps and timezone handling.
- Apply indexes based on actual queries.
- Define retention and deletion behavior.
- Never store passwords in plaintext.

## 2. Discovery checklist

Before design or migration, inspect:
- Database engine and version.
- Existing tables and columns.
- Primary and foreign keys.
- Existing admin and user tables.
- Existing CMS or content tables.
- Existing form submission tables.
- Existing indexes and constraints.
- Current backup and restore process.
- Data volumes and query patterns.
- Existing migrations and migration tool.

Produce a mapping: existing table -> proposed responsibility -> keep/extend/replace -> migration required.

## 3. Logical entities

The following are logical entities, not a requirement to create every table. Map them to the current schema.

### 3.1 divisions
Purpose: BUILD, GROW and AUTOMATE metadata.

Suggested fields:
- id
- code (unique: BUILD, GROW, AUTOMATE)
- name
- slug
- summary
- accent_key
- sort_order
- is_active
- created_at
- updated_at

### 3.2 services
Purpose: Service catalogue.

Suggested fields:
- id
- division_id (FK)
- name
- slug
- short_description
- full_description or content reference
- availability_status
- sort_order
- is_published
- meta_title
- meta_description
- canonical_path
- created_at
- updated_at

Availability status should distinguish active, by-consultation, planned or unavailable. Do not present planned services as currently delivered.

### 3.3 pages
Purpose: CMS-managed general pages, if the existing system needs this.

Suggested fields:
- id
- title
- slug
- page_type
- content_json or content_body
- status (draft, review, published, archived)
- meta_title
- meta_description
- canonical_url
- published_at
- created_by
- updated_by
- created_at
- updated_at

Use a schema validated content format if using JSON blocks. Avoid storing executable scripts or unsafe HTML.

### 3.4 industries
- id
- name
- slug
- summary
- content_reference
- is_published
- sort_order
- created_at
- updated_at

### 3.5 projects
Purpose: Portfolio entries.

Suggested fields:
- id
- title
- slug
- project_type (client, internal, demo, experimental, open_source)
- division_id (nullable)
- industry_id (nullable)
- summary
- challenge
- solution
- technologies_json or relation table
- image references
- public_url (nullable)
- permission_status
- is_published
- created_at
- updated_at

Do not store unverified outcome claims as facts. If outcomes are stored, include evidence/source and approval status.

### 3.6 case_studies
- id
- project_id
- title
- slug
- challenge
- objectives
- approach
- implementation
- outcomes
- outcome_evidence_reference
- client_attribution_permission
- testimonial_permission
- publication_status
- published_at
- created_at
- updated_at

### 3.7 faqs
- id
- question
- answer
- division_id (nullable)
- service_id (nullable)
- page_id (nullable)
- sort_order
- is_published
- created_at
- updated_at

### 3.8 articles
- id
- title
- slug
- excerpt
- body/content reference
- author_id
- category
- status
- published_at
- meta_title
- meta_description
- created_at
- updated_at

### 3.9 testimonials
- id
- display_name
- role_or_company (optional)
- testimonial_text
- source_reference
- permission_status
- verification_status
- is_published
- created_at
- updated_at

Do not publish a testimonial unless authenticity and permission are confirmed.

### 3.10 enquiries
Purpose: Private project enquiries.

Suggested fields:
- id
- name
- email
- company
- country
- website
- division_id
- service_id (nullable)
- project_summary
- budget_range (nullable)
- timeline (nullable)
- consent_at
- status
- assigned_to (nullable)
- created_at
- updated_at

Consider a retention policy. Restrict access to authorised staff. Avoid storing unnecessary personal data.

### 3.11 enquiry_events (optional)
- id
- enquiry_id
- actor_id
- event_type
- safe_summary
- created_at

Do not store secrets or full sensitive content in audit events.

### 3.12 admin_users / roles / permissions
Reuse the existing authentication model. If absent and approved, define:
- users
- roles
- permissions
- user_roles
- role_permissions
- audit_logs

Do not create a parallel identity system if one already exists.

## 4. Relationships

- One division has many services.
- A service belongs to one division.
- Projects may relate to one division and one industry.
- A project may have zero or one published case study, depending on the content model.
- FAQs may be global or associated with a page, division or service.
- An enquiry selects one division and optionally one service.
- An enquiry may have multiple status events.
- Admin users have roles and permissions according to the existing auth model.

## 5. Indexing recommendations

Validate against query patterns before applying:
- Unique index on division code and slug.
- Unique index on service slug within the agreed route model.
- Index published content by status and publication date.
- Index enquiries by created_at, status, division_id and assigned_to as needed.
- Index foreign keys.
- Add full-text search only if the product requires it and the database supports it appropriately.

Avoid excessive indexes on frequently written tables.

## 6. Data validation

- Validate email format and length.
- Enforce allowed division/service relationships.
- Restrict status values.
- Limit form field lengths.
- Validate URLs.
- Validate publication status transitions.
- Validate references to existing content.
- Never trust client-provided foreign keys without server checks.

## 7. Migration strategy

1. Export and back up the current database.
2. Inspect existing schema.
3. Map old data to proposed entities.
4. Identify duplicate or orphaned records.
5. Write migration scripts.
6. Test on a staging copy.
7. Verify row counts and relationships.
8. Test application reads and writes.
9. Prepare rollback or restore procedure.
10. Obtain approval before production migration.

Do not delete old columns or tables during the first migration unless absolutely necessary and approved. Prefer a staged migration.

## 8. Seed data

Seed only stable taxonomy such as:
- BUILD
- GROW
- AUTOMATE
- Approved service categories

Do not seed fake testimonials, clients, projects, metrics or enquiry records.

## 9. Backup and recovery

Document:
- Backup frequency.
- Backup encryption and access.
- Retention period.
- Restore procedure.
- Restore test date.
- Recovery point and recovery time expectations.

Never place production database backups in a public web directory or commit them to Git.

## 10. Database acceptance criteria

- Existing data is mapped.
- No duplicate content model is introduced unnecessarily.
- Enquiry data is private.
- Foreign keys and constraints are tested.
- Migrations are reproducible.
- Backups and restore are tested.
- No secrets or personal data appear in seed files or logs.
