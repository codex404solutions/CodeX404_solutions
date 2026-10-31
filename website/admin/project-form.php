<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

$projectId = trim((string)($_GET['id'] ?? ''));
$isEdit = false;
$projectTypes = ProjectService::getProjectTypes();
$showcaseStatuses = ProjectService::getShowcaseStatuses();
$permissionStatuses = ProjectService::getPermissionStatuses();

$project = [
    'id' => '',
    'title' => '',
    'category' => 'software',
    'category_label' => 'Custom Software',
    'project_type' => 'client',
    'showcase_status' => 'live_website',
    'badge_text' => 'Production Live',
    'badge_type' => 'live',
    'mockup_host' => 'app.internal.system',
    'mockup_tag1' => '',
    'mockup_tag2' => '',
    'cover_image' => '',
    'gallery' => [],
    'client_name' => '',
    'client_logo' => '',
    'anonymized_name' => '',
    'client_permission_status' => 'approved',
    'client_permission_restrictions' => [
        'allow_client_name' => true,
        'allow_client_logo' => true,
        'allow_live_link' => true,
        'allow_case_study' => true,
        'allow_metrics' => true,
        'allow_screenshots' => true,
        'allow_testimonial' => true
    ],
    'internal_notes' => '',
    'stat_1_val' => '',
    'stat_1_lbl' => '',
    'stat_2_val' => '',
    'stat_2_lbl' => '',
    'stat_3_val' => '',
    'stat_3_lbl' => '',
    'problem' => '',
    'solution' => '',
    'features' => [],
    'team_role' => '',
    'metric' => '',
    'verified_results' => '',
    'tags' => [],
    'demo_key' => 'erp',
    'demo_url' => '',
    'video_url' => '',
    'live_url' => '',
    'case_study_url' => 'case-studies',
    'case_study_content' => '',
    'order' => count(ProjectService::getAll()) + 1,
    'status' => 'published',
    'is_featured' => false,
    'active' => true,
];

if ($projectId !== '') {
    // Pass true so admin can view raw un-sanitized data including private notes
    $found = ProjectService::getById($projectId, true);
    if ($found) {
        $project = array_merge($project, $found);
        $isEdit = true;
    } else {
        set_admin_flash('error', "Project '{$projectId}' was not found.");
        header('Location: ' . admin_url('deliverables'));
        exit;
    }
}

$errors = [];

// Form submission handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        $errors[] = 'Security token expired. Please refresh the page.';
    } else {
        $title = trim((string)($_POST['title'] ?? ''));
        if ($title === '') {
            $errors[] = 'Project title is required.';
        }

        $problem = trim((string)($_POST['problem'] ?? ''));
        $solution = trim((string)($_POST['solution'] ?? ''));
        if ($problem === '') {
            $errors[] = 'Problem description is required.';
        }
        if ($solution === '') {
            $errors[] = 'Engineering solution description is required.';
        }

        // Validate URLs if provided
        $liveUrl = trim((string)($_POST['live_url'] ?? ''));
        if ($liveUrl !== '' && !filter_var($liveUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'Live Production URL is not a valid URL (must start with http:// or https://).';
        }

        $demoUrl = trim((string)($_POST['demo_url'] ?? ''));
        if ($demoUrl !== '' && !filter_var($demoUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'Demo URL is not a valid URL.';
        }

        $videoUrl = trim((string)($_POST['video_url'] ?? ''));
        if ($videoUrl !== '' && !filter_var($videoUrl, FILTER_VALIDATE_URL)) {
            $errors[] = 'Video Walkthrough URL is not a valid URL.';
        }

        // Handle File Uploads (Cover Image)
        $coverImage = trim((string)($_POST['cover_image'] ?? $project['cover_image']));
        if (!empty($_FILES['cover_image_file']['tmp_name'])) {
            $uploadResult = ProjectService::handleImageUpload($_FILES['cover_image_file'], 'cover');
            if ($uploadResult['success']) {
                $coverImage = $uploadResult['path'];
            } else {
                $errors[] = 'Cover Image Upload: ' . $uploadResult['error'];
            }
        }

        // Handle File Uploads (Client Logo)
        $clientLogo = trim((string)($_POST['client_logo'] ?? $project['client_logo']));
        if (!empty($_FILES['client_logo_file']['tmp_name'])) {
            $uploadResult = ProjectService::handleImageUpload($_FILES['client_logo_file'], 'logo');
            if ($uploadResult['success']) {
                $clientLogo = $uploadResult['path'];
            } else {
                $errors[] = 'Client Logo Upload: ' . $uploadResult['error'];
            }
        }

        // Handle Gallery
        $rawGalleryText = trim((string)($_POST['gallery_text'] ?? ''));
        $gallery = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $rawGalleryText)))));

        // Handle multi-file uploads for gallery
        if (!empty($_FILES['gallery_files']['name'][0])) {
            $totalFiles = count($_FILES['gallery_files']['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                if (!empty($_FILES['gallery_files']['tmp_name'][$i])) {
                    $singleFile = [
                        'name' => $_FILES['gallery_files']['name'][$i],
                        'type' => $_FILES['gallery_files']['type'][$i],
                        'tmp_name' => $_FILES['gallery_files']['tmp_name'][$i],
                        'error' => $_FILES['gallery_files']['error'][$i],
                        'size' => $_FILES['gallery_files']['size'][$i],
                    ];
                    $uploadResult = ProjectService::handleImageUpload($singleFile, 'gallery');
                    if ($uploadResult['success']) {
                        $gallery[] = $uploadResult['path'];
                    } else {
                        $errors[] = "Gallery File {$singleFile['name']}: " . $uploadResult['error'];
                    }
                }
            }
        }

        if (empty($errors)) {
            $rawTags = (string)($_POST['tags'] ?? '');
            $tagsArr = array_values(array_filter(array_map('trim', explode(',', $rawTags))));

            $rawFeatures = (string)($_POST['features'] ?? '');
            $featuresArr = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $rawFeatures)))));

            $restrictions = [
                'allow_client_name' => !empty($_POST['perm_allow_client_name']),
                'allow_client_logo' => !empty($_POST['perm_allow_client_logo']),
                'allow_screenshots' => !empty($_POST['perm_allow_screenshots']),
                'allow_live_link' => !empty($_POST['perm_allow_live_link']),
                'allow_case_study' => !empty($_POST['perm_allow_case_study']),
                'allow_metrics' => !empty($_POST['perm_allow_metrics']),
                'allow_testimonial' => !empty($_POST['perm_allow_testimonial']),
            ];

            $status = trim((string)($_POST['status'] ?? 'published'));
            $active = ($status === 'published' || !empty($_POST['active']));

            $saveData = [
                'id' => $isEdit ? $project['id'] : trim((string)($_POST['id'] ?? '')),
                'title' => $title,
                'category' => trim((string)($_POST['category'] ?? 'software')),
                'category_label' => trim((string)($_POST['category_label'] ?? 'Custom Software')),
                'project_type' => trim((string)($_POST['project_type'] ?? 'client')),
                'showcase_status' => trim((string)($_POST['showcase_status'] ?? 'live_website')),
                'badge_text' => trim((string)($_POST['badge_text'] ?? 'Production Live')),
                'badge_type' => trim((string)($_POST['badge_type'] ?? 'live')),
                'cover_image' => $coverImage,
                'gallery' => $gallery,
                'client_name' => trim((string)($_POST['client_name'] ?? '')),
                'client_logo' => $clientLogo,
                'anonymized_name' => trim((string)($_POST['anonymized_name'] ?? '')),
                'client_permission_status' => trim((string)($_POST['client_permission_status'] ?? 'approved')),
                'client_permission_restrictions' => $restrictions,
                'internal_notes' => trim((string)($_POST['internal_notes'] ?? '')),
                'mockup_host' => trim((string)($_POST['mockup_host'] ?? 'app.internal.system')),
                'mockup_tag1' => trim((string)($_POST['mockup_tag1'] ?? '')),
                'mockup_tag2' => trim((string)($_POST['mockup_tag2'] ?? '')),
                'stat_1_val' => trim((string)($_POST['stat_1_val'] ?? '')),
                'stat_1_lbl' => trim((string)($_POST['stat_1_lbl'] ?? '')),
                'stat_2_val' => trim((string)($_POST['stat_2_val'] ?? '')),
                'stat_2_lbl' => trim((string)($_POST['stat_2_lbl'] ?? '')),
                'stat_3_val' => trim((string)($_POST['stat_3_val'] ?? '')),
                'stat_3_lbl' => trim((string)($_POST['stat_3_lbl'] ?? '')),
                'problem' => $problem,
                'solution' => $solution,
                'features' => $featuresArr,
                'team_role' => trim((string)($_POST['team_role'] ?? '')),
                'metric' => trim((string)($_POST['metric'] ?? '')),
                'verified_results' => trim((string)($_POST['verified_results'] ?? '')),
                'tags' => $tagsArr,
                'demo_key' => trim((string)($_POST['demo_key'] ?? 'erp')),
                'demo_url' => $demoUrl,
                'video_url' => $videoUrl,
                'live_url' => $liveUrl,
                'case_study_url' => trim((string)($_POST['case_study_url'] ?? 'case-studies')),
                'case_study_content' => trim((string)($_POST['case_study_content'] ?? '')),
                'order' => (int)($_POST['order'] ?? 1),
                'status' => $status,
                'is_featured' => !empty($_POST['is_featured']),
                'active' => $active,
            ];

            $saved = ProjectService::save($saveData);
            set_admin_flash('success', "Project '{$saved['title']}' was successfully " . ($isEdit ? 'updated' : 'created') . '!');
            header('Location: ' . admin_url('deliverables'));
            exit;
        } else {
            // Repopulate form with submitted values
            $project = array_merge($project, $_POST);
            $rawTags = (string)($_POST['tags'] ?? '');
            $project['tags'] = array_values(array_filter(array_map('trim', explode(',', $rawTags))));
            $rawFeatures = (string)($_POST['features'] ?? '');
            $project['features'] = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $rawFeatures)))));
            $project['gallery'] = $gallery;
            $project['cover_image'] = $coverImage;
            $project['client_logo'] = $clientLogo;
            $project['active'] = !empty($_POST['active']);
            $project['is_featured'] = !empty($_POST['is_featured']);
        }
    }
}

$tagsString = implode(', ', $project['tags'] ?? []);
$featuresString = implode("\n", $project['features'] ?? []);
$galleryString = implode("\n", $project['gallery'] ?? []);
$curRestrictions = $project['client_permission_restrictions'] ?? [];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit ' . htmlspecialchars($project['title']) : 'Create New Deliverable' ?> — CodeX404 Admin</title>
    <meta name="robots" content="noindex, nofollow">

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_admin_theme');
            let theme = storedTheme ? storedTheme : 'combo';
            const effective = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effective);
        })();
    </script>

    <!-- Bootstrap 5.3.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">

    <style>
        :root {
            --cx-cyan: #22D3EE;
            --cx-blue: #3B82F6;
            --cx-indigo: #6366F1;
            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-mono: 'Fira Code', monospace;
        }

        [data-bs-theme="dark"] {
            --cx-bg-canvas: #030712;
            --cx-bg-surface: #0B0F19;
            --cx-bg-card: rgba(17, 24, 39, 0.7);
            --cx-border: rgba(255, 255, 255, 0.08);
            --cx-text-primary: #F8FAFC;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        [data-bs-theme="light"] {
            --cx-bg-canvas: #F8FAFC;
            --cx-bg-surface: #FFFFFF;
            --cx-bg-card: #FFFFFF;
            --cx-border: #E2E8F0;
            --cx-text-primary: #0F172A;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #FFFFFF;
            --cx-card-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        [data-bs-theme="combo"] {
            --cx-bg-canvas: #F1F5F9;
            --cx-bg-surface: #FFFFFF;
            --cx-bg-card: #FFFFFF;
            --cx-border: #E2E8F0;
            --cx-text-primary: #0F172A;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--cx-bg-canvas);
            color: var(--cx-text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .admin-navbar {
            background-color: var(--cx-nav-bg);
            border-bottom: 1px solid var(--cx-border);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            backdrop-filter: blur(16px);
        }

        .admin-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #0B0F19;
            padding: 6px 14px;
            border-radius: 12px;
            border: 1px solid rgba(34, 211, 238, 0.3);
            text-decoration: none;
        }

        .admin-card {
            background-color: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            box-shadow: var(--cx-card-shadow);
        }

        .form-section-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--cx-text-muted);
            margin-bottom: 0.35rem;
        }
    </style>
</head>
<body>

<!-- Navigation Header -->
<nav class="admin-navbar">
    <div class="container-fluid px-md-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <a href="<?= admin_url() ?>" class="admin-brand-pill">
                <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" style="height: 30px; object-fit: contain;">
            </a>
            <span class="badge bg-dark border border-secondary text-info text-uppercase" style="font-size: 0.68rem;">PORTFOLIO ARCHITECT</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Theme Toggle -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1" id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-circle-half theme-icon-active text-info"></i>
                    <span class="small d-none d-sm-inline" id="bd-theme-admin-text">Theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="combo"><i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark"><i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light"><i class="bi bi-sun-fill text-warning"></i> Pure Light Mode</button></li>
                </ul>
            </div>

            <?php if ($isEdit): ?>
                <a href="<?= url('project.php?id=' . urlencode($project['id'])) ?>" target="_blank" class="btn btn-outline-info btn-sm d-flex align-items-center gap-1 px-3 py-1" style="border-radius: 8px;">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Preview Public View</span>
                </a>
            <?php endif; ?>

            <a href="<?= admin_url('deliverables') ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 px-3 py-1" style="border-radius: 8px;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Deliverables</span>
            </a>
        </div>
    </div>
</nav>

<!-- Main Form Container -->
<main class="container px-3 px-md-4 py-4" style="max-width: 1040px;">

    <!-- Page Title -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                <a href="<?= admin_url('deliverables') ?>" class="text-decoration-none text-muted">Deliverables</a>
                <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                <span class="text-info"><?= $isEdit ? 'Edit Deliverable' : 'Upload New' ?></span>
            </div>
            <h1 class="h3 fw-bold mb-1"><?= $isEdit ? 'Edit: ' . htmlspecialchars($project['title']) : 'Create Production Deliverable' ?></h1>
            <p class="text-muted small mb-0">Configure project taxonomy, client authorization restrictions, verified results, and media assets.</p>
        </div>
    </div>

    <!-- Errors Banner -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger shadow-sm rounded-3 mb-4">
            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please resolve the following issues:</h6>
            <ul class="mb-0 ps-3 small">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= admin_url('project-form' . ($isEdit ? '?id=' . urlencode($project['id']) : '')) ?>" enctype="multipart/form-data">
        <?= csrf_input_field() ?>

        <!-- ======================================================== -->
        <!-- SECTION 1: IDENTITY & TAXONOMY                           -->
        <!-- ======================================================== -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-info"><i class="bi bi-card-heading"></i> 1. Project Identity, Type &amp; Showcase Status</h2>
            <p class="text-muted small mb-4">Classify deliverables by project nature and showcase format so visitors immediately recognize authentic client deliverables vs. internal prototypes.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-8">
                    <label class="form-label" for="title">Project Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($project['title']) ?>" required placeholder="e.g. Insan Degree College — Official Web Portal">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label" for="id">Unique Slug / ID</label>
                    <input type="text" id="id" name="id" class="form-control" value="<?= htmlspecialchars($project['id']) ?>" <?= $isEdit ? 'readonly style="opacity: 0.7;"' : '' ?> placeholder="auto-generated-if-blank" style="font-family: var(--font-mono);">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-3">
                    <label class="form-label" for="project_type">Project Type *</label>
                    <select id="project_type" name="project_type" class="form-select fw-semibold">
                        <?php foreach ($projectTypes as $tKey => $tVal): ?>
                            <option value="<?= htmlspecialchars($tKey) ?>" <?= (($project['project_type'] ?? 'client') === $tKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tVal['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label" for="showcase_status">Showcase Format *</label>
                    <select id="showcase_status" name="showcase_status" class="form-select fw-semibold">
                        <?php foreach ($showcaseStatuses as $sKey => $sVal): ?>
                            <option value="<?= htmlspecialchars($sKey) ?>" <?= (($project['showcase_status'] ?? 'live_website') === $sKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sVal['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label" for="category">Category Filter Tab *</label>
                    <select id="category" name="category" class="form-select">
                        <option value="booking" <?= ($project['category'] === 'booking') ? 'selected' : '' ?>>Booking &amp; Scheduling (booking)</option>
                        <option value="software" <?= ($project['category'] === 'software') ? 'selected' : '' ?>>Custom Software &amp; Portals (software)</option>
                        <option value="ai" <?= ($project['category'] === 'ai') ? 'selected' : '' ?>>AI Agents &amp; Automation (ai)</option>
                        <option value="commerce" <?= ($project['category'] === 'commerce') ? 'selected' : '' ?>>B2B Commerce &amp; Wholesale (commerce)</option>
                        <option value="mobile" <?= ($project['category'] === 'mobile') ? 'selected' : '' ?>>Mobile Apps &amp; PWA (mobile)</option>
                        <option value="cloud" <?= ($project['category'] === 'cloud') ? 'selected' : '' ?>>Cloud &amp; DevOps (cloud)</option>
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label" for="category_label">Badge Sub-Label</label>
                    <input type="text" id="category_label" name="category_label" class="form-control" value="<?= htmlspecialchars($project['category_label'] ?? '') ?>" placeholder="e.g. Higher Education Portal">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="status">Publication Lifecycle</label>
                    <select id="status" name="status" class="form-select">
                        <option value="published" <?= (($project['status'] ?? 'published') === 'published') ? 'selected' : '' ?>>Published (Live on Website)</option>
                        <option value="draft" <?= (($project['status'] ?? '') === 'draft') ? 'selected' : '' ?>>Draft (Internal Preview Only)</option>
                        <option value="archived" <?= (($project['status'] ?? '') === 'archived') ? 'selected' : '' ?>>Archived (Hidden from Catalog)</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label" for="order">Display Sort Order</label>
                    <input type="number" id="order" name="order" class="form-control" value="<?= (int)($project['order'] ?? 1) ?>" min="1" max="99">
                </div>

                <div class="col-12 col-md-4 d-flex align-items-center pt-md-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" <?= !empty($project['is_featured']) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-bold" for="is_featured">
                            Featured Deliverable (Top Carousel)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 2: CLIENT GOVERNANCE & NDA PERMISSION TRACKING    -->
        <!-- ======================================================== -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-warning"><i class="bi bi-shield-lock-fill"></i> 2. Client Governance &amp; NDA Permission Tracking</h2>
            <p class="text-muted small mb-4">Control what client identity assets can be publicly published. Unauthorized names and logos are automatically withheld or anonymized on public views.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="client_name">Client Real Name</label>
                    <input type="text" id="client_name" name="client_name" class="form-control" value="<?= htmlspecialchars($project['client_name'] ?? '') ?>" placeholder="e.g. Insan Degree College">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label" for="anonymized_name">Anonymized Name (Fallback under NDA)</label>
                    <input type="text" id="anonymized_name" name="anonymized_name" class="form-control" value="<?= htmlspecialchars($project['anonymized_name'] ?? '') ?>" placeholder="e.g. Leading Higher Education Institution">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label" for="client_permission_status">Client Permission Status *</label>
                    <select id="client_permission_status" name="client_permission_status" class="form-select fw-bold">
                        <?php foreach ($permissionStatuses as $pKey => $pVal): ?>
                            <option value="<?= htmlspecialchars($pKey) ?>" <?= (($project['client_permission_status'] ?? 'approved') === $pKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pVal['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Granular Permission Toggles -->
            <div class="p-3 rounded-3 mb-3" style="background: rgba(0,0,0,0.02); border: 1px solid var(--cx-border);">
                <label class="form-label d-block mb-2">Granular Authorization Checklist (For "Approved with Restrictions"):</label>
                <div class="row g-2">
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm_allow_client_name" id="perm_allow_client_name" value="1" <?= !empty($curRestrictions['allow_client_name']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="perm_allow_client_name">Allow Real Client Name</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm_allow_client_logo" id="perm_allow_client_logo" value="1" <?= !empty($curRestrictions['allow_client_logo']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="perm_allow_client_logo">Allow Client Logo</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm_allow_live_link" id="perm_allow_live_link" value="1" <?= !empty($curRestrictions['allow_live_link']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="perm_allow_live_link">Allow Live Website Link</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm_allow_screenshots" id="perm_allow_screenshots" value="1" <?= !empty($curRestrictions['allow_screenshots']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="perm_allow_screenshots">Allow Screenshots / Gallery</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm_allow_metrics" id="perm_allow_metrics" value="1" <?= !empty($curRestrictions['allow_metrics']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="perm_allow_metrics">Allow Quantitative Metrics</label>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="perm_allow_case_study" id="perm_allow_case_study" value="1" <?= !empty($curRestrictions['allow_case_study']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="perm_allow_case_study">Allow In-Depth Case Study</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Logo Upload / URL -->
            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="client_logo">Client Logo Path or URL</label>
                    <input type="text" id="client_logo" name="client_logo" class="form-control mb-1" value="<?= htmlspecialchars($project['client_logo'] ?? '') ?>" placeholder="assets/images/projects/client-logo.png">
                    <input type="file" id="client_logo_file" name="client_logo_file" class="form-control form-control-sm" accept="image/*">
                    <div class="text-muted small mt-1">Upload PNG/SVG/WEBP logo or paste existing path.</div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label" for="internal_notes">Private Internal Permission Notes (ADMIN ONLY)</label>
                    <textarea id="internal_notes" name="internal_notes" class="form-control" rows="3" placeholder="Contract #, verbal agreement details, NDA clause, or review requirements. STRICTLY PRIVATE — NEVER RENDERED PUBLICLY."><?= htmlspecialchars($project['internal_notes'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 3: MEDIA, COVER & GALLERY                        -->
        <!-- ======================================================== -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-primary"><i class="bi bi-images"></i> 3. Cover Image &amp; Interface Gallery</h2>
            <p class="text-muted small mb-4">Hero cover visual and screenshot gallery for the project detail page.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="cover_image">Cover Image Path / URL</label>
                    <input type="text" id="cover_image" name="cover_image" class="form-control mb-1" value="<?= htmlspecialchars($project['cover_image'] ?? '') ?>" placeholder="assets/images/projects/cover-insan.webp">
                    <input type="file" id="cover_image_file" name="cover_image_file" class="form-control form-control-sm" accept="image/*">
                    <div class="text-muted small mt-1">Hero cover banner for project detail page.</div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label" for="gallery_files">Upload Screenshot Gallery Images</label>
                    <input type="file" id="gallery_files" name="gallery_files[]" class="form-control form-control-sm mb-2" accept="image/*" multiple>
                    <label class="form-label" for="gallery_text">Existing Gallery Image URLs (One per line)</label>
                    <textarea id="gallery_text" name="gallery_text" class="form-control form-control-sm" rows="3" placeholder="assets/images/projects/screen1.webp&#10;assets/images/projects/screen2.webp" style="font-family: var(--font-mono); font-size: 0.8rem;"><?= htmlspecialchars($galleryString) ?></textarea>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 4: PROBLEM, SOLUTION & CAPABILITIES              -->
        <!-- ======================================================== -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-success"><i class="bi bi-gear-wide-connected"></i> 4. Problem Statement, Engineering Solution &amp; Key Features</h2>
            <p class="text-muted small mb-4">Detail the operational bottleneck and architectural solution engineered by CodeX404.</p>

            <div class="mb-3">
                <label class="form-label" for="problem">Client Problem / Operational Bottleneck *</label>
                <textarea id="problem" name="problem" class="form-control" rows="3" required placeholder="What manual bottleneck, lost inquiries, or high server load did the client face?"><?= htmlspecialchars($project['problem']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="solution">CodeX404 Engineering Solution *</label>
                <textarea id="solution" name="solution" class="form-control" rows="3" required placeholder="What technical architecture, caching, or database did CodeX404 engineer to solve it?"><?= htmlspecialchars($project['solution']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="features">Key System Capabilities &amp; Features (One per line)</label>
                <textarea id="features" name="features" class="form-control" rows="4" placeholder="Dynamic Academic Notice Board&#10;Atomic Slot Reservation Engine&#10;Mobile-Responsive UI"><?= htmlspecialchars($featuresString) ?></textarea>
                <div class="text-muted small mt-1">Rendered as interactive checklist points on project cards and detail pages.</div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 5: TEAM CONTRIBUTION & VERIFIED OUTCOMES         -->
        <!-- ======================================================== -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-warning"><i class="bi bi-speedometer2"></i> 5. Team Contribution &amp; Verified Business Outcomes</h2>
            <p class="text-muted small mb-4">Quantifiable results backed by real telemetry. Do not invent metrics.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="team_role">Team Role &amp; Contribution</label>
                    <textarea id="team_role" name="team_role" class="form-control" rows="3" placeholder="Lead Architecture, Full-Stack PHP Engineering, Database Normalization..."><?= htmlspecialchars($project['team_role'] ?? '') ?></textarea>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label" for="verified_results">Verified Business Results &amp; Telemetry</label>
                    <textarea id="verified_results" name="verified_results" class="form-control" rows="3" placeholder="Zero downtime across 25,000 monthly portal visits; 65% reduction in administrative overhead..."><?= htmlspecialchars($project['verified_results'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="metric">Highlighted Impact Metric Strip</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-graph-up text-success"></i></span>
                    <input type="text" id="metric" name="metric" class="form-control" value="<?= htmlspecialchars($project['metric'] ?? '') ?>" placeholder="e.g. Over 25,000 monthly portal visits during admission season with zero downtime">
                </div>
            </div>

            <!-- Quick Stat Triplets -->
            <label class="form-label d-block mb-2">Quick Mockup KPI Triplets (Displayed inside Browser Frame):</label>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px solid var(--cx-border);">
                        <label class="form-label" for="stat_1_val">Stat 1 Value</label>
                        <input type="text" id="stat_1_val" name="stat_1_val" class="form-control mb-2 fw-bold text-success" value="<?= htmlspecialchars($project['stat_1_val'] ?? '') ?>" placeholder="e.g. 100%">
                        <label class="form-label" for="stat_1_lbl">Stat 1 Label</label>
                        <input type="text" id="stat_1_lbl" name="stat_1_lbl" class="form-control form-control-sm" value="<?= htmlspecialchars($project['stat_1_lbl'] ?? '') ?>" placeholder="e.g. Mobile Responsive">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px solid var(--cx-border);">
                        <label class="form-label" for="stat_2_val">Stat 2 Value</label>
                        <input type="text" id="stat_2_val" name="stat_2_val" class="form-control mb-2 fw-bold text-info" value="<?= htmlspecialchars($project['stat_2_val'] ?? '') ?>" placeholder="e.g. Sub-200ms">
                        <label class="form-label" for="stat_2_lbl">Stat 2 Label</label>
                        <input type="text" id="stat_2_lbl" name="stat_2_lbl" class="form-control form-control-sm" value="<?= htmlspecialchars($project['stat_2_lbl'] ?? '') ?>" placeholder="e.g. TTFB Latency">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.02); border: 1px solid var(--cx-border);">
                        <label class="form-label" for="stat_3_val">Stat 3 Value</label>
                        <input type="text" id="stat_3_val" name="stat_3_val" class="form-control mb-2 fw-bold text-primary" value="<?= htmlspecialchars($project['stat_3_val'] ?? '') ?>" placeholder="e.g. 25,000+">
                        <label class="form-label" for="stat_3_lbl">Stat 3 Label</label>
                        <input type="text" id="stat_3_lbl" name="stat_3_lbl" class="form-control form-control-sm" value="<?= htmlspecialchars($project['stat_3_lbl'] ?? '') ?>" placeholder="e.g. Monthly Inquiries">
                    </div>
                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 6: LINKS, SIMULATOR & CASE STUDY                 -->
        <!-- ======================================================== -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-info"><i class="bi bi-link-45deg"></i> 6. Live Links, Interactive Sandbox &amp; Case Study</h2>
            <p class="text-muted small mb-4">Production URLs, in-browser simulator bindings, video walkthroughs, and case study documentation.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="live_url">Verified Live Production URL</label>
                    <input type="url" id="live_url" name="live_url" class="form-control" value="<?= htmlspecialchars($project['live_url'] ?? '') ?>" placeholder="https://insandegreeclg.codex404solutions.online">
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label" for="mockup_host">Address Bar Host Name</label>
                    <input type="text" id="mockup_host" name="mockup_host" class="form-control" value="<?= htmlspecialchars($project['mockup_host'] ?? '') ?>" placeholder="insandegreeclg.codex404solutions.online" style="font-family: var(--font-mono);">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="demo_key">In-Browser Simulator Tab</label>
                    <select id="demo_key" name="demo_key" class="form-select">
                        <option value="erp" <?= (($project['demo_key'] ?? '') === 'erp') ? 'selected' : '' ?>>School ERP / Role Simulator (erp)</option>
                        <option value="wa" <?= (($project['demo_key'] ?? '') === 'wa') ? 'selected' : '' ?>>WhatsApp Webhook Simulator (wa)</option>
                        <option value="b2b" <?= (($project['demo_key'] ?? '') === 'b2b') ? 'selected' : '' ?>>B2B Wholesale Checkout Engine (b2b)</option>
                        <option value="rag" <?= (($project['demo_key'] ?? '') === 'rag') ? 'selected' : '' ?>>Private RAG Knowledge Assistant (rag)</option>
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label" for="demo_url">External Live Demo / Sandbox App URL</label>
                    <input type="url" id="demo_url" name="demo_url" class="form-control" value="<?= htmlspecialchars($project['demo_url'] ?? '') ?>" placeholder="https://demo.codex404solutions.online/app">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label" for="video_url">Video Walkthrough URL (YouTube / Vimeo / MP4)</label>
                    <input type="url" id="video_url" name="video_url" class="form-control" value="<?= htmlspecialchars($project['video_url'] ?? '') ?>" placeholder="https://youtube.com/watch?v=...">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-8">
                    <label class="form-label" for="tags">Tech Stack Tags (Comma-Separated)</label>
                    <input type="text" id="tags" name="tags" class="form-control" value="<?= htmlspecialchars($tagsString) ?>" placeholder="PHP 8.2, MySQL Relational, Granular RBAC, Sub-200ms TTFB">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label" for="case_study_url">Case Study Anchor / URL</label>
                    <input type="text" id="case_study_url" name="case_study_url" class="form-control" value="<?= htmlspecialchars($project['case_study_url'] ?? 'case-studies') ?>" placeholder="case-studies">
                </div>
            </div>

            <div>
                <label class="form-label" for="case_study_content">In-Depth Case Study Article / Breakdown</label>
                <textarea id="case_study_content" name="case_study_content" class="form-control" rows="4" placeholder="Detailed architectural narrative, migration hurdles, concurrency solutions, and performance benchmarking..."><?= htmlspecialchars($project['case_study_content'] ?? '') ?></textarea>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="d-flex align-items-center gap-3 mb-5">
            <button type="submit" class="btn btn-primary btn-lg fw-bold px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                <i class="bi bi-check2-circle fs-5"></i>
                <span><?= $isEdit ? 'Save Changes' : 'Publish Project Deliverable' ?></span>
            </button>
            <a href="<?= admin_url('deliverables') ?>" class="btn btn-outline-secondary btn-lg px-4 py-2" style="border-radius: 10px;">
                Cancel
            </a>
            <?php if ($isEdit): ?>
                <a href="<?= url('project.php?id=' . urlencode($project['id'])) ?>" target="_blank" class="btn btn-outline-info ms-auto" style="border-radius: 10px;">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Live on Site
                </a>
            <?php endif; ?>
        </div>

    </form>
</main>

<!-- Bootstrap 5.3.3 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const getStoredTheme = () => localStorage.getItem('codex_admin_theme') || 'combo';
    const applyTheme = (theme) => {
        const effectiveTheme = (theme === 'auto')
            ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
            : theme;
        document.documentElement.setAttribute('data-bs-theme', effectiveTheme);
    };
    applyTheme(getStoredTheme());
});
</script>
</body>
</html>
