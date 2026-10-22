<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

$projectId = trim((string)($_GET['id'] ?? ''));
$isEdit = false;
$project = [
    'id' => '',
    'title' => '',
    'category' => 'software',
    'category_label' => 'Custom Software',
    'badge_text' => 'Production Live',
    'badge_type' => 'live',
    'mockup_host' => 'app.internal.system',
    'mockup_tag1' => '',
    'mockup_tag2' => '',
    'stat_1_val' => '',
    'stat_1_lbl' => '',
    'stat_2_val' => '',
    'stat_2_lbl' => '',
    'stat_3_val' => '',
    'stat_3_lbl' => '',
    'problem' => '',
    'solution' => '',
    'metric' => '',
    'tags' => [],
    'demo_key' => 'erp',
    'live_url' => '',
    'case_study_url' => 'case-studies',
    'order' => count(ProjectService::getAll()) + 1,
    'active' => true,
];

if ($projectId !== '') {
    $found = ProjectService::getById($projectId);
    if ($found) {
        $project = $found;
        $isEdit = true;
    } else {
        set_admin_flash('error', "Project '{$projectId}' was not found.");
        header('Location: ' . admin_url());
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

        if (empty($errors)) {
            $rawTags = (string)($_POST['tags'] ?? '');
            $tagsArr = array_values(array_filter(array_map('trim', explode(',', $rawTags))));

            $saveData = [
                'id' => $isEdit ? $project['id'] : trim((string)($_POST['id'] ?? '')),
                'title' => $title,
                'category' => trim((string)($_POST['category'] ?? 'software')),
                'category_label' => trim((string)($_POST['category_label'] ?? 'Custom Software')),
                'badge_text' => trim((string)($_POST['badge_text'] ?? 'Production Live')),
                'badge_type' => trim((string)($_POST['badge_type'] ?? 'live')),
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
                'metric' => trim((string)($_POST['metric'] ?? '')),
                'tags' => $tagsArr,
                'demo_key' => trim((string)($_POST['demo_key'] ?? 'erp')),
                'live_url' => trim((string)($_POST['live_url'] ?? '')),
                'case_study_url' => trim((string)($_POST['case_study_url'] ?? 'case-studies')),
                'order' => (int)($_POST['order'] ?? 1),
                'active' => !empty($_POST['active']),
            ];

            $saved = ProjectService::save($saveData);
            set_admin_flash('success', "Project '{$saved['title']}' was successfully " . ($isEdit ? 'updated' : 'created') . '!');
            header('Location: ' . admin_url());
            exit;
        } else {
            // Repopulate form with submitted values
            $project = array_merge($project, $_POST);
            $rawTags = (string)($_POST['tags'] ?? '');
            $project['tags'] = array_values(array_filter(array_map('trim', explode(',', $rawTags))));
            $project['active'] = !empty($_POST['active']);
        }
    }
}

$tagsString = implode(', ', $project['tags'] ?? []);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit ' . htmlspecialchars($project['title']) : 'Upload New Deliverable' ?> — CodeX404 Admin</title>
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
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/logo/favicon-16x16.png') ?>">

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

        [data-bs-theme="combo"] .admin-navbar,
        [data-bs-theme="dark"] .admin-navbar {
            border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        }

        .admin-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #0B0F19;
            padding: 6px 14px;
            border-radius: 12px;
            border: 1px solid rgba(34, 211, 238, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
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

        /* ========================================================= */
        /* ADMIN CONSOLE ENTERPRISE FOOTER SYSTEM                    */
        /* ========================================================= */
        .admin-footer {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 3rem;
            box-shadow: var(--cx-card-shadow);
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer,
        [data-bs-theme="combo"] .admin-footer {
            background: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05) !important;
        }

        [data-bs-theme="dark"] .admin-footer {
            background: rgba(11, 15, 25, 0.85) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55) !important;
            backdrop-filter: blur(12px);
        }

        .admin-footer-link {
            color: var(--cx-text-secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            transition: all 0.15s ease;
        }

        .admin-footer-link:hover {
            color: var(--cx-cyan) !important;
            background: rgba(34, 211, 238, 0.08);
            transform: translateX(2px);
        }

        [data-bs-theme="light"] .admin-footer-link,
        [data-bs-theme="combo"] .admin-footer-link {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .admin-footer-link:hover,
        [data-bs-theme="combo"] .admin-footer-link:hover {
            color: #0284C7 !important;
            background: rgba(2, 132, 199, 0.08);
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
            <span class="badge bg-dark border border-secondary text-info text-uppercase" style="font-size: 0.68rem;">PORTFOLIO EDITOR</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Theme Toggle -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1" id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-circle-half theme-icon-active text-info"></i>
                    <span class="small d-none d-sm-inline" id="bd-theme-admin-text">Dark &amp; Light</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="combo"><i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark"><i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode</button></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light"><i class="bi bi-sun-fill text-warning"></i> Pure Light Mode</button></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto"><i class="bi bi-laptop text-secondary"></i> System Auto</button></li>
                </ul>
            </div>

            <a href="<?= admin_url() ?>" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 px-3 py-1" style="border-radius: 8px;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>
    </div>
</nav>

<!-- Main Form Container -->
<main class="container px-3 px-md-4 py-4" style="max-width: 1000px;">

    <!-- Page Title -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 text-muted small mb-1">
                <a href="<?= admin_url() ?>" class="text-decoration-none text-muted">Projects</a>
                <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
                <span class="text-info"><?= $isEdit ? 'Edit Deliverable' : 'Upload New' ?></span>
            </div>
            <h1 class="h3 fw-bold mb-1"><?= $isEdit ? 'Edit: ' . htmlspecialchars($project['title']) : 'Upload Production Deliverable' ?></h1>
            <p class="text-muted small mb-0">Fill in verified technical parameters. Saved changes update live on the website immediately.</p>
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

    <form method="POST" action="<?= admin_url('project-form' . ($isEdit ? '?id=' . urlencode($project['id']) : '')) ?>">
        <?= csrf_input_field() ?>

        <!-- SECTION 1: IDENTITY -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-info"><i class="bi bi-card-heading"></i> 1. Project Identity &amp; Classification</h2>
            <p class="text-muted small mb-4">Core name, slug identifier, and navigation taxonomy.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-8">
                    <label class="form-label" for="title">Project Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($project['title']) ?>" required placeholder="e.g. Insan Degree College — Official Web Portal">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label" for="id">Unique ID / Slug</label>
                    <input type="text" id="id" name="id" class="form-control" value="<?= htmlspecialchars($project['id']) ?>" <?= $isEdit ? 'readonly style="opacity: 0.7;"' : '' ?> placeholder="auto-generated-if-blank" style="font-family: var(--font-mono);">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-4">
                    <label class="form-label" for="category">Filter Tab Category *</label>
                    <select id="category" name="category" class="form-select">
                        <option value="booking" <?= ($project['category'] === 'booking') ? 'selected' : '' ?>>Online Booking &amp; Appointment Systems (booking)</option>
                        <option value="software" <?= ($project['category'] === 'software') ? 'selected' : '' ?>>Custom Software &amp; Portals (software)</option>
                        <option value="ai" <?= ($project['category'] === 'ai') ? 'selected' : '' ?>>AI Agents &amp; Automation (ai)</option>
                        <option value="commerce" <?= ($project['category'] === 'commerce') ? 'selected' : '' ?>>B2B Commerce &amp; Wholesale (commerce)</option>
                        <option value="mobile" <?= ($project['category'] === 'mobile') ? 'selected' : '' ?>>Mobile Apps &amp; PWA (mobile)</option>
                        <option value="cloud" <?= ($project['category'] === 'cloud') ? 'selected' : '' ?>>Cloud &amp; DevOps (cloud)</option>
                    </select>
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="category_label">Category Badge Label</label>
                    <input type="text" id="category_label" name="category_label" class="form-control" value="<?= htmlspecialchars($project['category_label'] ?? '') ?>" placeholder="e.g. Institutional Web Portal">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="order">Display Order</label>
                    <input type="number" id="order" name="order" class="form-control" value="<?= (int)($project['order'] ?? 1) ?>" min="1" max="99">
                </div>
            </div>

            <div class="form-check form-switch pt-2">
                <input class="form-check-input" type="checkbox" role="switch" id="active" name="active" value="1" <?= !empty($project['active']) ? 'checked' : '' ?>>
                <label class="form-check-label fw-bold" for="active">
                    Published &amp; Active on Website
                </label>
                <div class="text-muted small">When checked, this project renders immediately on the public website showcase.</div>
            </div>
        </div>

        <!-- SECTION 2: BROWSER MOCKUP HEADER -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-success"><i class="bi bi-window"></i> 2. Browser Frame &amp; Status Header</h2>
            <p class="text-muted small mb-4">Hostname address bar and visual status tags.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="mockup_host">Mockup URL / Host Address Bar</label>
                    <input type="text" id="mockup_host" name="mockup_host" class="form-control" value="<?= htmlspecialchars($project['mockup_host'] ?? '') ?>" placeholder="e.g. portal.insandegreeclg.online" style="font-family: var(--font-mono);">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="badge_text">Status Badge Text</label>
                    <input type="text" id="badge_text" name="badge_text" class="form-control" value="<?= htmlspecialchars($project['badge_text'] ?? 'Live Production') ?>" placeholder="e.g. Live Production">
                </div>
                <div class="col-12 col-md-3">
                    <label class="form-label" for="badge_type">Badge Glow Style</label>
                    <select id="badge_type" name="badge_type" class="form-select">
                        <option value="live" <?= (($project['badge_type'] ?? '') === 'live') ? 'selected' : '' ?>>Live Green (Production)</option>
                        <option value="demo" <?= (($project['badge_type'] ?? '') === 'demo') ? 'selected' : '' ?>>Cyan Demo (Sandbox Ready)</option>
                    </select>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="mockup_tag1">Screen Top Tag 1</label>
                    <input type="text" id="mockup_tag1" name="mockup_tag1" class="form-control" value="<?= htmlspecialchars($project['mockup_tag1'] ?? '') ?>" placeholder="e.g. 🎓 Higher Education">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="mockup_tag2">Screen Top Tag 2</label>
                    <input type="text" id="mockup_tag2" name="mockup_tag2" class="form-control" value="<?= htmlspecialchars($project['mockup_tag2'] ?? '') ?>" placeholder="e.g. Sub-200ms TTFB">
                </div>
            </div>
        </div>

        <!-- SECTION 3: KPI METRICS -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-warning"><i class="bi bi-speedometer2"></i> 3. Quick KPI Metric Stat Triplets</h2>
            <p class="text-muted small mb-4">Three standout quantitative metrics displayed inside the project card mockup.</p>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.03); border: 1px solid var(--cx-border);">
                        <label class="form-label" for="stat_1_val">Stat 1 Value</label>
                        <input type="text" id="stat_1_val" name="stat_1_val" class="form-control mb-2 fw-bold text-success" value="<?= htmlspecialchars($project['stat_1_val'] ?? '') ?>" placeholder="e.g. 100%">
                        <label class="form-label" for="stat_1_lbl">Stat 1 Label</label>
                        <input type="text" id="stat_1_lbl" name="stat_1_lbl" class="form-control form-control-sm" value="<?= htmlspecialchars($project['stat_1_lbl'] ?? '') ?>" placeholder="e.g. Mobile Responsive">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.03); border: 1px solid var(--cx-border);">
                        <label class="form-label" for="stat_2_val">Stat 2 Value</label>
                        <input type="text" id="stat_2_val" name="stat_2_val" class="form-control mb-2 fw-bold text-info" value="<?= htmlspecialchars($project['stat_2_val'] ?? '') ?>" placeholder="e.g. Sub-200ms">
                        <label class="form-label" for="stat_2_lbl">Stat 2 Label</label>
                        <input type="text" id="stat_2_lbl" name="stat_2_lbl" class="form-control form-control-sm" value="<?= htmlspecialchars($project['stat_2_lbl'] ?? '') ?>" placeholder="e.g. Page Load TTFB">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="p-3 rounded-3" style="background: rgba(0,0,0,0.03); border: 1px solid var(--cx-border);">
                        <label class="form-label" for="stat_3_val">Stat 3 Value</label>
                        <input type="text" id="stat_3_val" name="stat_3_val" class="form-control mb-2 fw-bold text-primary" value="<?= htmlspecialchars($project['stat_3_val'] ?? '') ?>" placeholder="e.g. 25,000+">
                        <label class="form-label" for="stat_3_lbl">Stat 3 Label</label>
                        <input type="text" id="stat_3_lbl" name="stat_3_lbl" class="form-control form-control-sm" value="<?= htmlspecialchars($project['stat_3_lbl'] ?? '') ?>" placeholder="e.g. Monthly Inquiries">
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 4: PROBLEM & SOLUTION -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-primary"><i class="bi bi-gear-wide-connected"></i> 4. Problem Statement &amp; Engineering Solution</h2>
            <p class="text-muted small mb-4">Explain the operational bottleneck and architectural solution engineered by CodeX404.</p>

            <div class="mb-3">
                <label class="form-label" for="problem">Client Problem / Operational Bottleneck *</label>
                <textarea id="problem" name="problem" class="form-control" rows="3" required placeholder="What manual bottleneck, lost inquiries, or high server load did the client face?"><?= htmlspecialchars($project['problem']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="solution">CodeX404 Engineering Solution *</label>
                <textarea id="solution" name="solution" class="form-control" rows="3" required placeholder="What technical architecture, caching, or database did CodeX404 engineer to solve it?"><?= htmlspecialchars($project['solution']) ?></textarea>
            </div>

            <div>
                <label class="form-label" for="metric">Highlighted Impact Metric</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-graph-up text-success"></i></span>
                    <input type="text" id="metric" name="metric" class="form-control" value="<?= htmlspecialchars($project['metric'] ?? '') ?>" placeholder="e.g. Over 25,000 monthly portal visits during admission season with zero downtime">
                </div>
            </div>
        </div>

        <!-- SECTION 5: TECH STACK & URLS -->
        <div class="admin-card p-4 mb-4">
            <h2 class="form-section-title text-info"><i class="bi bi-link-45deg"></i> 5. Technology Stack &amp; Live Demo Sandbox</h2>
            <p class="text-muted small mb-4">Tag chips and simulator bindings.</p>

            <div class="row g-3 mb-3">
                <div class="col-12 col-md-8">
                    <label class="form-label" for="tags">Tech Stack Tags (Comma-Separated)</label>
                    <input type="text" id="tags" name="tags" class="form-control" value="<?= htmlspecialchars($tagsString) ?>" placeholder="e.g. PHP 8.2, MySQL Relational, Granular RBAC, Sub-200ms TTFB">
                    <div class="text-muted small mt-1">Separate tags with commas. Rendered as interactive chips.</div>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label" for="demo_key">Interactive Sandbox Binding</label>
                    <select id="demo_key" name="demo_key" class="form-select">
                        <option value="erp" <?= (($project['demo_key'] ?? '') === 'erp') ? 'selected' : '' ?>>School ERP / Role Simulator (erp)</option>
                        <option value="wa" <?= (($project['demo_key'] ?? '') === 'wa') ? 'selected' : '' ?>>WhatsApp Webhook Simulator (wa)</option>
                        <option value="b2b" <?= (($project['demo_key'] ?? '') === 'b2b') ? 'selected' : '' ?>>B2B Wholesale Checkout Engine (b2b)</option>
                        <option value="rag" <?= (($project['demo_key'] ?? '') === 'rag') ? 'selected' : '' ?>>Private RAG Knowledge Assistant (rag)</option>
                    </select>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label" for="live_url">Verified Live Production URL</label>
                    <input type="url" id="live_url" name="live_url" class="form-control" value="<?= htmlspecialchars($project['live_url'] ?? '') ?>" placeholder="https://insandegreeclg.codex404solutions.online">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="case_study_url">Case Study URL / Anchor</label>
                    <input type="text" id="case_study_url" name="case_study_url" class="form-control" value="<?= htmlspecialchars($project['case_study_url'] ?? 'case-studies') ?>" placeholder="e.g. case-studies">
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary btn-lg fw-bold px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                <i class="bi bi-check2-circle fs-5"></i>
                <span><?= $isEdit ? 'Save Changes' : 'Publish Project Deliverable' ?></span>
            </button>
            <a href="<?= admin_url() ?>" class="btn btn-outline-secondary btn-lg px-4 py-2" style="border-radius: 10px;">
                Cancel
            </a>
        </div>

    <!-- ======================================================== -->
    <!-- ADMIN FORM FOOTER                                        -->
    <!-- ======================================================== -->
    <footer class="admin-footer text-muted small mt-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                &copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong> &bull; Enterprise Deliverables Admin Console &bull; All Rights Reserved.
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="<?= admin_url() ?>" class="admin-footer-link"><i class="bi bi-grid-1x2-fill text-info"></i> Dashboard</a>
                <span>&bull;</span>
                <a href="../../crm/" target="_blank" class="admin-footer-link"><i class="bi bi-robot text-warning"></i> CRM Swarm</a>
                <span>&bull;</span>
                <a href="<?= url('#work') ?>" target="_blank" class="admin-footer-link"><i class="bi bi-box-arrow-up-right text-primary"></i> Public Front</a>
            </div>
        </div>
    </footer>

</main>

<!-- Bootstrap 5.3.3 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const getStoredTheme = () => localStorage.getItem('codex_admin_theme');
    const setStoredTheme = theme => localStorage.setItem('codex_admin_theme', theme);
    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        if (storedTheme) return storedTheme;
        return 'combo';
    };

    const updateThemeUI = (theme) => {
        let label = 'Dark & Light';
        let iconClass = 'bi bi-circle-half text-primary theme-icon-active';

        if (theme === 'combo') {
            label = 'Dark & Light';
            iconClass = 'bi bi-circle-half text-primary theme-icon-active';
        } else if (theme === 'light') {
            label = 'Light';
            iconClass = 'bi bi-sun-fill text-warning theme-icon-active';
        } else if (theme === 'dark') {
            label = 'Dark';
            iconClass = 'bi bi-moon-stars-fill text-info theme-icon-active';
        } else {
            label = 'Auto';
            iconClass = 'bi bi-laptop text-secondary theme-icon-active';
        }

        const textEl = document.getElementById('bd-theme-admin-text');
        const iconEl = document.querySelector('#bd-theme-admin .theme-icon-active');
        if (textEl) textEl.textContent = label;
        if (iconEl) iconEl.className = iconClass;
    };

    const applyTheme = (theme) => {
        const effectiveTheme = (theme === 'auto')
            ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
            : theme;
        document.documentElement.setAttribute('data-bs-theme', effectiveTheme);
        updateThemeUI(theme);
    };

    applyTheme(getPreferredTheme());

    document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
        btn.addEventListener('click', () => {
            const selected = btn.getAttribute('data-bs-theme-value');
            setStoredTheme(selected);
            applyTheme(selected);
        });
    });
});
</script>

</body>
</html>
