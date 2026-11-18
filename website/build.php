<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'BUILD',
    'eyebrow' => 'BUILD · Digital products and software',
    'title' => 'Build digital products around real business needs',
    'intro' => 'Plan and develop websites, applications, SaaS products, and custom software with clear scope, practical architecture, and collaborative delivery.',
    'audience' => 'Organizations replacing manual processes, teams improving customer or staff journeys, and founders evaluating a digital product idea.',
    'problems' => [
        'Important work is spread across spreadsheets, inboxes, and disconnected tools.',
        'Customers or staff cannot complete key tasks through the current website or portal.',
        'A product idea needs a clear first release and technical plan before investment.',
    ],
    'services' => [
        ['icon' => '⌘', 'title' => 'Custom software and web platforms', 'description' => 'Business applications, customer portals, dashboards, and APIs shaped around your workflows.', 'url' => 'software-development.php'],
        ['icon' => '◈', 'title' => 'SaaS products and MVPs', 'description' => 'Explore product requirements, core workflows, architecture, and an implementation plan for a software product.', 'url' => 'saas.php'],
        ['icon' => '▣', 'title' => 'Mobile applications', 'description' => 'Plan mobile and progressive web experiences for customers, staff, or field teams.', 'url' => 'mobile-apps.php'],
    ],
    'steps' => [
        ['title' => 'Understand the need', 'description' => 'Review users, goals, constraints, and existing systems.'],
        ['title' => 'Agree on scope', 'description' => 'Document features, dependencies, deliverables, and acceptance criteria.'],
        ['title' => 'Design and build', 'description' => 'Develop in reviewable stages and gather feedback as the product takes shape.'],
        ['title' => 'Prepare for handoff', 'description' => 'Review the agreed deliverables, documentation, and next steps.'],
    ],
    'examples' => [
        ['title' => 'Customer portal', 'description' => 'A scoped portal for account information, requests, or document exchange.'],
        ['title' => 'Operations dashboard', 'description' => 'A web application that brings selected workflows and system data into one interface.'],
        ['title' => 'Product MVP', 'description' => 'A first release plan covering priority users, core flows, dependencies, and acceptance criteria.'],
    ],
    'faqs' => [
        ['q' => 'What types of software projects fit BUILD?', 'a' => 'BUILD covers websites, web applications, internal tools, SaaS or MVP work, mobile experiences, and integrations. The suitable scope depends on the users, existing systems, and constraints.'],
        ['q' => 'How are delivery timelines and budgets set?', 'a' => 'They are discussed after reviewing requirements, dependencies, and acceptance criteria. The written scope records agreed deliverables and commercial terms.'],
        ['q' => 'Do you guarantee a launch date or business result?', 'a' => 'No universal result or date is promised. Timing and outcomes depend on the agreed scope, inputs, dependencies, and decisions during the project.'],
    ],
];
$pageMeta = ['title' => 'BUILD — Software and Digital Product Development', 'description' => $division['intro'], 'canonical' => url('build.php')];
require __DIR__ . '/includes/division-overview-content.php';
