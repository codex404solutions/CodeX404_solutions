<?php
declare(strict_types=1);

use App\Careers\ApplicationService;
use App\Careers\CareersDB;
use App\Careers\VacancyService;

$canManage = current_admin_can('careers.applications.manage');
$canExport = current_admin_can('careers.candidates.export');

$filters = [
    'status' => trim((string)($_GET['status'] ?? 'all')),
    'job_id' => trim((string)($_GET['job_id'] ?? '')),
    'search' => trim((string)($_GET['search'] ?? '')),
    'sort'   => trim((string)($_GET['sort'] ?? 'newest')),
];
$page = max(1, (int)($_GET['page'] ?? 1));
$result = ApplicationService::listApplications($filters, $page, 20);
$allJobs = VacancyService::listAdminVacancies();
$exportQuery = http_build_query(array_filter($filters, fn($v) => $v !== '' && $v !== 'all'));
?>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
        <input type="hidden" name="tab" value="applications">
        <input type="text" name="search" class="form-control form-control-sm" style="width:220px;" value="<?= htmlspecialchars($filters['search']) ?>" placeholder="Search name, email, ref ID...">
        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all">All Pipeline Stages</option>
            <?php foreach (CareersDB::PIPELINE_STATUSES as $stKey => $stMeta): ?>
                <option value="<?= $stKey ?>" <?= $filters['status'] === $stKey ? 'selected' : '' ?>><?= htmlspecialchars($stMeta['label']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="job_id" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="">All Vacancies &amp; Talent Pool</option>
            <option value="general" <?= $filters['job_id'] === 'general' ? 'selected' : '' ?>>General Talent Pool Only</option>
            <?php foreach ($allJobs as $jb): ?>
                <option value="<?= (int)$jb['id'] ?>" <?= (string)$filters['job_id'] === (string)$jb['id'] ? 'selected' : '' ?>><?= htmlspecialchars((string)$jb['title']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="sort" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Newest First</option>
            <option value="oldest" <?= $filters['sort'] === 'oldest' ? 'selected' : '' ?>>Oldest First</option>
            <option value="name" <?= $filters['sort'] === 'name' ? 'selected' : '' ?>>Name A–Z</option>
            <option value="status" <?= $filters['sort'] === 'status' ? 'selected' : '' ?>>Pipeline Stage</option>
        </select>
        <button type="submit" class="btn btn-outline-info btn-sm">Apply</button>
    </form>

    <?php if ($canExport): ?>
        <a href="<?= admin_url('careers?tab=export' . ($exportQuery !== '' ? '&' . $exportQuery : '')) ?>" class="btn btn-outline-success btn-sm">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Filtered CSV (<?= $result['total'] ?>)
        </a>
    <?php endif; ?>
</div>

<form method="POST" action="<?= admin_url('careers?tab=applications') ?>">
    <?= csrf_input_field() ?>
    <input type="hidden" name="action" value="bulk_application_status">

    <?php if ($canManage): ?>
        <div class="d-flex align-items-center gap-2 mb-2 p-2 rounded-2" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);">
            <span class="small text-muted">Bulk action for checked rows:</span>
            <select name="bulk_status" class="form-select form-select-sm" style="width:auto;" required>
                <option value="">Choose stage...</option>
                <?php foreach (CareersDB::PIPELINE_STATUSES as $stKey => $stMeta): ?>
                    <option value="<?= $stKey ?>"><?= htmlspecialchars($stMeta['label']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-sm btn-outline-warning">Update Selected</button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" style="background:transparent;">
                <thead>
                    <tr class="small text-muted">
                        <th style="width:32px;"><input type="checkbox" class="form-check-input" id="chkAllApps"></th>
                        <th>Reference</th>
                        <th>Candidate</th>
                        <th>Position Applied</th>
                        <th>Pipeline Status</th>
                        <th>Recruiter</th>
                        <th>Submitted</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($result['items'])): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">No applications found matching your filters.</td></tr>
                    <?php else: ?>
                        <?php foreach ($result['items'] as $item): ?>
                            <?php $stMeta = CareersDB::PIPELINE_STATUSES[$item['status']] ?? ['label' => $item['status'], 'badge' => 'secondary']; ?>
                            <tr>
                                <td><input type="checkbox" class="form-check-input app-row-chk" name="selected_ids[]" value="<?= (int)$item['id'] ?>"></td>
                                <td class="font-monospace small text-info"><?= htmlspecialchars((string)$item['reference_code']) ?></td>
                                <td>
                                    <div class="fw-semibold"><?= htmlspecialchars((string)$item['full_name']) ?></div>
                                    <div class="small text-muted"><?= htmlspecialchars((string)$item['email']) ?> &bull; <?= htmlspecialchars((string)($item['city'] ?: '')) ?></div>
                                </td>
                                <td class="small">
                                    <div><?= htmlspecialchars((string)$item['job_title']) ?></div>
                                    <?php if ($item['application_type'] === 'general_talent_pool'): ?>
                                        <span class="badge bg-warning-subtle text-warning" style="font-size:0.65rem;">Talent Pool</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?>-subtle text-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?> border border-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?>-subtle">
                                        <?= htmlspecialchars($stMeta['label']) ?>
                                    </span>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars((string)($item['assigned_recruiter_name'] ?? 'Unassigned')) ?></td>
                                <td class="small text-muted"><?= date('M j, Y H:i', strtotime((string)$item['submitted_at'])) ?></td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <?php if ($canExport && !empty($item['resume_path'])): ?>
                                            <a href="<?= admin_url('careers?tab=resume&app_id=' . (int)$item['id']) ?>" class="btn btn-outline-light btn-sm" title="Download CV"><i class="bi bi-file-earmark-arrow-down"></i></a>
                                        <?php endif; ?>
                                        <a href="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$item['id']) ?>" class="btn btn-outline-info btn-sm">Open</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</form>

<?php if ($result['total_pages'] > 1): ?>
    <nav class="mt-3">
        <ul class="pagination pagination-sm justify-content-end">
            <?php for ($p = 1; $p <= $result['total_pages']; $p++): ?>
                <li class="page-item <?= $p === $result['page'] ? 'active' : '' ?>">
                    <a class="page-link" href="<?= admin_url('careers?tab=applications&page=' . $p . ($exportQuery !== '' ? '&' . $exportQuery : '')) ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>

<script>
document.getElementById('chkAllApps')?.addEventListener('change', function () {
    document.querySelectorAll('.app-row-chk').forEach(chk => { chk.checked = this.checked; });
});
</script>
