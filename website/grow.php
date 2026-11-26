<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/config.php';
$division = [
    'code' => 'GROW',
    'eyebrow' => 'GROW · Digital marketing and discoverability',
    'title' => 'Accelerate Discoverability and Convert High-Intent Traffic',
    'title_html' => 'Help More Customers Find &amp; <span class="text-amber">Choose Your Business</span>',
    'intro' => 'Attract ready-to-buy visitors through clearer Google search visibility, focused ad campaigns, and faster websites built to turn visits into real inquiries.',
    'audience' => 'Brands seeking predictable organic search rankings, e-commerce storefronts optimizing sales conversions, and B2B firms scaling qualified leads.',
    'problems' => [
        'High-value buyers cannot discover your website on major search engines.',
        'Marketing spend is scattered across unfocused channels with poor attribution.',
        'Website traffic fails to convert into qualified inquiries or paying customers.',
    ],
    'services' => [
        ['icon' => '⌕', 'title' => 'Google Search & SEO', 'description' => 'Improve your website structure, page speed, and search keywords so local and online buyers find you first.', 'url' => 'seo-visibility.php'],
        ['icon' => '↗', 'title' => 'Ads & Social Media', 'description' => 'Clear Google, Instagram, and LinkedIn campaigns with honest budget tracking focused on real inquiries.', 'url' => 'digital-ads.php'],
        ['icon' => '◎', 'title' => 'Website Speed & More Sales', 'description' => 'Make pages load faster and guide visitors cleanly toward calling, messaging, or booking a consultation.', 'url' => 'conversion-optimization.php'],
    ],
    'steps' => [
        ['title' => 'Audit & Benchmark', 'description' => 'Analyze technical SEO, site speed, competitor positioning, and conversion friction.'],
        ['title' => 'Formulate Strategy', 'description' => 'Map target keywords, customer search intent, and high-impact acquisition channels.'],
        ['title' => 'Execute & Optimize', 'description' => 'Deploy on-page optimizations, launch targeted campaigns, and refine landing pages.'],
        ['title' => 'Analyze & Compound', 'description' => 'Monitor real-time analytics to double down on highest ROI conversion funnels.'],
    ],
    'examples' => [
        ['title' => 'Technical SEO Overhaul', 'description' => 'Complete site re-indexing, Core Web Vitals speed boost, and semantic structured schema.'],
        ['title' => 'Multi-Channel Acquisition Campaign', 'description' => 'Targeted search and social campaigns delivering measurable return on ad spend (ROAS).'],
        ['title' => 'Conversion Rate Optimization', 'description' => 'Frictionless checkout and lead capture journeys that systematically increase conversion rates.'],
    ],
    'faqs' => [
        ['q' => 'What is included in the GROW division?', 'a' => 'GROW combines technical SEO, content strategy, performance marketing, and conversion rate optimization (CRO) into an integrated growth engine tailored to your market.'],
        ['q' => 'How do you measure marketing ROI?', 'a' => 'We configure transparent end-to-end analytics with event tracking, cost-per-acquisition (CPA) dashboards, and pipeline attribution. You see exactly what every marketing dollar generates.'],
        ['q' => 'How fast do we see results from SEO and marketing?', 'a' => 'Paid performance campaigns deliver traffic within days of launch. Organic SEO gains typically compound within 60 to 90 days as search engines index optimized site architecture and authority signals.'],
    ],
];
$pageMeta = ['title' => 'GROW — Digital Marketing and Search Visibility', 'description' => $division['intro'], 'canonical' => url('grow.php')];
require __DIR__ . '/includes/division-overview-content.php';
