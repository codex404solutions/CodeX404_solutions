<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — SEO & Structured Data Engine
 * Outputs OpenGraph, Twitter Card, and Google-compliant JSON-LD schema.
 */

function render_meta_tags(array $pageMeta = []): void {
    $title = !empty($pageMeta['title']) 
        ? $pageMeta['title'] . ' | ' . APP_NAME 
        : APP_NAME . ' — ' . APP_TAGLINE;

    $description = $pageMeta['description'] ?? APP_DESCRIPTION;
    $canonical = $pageMeta['canonical'] ?? (BASE_URL . ltrim($_SERVER['REQUEST_URI'] ?? '', '/'));
    $ogType = $pageMeta['ogType'] ?? 'website';
    $ogImage = $pageMeta['ogImage'] ?? asset('images/logo/og-preview.jpg');
    $keywords = $pageMeta['keywords'] ?? 'custom software development, enterprise AI solutions, AI agents, workflow automation, SaaS MVP, bespoke CRM systems, India software partner';

    echo '<title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>' . PHP_EOL;
    echo '    <meta name="description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta name="keywords" content="' . htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <link rel="canonical" href="' . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta name="robots" content="index, follow">' . PHP_EOL;

    // OpenGraph
    echo '    <meta property="og:locale" content="en_US">' . PHP_EOL;
    echo '    <meta property="og:site_name" content="' . htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:type" content="' . htmlspecialchars($ogType, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:title" content="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:url" content="' . htmlspecialchars($canonical, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:image" content="' . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:image:secure_url" content="' . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta property="og:image:type" content="image/jpeg">' . PHP_EOL;
    echo '    <meta property="og:image:width" content="1200">' . PHP_EOL;
    echo '    <meta property="og:image:height" content="630">' . PHP_EOL;
    echo '    <meta property="og:image:alt" content="' . htmlspecialchars(APP_NAME . ' — ' . APP_TAGLINE, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;

    // Twitter Card
    echo '    <meta name="twitter:card" content="summary_large_image">' . PHP_EOL;
    echo '    <meta name="twitter:title" content="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta name="twitter:description" content="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
    echo '    <meta name="twitter:image" content="' . htmlspecialchars($ogImage, ENT_QUOTES, 'UTF-8') . '">' . PHP_EOL;
}

function render_json_ld_organization(): void {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => APP_NAME,
        'url' => BASE_URL,
        'logo' => asset('images/logo/logo.png'),
        'image' => asset('images/logo/og-preview.jpg'),
        'description' => APP_DESCRIPTION,
        'email' => COMPANY_EMAIL,
        'founder' => [
            '@type' => 'Person',
            'name' => FOUNDER_NAME,
            'jobTitle' => FOUNDER_ROLE,
            'sameAs' => [FOUNDER_LINKEDIN, FOUNDER_PORTFOLIO]
        ],
        'sameAs' => [
            COMPANY_LINKEDIN,
            FOUNDER_LINKEDIN
        ],
        'areaServed' => ['India'],
        'knowsAbout' => [
            'Software Development', 'Artificial Intelligence', 'AI Agents', 'Business Automation', 'SaaS Development', 'CRM Development'
        ]
    ];

    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . PHP_EOL;
}

function render_json_ld_faq(array $faqItems): void {
    if (empty($faqItems)) return;

    $elements = [];
    foreach ($faqItems as $item) {
        $elements[] = [
            '@type' => 'Question',
            'name' => $item['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $item['a']
            ]
        ];
    }

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $elements
    ];

    echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . PHP_EOL;
}
