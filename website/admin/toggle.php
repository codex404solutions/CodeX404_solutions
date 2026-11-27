<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_permission('portfolio.edit');

use App\Services\ProjectService;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        set_admin_flash('error', 'Security token mismatch. Operation aborted.');
    } else {
        $id = trim((string)($_POST['id'] ?? ''));
        if ($id !== '' && ProjectService::toggleStatus($id)) {
            $project = ProjectService::getById($id);
            $statusLabel = (!empty($project['active'])) ? 'Published (Active)' : 'Draft (Hidden)';
            $actor = current_admin_profile();
            \App\Services\AuditLogService::record((string)($actor['id'] ?? ''), (string)($actor['username'] ?? ''), 'portfolio.toggled', 'project', $id, "Changed project '{$id}' status to {$statusLabel}");
            set_admin_flash('success', "Project status changed to {$statusLabel}.");
        } else {
            set_admin_flash('error', 'Could not toggle project status.');
        }
    }
}

$returnUrl = trim((string)($_POST['return_url'] ?? ''));
if ($returnUrl !== '' && str_starts_with($returnUrl, '/')) {
    header('Location: ' . $returnUrl);
    exit;
}

header('Location: ' . admin_url('deliverables'));
exit;
