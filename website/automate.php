<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'AUTOMATE',
    'eyebrow' => 'AUTOMATE · Integrations, workflows, and AI',
    'title' => 'Connect systems and simplify repetitive work',
    'intro' => 'Identify practical automation opportunities and build integrations, AI-assisted workflows, and knowledge tools with appropriate review and control.',
    'audience' => 'Operations, support, and product teams handling repeated handoffs, fragmented information, or rules-based work across several systems.',
    'problems' => [
        'Staff re-enter the same information in multiple tools.',
        'Important documents or policies are difficult to search consistently.',
        'Automations need clear approval points, exception handling, and failure paths.',
    ],
    'services' => [
        ['icon' => '◎', 'title' => 'AI and knowledge tools', 'description' => 'Explore assistants and retrieval systems that help teams work with approved information.', 'url' => 'ai-solutions.php'],
        ['icon' => '⎇', 'title' => 'AI agents', 'description' => 'Design tool-using assistants with explicit boundaries, review points, and error handling.', 'url' => 'ai-agents.php'],
        ['icon' => '⟳', 'title' => 'Workflow and system integrations', 'description' => 'Connect APIs and business tools to reduce repetitive handoffs and manual updates.', 'url' => 'automation.php'],
    ],
    'steps' => [
        ['title' => 'Map the workflow', 'description' => 'Understand the people, systems, data, exceptions, and approval points involved.'],
        ['title' => 'Select a safe first step', 'description' => 'Choose a bounded workflow and define what requires human review.'],
        ['title' => 'Build and connect', 'description' => 'Implement the agreed integration with suitable validation and failure handling.'],
        ['title' => 'Review operation', 'description' => 'Confirm the workflow with stakeholders and document support and ownership.'],
    ],
    'examples' => [
        ['title' => 'Document search assistant', 'description' => 'A bounded search experience over approved documents with source references and human review.'],
        ['title' => 'Workflow handoff', 'description' => 'A scoped integration that moves selected events between existing systems and reports exceptions.'],
        ['title' => 'Structured intake', 'description' => 'An automation concept that extracts agreed fields from incoming documents for staff verification.'],
    ],
    'faqs' => [
        ['q' => 'Are the website’s automation demonstrations connected to production services?', 'a' => 'No. The interactive examples on the website are labeled simulations and do not connect to active databases, messaging services, or external APIs.'],
        ['q' => 'Can an AI workflow take actions without review?', 'a' => 'Approval boundaries depend on the workflow and risk. The scope should identify which actions are automated, which require human confirmation, and how failures are handled.'],
        ['q' => 'How do you protect connected data?', 'a' => 'Data sources, access, retention, permissions, and operating controls must be reviewed and agreed for each implementation before integration work begins.'],
    ],
];
$pageMeta = ['title' => 'AUTOMATE — AI, Workflows, and Integrations', 'description' => $division['intro'], 'canonical' => url('automate.php')];
require __DIR__ . '/includes/division-overview-content.php';
