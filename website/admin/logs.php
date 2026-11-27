<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Audit & Security Logs Console
 */

require_once __DIR__ . '/auth.php';
require_admin_permission('settings.view');

use App\Services\AuditLogService;

$filters = [
    'q'        => trim((string) ($_GET['q'] ?? '')),
    'entity'   => trim((string) ($_GET['entity'] ?? 'all')),
    'severity' => trim((string) ($_GET['severity'] ?? 'all')),
    'from'     => trim((string) ($_GET['from'] ?? '')),
    'to'       => trim((string) ($_GET['to'] ?? '')),
];

// Handle CSV export preserving current filters
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $exportRows = AuditLogService::query($filters, 500, 0);
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="codex404-audit-logs-' . date('Ymd-His') . '.csv"');
    $out = fopen('php://output', 'w');
    if ($out !== false) {
        fputcsv($out, ['ID', 'Timestamp', 'Actor', 'Action', 'Entity Type', 'Entity ID', 'Summary', 'IP Address', 'Metadata']);
        $safeCell = static function (?string $v): string {
            $s = (string) $v;
            if ($s !== '' && in_array($s[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
                return "'" . $s;
            }
            return $s;
        };
        foreach ($exportRows as $row) {
            fputcsv($out, [
                $row['id'] ?? '',
                $safeCell((string) ($row['created_at'] ?? '')),
                $safeCell((string) ($row['actor_username'] ?? 'system')),
                $safeCell((string) ($row['action'] ?? '')),
                $safeCell((string) ($row['entity_type'] ?? '')),
                $safeCell((string) ($row['entity_id'] ?? '')),
                $safeCell((string) ($row['summary'] ?? '')),
                $safeCell((string) ($row['ip_address'] ?? '')),
                $safeCell((string) ($row['metadata_json'] ?? '')),
            ]);
        }
        fclose($out);
    }
    exit;
}

$perPage = 25;
$page = max(1, (int) ($_GET['page'] ?? 1));
$totalFiltered = AuditLogService::count($filters);
$totalPages = max(1, (int) ceil($totalFiltered / $perPage));
if ($page > $totalPages) {
    $page = $totalPages;
}
$offset = ($page - 1) * $perPage;

$logs = AuditLogService::query($filters, $perPage, $offset);
$stats = AuditLogService::stats();

$currentPage = 'logs';
$pageTitle = 'Audit & Security Logs';
$pageSubtitle = 'Immutable trail of authentication, RBAC, and deliverable mutations';

require_once __DIR__ . '/includes/header.php';

$hasActiveFilters = ($filters['q'] !== '' || ($filters['entity'] !== '' && $filters['entity'] !== 'all') || ($filters['severity'] !== '' && $filters['severity'] !== 'all') || $filters['from'] !== '' || $filters['to'] !== '');
$exportQuery = http_build_query(array_merge($filters, ['export' => 'csv']));
?>

<!-- ======================================================== -->
<!-- 1. AUDIT KPI METRICS                                     -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Total Events</span>
                <div class="stat-icon" style="background: var(--cx-accent-soft); color: var(--cx-accent);">
                    <i class="bi bi-journal-text"></i>
                </div>
            </div>
            <div class="stat-value" style="color: var(--cx-text-primary);"><?= number_format($stats['total']) ?></div>
            <div class="small text-muted">Recorded in MySQL</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Events Today</span>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="stat-value text-success"><?= number_format($stats['today']) ?></div>
            <div class="small text-muted"><?= date('M d, Y') ?></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Security / Destructive</span>
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
            </div>
            <div class="stat-value text-danger"><?= number_format($stats['security_alerts']) ?></div>
            <div class="small text-muted">Failed logins, deletes, revokes</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Unique Actors</span>
                <div class="stat-icon" style="background: var(--cx-pill-bg); color: var(--cx-text-secondary);">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
            <div class="stat-value" style="color: var(--cx-text-primary);"><?= number_format($stats['unique_actors']) ?></div>
            <div class="small text-muted">Audited accounts</div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. FILTER TOOLBAR                                        -->
<!-- ======================================================== -->
<div class="admin-card p-3 mb-4">
    <form method="GET" action="<?= admin_url('logs') ?>" class="row g-2 align-items-end">
        <div class="col-12 col-md-4 col-lg-3">
            <label class="form-label small text-muted mb-1">Search</label>
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted" style="font-size: 0.8rem;"></i>
                <input type="search" name="q" value="<?= htmlspecialchars($filters['q']) ?>"
                    class="form-control form-control-sm ps-4" placeholder="Actor, action, IP, summary...">
            </div>
        </div>

        <div class="col-6 col-md-2">
            <label class="form-label small text-muted mb-1">Entity</label>
            <select name="entity" class="form-select form-select-sm">
                <option value="all">All Entities</option>
                <?php foreach ($stats['entity_types'] as $et): ?>
                    <option value="<?= htmlspecialchars($et) ?>" <?= $filters['entity'] === $et ? 'selected' : '' ?>>
                        <?= htmlspecialchars(ucfirst($et)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-6 col-md-2">
            <label class="form-label small text-muted mb-1">Focus</label>
            <select name="severity" class="form-select form-select-sm">
                <option value="all" <?= $filters['severity'] === 'all' ? 'selected' : '' ?>>All Events</option>
                <option value="auth" <?= $filters['severity'] === 'auth' ? 'selected' : '' ?>>Auth Only</option>
                <option value="security" <?= $filters['severity'] === 'security' ? 'selected' : '' ?>>Security / Deletes</option>
            </select>
        </div>

        <div class="col-6 col-md-2 col-lg-1">
            <label class="form-label small text-muted mb-1">From</label>
            <input type="date" name="from" value="<?= htmlspecialchars($filters['from']) ?>" class="form-control form-control-sm">
        </div>

        <div class="col-6 col-md-2 col-lg-1">
            <label class="form-label small text-muted mb-1">To</label>
            <input type="date" name="to" value="<?= htmlspecialchars($filters['to']) ?>" class="form-control form-control-sm">
        </div>

        <div class="col-12 col-lg-3 d-flex align-items-center justify-content-lg-end gap-2">
            <button type="submit" class="btn btn-sm btn-cx-primary px-3">Filter</button>
            <?php if ($hasActiveFilters): ?>
                <a href="<?= admin_url('logs') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            <?php endif; ?>
            <a href="<?= admin_url('logs?' . $exportQuery) ?>" class="btn btn-sm btn-outline-secondary" title="Export filtered logs to CSV">
                <i class="bi bi-download me-1"></i>CSV
            </a>
        </div>
    </form>
</div>

<!-- ======================================================== -->
<!-- 3. AUDIT LOGS TABLE                                      -->
<!-- ======================================================== -->
<div class="admin-card overflow-hidden mb-4">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2"
        style="border-color: var(--cx-border) !important;">
        <div>
            <h6 class="fw-semibold mb-0">Event Stream</h6>
            <small class="text-muted">Showing <?= count($logs) ?> of <?= number_format($totalFiltered) ?> matching events (Page <?= $page ?> of <?= $totalPages ?>)</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Actor</th>
                    <th>Action</th>
                    <th>Target</th>
                    <th>Summary</th>
                    <th>IP</th>
                    <th style="width: 72px; text-align: right;">Meta</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5 small">
                            No audit events matched your current filter criteria.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <?php
                        $act = (string) ($log['action'] ?? '');
                        $actLower = strtolower($act);
                        $badgeClass = 'bg-secondary-subtle text-secondary border-secondary-subtle';
                        if (str_contains($actLower, 'fail') || str_contains($actLower, 'delete') || str_contains($actLower, 'revoke')) {
                            $badgeClass = 'bg-danger-subtle text-danger border-danger-subtle';
                        } elseif (str_contains($actLower, 'login') || str_contains($actLower, 'create') || str_contains($actLower, 'publish')) {
                            $badgeClass = 'bg-success-subtle text-success border-success-subtle';
                        } elseif (str_contains($actLower, 'update') || str_contains($actLower, 'toggle') || str_contains($actLower, 'role')) {
                            $badgeClass = 'bg-info-subtle text-info border-info-subtle';
                        }
                        $metaRaw = (string) ($log['metadata_json'] ?? '');
                        ?>
                        <tr>
                            <td class="small text-muted" style="font-family: var(--font-mono); white-space: nowrap;">
                                <?= htmlspecialchars((string) ($log['created_at'] ?? '')) ?>
                            </td>
                            <td class="small fw-semibold">
                                <?= htmlspecialchars((string) ($log['actor_username'] ?: 'system')) ?>
                            </td>
                            <td>
                                <span class="badge border <?= $badgeClass ?>" style="font-family: var(--font-mono); font-size: 0.7rem;">
                                    <?= htmlspecialchars($act) ?>
                                </span>
                            </td>
                            <td class="small text-muted" style="font-family: var(--font-mono); white-space: nowrap;">
                                <?= htmlspecialchars((string) ($log['entity_type'] ?? '')) ?>
                                <?= !empty($log['entity_id']) ? '#' . htmlspecialchars((string) $log['entity_id']) : '' ?>
                            </td>
                            <td class="small" style="color: var(--cx-text-secondary);">
                                <?= htmlspecialchars((string) ($log['summary'] ?? '')) ?>
                            </td>
                            <td class="small text-muted" style="font-family: var(--font-mono); white-space: nowrap;">
                                <?= htmlspecialchars((string) ($log['ip_address'] ?: '—')) ?>
                            </td>
                            <td class="text-end">
                                <?php if ($metaRaw !== '' && $metaRaw !== 'null'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-action-icon btn-view-meta"
                                        data-bs-toggle="modal" data-bs-target="#modalAuditMeta"
                                        data-action="<?= htmlspecialchars($act) ?>"
                                        data-meta="<?= htmlspecialchars($metaRaw) ?>" title="Inspect Metadata">
                                        <i class="bi bi-braces"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted small">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="p-3 border-top d-flex align-items-center justify-content-between" style="border-color: var(--cx-border) !important;">
            <span class="small text-muted">Page <?= $page ?> of <?= $totalPages ?></span>
            <div class="d-flex align-items-center gap-2">
                <?php if ($page > 1): ?>
                    <a href="<?= admin_url('logs?' . http_build_query(array_merge($filters, ['page' => $page - 1]))) ?>"
                        class="btn btn-sm btn-outline-secondary">Previous</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="<?= admin_url('logs?' . http_build_query(array_merge($filters, ['page' => $page + 1]))) ?>"
                        class="btn btn-sm btn-outline-secondary">Next</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Metadata Inspector Modal -->
<div class="modal fade" id="modalAuditMeta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-semibold mb-0" id="auditMetaTitle">Event Metadata</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="auditMetaPre" class="p-3 rounded-3 mb-0 small"
                    style="background: var(--cx-pill-bg); border: 1px solid var(--cx-border); font-family: var(--font-mono); white-space: pre-wrap; max-height: 360px; overflow: auto;"></pre>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-view-meta').forEach(btn => {
        btn.addEventListener('click', () => {
            const title = document.getElementById('auditMetaTitle');
            const pre = document.getElementById('auditMetaPre');
            if (title) title.textContent = 'Metadata · ' + (btn.dataset.action || 'Event');
            if (pre) {
                try {
                    pre.textContent = JSON.stringify(JSON.parse(btn.dataset.meta || '{}'), null, 2);
                } catch {
                    pre.textContent = btn.dataset.meta || '';
                }
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
