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
    'case_study_url' => 'case-studies.php',
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
        header('Location: ' . admin_url('index.php'));
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
                'case_study_url' => trim((string)($_POST['case_study_url'] ?? 'case-studies.php')),
                'order' => (int)($_POST['order'] ?? 1),
                'active' => !empty($_POST['active']),
            ];

            $saved = ProjectService::save($saveData);
            set_admin_flash('success', "Project '{$saved['title']}' was successfully " . ($isEdit ? 'updated' : 'created') . '!');
            header('Location: ' . admin_url('index.php'));
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Project' : 'Upload New Project' ?> — CodeX404 Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <style>
        :root {
            --admin-bg: #030712;
            --admin-panel: rgba(15, 23, 42, 0.75);
            --admin-border: rgba(56, 189, 248, 0.15);
        }
        body {
            background-color: var(--admin-bg);
            color: #F8FAFC;
            font-family: var(--font-main);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .admin-nav {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid var(--admin-border);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
        }
        .admin-nav-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0.9rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem 1.5rem;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .btn-back {
            color: #94A3B8;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.85rem;
            transition: color 0.2s;
        }
        .btn-back:hover {
            color: var(--cyan);
        }

        .form-section {
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 1rem;
            padding: 1.75rem 2rem;
            margin-bottom: 1.75rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(16px);
        }
        .section-heading {
            font-size: 1.15rem;
            font-weight: 700;
            color: #FFFFFF;
            margin: 0 0 0.35rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .section-desc {
            color: var(--slate);
            font-size: 0.85rem;
            margin: 0 0 1.5rem 0;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .form-row.triplet {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #E2E8F0;
            margin-bottom: 0.45rem;
        }
        .form-hint {
            display: block;
            font-size: 0.75rem;
            color: var(--slate);
            margin-top: 0.3rem;
        }
        .form-control {
            width: 100%;
            background: rgba(3, 7, 18, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 0.5rem;
            padding: 0.75rem 0.9rem;
            color: #F8FAFC;
            font-size: 0.9rem;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }
        .form-control:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.15);
            background: rgba(3, 7, 18, 0.9);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 90px;
            line-height: 1.5;
        }
        select.form-control {
            cursor: pointer;
        }
        .checkbox-label {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.9rem;
            color: #F8FAFC;
            cursor: pointer;
            user-select: none;
        }
        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--cyan);
            cursor: pointer;
        }
        .btn-submit-save {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%);
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.85rem 1.75rem;
            border-radius: 0.65rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
            transition: all 0.2s ease;
        }
        .btn-submit-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
        }
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            border-radius: 0.65rem;
            color: #94A3B8;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            border: 1px solid rgba(148, 163, 184, 0.2);
            transition: all 0.2s;
        }
        .btn-cancel:hover {
            color: #FFFFFF;
            border-color: #CBD5E1;
        }
        .alert-errors {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #FCA5A5;
            padding: 1rem 1.25rem;
            border-radius: 0.65rem;
            margin-bottom: 2rem;
        }
        .alert-errors ul {
            margin: 0.5rem 0 0 1.25rem;
            padding: 0;
        }
    </style>
</head>
<body>

<header class="admin-nav">
    <div class="admin-nav-inner">
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <a href="<?= admin_url('index.php') ?>" style="font-weight:800; font-size:1.15rem; color:#FFFFFF; text-decoration:none;">CodeX404</a>
            <span style="background:rgba(34,211,238,0.1); border:1px solid rgba(34,211,238,0.3); color:var(--cyan); padding:0.15rem 0.5rem; border-radius:9999px; font-size:0.7rem; font-weight:700;">Admin</span>
        </div>
        <div>
            <a href="<?= admin_url('index.php') ?>" class="btn-back">← Back to Dashboard</a>
        </div>
    </div>
</header>

<main class="admin-container">

    <div class="page-header">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 800; margin: 0 0 0.35rem 0;">
                <?= $isEdit ? 'Edit Deliverable: ' . htmlspecialchars($project['title']) : 'Upload New Project Deliverable' ?>
            </h1>
            <p style="color: var(--slate); font-size: 0.9rem; margin: 0;">
                Fill in the verified engineering project parameters. Changes reflect live on the website immediately.
            </p>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert-errors">
            <strong>Please resolve the following issues:</strong>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= admin_url('project-form.php' . ($isEdit ? '?id=' . urlencode($project['id']) : '')) ?>">
        <?= csrf_input_field() ?>

        <!-- SECTION 1: CORE IDENTITY -->
        <div class="form-section">
            <h2 class="section-heading">1. Project Identity & Categorization</h2>
            <p class="section-desc">Basic names, tabs, and publication settings.</p>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="title">Project Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($project['title']) ?>" required placeholder="e.g. School ERP & Administrative Portal">
                </div>
                <div class="form-group">
                    <label class="form-label" for="id">Unique Slug / ID</label>
                    <input type="text" id="id" name="id" class="form-control" value="<?= htmlspecialchars($project['id']) ?>" <?= $isEdit ? 'readonly style="background:rgba(15,23,42,0.4); opacity:0.8;"' : '' ?> placeholder="Auto-generated if left blank (e.g. school-erp)">
                    <span class="form-hint">Used for internal anchor and unique key.</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="category">Filter Tab Category *</label>
                    <select id="category" name="category" class="form-control">
                        <option value="software" <?= ($project['category'] === 'software') ? 'selected' : '' ?>>Custom Software & ERP (software)</option>
                        <option value="ai" <?= ($project['category'] === 'ai') ? 'selected' : '' ?>>AI & Automation (ai)</option>
                        <option value="commerce" <?= ($project['category'] === 'commerce') ? 'selected' : '' ?>>B2B Commerce & Wholesale (commerce)</option>
                        <option value="mobile" <?= ($project['category'] === 'mobile') ? 'selected' : '' ?>>Mobile & PWA (mobile)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="category_label">Category Badge Label</label>
                    <input type="text" id="category_label" name="category_label" class="form-control" value="<?= htmlspecialchars($project['category_label'] ?? '') ?>" placeholder="e.g. Custom Enterprise Software">
                </div>
                <div class="form-group">
                    <label class="form-label" for="order">Display Order</label>
                    <input type="number" id="order" name="order" class="form-control" value="<?= (int)($project['order'] ?? 1) ?>" min="1" max="99">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="checkbox-label">
                    <input type="checkbox" name="active" value="1" <?= !empty($project['active']) ? 'checked' : '' ?>>
                    <span><strong>Active & Published</strong> (Show on public website homepage & portfolio)</span>
                </label>
            </div>
        </div>

        <!-- SECTION 2: TERMINAL MOCKUP & STATUS -->
        <div class="form-section">
            <h2 class="section-heading">2. Browser Frame & Top Mockup Display</h2>
            <p class="section-desc">The browser header bar and status pills shown at the top of each project card.</p>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="mockup_host">Mockup URL / Host bar</label>
                    <input type="text" id="mockup_host" name="mockup_host" class="form-control" value="<?= htmlspecialchars($project['mockup_host'] ?? '') ?>" placeholder="e.g. erp.institution-portal">
                </div>
                <div class="form-group">
                    <label class="form-label" for="badge_text">Status Badge Text</label>
                    <input type="text" id="badge_text" name="badge_text" class="form-control" value="<?= htmlspecialchars($project['badge_text'] ?? 'Production Live') ?>" placeholder="e.g. Production Live">
                </div>
                <div class="form-group">
                    <label class="form-label" for="badge_type">Badge Glow Style</label>
                    <select id="badge_type" name="badge_type" class="form-control">
                        <option value="live" <?= (($project['badge_type'] ?? '') === 'live') ? 'selected' : '' ?>>Live Green (Production Live)</option>
                        <option value="demo" <?= (($project['badge_type'] ?? '') === 'demo') ? 'selected' : '' ?>>Cyan Demo (Interactive Demo Ready)</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="mockup_tag1">Screen Top Tag 1</label>
                    <input type="text" id="mockup_tag1" name="mockup_tag1" class="form-control" value="<?= htmlspecialchars($project['mockup_tag1'] ?? '') ?>" placeholder="e.g. 🏫 Academic Ledger & Fees">
                </div>
                <div class="form-group">
                    <label class="form-label" for="mockup_tag2">Screen Top Tag 2</label>
                    <input type="text" id="mockup_tag2" name="mockup_tag2" class="form-control" value="<?= htmlspecialchars($project['mockup_tag2'] ?? '') ?>" placeholder="e.g. Role: SuperAdmin">
                </div>
            </div>
        </div>

        <!-- SECTION 3: QUICK KPI TRIPLETS -->
        <div class="form-section">
            <h2 class="section-heading">3. Quick KPI Metric Stat Triplets</h2>
            <p class="section-desc">The 3 quick numerical achievements displayed in the mockup frame.</p>

            <div class="form-row triplet">
                <div class="form-group">
                    <label class="form-label" for="stat_1_val">Stat 1 Value</label>
                    <input type="text" id="stat_1_val" name="stat_1_val" class="form-control" value="<?= htmlspecialchars($project['stat_1_val'] ?? '') ?>" placeholder="e.g. 4,800+">
                    <label class="form-label" for="stat_1_lbl" style="margin-top: 0.5rem; font-size: 0.75rem;">Stat 1 Label</label>
                    <input type="text" id="stat_1_lbl" name="stat_1_lbl" class="form-control" value="<?= htmlspecialchars($project['stat_1_lbl'] ?? '') ?>" placeholder="e.g. Students Managed">
                </div>
                <div class="form-group">
                    <label class="form-label" for="stat_2_val">Stat 2 Value</label>
                    <input type="text" id="stat_2_val" name="stat_2_val" class="form-control" value="<?= htmlspecialchars($project['stat_2_val'] ?? '') ?>" placeholder="e.g. 4 Roles">
                    <label class="form-label" for="stat_2_lbl" style="margin-top: 0.5rem; font-size: 0.75rem;">Stat 2 Label</label>
                    <input type="text" id="stat_2_lbl" name="stat_2_lbl" class="form-control" value="<?= htmlspecialchars($project['stat_2_lbl'] ?? '') ?>" placeholder="e.g. Strict RBAC">
                </div>
                <div class="form-group">
                    <label class="form-label" for="stat_3_val">Stat 3 Value</label>
                    <input type="text" id="stat_3_val" name="stat_3_val" class="form-control" value="<?= htmlspecialchars($project['stat_3_val'] ?? '') ?>" placeholder="e.g. 15 Mins">
                    <label class="form-label" for="stat_3_lbl" style="margin-top: 0.5rem; font-size: 0.75rem;">Stat 3 Label</label>
                    <input type="text" id="stat_3_lbl" name="stat_3_lbl" class="form-control" value="<?= htmlspecialchars($project['stat_3_lbl'] ?? '') ?>" placeholder="e.g. Fee Reconciliation">
                </div>
            </div>
        </div>

        <!-- SECTION 4: PROBLEM, SOLUTION & IMPACT -->
        <div class="form-section">
            <h2 class="section-heading">4. Business Problem & Engineering Solution</h2>
            <p class="section-desc">Clear, honest explanation of the operational bottleneck and engineering solution.</p>

            <div class="form-group">
                <label class="form-label" for="problem">Problem Statement *</label>
                <textarea id="problem" name="problem" class="form-control" required rows="3" placeholder="What manual bottleneck, lost time, or error did the client face?"><?= htmlspecialchars($project['problem']) ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="solution">Engineering Solution *</label>
                <textarea id="solution" name="solution" class="form-control" required rows="3" placeholder="What architecture, database, or workflow did CodeX404 engineer to solve it?"><?= htmlspecialchars($project['solution']) ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="metric">Highlight Impact Metric</label>
                <input type="text" id="metric" name="metric" class="form-control" value="<?= htmlspecialchars($project['metric'] ?? '') ?>" placeholder="e.g. Fee reconciliation time dropped from 10 days to under 15 minutes">
                <span class="form-hint">Shown in green highlighted callout box with a checkmark.</span>
            </div>
        </div>

        <!-- SECTION 5: TECH TAGS & INTERACTIVE DEMO BINDING -->
        <div class="form-section">
            <h2 class="section-heading">5. Technology Stack & In-Browser Interactive Demo</h2>
            <p class="section-desc">Tag chips and simulator bindings.</p>

            <div class="form-row">
                <div class="form-group" style="flex: 2;">
                    <label class="form-label" for="tags">Tech Stack Tags (Comma-separated)</label>
                    <input type="text" id="tags" name="tags" class="form-control" value="<?= htmlspecialchars($tagsString) ?>" placeholder="e.g. PHP 8.2, MySQL Relational, Granular RBAC, Automated PDF Receipts">
                    <span class="form-hint">Separate with commas. These display as interactive chips.</span>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="demo_key">Interactive Demo Sandbox</label>
                    <select id="demo_key" name="demo_key" class="form-control">
                        <option value="erp" <?= (($project['demo_key'] ?? '') === 'erp') ? 'selected' : '' ?>>School ERP / Role Simulator (erp)</option>
                        <option value="wa" <?= (($project['demo_key'] ?? '') === 'wa') ? 'selected' : '' ?>>WhatsApp Webhook Simulator (wa)</option>
                        <option value="b2b" <?= (($project['demo_key'] ?? '') === 'b2b') ? 'selected' : '' ?>>B2B Wholesale Checkout Engine (b2b)</option>
                        <option value="rag" <?= (($project['demo_key'] ?? '') === 'rag') ? 'selected' : '' ?>>Private RAG Knowledge Assistant (rag)</option>
                    </select>
                    <span class="form-hint">Launches live modal when visitor clicks 'Launch Live Interactive Demo'.</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="live_url">Live Website URL</label>
                    <input type="url" id="live_url" name="live_url" class="form-control" value="<?= htmlspecialchars($project['live_url'] ?? '') ?>" placeholder="https://erpinsandegreeclg.codex404solutions.online">
                    <span class="form-hint">Direct link to the client's verified live production website.</span>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label" for="case_study_url">Case Study Link</label>
                    <input type="text" id="case_study_url" name="case_study_url" class="form-control" value="<?= htmlspecialchars($project['case_study_url'] ?? 'case-studies.php') ?>" placeholder="e.g. case-studies.php">
                </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 2rem;">
            <button type="submit" class="btn-submit-save">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                <span><?= $isEdit ? 'Save Changes' : 'Publish Project Deliverable' ?></span>
            </button>
            <a href="<?= admin_url('index.php') ?>" class="btn-cancel">Cancel</a>
        </div>

    </form>

</main>

</body>
</html>
