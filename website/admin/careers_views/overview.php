<?php
declare(strict_types=1);

use App\Careers\ActivityLogService;
use App\Careers\ApplicationService;
use App\Careers\CareersDB;
use App\Careers\VacancyService;

$recentApps = ApplicationService::listApplications([], 1, 8)['items'];
$recentLogs = ActivityLogService::listRecent(8);
$openJobs = VacancyService::listAdminVacancies('published');
?>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 h-100" style="background:rgba(15,23,42,0.7);border:1px solid rgba(255,255,255,0.08);">
            <div class="text-muted small mb-1"><i class="bi bi-briefcase text-info me-1"></i> Live Vacancies</div>
            <div class="h3 fw-bold mb-0 text-white"><?= $stats['published_jobs'] ?> <span class="fs-6 text-muted fw-normal">/ <?= $stats['total_jobs'] ?></span></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 h-100" style="background:rgba(15,23,42,0.7);border:1px solid rgba(255,255,255,0.08);">
            <div class="text-muted small mb-1"><i class="bi bi-inbox text-warning me-1"></i> New Queue / Total</div>
            <div class="h3 fw-bold mb-0 text-white"><?= $stats['new_applications'] ?> <span class="fs-6 text-muted fw-normal">/ <?= $stats['total_applications'] ?></span></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 h-100" style="background:rgba(15,23,42,0.7);border:1px solid rgba(255,255,255,0.08);">
            <div class="text-muted small mb-1"><i class="bi bi-calendar-event text-info me-1"></i> Upcoming Interviews</div>
            <div class="h3 fw-bold mb-0 text-white"><?= $stats['upcoming_interviews'] ?></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="p-3 rounded-3 h-100" style="background:rgba(15,23,42,0.7);border:1px solid rgba(255,255,255,0.08);">
            <div class="text-muted small mb-1"><i class="bi bi-people text-success me-1"></i> Active Pipeline / Hired</div>
            <div class="h3 fw-bold mb-0 text-white"><?= $stats['shortlisted_count'] ?> <span class="fs-6 text-success fw-normal">(<?= $stats['hired_count'] ?> hired)</span></div>
        </div>
    </div>
</div>

<?php if ($stats['unread_del_requests'] > 0): ?>
    <div class="alert alert-warning d-flex align-items-center justify-content-between mb-4">
        <div><i class="bi bi-shield-exclamation me-2"></i><strong><?= $stats['unread_del_requests'] ?></strong> candidate data-deletion request(s) flagged in the system.</div>
        <a href="<?= admin_url('careers?tab=applications') ?>" class="btn btn-sm btn-warning">Inspect Applications</a>
    </div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm h-100" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3" style="border-color:rgba(255,255,255,0.08) !important;">
                <h5 class="mb-0 fw-bold fs-6">Recent Candidate Applications</h5>
                <a href="<?= admin_url('careers?tab=applications') ?>" class="btn btn-outline-light btn-sm">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" style="background:transparent;">
                    <thead>
                        <tr class="small text-muted">
                            <th>Ref</th>
                            <th>Candidate</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentApps)): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">No applications submitted yet. Publish jobs on <a href="<?= url('careers') ?>" target="_blank">/careers</a> to begin collecting submissions.</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentApps as $app): ?>
                                <?php $stMeta = CareersDB::PIPELINE_STATUSES[$app['status']] ?? ['label' => $app['status'], 'badge' => 'secondary']; ?>
                                <tr>
                                    <td class="font-monospace small text-info"><?= htmlspecialchars((string)$app['reference_code']) ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars((string)$app['full_name']) ?></div>
                                        <div class="small text-muted"><?= htmlspecialchars((string)$app['email']) ?></div>
                                    </td>
                                    <td class="small"><?= htmlspecialchars((string)$app['job_title']) ?></td>
                                    <td><span class="badge bg-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?>-subtle text-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?> border border-<?= $stMeta['badge'] === 'cyan' ? 'info' : $stMeta['badge'] ?>-subtle"><?= htmlspecialchars($stMeta['label']) ?></span></td>
                                    <td class="text-end">
                                        <a href="<?= admin_url('careers?tab=candidate-detail&id=' . (int)$app['id']) ?>" class="btn btn-outline-info btn-sm">Review</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-5">
        <div class="card border-0 shadow-sm h-100" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3" style="border-color:rgba(255,255,255,0.08) !important;">
                <h5 class="mb-0 fw-bold fs-6">Live Published Vacancies &amp; Audit Feed</h5>
                <a href="<?= admin_url('careers?tab=jobs') ?>" class="btn btn-outline-light btn-sm">Manage Jobs</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="small text-muted text-uppercase fw-semibold mb-2">Active Public Listings</div>
                    <?php if (empty($openJobs)): ?>
                        <div class="small text-muted">No active vacancies published.</div>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach (array_slice($openJobs, 0, 5) as $job): ?>
                                <div class="d-flex justify-content-between align-items-center p-2 rounded-2" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);">
                                    <div>
                                        <div class="fw-semibold small"><?= htmlspecialchars((string)$job['title']) ?></div>
                                        <div class="text-muted" style="font-size:0.75rem;"><?= htmlspecialchars((string)$job['category_name']) ?> &bull; <?= htmlspecialchars((string)$job['work_mode']) ?></div>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary"><?= (int)$job['applications_count'] ?> apps</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="small text-muted text-uppercase fw-semibold mb-2 mt-4">Recent Recruitment Audit Events</div>
                <?php if (empty($recentLogs)): ?>
                    <div class="small text-muted">No recruitment events recorded yet.</div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($recentLogs as $lg): ?>
                            <div class="small border-start border-info ps-2 py-1" style="border-width:2px !important;">
                                <div class="text-white"><?= htmlspecialchars((string)$lg['summary']) ?></div>
                                <div class="text-muted" style="font-size:0.72rem;"><?= htmlspecialchars((string)($lg['actor_name'] ?? 'System')) ?> &bull; <?= htmlspecialchars((string)$lg['created_at']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
