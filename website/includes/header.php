<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/seo.php';

// Allow pages to specify custom metadata
$pageMeta = $pageMeta ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Optional analytics loads only after the visitor accepts cookies. -->
    <script>
      window.loadCodeX404Analytics = function () {
        if (window.codeX404AnalyticsLoaded) return;
        window.codeX404AnalyticsLoaded = true;
        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=G-Z1079KLQE9';
        script.onload = function () {
          window.dataLayer = window.dataLayer || [];
          window.gtag = function(){ window.dataLayer.push(arguments); };
          window.gtag('js', new Date());
          window.gtag('config', 'G-Z1079KLQE9');
        };
        document.head.appendChild(script);
      };
      try {
        if (window.localStorage.getItem('codex404_cookie_consent') === 'accepted') {
          window.loadCodeX404Analytics();
        }
      } catch (error) {
        // Keep optional analytics disabled when browser storage is unavailable.
      }
    </script>
    <link rel="icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/logo/favicon-16x16.png') ?>">

    <!-- Meta tags & Open Graph -->
    <?php render_meta_tags($pageMeta); ?>

    <!-- Structured Data -->
    <?php render_json_ld_organization(); ?>
    <?php if (!empty($pageMeta['faq'])) {
        render_json_ld_faq($pageMeta['faq']);
    } ?>

    <!-- Fonts & Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/main.css') ? filemtime(dirname(__DIR__) . '/assets/css/main.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/animations.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/animations.css') ? filemtime(dirname(__DIR__) . '/assets/css/animations.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/components.css') ? filemtime(dirname(__DIR__) . '/assets/css/components.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/responsive.css') ? filemtime(dirname(__DIR__) . '/assets/css/responsive.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/depth3d.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/depth3d.css') ? filemtime(dirname(__DIR__) . '/assets/css/depth3d.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/careers.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/careers.css') ? filemtime(dirname(__DIR__) . '/assets/css/careers.css') : '1.0' ?>">
</head>

<body class="<?= htmlspecialchars((string)($bodyClass ?? ''), ENT_QUOTES, 'UTF-8') ?>">
    <!-- Reading Progress Bar -->
    <div id="scroll-progress" class="scroll-progress" aria-hidden="true"></div>

    <!-- Interactive Neural Constellation Canvas (Reactive Background Motion) -->
    <canvas id="neural-canvas" aria-hidden="true"></canvas>

    <a class="skip-link" href="#main-content">Skip to main content</a>
    <div class="screen-vignette" aria-hidden="true"></div>

    <!-- Top Utility & Announcement Bar -->
    <div class="top-announcement-bar">
        <div class="container top-announcement-container">
            <div class="top-announcement-left">
                <span class="status-indicator" aria-hidden="true"></span>
                <span class="top-announcement-text">
                    <span class="status-label-bold">BUILD · GROW · AUTOMATE</span>
                    <span class="status-divider" aria-hidden="true">•</span>
                    <span class="status-subtext">Where Bugs Meet Their Match</span>
                </span>
            </div>

            <div class="top-announcement-right">
                <a href="https://mnoukhej.github.io/portfolio/" target="_blank" rel="noopener"
                    class="top-announcement-pill" title="View Founder Portfolio">
                    <span>Founder Portfolio</span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" aria-hidden="true">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a>
                <a href="mailto:<?= COMPANY_EMAIL ?>"
                    class="top-announcement-wa-btn" title="Email CodeX404" aria-label="Email CodeX404">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/navigation.php'; ?>
    <main id="main-content" tabindex="-1">
