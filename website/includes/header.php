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
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/main.css') ? filemtime(dirname(__DIR__) . '/assets/css/main.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/components.css') ? filemtime(dirname(__DIR__) . '/assets/css/components.css') : '1.0' ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/css/responsive.css') ? filemtime(dirname(__DIR__) . '/assets/css/responsive.css') : '1.0' ?>">
</head>

<body>
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
                    <span class="status-label-bold">Available for Q4/2026</span>
                    <span class="status-divider" aria-hidden="true">•</span>
                    <span class="status-subtext">Senior Engineering Studio</span>
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
                <a href="<?= COMPANY_WHATSAPP_URL ?>" target="_blank" rel="noopener noreferrer"
                    class="top-announcement-wa-btn" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M17.472 14.382c-.301-.15-1.782-.879-2.058-.979-.276-.1-.476-.15-.676.15-.2.301-.777.979-.952 1.18-.175.201-.351.226-.652.076-.301-.15-1.27-.468-2.42-1.493-.895-.798-1.5-1.784-1.675-2.085-.175-.301-.019-.464.132-.614.135-.135.301-.351.451-.527.15-.175.2-.301.301-.501.1-.2.05-.376-.025-.527-.075-.15-.676-1.63-.927-2.232-.244-.587-.492-.507-.676-.516l-.576-.01c-.2 0-.526.075-.802.376-.275.301-1.053 1.028-1.053 2.508s1.078 2.909 1.229 3.11c.15.2 2.122 3.24 5.14 4.544.718.31 1.278.496 1.716.635.722.23 1.379.197 1.9.12.58-.087 1.782-.728 2.033-1.431.25-.703.25-1.305.175-1.431-.075-.126-.275-.201-.576-.351zM12.04 2C6.54 2 2.07 6.47 2.07 11.97c0 1.93.55 3.73 1.5 5.26L2 22l4.9-1.53a9.92 9.92 0 005.14 1.44h.01c5.5 0 9.97-4.47 9.97-9.97 0-5.5-4.47-9.97-9.97-9.97zm0 18.23c-1.64 0-3.23-.44-4.63-1.28l-.33-.2-3.44 1.08 1.1-3.35-.22-.35A8.19 8.19 0 013.87 11.97c0-4.5 3.66-8.17 8.17-8.17 4.5 0 8.17 3.66 8.17 8.17 0 4.51-3.67 8.17-8.17 8.17z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . '/navigation.php'; ?>
    <main id="main-content" tabindex="-1">