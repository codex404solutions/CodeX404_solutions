<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

http_response_code(404);

$pageMeta = [
    'title' => 'Page Not Found (404)',
    'description' => 'The requested page could not be located. Explore CodeX404 Solutions software, AI, and automation solutions.',
    'canonical' => url('404.php')
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section" style="min-height: 65vh; display: flex; align-items: center;">
    <div class="container container-narrow" style="text-align: center;">
        <div class="section-tag" style="margin-bottom: 1.5rem;">
            <span class="dot"></span>
            <span>HTTP Status 404</span>
        </div>

        <h1 style="font-size: clamp(3rem, 6vw, 5.5rem); font-weight: 800; margin-bottom: 1rem; color: var(--white); font-family: var(--font-mono); text-transform: uppercase;">
            404<span class="text-amber">:</span> Not Found
        </h1>

        <p style="font-size: 1.25rem; color: var(--slate); max-width: 580px; margin: 0 auto 2.5rem; line-height: 1.6;">
            The endpoint or page you requested does not exist or has been relocated to another service path.
        </p>

        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
            <a href="<?= url('index.php') ?>" class="btn btn-primary">
                Return to Homepage
            </a>
            <a href="<?= url('solutions.php') ?>" class="btn btn-secondary">
                Explore Solutions
            </a>
            <a href="<?= url('contact.php') ?>" class="btn btn-outline">
                Contact Support
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
