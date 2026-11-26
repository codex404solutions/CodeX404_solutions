<?php
declare(strict_types=1);

use App\Careers\CareersDB;
use App\Careers\FormBuilderService;
use App\Careers\VacancyService;

$canManageJobs = current_admin_can('careers.jobs.manage');
$categories = VacancyService::listCategories();
$templates = FormBuilderService::listTemplates();

$editId = (int)($_GET['edit'] ?? 0);
$isNew = !empty($_GET['new']);
$editingJob = $editId > 0 ? VacancyService::getById($editId) : null;

$filterStatus = trim((string)($_GET['status'] ?? 'all'));
$filterCat = (int)($_GET['category_id'] ?? 0);
$searchQ = trim((string)($_GET['q'] ?? ''));
$jobsList = VacancyService::listAdminVacancies($filterStatus, $filterCat, $searchQ);
?>

<?php if ($canManageJobs && ($isNew || $editingJob)): ?>
    <?php
    $j = $editingJob ?: [
        'id' => 0, 'title' => '', 'slug' => '', 'category_id' => $categories[0]['id'] ?? 1,
        'department' => 'Engineering', 'employment_type' => 'Full-Time', 'work_mode' => 'Remote',
        'location' => 'Remote', 'experience_level' => 'Mid-Level', 'experience_min_years' => '1',
        'compensation_type' => 'Salary', 'salary_display' => '', 'vacancies_count' => 1,
        'working_hours' => 'Monday–Friday (Flexible Core Overlap)', 'overview' => '',
        'about_position' => '', 'responsibilities' => '', 'qualifications' => '', 'skills' => '',
        'employment_conditions' => '', 'status' => 'draft', 'scheduled_publish_at' => '',
        'application_deadline' => '', 'form_template_id' => $templates[0]['id'] ?? 1,
        'use_custom_form' => 0, 'featured' => 0, 'seo_title' => '', 'seo_description' => '',
    ];
    ?>
    <div class="card border-0 shadow-sm mb-4" style="background:rgba(15,23,42,0.78);border:1px solid rgba(255,255,255,0.1) !important;">
        <div class="card-header bg-transparent border-bottom d-flex justify-content-between align-items-center py-3" style="border-color:rgba(255,255,255,0.08) !important;">
            <h5 class="mb-0 fw-bold"><?= $editingJob ? 'Edit Vacancy: ' . htmlspecialchars((string)$j['title']) : 'Create New Job Vacancy' ?></h5>
            <div class="d-flex gap-2">
                <?php if (!empty($j['slug'])): ?>
                    <a href="<?= url('careers/' . urlencode((string)$j['slug']) . '?preview=1') ?>" target="_blank" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-eye me-1"></i> Preview Vacancy
                    </a>
                    <a href="<?= admin_url('careers?tab=form-builder&job_id=' . (int)$j['id']) ?>" class="btn btn-outline-warning btn-sm">
                        <i class="bi bi-ui-checks-grid me-1"></i> Edit Job Form
                    </a>
                <?php endif; ?>
                <a href="<?= admin_url('careers?tab=jobs') ?>" class="btn btn-outline-secondary btn-sm">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= admin_url('careers?tab=jobs') ?>">
                <?= csrf_input_field() ?>
                <input type="hidden" name="action" value="save_vacancy">
                <input type="hidden" name="id" value="<?= (int)$j['id'] ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Job Title *</label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars((string)$j['title']) ?>" placeholder="e.g., Marketing & Growth Associate">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">URL Slug (shareable path: /careers/slug)</label>
                        <input type="text" name="slug" class="form-control font-monospace" value="<?= htmlspecialchars((string)$j['slug']) ?>" placeholder="auto-generated if blank">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Category *</label>
                        <select name="category_id" class="form-select">
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= (int)$cat['id'] ?>" <?= (int)$j['category_id'] === (int)$cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars((string)$cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Department</label>
                        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars((string)$j['department']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Employment Type</label>
                        <select name="employment_type" class="form-select">
                            <?php foreach (['Full-Time', 'Part-Time', 'Internship', 'Fellowship', 'Contract'] as $et): ?>
                                <option value="<?= $et ?>" <?= $j['employment_type'] === $et ? 'selected' : '' ?>><?= $et ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Work Mode</label>
                        <select name="work_mode" class="form-select">
                            <?php foreach (['Remote', 'Hybrid', 'On-Site'] as $wm): ?>
                                <option value="<?= $wm ?>" <?= $j['work_mode'] === $wm ? 'selected' : '' ?>><?= $wm ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Work Location</label>
                        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars((string)$j['location']) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Experience Level</label>
                        <input type="text" name="experience_level" class="form-control" value="<?= htmlspecialchars((string)$j['experience_level']) ?>" placeholder="e.g., 1–3 Years / Entry Level">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Compensation Type</label>
                        <input type="text" name="compensation_type" class="form-control" value="<?= htmlspecialchars((string)$j['compensation_type']) ?>" placeholder="Salary / Stipend / Commission">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Salary / Stipend Display</label>
                        <input type="text" name="salary_display" class="form-control" value="<?= htmlspecialchars((string)($j['salary_display'] ?? '')) ?>" placeholder="Optional display text">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Vacancies Count</label>
                        <input type="number" min="1" name="vacancies_count" class="form-control" value="<?= (int)($j['vacancies_count'] ?? 1) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Working Hours</label>
                        <input type="text" name="working_hours" class="form-control" value="<?= htmlspecialchars((string)($j['working_hours'] ?? '')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Application Deadline</label>
                        <input type="date" name="application_deadline" class="form-control" value="<?= htmlspecialchars((string)($j['application_deadline'] ?? '')) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Status *</label>
                        <select name="status" class="form-select">
                            <?php foreach (CareersDB::JOB_STATUSES as $stKey => $stMeta): ?>
                                <option value="<?= $stKey ?>" <?= $j['status'] === $stKey ? 'selected' : '' ?>><?= htmlspecialchars($stMeta['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Scheduled Publish Time (if Scheduled)</label>
                        <input type="datetime-local" name="scheduled_publish_at" class="form-control" value="<?= !empty($j['scheduled_publish_at']) ? date('Y-m-d\TH:i', strtotime((string)$j['scheduled_publish_at'])) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Application Form Template</label>
                        <select name="form_template_id" class="form-select">
                            <?php foreach ($templates as $tpl): ?>
                                <option value="<?= (int)$tpl['id'] ?>" <?= (int)($j['form_template_id'] ?? 0) === (int)$tpl['id'] ? 'selected' : '' ?>><?= htmlspecialchars((string)$tpl['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-3 pb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="use_custom_form" id="useCustomForm" value="1" <?= !empty($j['use_custom_form']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="useCustomForm">Override with Job-Specific Form</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="featured" id="isFeaturedJob" value="1" <?= !empty($j['featured']) ? 'checked' : '' ?>>
                            <label class="form-check-label small" for="isFeaturedJob">Featured</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-semibold">Job Overview (Short Card Summary) *</label>
                        <textarea name="overview" rows="2" class="form-control" required><?= htmlspecialchars((string)$j['overview']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">About the Position *</label>
                        <textarea name="about_position" rows="4" class="form-control" required><?= htmlspecialchars((string)$j['about_position']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Key Responsibilities *</label>
                        <textarea name="responsibilities" rows="4" class="form-control" required placeholder="Use line breaks or bullet points..."><?= htmlspecialchars((string)$j['responsibilities']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Required Qualifications *</label>
                        <textarea name="qualifications" rows="4" class="form-control" required><?= htmlspecialchars((string)$j['qualifications']) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Required Skills &amp; Employment Conditions</label>
                        <textarea name="skills" rows="2" class="form-control mb-2" placeholder="Comma-separated skills..."><?= htmlspecialchars((string)$j['skills']) ?></textarea>
                        <textarea name="employment_conditions" rows="2" class="form-control" placeholder="Employment conditions & review terms..."><?= htmlspecialchars((string)($j['employment_conditions'] ?? '')) ?></textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <a href="<?= admin_url('careers?tab=jobs') ?>" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4" style="background:#0B5ED7;border-color:#0B5ED7;">
                        <i class="bi bi-check2-circle me-1"></i> Save Vacancy
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<!-- Filter Bar + Add Category -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
        <input type="hidden" name="tab" value="jobs">
        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="all" <?= $filterStatus === 'all' ? 'selected' : '' ?>>All Statuses</option>
            <?php foreach (CareersDB::JOB_STATUSES as $stKey => $stMeta): ?>
                <option value="<?= $stKey ?>" <?= $filterStatus === $stKey ? 'selected' : '' ?>><?= htmlspecialchars($stMeta['label']) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="category_id" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
            <option value="0">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat['id'] ?>" <?= $filterCat === (int)$cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars((string)$cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="q" class="form-control form-control-sm" style="width:200px;" value="<?= htmlspecialchars($searchQ) ?>" placeholder="Search title or dept...">
        <button type="submit" class="btn btn-outline-info btn-sm">Filter</button>
    </form>

    <?php if ($canManageJobs): ?>
        <form method="POST" action="<?= admin_url('careers?tab=jobs') ?>" class="d-flex gap-2 align-items-center">
            <?= csrf_input_field() ?>
            <input type="hidden" name="action" value="create_category">
            <input type="text" name="category_name" class="form-control form-control-sm" style="width:170px;" placeholder="New Category Name..." required>
            <button type="submit" class="btn btn-outline-secondary btn-sm">+ Category</button>
        </form>
    <?php endif; ?>
</div>

<!-- Vacancies Table -->
<div class="card border-0 shadow-sm" style="background:rgba(15,23,42,0.65);border:1px solid rgba(255,255,255,0.08) !important;">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0" style="background:transparent;">
            <thead>
                <tr class="small text-muted">
                    <th>Vacancy &amp; URL</th>
                    <th>Category / Mode</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Form</th>
                    <th>Applicants</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($jobsList)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">No vacancies match the current filters.</td></tr>
                <?php else: ?>
                    <?php foreach ($jobsList as $job): ?>
                        <?php $stMeta = CareersDB::JOB_STATUSES[$job['status']] ?? ['label' => $job['status'], 'badge' => 'secondary']; ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars((string)$job['title']) ?></div>
                                <div class="small font-monospace text-info">/careers/<?= htmlspecialchars((string)$job['slug']) ?></div>
                            </td>
                            <td class="small">
                                <div><?= htmlspecialchars((string)$job['category_name']) ?></div>
                                <div class="text-muted"><?= htmlspecialchars((string)$job['employment_type']) ?> &bull; <?= htmlspecialchars((string)$job['work_mode']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-<?= $stMeta['badge'] ?>-subtle text-<?= $stMeta['badge'] ?> border border-<?= $stMeta['badge'] ?>-subtle"><?= htmlspecialchars($stMeta['label']) ?></span>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars((string)($job['application_deadline'] ?: 'Open')) ?></td>
                            <td class="small">
                                <?php if (!empty($job['use_custom_form'])): ?>
                                    <span class="badge bg-warning-subtle text-warning">Custom Job Form</span>
                                <?php else: ?>
                                    <span class="text-muted"><?= htmlspecialchars((string)($job['form_template_name'] ?? 'Default')) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= admin_url('careers?tab=applications&job_id=' . (int)$job['id']) ?>" class="badge bg-primary-subtle text-primary text-decoration-none">
                                    <?= (int)$job['applications_count'] ?> Applications
                                </a>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 flex-wrap justify-content-end">
                                    <a href="<?= url('careers/' . urlencode((string)$job['slug']) . '?preview=1') ?>" target="_blank" class="btn btn-outline-light btn-sm" title="Preview"><i class="bi bi-eye"></i></a>
                                    <?php if ($canManageJobs): ?>
                                        <a href="<?= admin_url('careers?tab=jobs&edit=' . (int)$job['id']) ?>" class="btn btn-outline-info btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <a href="<?= admin_url('careers?tab=form-builder&job_id=' . (int)$job['id']) ?>" class="btn btn-outline-warning btn-sm" title="Customize Form"><i class="bi bi-ui-checks"></i></a>
                                        <form method="POST" action="<?= admin_url('careers?tab=jobs') ?>" class="d-inline">
                                            <?= csrf_input_field() ?>
                                            <input type="hidden" name="action" value="duplicate_vacancy">
                                            <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm" title="Duplicate"><i class="bi bi-files"></i></button>
                                        </form>
                                        <?php if ($job['status'] !== 'published'): ?>
                                            <form method="POST" action="<?= admin_url('careers?tab=jobs') ?>" class="d-inline">
                                                <?= csrf_input_field() ?>
                                                <input type="hidden" name="action" value="job_status">
                                                <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                                                <input type="hidden" name="new_status" value="published">
                                                <button type="submit" class="btn btn-outline-success btn-sm" title="Publish Now">Publish</button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" action="<?= admin_url('careers?tab=jobs') ?>" class="d-inline">
                                                <?= csrf_input_field() ?>
                                                <input type="hidden" name="action" value="job_status">
                                                <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                                                <input type="hidden" name="new_status" value="closed">
                                                <button type="submit" class="btn btn-outline-warning btn-sm" title="Close Vacancy">Close</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
