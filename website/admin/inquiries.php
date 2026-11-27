<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Inquiries & Leads Inbox
 * Displays structured submissions from Contact (4 categories), Discovery Call, and Chatbot.
 */

require_once __DIR__ . '/auth.php';
require_admin_permission('inquiries.view');

use App\Services\AuditLogService;

$canManage = current_admin_can('inquiries.manage');
$pdo = class_exists('Database') ? \Database::getConnection() : null;

// Handle status mutation or delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    require_admin_permission('inquiries.manage', false, 'inquiries');
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        set_admin_flash('error', 'Security token invalid or expired.');
        header('Location: ' . admin_url('inquiries'));
        exit;
    }

    $action = (string) ($_POST['action'] ?? '');
    $inquiryId = (int) ($_POST['id'] ?? 0);
    $actor = current_admin_profile();

    if ($inquiryId > 0 && $action === 'status') {
        $newStatus = (string) ($_POST['status'] ?? 'new');
        if (in_array($newStatus, ['new', 'in_review', 'replied', 'archived'], true)) {
            $stmt = $pdo->prepare('UPDATE `contact_messages` SET `status` = ? WHERE `id` = ?');
            $stmt->execute([$newStatus, $inquiryId]);
            AuditLogService::record((string) ($actor['id'] ?? ''), (string) ($actor['username'] ?? ''), 'inquiry.status_updated', 'inquiry', (string) $inquiryId, "Updated inquiry #{$inquiryId} status to {$newStatus}");
            set_admin_flash('success', "Inquiry #{$inquiryId} marked as " . ucfirst(str_replace('_', ' ', $newStatus)) . '.');
        }
    } elseif ($inquiryId > 0 && $action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM `contact_messages` WHERE `id` = ?');
        $stmt->execute([$inquiryId]);
        AuditLogService::record((string) ($actor['id'] ?? ''), (string) ($actor['username'] ?? ''), 'inquiry.deleted', 'inquiry', (string) $inquiryId, "Deleted inquiry #{$inquiryId}");
        set_admin_flash('success', "Inquiry #{$inquiryId} deleted.");
    }

    header('Location: ' . admin_url('inquiries'));
    exit;
}

$q = trim((string) ($_GET['q'] ?? ''));
$catFilter = trim((string) ($_GET['category'] ?? 'all'));
$statusFilter = trim((string) ($_GET['status'] ?? 'all'));

$inquiries = [];
$counts = ['total' => 0, 'new' => 0, 'project' => 0, 'service' => 0, 'partnership' => 0, 'general' => 0, 'discovery' => 0];

if ($pdo) {
    $clauses = [];
    $params = [];
    if ($q !== '') {
        $like = '%' . $q . '%';
        $clauses[] = '(`name` LIKE ? OR `email` LIKE ? OR `company` LIKE ? OR `subject` LIKE ? OR `message` LIKE ? OR `reference_code` LIKE ?)';
        array_push($params, $like, $like, $like, $like, $like, $like);
    }
    if ($catFilter !== '' && $catFilter !== 'all') {
        $clauses[] = '`inquiry_category` = ?';
        $params[] = $catFilter;
    }
    if ($statusFilter !== '' && $statusFilter !== 'all') {
        $clauses[] = '`status` = ?';
        $params[] = $statusFilter;
    }

    $where = $clauses ? ('WHERE ' . implode(' AND ', $clauses)) : '';
    $stmt = $pdo->prepare("SELECT * FROM `contact_messages` {$where} ORDER BY `id` DESC LIMIT 100");
    $stmt->execute($params);
    $inquiries = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

    $counts['total'] = (int) $pdo->query('SELECT COUNT(*) FROM `contact_messages`')->fetchColumn();
    $counts['new'] = (int) $pdo->query("SELECT COUNT(*) FROM `contact_messages` WHERE `status` = 'new'")->fetchColumn();
    foreach (['project', 'service', 'partnership', 'general', 'discovery'] as $cKey) {
        $cStmt = $pdo->prepare('SELECT COUNT(*) FROM `contact_messages` WHERE `inquiry_category` = ?');
        $cStmt->execute([$cKey]);
        $counts[$cKey] = (int) $cStmt->fetchColumn();
    }
}

$categoryLabels = [
    'project'     => 'Project Discussion',
    'service'     => 'Service Inquiry',
    'partnership' => 'Business Partnership',
    'general'     => 'General Inquiry',
    'discovery'   => 'Discovery Call',
];

$currentPage = 'inquiries';
$pageTitle = 'Inquiries & Leads';
$pageSubtitle = 'Contact submissions across all 4 categories, Discovery Calls, and Chatbot';

require_once __DIR__ . '/includes/header.php';
?>

<!-- KPI Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Total Inquiries</span>
                <div class="stat-icon" style="background: var(--cx-accent-soft); color: var(--cx-accent);">
                    <i class="bi bi-envelope-paper"></i>
                </div>
            </div>
            <div class="stat-value" style="color: var(--cx-text-primary);"><?= $counts['total'] ?></div>
            <div class="small text-muted">Across all channels</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Unread / New</span>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-inbox"></i>
                </div>
            </div>
            <div class="stat-value text-success"><?= $counts['new'] ?></div>
            <div class="small text-muted">Awaiting review</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Projects &amp; Services</span>
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-code-square"></i>
                </div>
            </div>
            <div class="stat-value" style="color: var(--cx-accent);"><?= $counts['project'] + $counts['service'] ?></div>
            <div class="small text-muted"><?= $counts['project'] ?> Project &middot; <?= $counts['service'] ?> Service</div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-muted fw-semibold small">Partnerships &amp; Calls</span>
                <div class="stat-icon" style="background: var(--cx-pill-bg); color: var(--cx-text-secondary);">
                    <i class="bi bi-diagram-3"></i>
                </div>
            </div>
            <div class="stat-value" style="color: var(--cx-text-primary);"><?= $counts['partnership'] + $counts['discovery'] ?></div>
            <div class="small text-muted"><?= $counts['partnership'] ?> Partner &middot; <?= $counts['discovery'] ?> Call &middot; <?= $counts['general'] ?> General</div>
        </div>
    </div>
</div>

<!-- Filter Toolbar -->
<div class="admin-card p-3 mb-4">
    <form method="GET" action="<?= admin_url('inquiries') ?>" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
            <label class="form-label small text-muted mb-1">Search</label>
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted" style="font-size: 0.8rem;"></i>
                <input type="search" name="q" value="<?= htmlspecialchars($q) ?>" class="form-control form-control-sm ps-4"
                    placeholder="Name, email, company, subject, ref...">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label small text-muted mb-1">Category</label>
            <select name="category" class="form-select form-select-sm">
                <option value="all">All Categories</option>
                <?php foreach ($categoryLabels as $k => $lbl): ?>
                    <option value="<?= htmlspecialchars($k) ?>" <?= $catFilter === $k ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lbl) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-6 col-md-2">
            <label class="form-label small text-muted mb-1">Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All Statuses</option>
                <option value="new" <?= $statusFilter === 'new' ? 'selected' : '' ?>>New</option>
                <option value="in_review" <?= $statusFilter === 'in_review' ? 'selected' : '' ?>>In Review</option>
                <option value="replied" <?= $statusFilter === 'replied' ? 'selected' : '' ?>>Replied</option>
                <option value="archived" <?= $statusFilter === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>
        </div>
        <div class="col-12 col-md-3 d-flex align-items-center justify-content-md-end gap-2">
            <button type="submit" class="btn btn-sm btn-cx-primary px-3">Filter</button>
            <?php if ($q !== '' || $catFilter !== 'all' || $statusFilter !== 'all'): ?>
                <a href="<?= admin_url('inquiries') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Inquiries Table -->
<div class="admin-card overflow-hidden mb-4">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2"
        style="border-color: var(--cx-border) !important;">
        <div>
            <h6 class="fw-semibold mb-0">Submitted Inquiries</h6>
            <small class="text-muted">Showing <?= count($inquiries) ?> latest entries</small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-admin align-middle mb-0">
            <thead>
                <tr>
                    <th>Contact</th>
                    <th>Category &amp; Scope</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th style="width: 150px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($inquiries)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5 small">
                            No inquiries match your current filter.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($inquiries as $inq): ?>
                        <?php
                        $cat = (string) ($inq['inquiry_category'] ?? 'project');
                        $catText = $categoryLabels[$cat] ?? ucfirst($cat);
                        $st = (string) ($inq['status'] ?? 'new');
                        $stClass = match ($st) {
                            'new'       => 'bg-success-subtle text-success border-success-subtle',
                            'in_review' => 'bg-warning-subtle text-warning border-warning-subtle',
                            'replied'   => 'bg-info-subtle text-info border-info-subtle',
                            default     => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                        };
                        ?>
                        <tr>
                            <td>
                                <div class="fw-semibold small"><?= htmlspecialchars((string) $inq['name']) ?></div>
                                <div class="small text-muted" style="font-size: 0.75rem;">
                                    <?= htmlspecialchars((string) $inq['email']) ?>
                                    <?= !empty($inq['company']) ? ' &middot; ' . htmlspecialchars((string) $inq['company']) : '' ?>
                                </div>
                            </td>
                            <td>
                                <span class="category-chip"><?= htmlspecialchars($catText) ?></span>
                                <?php if (!empty($inq['division'])): ?>
                                    <span class="badge border bg-secondary-subtle text-secondary ms-1" style="font-size: 0.68rem;">
                                        <?= htmlspecialchars((string) $inq['division']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small fw-medium text-truncate" style="max-width: 240px;">
                                    <?= htmlspecialchars((string) ($inq['subject'] ?: 'Website Inquiry')) ?>
                                </div>
                                <div class="small text-muted text-truncate" style="max-width: 240px; font-size: 0.74rem;">
                                    <?= htmlspecialchars((string) $inq['message']) ?>
                                </div>
                            </td>
                            <td>
                                <?php if ($canManage): ?>
                                    <form method="POST" action="<?= admin_url('inquiries') ?>" class="d-inline">
                                        <?= csrf_input_field() ?>
                                        <input type="hidden" name="action" value="status">
                                        <input type="hidden" name="id" value="<?= (int) $inq['id'] ?>">
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm"
                                            style="width: auto; font-size: 0.75rem; padding: 0.2rem 1.75rem 0.2rem 0.5rem;">
                                            <?php foreach (['new' => 'New', 'in_review' => 'In Review', 'replied' => 'Replied', 'archived' => 'Archived'] as $sk => $sl): ?>
                                                <option value="<?= $sk ?>" <?= $st === $sk ? 'selected' : '' ?>><?= $sl ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                <?php else: ?>
                                    <span class="badge border <?= $stClass ?>"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $st))) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted" style="font-family: var(--font-mono); white-space: nowrap;">
                                <?= htmlspecialchars(date('M d H:i', strtotime((string) ($inq['created_at'] ?? 'now')))) ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-action-icon btn-view-inquiry"
                                        data-bs-toggle="modal" data-bs-target="#modalViewInquiry"
                                        data-inquiry='<?= htmlspecialchars(json_encode($inq, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_INVALID_UTF8_SUBSTITUTE), ENT_QUOTES, 'UTF-8') ?>'
                                        title="View Full Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if ($canManage): ?>
                                        <form method="POST" action="<?= admin_url('inquiries') ?>" class="d-inline"
                                            onsubmit="return confirm('Delete this inquiry permanently?');">
                                            <?= csrf_input_field() ?>
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int) $inq['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action-icon" title="Delete Inquiry">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
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

<!-- Inquiry Detail Modal -->
<div class="modal fade" id="modalViewInquiry" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <span class="category-chip mb-1" id="inqModalCategory">Category</span>
                    <h5 class="modal-title fw-semibold mb-0" id="inqModalSubject">Inquiry Subject</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-3 small" id="inqModalGrid"></div>
                <div class="p-3 rounded-3" style="background: var(--cx-pill-bg); border: 1px solid var(--cx-border);">
                    <div class="small text-muted fw-semibold mb-1">Message</div>
                    <div id="inqModalMessage" style="white-space: pre-wrap;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" id="inqModalMailto" class="btn btn-sm btn-cx-primary"><i class="bi bi-reply me-1"></i>Reply via Email</a>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-view-inquiry').forEach(btn => {
        btn.addEventListener('click', () => {
            const data = JSON.parse(btn.dataset.inquiry || '{}');
            document.getElementById('inqModalCategory').textContent = (data.inquiry_category || 'project').toUpperCase();
            document.getElementById('inqModalSubject').textContent = data.subject || 'Website Inquiry';
            document.getElementById('inqModalMessage').textContent = data.message || '';
            const mailto = document.getElementById('inqModalMailto');
            if (mailto && data.email) {
                mailto.href = 'mailto:' + encodeURIComponent(data.email) + '?subject=' + encodeURIComponent('Re: ' + (data.subject || 'CodeX404 Solutions Inquiry'));
            }

            const fields = [
                ['Name', data.name],
                ['Email', data.email],
                ['Phone', data.phone],
                ['Company', data.company],
                ['Role / Title', data.partner_role],
                ['Division', data.division],
                ['Service', data.service_interest],
                ['Engagement Model', data.engagement_model],
                ['Partnership Type', data.partnership_type],
                ['Inquiry Area', data.inquiry_area],
                ['Budget', data.budget],
                ['Timeline', data.timeline],
                ['Website', data.website],
                ['Country', data.country],
                ['Reference Code', data.reference_code],
                ['IP Address', data.ip_address],
                ['Submitted At', data.created_at]
            ];

            const grid = document.getElementById('inqModalGrid');
            grid.innerHTML = '';
            fields.forEach(([label, val]) => {
                if (!val) return;
                const col = document.createElement('div');
                col.className = 'col-6 col-md-4';
                const lbl = document.createElement('div');
                lbl.className = 'text-muted';
                lbl.style.fontSize = '0.72rem';
                lbl.textContent = label;
                const txt = document.createElement('div');
                txt.className = 'fw-semibold text-break';
                txt.textContent = val;
                col.append(lbl, txt);
                grid.appendChild(col);
            });
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
