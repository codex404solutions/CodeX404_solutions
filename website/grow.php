<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'GROW',
    'eyebrow' => 'GROW · Digital marketing and discoverability',
    'title' => 'Help the right customers find and choose your business',
    'intro' => 'Improve how your business is discovered and understood through search foundations, useful content, digital campaigns, and measurement tied to your goals.',
    'audience' => 'Businesses and marketing teams that want clearer digital journeys, stronger discoverability, or more useful measurement of their online activity.',
    'problems' => [
        'Potential customers struggle to find or understand the business online.',
        'Campaigns and content are spread across channels without clear priorities.',
        'Website journeys and enquiry activity are difficult to assess with the available data.',
    ],
    'services' => [
        ['icon' => '⌕', 'title' => 'Search visibility', 'description' => 'SEO, technical foundations, local discovery, and answer-oriented content opportunities.', 'url' => 'solutions.php'],
        ['icon' => '↗', 'title' => 'Digital marketing', 'description' => 'Campaign planning across suitable search, social, email, and paid channels.', 'url' => 'contact.php'],
        ['icon' => '✎', 'title' => 'Content and brand growth', 'description' => 'Content strategy, website copy, useful articles, and campaign content.', 'url' => 'contact.php'],
        ['icon' => '◎', 'title' => 'Conversion and measurement', 'description' => 'Review landing pages, enquiry journeys, analytics, and reporting needs.', 'url' => 'contact.php'],
    ],
    'steps' => [
        ['title' => 'Review your starting point', 'description' => 'Understand your audience, offer, channels, website, and existing measurement.'],
        ['title' => 'Choose priorities', 'description' => 'Agree on the audience, channels, content, and indicators that matter for the work.'],
        ['title' => 'Plan and implement', 'description' => 'Deliver the agreed improvements and campaigns with clear ownership.'],
        ['title' => 'Measure and refine', 'description' => 'Review available data and use it to guide the next round of work.'],
    ],
    'examples' => [
        ['title' => 'Search readiness review', 'description' => 'A scoped review of technical access, page structure, local information, and content priorities.'],
        ['title' => 'Campaign plan', 'description' => 'An agreed channel and content plan with responsibilities, budget assumptions, and measurement needs.'],
        ['title' => 'Enquiry journey review', 'description' => 'A review of landing pages and form steps to identify measurable usability improvements.'],
    ],
    'faqs' => [
        ['q' => 'What is included in GROW?', 'a' => 'GROW brings together search visibility, digital marketing, content and brand growth, and conversion measurement. The mix is selected for the audience, objectives, and available channels.'],
        ['q' => 'Do you guarantee rankings, leads, or advertising returns?', 'a' => 'No. Search visibility, campaign response, and revenue depend on many factors outside a provider’s control. Work is scoped around defined activities and suitable measurement.'],
        ['q' => 'How do you measure progress?', 'a' => 'Measurement is agreed for the project and depends on access to analytics, advertising, and conversion data. No performance result is assumed before it is measured.'],
    ],
];
$pageMeta = ['title' => 'GROW — Digital Marketing and Search Visibility', 'description' => $division['intro'], 'canonical' => url('grow.php')];
require __DIR__ . '/includes/division-overview-content.php';
