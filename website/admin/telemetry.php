<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Platform Telemetry & System Diagnostics
 */

require_once __DIR__ . '/auth.php';
require_admin_permission('settings.view');

use App\Services\AuditLogService;
use App\Services\MigrationService;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['action'] ?? '') === 'apply_migrations')) {
    require_admin_permission('settings.edit', false, 'telemetry');
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        set_admin_flash('error', 'Security token invalid or expired.');
    } else {
        $actor = current_admin_profile();
        $res = MigrationService::applyPending(
            (string) ($actor['id'] ?? ''),
            (string) ($actor['username'] ?? '')
        );
        set_admin_flash($res['ok'] ? 'success' : 'error', $res['message']);
    }
    header('Location: ' . admin_url('telemetry') . '#migrations');
    exit;
}

$migrationStatus = MigrationService::status();

$currentPage = 'telemetry';
$pageTitle = 'Platform Telemetry & System Diagnostics';
$pageSubtitle = 'Live MySQL PDO status, fallback storage health, PHP runtime metrics, and recent admin audit logs';

// Fallback JSON file inspection
$dataPath = dirname(__DIR__) . '/data/projects.json';
$fileExists = file_exists($dataPath);
$fileSizeKb = $fileExists ? round(filesize($dataPath) / 1024, 2) : 0;
$fileModified = $fileExists ? date('Y-m-d H:i:s T', (int) filemtime($dataPath)) : 'N/A';
$fileWritable = $fileExists && is_writable($dataPath);

// Live MySQL PDO inspection
$pdo = class_exists('Database') ? \Database::getConnection() : null;
$dbConnected = $pdo !== null;
$dbStats = ['projects' => 0, 'users' => 0, 'roles' => 0, 'audit_logs' => 0];
if ($pdo) {
    try {
        $dbStats['projects'] = (int) $pdo->query('SELECT COUNT(*) FROM `portfolio_projects`')->fetchColumn();
        $dbStats['users'] = (int) $pdo->query('SELECT COUNT(*) FROM `users`')->fetchColumn();
        $dbStats['roles'] = (int) $pdo->query('SELECT COUNT(*) FROM `roles`')->fetchColumn();
        $dbStats['audit_logs'] = (int) $pdo->query('SELECT COUNT(*) FROM `admin_audit_logs`')->fetchColumn();
    } catch (\Throwable $e) {
        // Keep defaults if a table isn't initialized
    }
}

$recentAuditLogs = AuditLogService::recent(8);
$crmAvailable = is_dir(dirname(__DIR__, 2) . '/crm');

// Environment stats
$phpVersion = PHP_VERSION;
$osFamily = PHP_OS_FAMILY;
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/2.4 (XAMPP)';
$memoryLimit = ini_get('memory_limit') ?: '128M';
$maxExecTime = ini_get('max_execution_time') ?: '30';
$opcacheEnabled = function_exists('opcache_get_status') && !empty(opcache_get_status()['opcache_enabled']);
$ipBindMode = strtoupper((string) \Env::get('ADMIN_SESSION_IP_BIND', 'strict'));

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- 1. SYSTEM STATUS STRIP                                   -->
<!-- ======================================================== -->
<div class="admin-status-strip" id="telemetry-ticker">
    <div class="admin-status-item">
        <i class="bi bi-database-check <?= $dbConnected ? 'text-success' : 'text-warning' ?>"></i>
        <span>Primary DB: <strong><?= $dbConnected ? 'MySQL PDO Connected' : 'JSON Fallback' ?></strong></span>
    </div>
    <div class="admin-status-item">
        <i class="bi bi-collection-play-fill text-info"></i>
        <span>Deliverables: <strong><?= $totalCount ?> Systems (<?= $activeCount ?> Live)</strong></span>
    </div>
    <div class="admin-status-item">
        <i class="bi bi-people-fill text-primary"></i>
        <span>Workforce: <strong><?= $dbStats['users'] ?> Users &middot; <?= $dbStats['roles'] ?> Roles</strong></span>
    </div>
    <div class="admin-status-item">
        <i class="bi bi-shield-lock-fill text-success"></i>
        <span>Session Guard: <strong>IP <?= htmlspecialchars($ipBindMode) ?> &middot; SameSite=Strict</strong></span>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2. TELEMETRY KPI TILES (4 DISTINCT METRICS)              -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted fw-bold text-uppercase"
                        style="font-size: 0.68rem; letter-spacing: 0.06em;">Storage Engine</span>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-database-fill-check"></i>
                    </div>
                </div>
                <div class="stat-value cx-text-primary"><?= $dbConnected ? 'MySQL' : 'JSON' ?></div>
            </div>
            <div class="small text-muted">
                <?= $dbConnected ? "{$dbStats['projects']} DB rows &bull; {$fileSizeKb} KB backup" : "{$fileSizeKb} KB atomic lock file" ?>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted fw-bold text-uppercase"
                        style="font-size: 0.68rem; letter-spacing: 0.06em;">PHP Runtime</span>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-filetype-php"></i>
                    </div>
                </div>
                <div class="stat-value text-success"><?= PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION ?></div>
            </div>
            <div class="small text-muted">
                v<?= htmlspecialchars($phpVersion) ?> &bull; <?= $opcacheEnabled ? 'OPcache On' : 'Standard' ?>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted fw-bold text-uppercase"
                        style="font-size: 0.68rem; letter-spacing: 0.06em;">Memory &amp; Timeout</span>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-memory"></i>
                    </div>
                </div>
                <div class="stat-value text-warning"><?= htmlspecialchars($memoryLimit) ?></div>
            </div>
            <div class="small text-muted">
                Max Execution: <?= htmlspecialchars($maxExecTime) ?>s &bull; <?= htmlspecialchars($osFamily) ?>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted fw-bold text-uppercase"
                        style="font-size: 0.68rem; letter-spacing: 0.06em;">Audit Events</span>
                    <div class="stat-icon" style="background: var(--cx-accent-soft); color: var(--cx-accent);">
                        <i class="bi bi-journal-check"></i>
                    </div>
                </div>
                <div class="stat-value cx-text-primary"><?= $dbStats['audit_logs'] ?></div>
            </div>
            <div class="small text-muted">
                Recorded security &amp; admin mutations
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 3. DETAILED SYSTEM DIAGNOSTICS PANELS                    -->
<!-- ======================================================== -->
<div class="row g-4 mb-4">
    <!-- Panel 1: Data Store Integrity -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2 cx-text-primary">
                    <i class="bi bi-database-fill-gear text-info"></i>
                    <span>Data Store &amp; Fallback Integrity</span>
                </h6>
                <span
                    class="badge <?= $dbConnected ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' ?> d-inline-flex align-items-center gap-1">
                    <span class="live-dot" style="width: 5px; height: 5px;"></span>
                    <?= $dbConnected ? 'MySQL Healthy' : 'JSON Fallback' ?>
                </span>
            </div>

            <ul class="list-group list-group-flush mb-0 small" style="background: transparent;">
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Primary Storage</span>
                    <span
                        class="fw-semibold"><?= $dbConnected ? 'MySQL PDO (codex404_db)' : 'Unavailable — Using JSON Fallback' ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Fallback JSON File</span>
                    <code class="text-info text-truncate ms-2"
                        style="max-width: 260px; font-size: 0.76rem;"><?= htmlspecialchars($dataPath) ?></code>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Backup Payload Size</span>
                    <span class="fw-bold"><?= $fileSizeKb ?> KB (<?= $totalCount ?> active records)</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Fallback Write Access</span>
                    <span>
                        <?php if ($fileWritable): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                <i class="bi bi-check2-circle me-1"></i> Read &amp; Write OK
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Read Only
                            </span>
                        <?php endif; ?>
                    </span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Fallback Last Modified</span>
                    <span class="text-muted fw-semibold"><?= htmlspecialchars($fileModified) ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel 2: Server & Environment -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2 cx-text-primary">
                    <i class="bi bi-server text-primary"></i>
                    <span>Server &amp; Runtime Environment</span>
                </h6>
                <span
                    class="badge bg-info-subtle text-info border border-info-subtle"><?= htmlspecialchars(ucfirst(defined('ENVIRONMENT') ? ENVIRONMENT : 'local')) ?></span>
            </div>

            <ul class="list-group list-group-flush mb-0 small" style="background: transparent;">
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Web Server</span>
                    <span class="fw-semibold text-truncate ms-2"
                        style="max-width: 260px;"><?= htmlspecialchars($serverSoftware) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">PHP Engine</span>
                    <span class="fw-bold cx-text-primary">v<?= htmlspecialchars($phpVersion) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Operating System</span>
                    <span class="fw-semibold"><?= htmlspecialchars(PHP_OS . ' (' . $osFamily . ')') ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Zend OPcache</span>
                    <span>
                        <?php if ($opcacheEnabled): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle">Standard
                                Interpreter</span>
                        <?php endif; ?>
                    </span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Max Memory &amp; Timeout</span>
                    <span class="fw-semibold"><?= htmlspecialchars($memoryLimit) ?> &bull;
                        <?= htmlspecialchars($maxExecTime) ?>s</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel 3: Security & Session Health -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2 cx-text-primary">
                    <i class="bi bi-shield-lock-fill text-success"></i>
                    <span>Authentication &amp; Session Guard</span>
                </h6>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Active Protection</span>
            </div>

            <ul class="list-group list-group-flush mb-0 small" style="background: transparent;">
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Active Operator</span>
                    <span class="fw-bold cx-text-primary"><i
                            class="bi bi-person-badge text-info me-1"></i><?= htmlspecialchars((string) ($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Session Fixation &amp; IP Policy</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Regenerated &bull;
                        <?= htmlspecialchars($ipBindMode) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Cookie Flags</span>
                    <span class="fw-semibold">SameSite=Strict &bull; HttpOnly</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Brute Force Lockout</span>
                    <span class="fw-semibold">5 attempts / 15-min lockout</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10"
                    style="background: transparent; color: inherit;">
                    <span class="text-muted">Session Timeout</span>
                    <span class="fw-semibold">30 mins idle / 8 hrs absolute</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel 4: Cross-Platform Bridge Interfaces -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2 cx-text-primary">
                    <i class="bi bi-hdd-network-fill text-warning"></i>
                    <span>Connected Interfaces</span>
                </h6>
                <span class="badge bg-info-subtle text-info border border-info-subtle">Active Routes</span>
            </div>

            <div class="d-flex flex-column gap-2">
                <div class="cx-subpanel p-3 d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-robot fs-4 text-warning"></i>
                        <div>
                            <div class="fw-bold small cx-text-primary">CodeX404 Executive CRM</div>
                            <small
                                class="text-muted"><?= $crmAvailable ? 'Executive Leads, Pipeline & Operations' : 'Not deployed in this workspace' ?></small>
                        </div>
                    </div>
                    <?php if ($crmAvailable): ?>
                        <a href="../../crm/" target="_blank" class="btn btn-sm btn-outline-warning py-1 px-2"
                            style="border-radius: 6px; font-size: 0.75rem;">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Connect
                        </a>
                    <?php else: ?>
                        <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle">Offline</span>
                    <?php endif; ?>
                </div>

                <div class="cx-subpanel p-3 d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-globe2 fs-4 text-info"></i>
                        <div>
                            <div class="fw-bold small cx-text-primary">Public Portfolio Frontend</div>
                            <small class="text-muted">Live consumer-facing showcase (#work)</small>
                        </div>
                    </div>
                    <a href="<?= url('#work') ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-sm btn-outline-info py-1 px-2" style="border-radius: 6px; font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> View Live
                    </a>
                </div>

                <div class="cx-subpanel p-3 d-flex align-items-center justify-content-between gap-2">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-lightning-charge fs-4 text-primary"></i>
                        <div>
                            <div class="fw-bold small cx-text-primary">Discovery Intake Gateway</div>
                            <small class="text-muted">Client discovery questionnaire &amp; lead ingestion</small>
                        </div>
                    </div>
                    <a href="<?= url('discovery-call') ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-sm btn-outline-primary py-1 px-2"
                        style="border-radius: 6px; font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Open Form
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 4. DATABASE SCHEMA & MIGRATIONS                          -->
<!-- ======================================================== -->
<div class="admin-card overflow-hidden mb-4" id="migrations">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2"
        style="border-color: var(--cx-border) !important;">
        <div>
            <h6 class="fw-semibold mb-0 d-flex align-items-center gap-2 cx-text-primary">
                <i class="bi bi-layers" style="color: var(--cx-accent);"></i>
                <span>Database Schema &amp; Migrations</span>
            </h6>
            <small class="text-muted">
                Connected DB: <code><?= htmlspecialchars($migrationStatus['database'] ?: 'None') ?></code>
                &middot; <?= $migrationStatus['applied_count'] ?> Applied
                &middot; <?= $migrationStatus['pending_count'] ?> Pending
            </small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <?php if ($migrationStatus['pending_count'] > 0): ?>
                <?php if (current_admin_can('settings.edit')): ?>
                    <form method="POST" action="<?= admin_url('telemetry') ?>" class="d-inline">
                        <?= csrf_input_field() ?>
                        <input type="hidden" name="action" value="apply_migrations">
                        <button type="submit" class="btn btn-sm btn-cx-primary px-3">
                            <i class="bi bi-play-fill me-1"></i>Apply Pending (<?= $migrationStatus['pending_count'] ?>)
                        </button>
                    </form>
                <?php else: ?>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><?= $migrationStatus['pending_count'] ?> Pending</span>
                <?php endif; ?>
            <?php else: ?>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Schema Up to Date</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th>Migration File</th>
                    <th>Status</th>
                    <th>Batch</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($migrationStatus['timeline'])): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3 small">No migration records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach (array_reverse($migrationStatus['timeline']) as $mig): ?>
                        <tr>
                            <td class="small" style="font-family: var(--font-mono);">
                                <?= htmlspecialchars($mig['filename']) ?>
                            </td>
                            <td>
                                <?php if ($mig['status'] === 'applied'): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Applied</span>
                                <?php else: ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted" style="font-family: var(--font-mono);">
                                <?= $mig['batch'] !== null ? '#' . (int) $mig['batch'] : '—' ?>
                            </td>
                            <td class="small text-muted" style="font-family: var(--font-mono);">
                                <?= htmlspecialchars((string) ($mig['applied_at'] ?? 'Pending apply')) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ======================================================== -->
<!-- 5. RECENT ADMIN AUDIT LOG                                -->
<!-- ======================================================== -->
<div class="admin-card overflow-hidden mb-4">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2"
        style="border-color: var(--cx-border) !important;">
        <div>
            <h6 class="fw-semibold mb-0 d-flex align-items-center gap-2 cx-text-primary">
                <i class="bi bi-journal-text" style="color: var(--cx-accent);"></i>
                <span>Recent Admin Audit Trail</span>
            </h6>
            <small class="text-muted">Authentication, RBAC, migration, and deliverable mutation events</small>
        </div>
        <a href="<?= admin_url('logs') ?>" class="small fw-semibold text-decoration-none" style="color: var(--cx-accent);">Open Full Logs &rarr;</a>
    </div>
    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Actor</th>
                    <th>Action</th>
                    <th>Summary</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentAuditLogs)): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4 small">
                            No audit events recorded yet. Actions on users, roles, logins, and deliverables will appear
                            here.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recentAuditLogs as $log): ?>
                        <tr>
                            <td class="small text-muted" style="font-family: var(--font-mono); white-space: nowrap;">
                                <?= htmlspecialchars((string) $log['created_at']) ?>
                            </td>
                            <td class="small fw-semibold cx-text-primary">
                                <?= htmlspecialchars((string) ($log['actor_username'] ?: 'system')) ?>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info border border-info-subtle"
                                    style="font-family: var(--font-mono); font-size: 0.7rem;">
                                    <?= htmlspecialchars((string) $log['action']) ?>
                                </span>
                            </td>
                            <td class="small cx-text-secondary">
                                <?= htmlspecialchars((string) $log['summary']) ?>
                            </td>
                            <td class="small text-muted" style="font-family: var(--font-mono);">
                                <?= htmlspecialchars((string) ($log['ip_address'] ?: '—')) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>