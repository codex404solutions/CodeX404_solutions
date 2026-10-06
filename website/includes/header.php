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

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= asset('css/main.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
</head>
<body>
<div class="screen-vignette" aria-hidden="true"></div>

<?php require_once __DIR__ . '/navigation.php'; ?>
