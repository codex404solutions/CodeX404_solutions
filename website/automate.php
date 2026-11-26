<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'AUTOMATE',
    'eyebrow' => 'AUTOMATE · Integrations, workflows, and AI',
    'title' => 'Streamline Operations With Applied AI & Intelligent Workflows',
    'title_html' => 'Streamline Operations With <span class="text-amber">Applied AI &amp; Workflows</span>',
    'intro' => 'Eliminate repetitive manual work by connecting internal tools, building grounded AI assistants, and automating business workflows with clear safety guardrails.',
    'audience' => 'Operations managers, support teams, and founders looking to eliminate repetitive manual handoffs and scattered data entry.',
    'problems' => [
        'Teams waste hours re-entering identical data across disparate CRMs, ERPs, and spreadsheets.',
        'Internal documentation and operating procedures are scattered and slow to retrieve.',
        'Manual workflows introduce human transcription errors and delayed customer follow-through.',
    ],
    'services' => [
        ['icon' => '◎', 'title' => 'Applied AI & RAG Knowledge Systems', 'description' => 'Private Retrieval-Augmented Generation (RAG) assistants anchored to approved company documentation with source citations.', 'url' => 'ai-solutions.php'],
        ['icon' => '⎇', 'title' => 'Accountable AI Agents', 'description' => 'Tool-using workflows with strict execution boundaries, schema checks, and human review gates.', 'url' => 'ai-agents.php'],
        ['icon' => '⟳', 'title' => 'Custom API & Workflow Integrations', 'description' => 'Webhooks, WhatsApp Cloud API flows, and custom middleware connecting your existing business software.', 'url' => 'automation.php'],
    ],
    'steps' => [
        ['title' => 'Audit & Map Workflows', 'description' => 'Analyze inputs, repetitive handoffs, system APIs, and critical human approval points.'],
        ['title' => 'Architect Security & Schema', 'description' => 'Establish scoped API credentials, validation rules, and clean fallback handlers.'],
        ['title' => 'Build & Orchestrate', 'description' => 'Implement resilient background queues, webhook listeners, and schema-checked AI routines.'],
        ['title' => 'Deploy & Maintain', 'description' => 'Launch into production with inspectable run logs, failure alerts, and ongoing support options.'],
    ],
    'examples' => [
        ['title' => 'Internal Knowledge Assistant', 'description' => 'RAG platform indexing manuals and policies with linked source citations.'],
        ['title' => 'Multi-System Sync Engine', 'description' => 'Automated event pipeline synchronizing web forms, invoicing, and internal records.'],
        ['title' => 'Document Intake & Extraction', 'description' => 'OCR and structured parsing pipeline turning PDFs and invoices into validated database rows.'],
    ],
    'faqs' => [
        ['q' => 'Can an AI workflow execute actions without human review?', 'a' => 'You control the boundaries. We implement human approval gates for high-impact actions such as refunds, financial edits, or outbound messaging.'],
        ['q' => 'How do you handle sensitive company data in AI workflows?', 'a' => 'We isolate credentials, choose private or API-controlled endpoints configured against training reuse, and enforce strict access permissions during retrieval.'],
        ['q' => 'What tech stack do you use for automations?', 'a' => 'We build custom services in PHP, Python, and Node.js alongside workflow tools like n8n, official WhatsApp Cloud webhooks, and vector search stores matched to project needs.'],
    ],
];
$pageMeta = ['title' => 'AUTOMATE — AI, Workflows, and Integrations', 'description' => $division['intro'], 'canonical' => url('automate.php')];
require __DIR__ . '/includes/division-overview-content.php';
