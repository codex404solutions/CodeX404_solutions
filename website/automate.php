<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'AUTOMATE',
    'eyebrow' => 'AUTOMATE · Integrations, workflows, and AI',
    'title' => 'Streamline Operations with Enterprise AI & Intelligent Workflows',
    'intro' => 'Eliminate manual operational bottlenecks by integrating internal tools, deploying custom AI assistants, and automating business workflows with strict security guardrails.',
    'audience' => 'Operations directors, customer support leaders, and engineering teams seeking to eliminate repetitive manual handoffs and fragmented data entry.',
    'problems' => [
        'Teams waste hours re-entering identical data across disparate CRMs, ERPs, and spreadsheets.',
        'Institutional documentation and internal knowledge are scattered and difficult to retrieve.',
        'Manual workflows introduce human error, delayed customer response times, and high overhead.',
    ],
    'services' => [
        ['icon' => '◎', 'title' => 'Enterprise AI & Knowledge Systems', 'description' => 'Secure private Retrieval-Augmented Generation (RAG) platforms that query your company docs with zero data leaks.', 'url' => 'ai-solutions.php'],
        ['icon' => '⎇', 'title' => 'Autonomous AI Agents', 'description' => 'Multi-step AI agents with strict execution boundaries, deterministic tool calling, and human review gates.', 'url' => 'ai-agents.php'],
        ['icon' => '⟳', 'title' => 'Custom API & Workflow Integrations', 'description' => 'End-to-end webhooks, Zapier/n8n pipelines, and custom event listeners connecting your business stack.', 'url' => 'automation.php'],
    ],
    'steps' => [
        ['title' => 'Audit & Map Workflows', 'description' => 'Analyze inputs, repetitive handoffs, system APIs, and critical human approval points.'],
        ['title' => 'Architect Security & Schema', 'description' => 'Establish zero-trust API credentials, validation rules, and error fallback handlers.'],
        ['title' => 'Build & Orchestrate', 'description' => 'Implement resilient micro-services, event queues, and deterministic AI parsing routines.'],
        ['title' => 'Deploy & Monitor', 'description' => 'Launch into production with audit logs, real-time alert triggers, and maintenance SLA.'],
    ],
    'examples' => [
        ['title' => 'Private Enterprise Knowledge Assistant', 'description' => 'RAG platform indexing company manuals and policies with precise source citations.'],
        ['title' => 'Multi-System Sync Engine', 'description' => 'Automated event pipeline synchronizing CRM leads, billing invoices, and ERP records.'],
        ['title' => 'Automated Document Extraction', 'description' => 'AI ingestion pipeline parsing invoices and PDFs directly into structured database tables.'],
    ],
    'faqs' => [
        ['q' => 'Can an AI workflow execute actions without human review?', 'a' => 'You decide the guardrails. We implement Human-in-the-Loop (HITL) checkpoints for high-impact actions (such as financial transactions or external emails), with autonomous execution reserved for verified routine tasks.'],
        ['q' => 'How do you safeguard proprietary enterprise data?', 'a' => 'All AI implementations utilize sovereign or enterprise private endpoints where customer data is never used to train foundational models. All API communications are strictly encrypted.'],
        ['q' => 'What tech stack do you use for automations?', 'a' => 'We engineer bespoke microservices in PHP, Python, and Node.js, and integrate with platforms like n8n, Zapier, LangChain, and OpenAI/Anthropic/Gemini APIs depending on enterprise scale.'],
    ],
];
$pageMeta = ['title' => 'AUTOMATE — AI, Workflows, and Integrations', 'description' => $division['intro'], 'canonical' => url('automate.php')];
require __DIR__ . '/includes/division-overview-content.php';
