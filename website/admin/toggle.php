<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_auth();

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
            set_admin_flash('success', "Project status changed to {$statusLabel}.");
        } else {
            set_admin_flash('error', 'Could not toggle project status.');
        }
    }
}

header('Location: ' . admin_url('index.php'));
exit;
