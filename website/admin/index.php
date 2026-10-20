<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

$projects = ProjectService::getAll();
$totalCount = count($projects);
$activeCount = count(array_filter($projects, fn($p) => !empty($p['active'])));
$draftCount = $totalCount - $activeCount;
$categories = array_unique(array_column($projects, 'category'));

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Project Portfolio Management | CodeX404</title>
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
            --admin-border-hover: rgba(56, 189, 248, 0.35);
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
        /* Top Navigation */
        .admin-nav {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid var(--admin-border);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
        }
        .admin-nav-inner {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0.9rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: #FFFFFF;
        }
        .admin-badge {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.15), rgba(59, 130, 246, 0.15));
            border: 1px solid rgba(34, 211, 238, 0.3);
            color: var(--cyan);
            padding: 0.2rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .admin-nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .btn-view-site {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #94A3B8;
            font-size: 0.85rem;
            text-decoration: none;
            padding: 0.45rem 0.85rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            transition: all 0.2s;
        }
        .btn-view-site:hover {
            color: var(--cyan);
            border-color: var(--cyan);
            background: rgba(34, 211, 238, 0.05);
        }
        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #F87171;
            font-size: 0.85rem;
            text-decoration: none;
            padding: 0.45rem 0.85rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
            transition: all 0.2s;
        }
        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.4);
        }

        /* Container & Layout */
        .admin-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 2.25rem 1.5rem 4rem 1.5rem;
            flex: 1;
            width: 100%;
            box-sizing: border-box;
        }

        /* Hero Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1.25rem;
        }
        .dashboard-title {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 0.35rem 0;
            letter-spacing: -0.02em;
        }
        .dashboard-subtitle {
            color: var(--slate);
            font-size: 0.95rem;
            margin: 0;
        }
        .btn-primary-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%);
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.75rem 1.35rem;
            border-radius: 0.65rem;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
        }

        /* Metric KPI Row */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 0.85rem;
            padding: 1.25rem 1.5rem;
            backdrop-filter: blur(12px);
        }
        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--slate);
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #FFFFFF;
            line-height: 1;
        }

        /* Filter & Search Bar */
        .filter-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .search-box {
            position: relative;
            flex: 1;
            max-width: 380px;
        }
        .search-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.9);
            border: 1px solid var(--admin-border);
            border-radius: 0.5rem;
            padding: 0.65rem 1rem 0.65rem 2.25rem;
            color: #F8FAFC;
            font-size: 0.875rem;
            box-sizing: border-box;
            outline: none;
        }
        .search-input:focus {
            border-color: var(--cyan);
        }
        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--slate);
        }

        /* Project Cards Table */
        .project-table-wrapper {
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(16px);
        }
        .project-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .project-table th {
            background: rgba(3, 7, 18, 0.6);
            color: #94A3B8;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--admin-border);
        }
        .project-table td {
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.08);
            vertical-align: middle;
            font-size: 0.875rem;
        }
        .project-table tr:hover td {
            background: rgba(56, 189, 248, 0.02);
        }
        .project-table tr:last-child td {
            border-bottom: none;
        }

        /* Project Cell Badges */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .status-pill.active {
            background: rgba(52, 211, 153, 0.12);
            color: #34D399;
            border: 1px solid rgba(52, 211, 153, 0.3);
        }
        .status-pill.draft {
            background: rgba(148, 163, 184, 0.12);
            color: #94A3B8;
            border: 1px solid rgba(148, 163, 184, 0.25);
        }

        .category-chip {
            display: inline-block;
            padding: 0.2rem 0.5rem;
            border-radius: 0.35rem;
            font-size: 0.75rem;
            background: rgba(56, 189, 248, 0.08);
            border: 1px solid rgba(56, 189, 248, 0.2);
            color: #38BDF8;
            font-family: var(--font-mono);
        }
        .demo-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.2rem 0.5rem;
            border-radius: 0.35rem;
            font-size: 0.75rem;
            background: rgba(168, 85, 247, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.25);
            color: #C084FC;
            font-family: var(--font-mono);
        }

        /* Action Buttons */
        .action-btn-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.75rem;
            border-radius: 0.45rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .btn-action-edit {
            background: rgba(34, 211, 238, 0.1);
            color: var(--cyan);
            border-color: rgba(34, 211, 238, 0.25);
        }
        .btn-action-edit:hover {
            background: rgba(34, 211, 238, 0.2);
            border-color: var(--cyan);
        }
        .btn-action-toggle {
            background: rgba(148, 163, 184, 0.1);
            color: #CBD5E1;
            border-color: rgba(148, 163, 184, 0.2);
        }
        .btn-action-toggle:hover {
            background: rgba(148, 163, 184, 0.2);
            color: #FFFFFF;
        }
        .btn-action-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #F87171;
            border-color: rgba(239, 68, 68, 0.25);
        }
        .btn-action-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #EF4444;
        }

        /* Flash notifications */
        .flash-alert {
            padding: 1rem 1.25rem;
            border-radius: 0.65rem;
            margin-bottom: 1.75rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }
        .flash-alert.success {
            background: rgba(52, 211, 153, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.3);
            color: #34D399;
        }
        .flash-alert.error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #F87171;
        }
        .flash-alert.info {
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #38BDF8;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--slate);
        }

        @media (max-width: 900px) {
            .project-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

<!-- Navigation Header -->
<header class="admin-nav">
    <div class="admin-nav-inner">
        <a href="<?= admin_url('index.php') ?>" class="admin-brand">
            <span style="font-weight: 800; font-size: 1.15rem; letter-spacing: -0.02em;">CodeX404</span>
            <span class="admin-badge">Admin Panel</span>
        </a>
        <div class="admin-nav-actions">
            <a href="<?= url('index.php#work') ?>" target="_blank" class="btn-view-site">
                <span>View Live Work Section</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
            </a>
            <span style="font-size: 0.8rem; color: var(--slate);">Logged in as <strong style="color: #F8FAFC;">admin</strong></span>
            <a href="<?= admin_url('logout.php') ?>" class="btn-logout" title="Sign out">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span>Logout</span>
            </a>
        </div>
    </div>
</header>

<main class="admin-container">

    <!-- Flash message -->
    <?php if ($flash): ?>
        <div class="flash-alert <?= htmlspecialchars($flash['type']) ?>" role="alert">
            <span><?= htmlspecialchars($flash['message']) ?></span>
        </div>
    <?php endif; ?>

    <!-- Header & Action -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Projects & Deliverables</h1>
            <p class="dashboard-subtitle">Upload, edit, reorder, and configure production deliverables displayed across the website.</p>
        </div>
        <div>
            <a href="<?= admin_url('project-form.php') ?>" class="btn-primary-action">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Upload New Project</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-label">Total Projects</div>
            <div class="stat-value"><?= $totalCount ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active on Website</div>
            <div class="stat-value" style="color: #34D399;"><?= $activeCount ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Draft / Hidden</div>
            <div class="stat-value" style="color: #94A3B8;"><?= $draftCount ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Active Categories</div>
            <div class="stat-value" style="color: var(--cyan);"><?= count($categories) ?></div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="filter-controls">
        <div class="search-box">
            <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input type="text" id="projectSearch" class="search-input" placeholder="Search projects by title, category, tech...">
        </div>
        <div style="font-size: 0.85rem; color: var(--slate);">
            All changes update live immediately on the website.
        </div>
    </div>

    <!-- Projects Table -->
    <div class="project-table-wrapper">
        <?php if (empty($projects)): ?>
            <div class="empty-state">
                <p style="font-size: 1.1rem; margin-bottom: 1rem;">No projects found in the repository.</p>
                <a href="<?= admin_url('project-form.php') ?>" class="btn-primary-action">Add First Project</a>
            </div>
        <?php else: ?>
            <table class="project-table" id="projectsTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Project & Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Interactive Demo</th>
                        <th>Key Metric</th>
                        <th style="text-align: right; width: 220px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $idx => $p): ?>
                        <tr class="project-row" data-search="<?= htmlspecialchars(strtolower($p['title'] . ' ' . $p['category'] . ' ' . implode(' ', $p['tags'] ?? []))) ?>">
                            <td style="color: var(--slate); font-family: var(--font-mono); font-size: 0.8rem;">
                                <?= (int)($p['order'] ?? ($idx + 1)) ?>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #FFFFFF; font-size: 0.95rem; margin-bottom: 0.25rem;">
                                    <?= htmlspecialchars($p['title']) ?>
                                </div>
                                <div style="font-size: 0.775rem; color: var(--slate); font-family: var(--font-mono); display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap;">
                                    <span><?= htmlspecialchars($p['id']) ?> &bull;</span>
                                    <?php if (!empty($p['live_url'])): ?>
                                        <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: var(--cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.2rem;">
                                            <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                        </a>
                                    <?php else: ?>
                                        <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="category-chip"><?= htmlspecialchars($p['category']) ?></span>
                            </td>
                            <td>
                                <?php if (!empty($p['active'])): ?>
                                    <span class="status-pill active">● Published</span>
                                <?php else: ?>
                                    <span class="status-pill draft">○ Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="demo-chip">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                    <?= htmlspecialchars($p['demo_key'] ?? 'erp') ?>
                                </span>
                            </td>
                            <td style="max-width: 260px; color: #CBD5E1; font-size: 0.8rem; line-height: 1.4;">
                                <?= htmlspecialchars(mb_strimwidth((string)($p['metric'] ?? ''), 0, 65, '...')) ?>
                            </td>
                            <td>
                                <div class="action-btn-group" style="justify-content: flex-end;">
                                    <!-- Edit -->
                                    <a href="<?= admin_url('project-form.php?id=' . urlencode($p['id'])) ?>" class="btn-action btn-action-edit" title="Edit project">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </a>

                                    <!-- Quick Toggle Active -->
                                    <form method="POST" action="<?= admin_url('toggle.php') ?>" style="display:inline; margin:0;">
                                        <?= csrf_input_field() ?>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                        <button type="submit" class="btn-action btn-action-toggle" title="<?= !empty($p['active']) ? 'Hide from public site' : 'Publish to public site' ?>">
                                            <?= !empty($p['active']) ? 'Hide' : 'Show' ?>
                                        </button>
                                    </form>

                                    <!-- Delete with confirmation -->
                                    <form method="POST" action="<?= admin_url('delete.php') ?>" style="display:inline; margin:0;" onsubmit="return confirm('Are you sure you want to permanently delete \'<?= htmlspecialchars(addslashes($p['title'])) ?>\'?');">
                                        <?= csrf_input_field() ?>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                        <button type="submit" class="btn-action btn-action-delete" title="Delete project">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</main>

<script>
// Live search in project table
document.getElementById('projectSearch')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase().trim();
    const rows = document.querySelectorAll('.project-row');
    rows.forEach(row => {
        const text = row.getAttribute('data-search') || '';
        row.style.display = text.includes(query) ? '' : 'none';
    });
});
</script>

</body>
</html>
