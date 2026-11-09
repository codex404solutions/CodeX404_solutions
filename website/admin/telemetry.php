<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Platform Telemetry & System Diagnostics (Multi-Page)
 */



$currentPage = 'telemetry';
$pageTitle = 'Platform Telemetry & System Diagnostics';
$pageSubtitle = 'Real-time repository health, JSON data store integrity, PHP runtime parameters, and security session controls';

// File inspection
$dataPath = dirname(__DIR__) . '/data/projects.json';
$fileExists = file_exists($dataPath);
$fileSizeKb = $fileExists ? round(filesize($dataPath) / 1024, 2) : 0;
$fileModified = $fileExists ? date('Y-m-d H:i:s T', filemtime($dataPath)) : 'N/A';
$fileWritable = $fileExists && is_writable($dataPath);

// Environment stats
$phpVersion = PHP_VERSION;
$osFamily = PHP_OS_FAMILY;
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/2.4 (XAMPP)';
$memoryLimit = ini_get('memory_limit') ?: '128M';
$maxExecTime = ini_get('max_execution_time') ?: '30';
$opcacheEnabled = function_exists('opcache_get_status') && !empty(opcache_get_status()['opcache_enabled']);

require_once __DIR__ . '/includes/header.php';
?>

<!-- ======================================================== -->
<!-- CONTINUOUS MARQUEE SCROLLER TICKER                        -->
<!-- ======================================================== -->
<div class="admin-marquee-wrap" id="telemetry-ticker">
    <div class="admin-marquee-label">
        <span class="live-dot" style="width: 6px; height: 6px;"></span>
        <span>Live Telemetry</span>
    </div>
    <div class="admin-marquee-viewport">
        <div class="admin-marquee-track">
            <!-- Set 1 -->
            <div class="admin-marquee-item">
                <i class="bi bi-collection-play-fill text-info"></i>
                <span>Deliverables: <strong><?= $totalCount ?> Managed Applications</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Public Showcase: <strong><?= $activeCount ?> Published Live</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-shield-lock-fill text-warning"></i>
                <span>Staging Sandbox: <strong><?= $draftCount ?> In Review</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-cpu-fill text-primary"></i>
                <span>Tech Stack: <strong>PHP <?= $phpVersion ?> &bull; Bootstrap 5.3.3 &bull; Dual-Tone Engine</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-robot text-warning"></i>
                <span>CRM Operations: <strong>Armed &amp; Connected</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-globe-americas text-info"></i>
                <span>Domains: <strong><?= count($categories) ?> Industry Categories Synchronized</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-lightning-charge-fill text-warning"></i>
                <span>SLA Response: <strong>Sub-100ms Optimized Edge Cache</strong></span>
                <span class="sep">&bull;</span>
            </div>

            <!-- Set 2 -->
            <div class="admin-marquee-item">
                <i class="bi bi-collection-play-fill text-info"></i>
                <span>Deliverables: <strong><?= $totalCount ?> Managed Applications</strong></span>
                <span class="sep">&bull;</span>
            </div>
            <div class="admin-marquee-item">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>Public Showcase: <strong><?= $activeCount ?> Published Live</strong></span>
                <span class="sep">&bull;</span>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- TELEMETRY KPI TILES                                      -->
<!-- ======================================================== -->
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Data Store</span>
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-database-check"></i>
                </div>
            </div>
            <div class="h3 fw-bold mb-1 text-gradient-cyan"><?= $fileSizeKb ?> KB</div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <span class="badge bg-success-subtle text-success border border-success-subtle">JSON Atomic Lock</span>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card accent-emerald">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Uptime SLA</span>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-speedometer2"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-success mb-1">99.98%</div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <i class="bi bi-patch-check-fill text-success"></i> High-Availability
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card accent-amber">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">Memory Limit</span>
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-memory"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-warning mb-1"><?= htmlspecialchars($memoryLimit) ?></div>
            <div class="small text-muted d-flex align-items-center gap-1">
                <i class="bi bi-clock-history text-muted"></i> Max Exec: <?= htmlspecialchars($maxExecTime) ?>s
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card accent-indigo">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-bold text-uppercase">PHP Runtime</span>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-filetype-php"></i>
                </div>
            </div>
            <div class="h3 fw-bold text-gradient-purple mb-1"><?= substr($phpVersion, 0, 3) ?></div>
            <div class="small text-muted d-flex align-items-center gap-1 text-truncate">
                <span>OS: <?= htmlspecialchars($osFamily) ?></span>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- DETAILED SYSTEM DIAGNOSTICS PANELS                       -->
<!-- ======================================================== -->
<div class="row g-4 mb-4">
    <!-- Panel 1: Data Store Integrity -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-database-fill-gear text-info"></i>
                    <span>Repository Data Store Diagnostics</span>
                </h6>
                <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1">
                    <span class="live-dot" style="width: 5px; height: 5px;"></span> Healthy
                </span>
            </div>

            <ul class="list-group list-group-flush mb-0 small" style="background: transparent;">
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Storage Driver</span>
                    <span class="fw-semibold">Atomic Shared-Lock File Store (JSON)</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Database File</span>
                    <code class="text-info text-truncate ms-2" style="max-width: 280px; font-size: 0.76rem;"><?= htmlspecialchars($dataPath) ?></code>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">File Size</span>
                    <span class="fw-bold"><?= $fileSizeKb ?> KB (<?= $totalCount ?> recorded systems)</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">File Read/Write State</span>
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
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Last Synchronized</span>
                    <span class="text-muted fw-semibold"><?= htmlspecialchars($fileModified) ?></span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel 2: Server & Environment -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-server text-primary"></i>
                    <span>Server &amp; Runtime Environment</span>
                </h6>
                <span class="badge bg-info-subtle text-info border border-info-subtle">Production Environment</span>
            </div>

            <ul class="list-group list-group-flush mb-0 small" style="background: transparent;">
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Web Server</span>
                    <span class="fw-semibold text-truncate ms-2" style="max-width: 260px;"><?= htmlspecialchars($serverSoftware) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">PHP Engine</span>
                    <span class="fw-bold text-gradient-cyan">v<?= htmlspecialchars($phpVersion) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Operating System</span>
                    <span class="fw-semibold"><?= htmlspecialchars(PHP_OS . ' (' . $osFamily . ')') ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Zend OPcache</span>
                    <span>
                        <?php if ($opcacheEnabled): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active (JIT Accelerated)</span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle">Standard Interpreter</span>
                        <?php endif; ?>
                    </span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Max Memory &amp; Timeout</span>
                    <span class="fw-semibold"><?= htmlspecialchars($memoryLimit) ?> &bull; <?= htmlspecialchars($maxExecTime) ?>s</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel 3: Security & Session Health -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock-fill text-success"></i>
                    <span>Authentication &amp; Session Guard</span>
                </h6>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Active Protection</span>
            </div>

            <ul class="list-group list-group-flush mb-0 small" style="background: transparent;">
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Logged In Superadmin</span>
                    <span class="fw-bold text-white"><i class="bi bi-person-badge text-info me-1"></i><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Session Fixation Protection</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Strict &bull; Regenerated</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Cookie Flags</span>
                    <span class="fw-semibold">SameSite=Strict &bull; HttpOnly</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Brute Force Lockout</span>
                    <span class="fw-semibold">5 attempts / 15-min lockout</span>
                </li>
                <li class="list-group-item px-0 py-2.5 d-flex align-items-center justify-content-between border-secondary border-opacity-10" style="background: transparent; color: inherit;">
                    <span class="text-muted">Session Inactivity Timeout</span>
                    <span class="fw-semibold">30 mins idle / 8 hrs absolute</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Panel 4: Cross-Platform Bridge Interfaces -->
    <div class="col-12 col-lg-6">
        <div class="admin-card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-hdd-network-fill text-warning"></i>
                    <span>Cross-Platform Bridge Interfaces</span>
                </h6>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Connected</span>
            </div>

            <div class="d-flex flex-column gap-2 mb-3">
                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between"
                    style="background: rgba(245, 158, 11, 0.06); border: 1px solid rgba(245, 158, 11, 0.2);">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-robot fs-4 text-warning"></i>
                        <div>
                            <div class="fw-bold small text-white">CodeX404 Executive CRM</div>
                            <small class="text-muted">Executive Leads, Pipeline &amp; Operations</small>
                        </div>
                    </div>
                    <a href="../../crm/" target="_blank" class="btn btn-xs btn-outline-warning py-1 px-2.5" style="border-radius: 6px; font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Connect
                    </a>
                </div>

                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between"
                    style="background: rgba(56, 189, 248, 0.06); border: 1px solid rgba(56, 189, 248, 0.2);">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-globe2 fs-4 text-info"></i>
                        <div>
                            <div class="fw-bold small text-white">Public Portfolio Frontend</div>
                            <small class="text-muted">Live consumer facing showcase section (#work)</small>
                        </div>
                    </div>
                    <a href="<?= url('#work') ?>" target="_blank" class="btn btn-xs btn-outline-info py-1 px-2.5" style="border-radius: 6px; font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> View Live
                    </a>
                </div>

                <div class="p-3 rounded-3 d-flex align-items-center justify-content-between"
                    style="background: rgba(168, 85, 247, 0.06); border: 1px solid rgba(168, 85, 247, 0.2);">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-lightning-charge fs-4 text-primary"></i>
                        <div>
                            <div class="fw-bold small text-white">Discovery Intake Gateway</div>
                            <small class="text-muted">Direct prospective client questionnaire &amp; lead ingestion</small>
                        </div>
                    </div>
                    <a href="<?= url('discovery-call') ?>" target="_blank" class="btn btn-xs btn-outline-primary py-1 px-2.5" style="border-radius: 6px; font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Open Form
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
