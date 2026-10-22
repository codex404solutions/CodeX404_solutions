<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? 'CodeX404 Solutions — Custom Web Development for US Businesses';
$pageDescription = $pageDescription ?? 'Senior-led custom web development for US businesses that need a faster, clearer path from website problems to measurable business results.';
$base = '/codes/CodeX404_solutions/website/';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="theme-color" content="#0b1120">
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $base ?>assets/css/v2-tokens.css">
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
  <div class="container nav">
    <a class="logo" href="<?= $base ?>index.php"><span class="logo-mark">404</span><span>CodeX404 <span style="color:#a5b4fc">Solutions</span></span></a>
    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">Menu</button>
    <nav class="nav-links" id="site-nav" aria-label="Primary navigation">
      <a href="<?= $base ?>index.php#solutions">Solutions</a>
      <a href="<?= $base ?>pricing.php">Pricing</a>
      <a href="<?= $base ?>index.php#work">Case Studies</a>
      <a href="<?= $base ?>blog.php">Insights</a>
      <a href="<?= $base ?>index.php#about">About</a>
      <a class="btn btn-primary" href="<?= $base ?>index.php#contact">Book a Call</a>
    </nav>
  </div>
</header>
<main id="main">
