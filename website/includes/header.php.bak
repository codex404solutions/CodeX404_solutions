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
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/logo.png') ?>">
    
    <!-- Meta tags & Open Graph -->
    <?php render_meta_tags($pageMeta); ?>
    
    <!-- Structured Data -->
    <?php render_json_ld_organization(); ?>
    <?php if (!empty($pageMeta['faq'])) { render_json_ld_faq($pageMeta['faq']); } ?>

    <!-- Fonts & Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap">
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<div class="screen-vignette" aria-hidden="true"></div>

<?php require_once __DIR__ . '/navigation.php'; ?>
<main id="main-content" tabindex="-1">
