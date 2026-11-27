<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Overview / Dashboard
 */

$currentPage = 'overview';
$pageTitle = 'Overview';
$pageSubtitle = 'Portfolio deliverables, publishing status, and recent admin activity';

require_once __DIR__ . '/includes/header.php';

use App\Services\AuditLogService;
use App\Services\MigrationService;

$pct = $totalCount > 0 ? (int) round(($activeCount / $totalCount) * 100) : 0;

// Operational DB & Audit snapshots
$pdo = class_exists('Database') ? \Database::getConnection() : null;
$dbConnected = $pdo !== null;
$usersCount = null;
if ($pdo) {
    try {
        $usersCount = (int) $pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();
    } catch (\Throwable $e) {
        $usersCount = null;
    }
}
$recentAuditLogs = class_exists('\\App\\Services\\AuditLogService') ? AuditLogService::recent(5) : [];
$pendingMigrations = (current_admin_can('settings.edit') && class_exists('\\App\\Services\\MigrationService'))
    ? MigrationService::pendingCount()
    : 0;
?>

<?php if ($pendingMigrations > 0): ?>
    <div class="admin-card p-3 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3"
        style="border-left: 3px solid var(--cx-amber) !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-database-up"></i>
            </div>
            <div>
                <div class="fw-semibold small"><?= $pendingMigrations ?> Pending Database Migration<?= $pendingMigrations === 1 ? '' : 's' ?></div>
                <div class="small text-muted">New SQL schema updates are ready to apply to this server&rsquo;s MySQL database.</div>
            </div>
        </div>
        <form method="POST" action="<?= admin_url('telemetry') ?>" class="d-inline">
            <?= csrf_input_field() ?>
            <input type="hidden" name="action" value="apply_migrations">
            <button type="submit" class="btn btn-sm btn-cx-primary px-3">
                <i class="bi bi-play-fill me-1"></i>Apply Migrations Now
            </button>
        </form>
    </div>
<?php endif; ?>

<!-- ======================================================== -->
<!-- 1. KPI METRICS ROW                                       -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <a href="<?= admin_url('deliverables') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fw-semibold small">Total Deliverables</span>
                        <div class="stat-icon" style="background: var(--cx-accent-soft); color: var(--cx-accent);">
                            <i class="bi bi-collection-play"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="color: var(--cx-text-primary);"><?= $totalCount ?></div>
                </div>
                <div>
                    <div class="small text-muted d-flex align-items-center justify-content-between">
                        <span><?= count($categories) ?> categories</span>
                        <i class="bi bi-arrow-up-right" style="color: var(--cx-accent);"></i>
                    </div>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 100%; background: var(--cx-accent);"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-xl-3">
        <a href="<?= admin_url('deliverables?filter=published') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fw-semibold small">Published Live</span>
                        <div class="stat-icon bg-success-subtle text-success">
                            <i class="bi bi-globe2"></i>
                        </div>
                    </div>
                    <div class="stat-value text-success"><?= $activeCount ?></div>
                </div>
                <div>
                    <div class="small text-muted d-flex align-items-center justify-content-between">
                        <span><?= $pct ?>% published</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">Live</span>
                    </div>
                    <div class="stat-progress">
                        <div class="stat-progress-bar bg-success" style="width: <?= $pct ?>%;"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-xl-3">
        <a href="<?= admin_url('deliverables?filter=draft') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fw-semibold small">Staging Drafts</span>
                        <div class="stat-icon bg-warning-subtle text-warning">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                    </div>
                    <div class="stat-value text-warning"><?= $draftCount ?></div>
                </div>
                <div>
                    <div class="small text-muted d-flex align-items-center justify-content-between">
                        <span>Hidden from public</span>
                        <i class="bi bi-shield-lock text-muted"></i>
                    </div>
                    <div class="stat-progress">
                        <div class="stat-progress-bar bg-warning" style="width: <?= max(0, 100 - $pct) ?>%;"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-xl-3">
        <a href="<?= admin_url(current_admin_can('users.view') ? 'users' : 'telemetry') ?>" class="text-decoration-none">
            <div class="stat-card">
                <div>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted fw-semibold small"><?= $usersCount !== null ? 'Workforce Accounts' : 'Industry Domains' ?></span>
                        <div class="stat-icon cx-highlight-pill">
                            <i class="bi <?= $usersCount !== null ? 'bi-people' : 'bi-tags' ?>"></i>
                        </div>
                    </div>
                    <div class="stat-value" style="color: var(--cx-highlight-ink);"><?= $usersCount !== null ? $usersCount : count($categories) ?></div>
                </div>
                <div>
                    <div class="small text-muted text-truncate">
                        <?= $usersCount !== null ? 'RBAC-protected admin & CRM users' : htmlspecialchars(implode(' · ', array_slice($categories, 0, 3))) ?>
                    </div>
                    <div class="stat-progress">
                        <div class="stat-progress-bar" style="width: 100%; background: var(--cx-highlight);"></div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. OPERATIONAL WORKSPACE: DELIVERABLES + ACTIVITY        -->
<!-- ======================================================== -->
<div class="row g-4 mb-4">
    <!-- Left Column: Actionable Deliverables Table -->
    <div class="col-12 col-xl-8">
        <div class="admin-card overflow-hidden h-100 d-flex flex-column">
            <div class="p-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2"
                style="border-color: var(--cx-border) !important;">
                <div>
                    <h6 class="fw-semibold mb-0">Deliverables Queue</h6>
                    <small class="text-muted" id="tableCounterText">Showing <?= min(8, $totalCount) ?> of <?= $totalCount ?> systems</small>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="position-relative" style="width: 210px;">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted" style="font-size: 0.8rem;"></i>
                        <input type="text" id="projectSearch" class="form-control form-control-sm ps-4"
                            placeholder="Search (/ or Ctrl+K)" style="border-radius: 8px; font-size: 0.8rem;">
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="filter-pill-btn active py-1 px-2" data-filter-status="all" style="font-size: 0.75rem;">All</button>
                        <button type="button" class="filter-pill-btn py-1 px-2" data-filter-status="active" style="font-size: 0.75rem;">Live</button>
                        <button type="button" class="filter-pill-btn py-1 px-2" data-filter-status="draft" style="font-size: 0.75rem;">Draft</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive flex-grow-1">
                <table class="table table-admin align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 48px;">#</th>
                            <th>Deliverable</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th style="width: 130px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($projects, 0, 8) as $idx => $p): ?>
                            <?php
                            $isActive = !empty($p['active']);
                            $category = strtolower((string) ($p['category'] ?? 'software'));
                            $searchBlob = strtolower(($p['title'] ?? '') . ' ' . ($p['id'] ?? '') . ' ' . ($p['mockup_host'] ?? '') . ' ' . $category);
                            ?>
                            <tr class="project-row"
                                data-search="<?= htmlspecialchars($searchBlob) ?>"
                                data-status="<?= $isActive ? 'active' : 'draft' ?>"
                                data-category="<?= htmlspecialchars($category) ?>">
                                <td class="text-muted small" style="font-family: var(--font-mono);">
                                    <?= (int) ($p['order'] ?? ($idx + 1)) ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2" style="min-width: 0;">
                                        <div style="min-width: 0;">
                                            <div class="project-title-text text-truncate" style="max-width: 260px;">
                                                <?= htmlspecialchars($p['title']) ?>
                                            </div>
                                            <div class="text-muted text-truncate" style="font-family: var(--font-mono); font-size: 0.72rem; max-width: 260px;">
                                                <?= htmlspecialchars($p['mockup_host'] ?: $p['id']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-chip"><?= htmlspecialchars($p['category_label'] ?? ucfirst($category)) ?></span>
                                </td>
                                <td>
                                    <?php if (current_admin_can('portfolio.edit')): ?>
                                        <form method="POST" action="<?= admin_url('toggle') ?>" class="d-inline">
                                            <?= csrf_input_field() ?>
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                            <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '') ?>">
                                            <button type="submit"
                                                class="btn btn-sm <?= $isActive ? 'btn-outline-success' : 'btn-outline-secondary' ?> d-inline-flex align-items-center gap-1 py-0 px-2 rounded-pill"
                                                style="font-size: 0.72rem; height: 24px;"
                                                title="<?= $isActive ? 'Click to unpublish' : 'Click to publish live' ?>">
                                                <?php if ($isActive): ?>
                                                    <span class="live-dot" style="width: 5px; height: 5px;"></span>
                                                    <span>Published</span>
                                                <?php else: ?>
                                                    <span>Draft</span>
                                                <?php endif; ?>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="badge <?= $isActive ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-muted' ?>" style="font-size: 0.72rem;">
                                            <?= $isActive ? 'Published' : 'Draft' ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary btn-action-icon btn-preview-project"
                                            data-bs-toggle="modal" data-bs-target="#modalProjectPreview"
                                            data-title="<?= htmlspecialchars($p['title']) ?>"
                                            data-category="<?= htmlspecialchars($p['category_label'] ?? $p['category']) ?>"
                                            data-host="<?= htmlspecialchars($p['mockup_host'] ?? '') ?>"
                                            data-problem="<?= htmlspecialchars($p['problem'] ?? '') ?>"
                                            data-solution="<?= htmlspecialchars($p['solution'] ?? '') ?>"
                                            data-metric="<?= htmlspecialchars((string) ($p['metric'] ?? '')) ?>"
                                            data-stat1-val="<?= htmlspecialchars($p['stat_1_val'] ?? '') ?>"
                                            data-stat1-lbl="<?= htmlspecialchars($p['stat_1_lbl'] ?? '') ?>"
                                            data-stat2-val="<?= htmlspecialchars($p['stat_2_val'] ?? '') ?>"
                                            data-stat2-lbl="<?= htmlspecialchars($p['stat_2_lbl'] ?? '') ?>"
                                            data-stat3-val="<?= htmlspecialchars($p['stat_3_val'] ?? '') ?>"
                                            data-stat3-lbl="<?= htmlspecialchars($p['stat_3_lbl'] ?? '') ?>"
                                            data-live-url="<?= htmlspecialchars($p['live_url'] ?? '') ?>"
                                            data-tags='<?= json_encode($p['tags'] ?? []) ?>' title="Quick Preview">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if (current_admin_can('portfolio.edit')): ?>
                                            <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>"
                                                class="btn btn-sm btn-outline-secondary btn-action-icon" title="Edit Deliverable">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger btn-action-icon btn-delete-project"
                                                data-bs-toggle="modal" data-bs-target="#modalDeleteProject"
                                                data-id="<?= htmlspecialchars($p['id']) ?>"
                                                data-title="<?= htmlspecialchars($p['title']) ?>" title="Delete">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--cx-border) !important;">
                <span class="small text-muted">Use inline status badges to publish or unpublish</span>
                <a href="<?= admin_url('deliverables') ?>" class="small fw-semibold text-decoration-none" style="color: var(--cx-accent);">
                    Manage all <?= $totalCount ?> deliverables <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Quick Actions, Audit Log, System Health -->
    <div class="col-12 col-xl-4 d-flex flex-column gap-3">
        <!-- Quick Actions -->
        <div class="admin-card cx-brand-signature-bar p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-semibold mb-0">Quick Actions</h6>
                <span class="badge cx-highlight-pill" style="font-size: 0.65rem;">Priority</span>
            </div>
            <div class="d-grid gap-2">
                <?php if (current_admin_can('portfolio.edit')): ?>
                    <a href="<?= admin_url('project-form') ?>" class="btn btn-sm btn-cx-primary d-flex align-items-center justify-content-between px-3 py-2">
                        <span><i class="bi bi-plus-lg me-2"></i>New Deliverable</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('inquiries.view')): ?>
                    <a href="<?= admin_url('inquiries') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-between px-3 py-2">
                        <span><i class="bi bi-envelope-paper me-2"></i>Inquiries Inbox</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('careers.view')): ?>
                    <a href="<?= admin_url('careers') ?>" class="btn btn-sm cx-btn-orange d-flex align-items-center justify-content-between px-3 py-2">
                        <span><i class="bi bi-briefcase me-2" style="color: var(--cx-highlight-ink);"></i>Review Applications</span>
                        <i class="bi bi-chevron-right" style="color: var(--cx-highlight-ink);"></i>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('users.view')): ?>
                    <a href="<?= admin_url('users') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-between px-3 py-2">
                        <span><i class="bi bi-people me-2"></i>Manage Users &amp; Roles</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                <?php endif; ?>
                <?php if (current_admin_can('settings.view')): ?>
                    <a href="<?= admin_url('telemetry') ?>" class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-between px-3 py-2">
                        <span><i class="bi bi-activity me-2"></i>Platform Telemetry</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Audit Activity -->
        <div class="admin-card p-3 flex-grow-1">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-semibold mb-0">Recent Activity</h6>
                <?php if (current_admin_can('settings.view')): ?>
                    <a href="<?= admin_url('logs') ?>" class="small text-decoration-none" style="color: var(--cx-accent);">All logs &rarr;</a>
                <?php endif; ?>
            </div>

            <?php if (!empty($recentAuditLogs)): ?>
                <div class="d-flex flex-column gap-2">
                    <?php foreach ($recentAuditLogs as $log): ?>
                        <div class="p-2 rounded-2" style="background: var(--cx-pill-bg); border: 1px solid var(--cx-border);">
                            <div class="d-flex align-items-center justify-content-between gap-2">
                                <span class="small fw-semibold text-truncate"><?= htmlspecialchars((string) ($log['action'] ?? 'event')) ?></span>
                                <span class="text-muted" style="font-family: var(--font-mono); font-size: 0.68rem;">
                                    <?= htmlspecialchars(date('M d H:i', strtotime((string) ($log['created_at'] ?? 'now')))) ?>
                                </span>
                            </div>
                            <div class="small text-muted text-truncate" style="font-size: 0.74rem;">
                                <?= htmlspecialchars((string) ($log['actor_username'] ?: 'system')) ?> &middot; <?= htmlspecialchars((string) ($log['summary'] ?? '')) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="small text-muted mb-0">No recent audit events recorded yet.</p>
            <?php endif; ?>
        </div>

        <!-- System Health -->
        <div class="admin-card p-3">
            <h6 class="fw-semibold mb-2">System Health</h6>
            <div class="d-flex flex-column gap-2 small">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Database</span>
                    <span class="fw-semibold <?= $dbConnected ? 'text-success' : 'text-warning' ?>">
                        <?= $dbConnected ? 'MySQL PDO' : 'JSON Fallback' ?>
                    </span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">PHP Runtime</span>
                    <span class="fw-semibold" style="font-family: var(--font-mono);"><?= PHP_VERSION ?></span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">Active Showcase</span>
                    <span class="fw-semibold"><?= $activeCount ?> / <?= $totalCount ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
