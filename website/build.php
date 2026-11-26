<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'BUILD',
    'eyebrow' => 'BUILD · Digital products and software',
    'title' => 'Engineer Scalable Digital Products Grounded in Business Value',
    'title_html' => 'Engineer Scalable Digital Products <span class="text-amber">Grounded in Business Value</span>',
    'intro' => 'We engineer custom web platforms, SaaS applications, and enterprise software with clean architecture, predictable two-week milestones, and complete client code ownership.',
    'audience' => 'Founders launching new software products, operations leaders replacing fragmented legacy tools, and businesses scaling customer portals.',
    'problems' => [
        'Critical business processes are scattered across brittle spreadsheets, chats, and disconnected tools.',
        'Existing portals or platforms suffer from sluggish performance, confusing UI, or frequent crashes.',
        'New product initiatives stall due to lack of senior architectural leadership and clear delivery milestones.',
    ],
    'services' => [
        ['icon' => '⌘', 'title' => 'Custom Software & Web Platforms', 'description' => 'High-performance web apps, client portals, internal ERPs, and secure REST APIs built for scale.', 'url' => 'software-development.php'],
        ['icon' => '◈', 'title' => 'SaaS Products & MVPs', 'description' => 'From wireframe to production launch: multi-tenant architecture, payment integrations, and modular code.', 'url' => 'saas.php'],
        ['icon' => '▣', 'title' => 'Mobile & Progressive Web Apps', 'description' => 'Fast, offline-resilient mobile and PWA experiences designed for seamless customer and field operations.', 'url' => 'mobile-apps.php'],
    ],
    'steps' => [
        ['title' => 'Discover & Specify', 'description' => 'Unpack technical requirements, database models, and sprint milestones.'],
        ['title' => 'Architect & Prototype', 'description' => 'Design clean UI wireframes, relational database schemas, and secure API contracts.'],
        ['title' => 'Build & Demo Sprints', 'description' => 'Deliver functioning code every two weeks on live staging environments for rapid review.'],
        ['title' => 'Handoff & Scale', 'description' => 'Deploy to production with automated backups, full source ownership, and 30-day warranty.'],
    ],
    'examples' => [
        ['title' => 'Business Client Portal', 'description' => 'Role-based customer platform featuring document exchange, status tracking, and automated invoicing.'],
        ['title' => 'Unified Operations ERP', 'description' => 'Centralized web platform unifying inventory, billing, staff permissions, and real-time reporting.'],
        ['title' => 'SaaS MVP Platform', 'description' => 'Production launch build with authentication, Stripe billing, customer onboarding, and analytics.'],
    ],
    'faqs' => [
        ['q' => 'What types of software projects fit BUILD?', 'a' => 'BUILD covers full-stack web applications, custom ERPs, customer portals, SaaS platforms, and mobile apps. Every system is built on modern, secure stacks with zero bloated templates.'],
        ['q' => 'How are delivery timelines and budgets structured?', 'a' => 'We operate on fixed-milestone pricing with transparent sprint deliverables. You know the exact cost and scope upfront, with working staging demos delivered every two weeks.'],
        ['q' => 'Who owns the code and intellectual property?', 'a' => 'You own 100% of all code, databases, design assets, and architecture upon milestone completion. Zero vendor lock-in, zero recurring licensing fees.'],
    ],
];
$pageMeta = ['title' => 'BUILD — Software and Digital Product Development', 'description' => $division['intro'], 'canonical' => url('build.php')];
require __DIR__ . '/includes/division-overview-content.php';
