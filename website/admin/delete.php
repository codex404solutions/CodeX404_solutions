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
        if ($id !== '' && ProjectService::delete($id)) {
            set_admin_flash('success', "Project '{$id}' was successfully deleted.");
        } else {
            set_admin_flash('error', "Failed to delete project. Item may not exist.");
        }
    }
} else {
    set_admin_flash('error', 'Invalid request method for project deletion.');
}

$returnUrl = trim((string)($_POST['return_url'] ?? ''));
if ($returnUrl !== '' && str_starts_with($returnUrl, '/')) {
    header('Location: ' . $returnUrl);
    exit;
}

header('Location: ' . admin_url('deliverables'));
exit;
