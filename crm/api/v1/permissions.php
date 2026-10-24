<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions CRM — API: Role Permissions Evaluation
 */

header('Content-Type: application/json; charset=utf-8');

$crmRoot = dirname(__DIR__, 2);
require_once $crmRoot . '/config/config.php';
require_once $crmRoot . '/app/Services/StorageService.php';
require_once $crmRoot . '/app/Services/RBACService.php';

use CRM\Services\StorageService;
use CRM\Services\RBACService;

StorageService::init($crmRoot . '/storage');

$rolesInput = $_GET['roles'] ?? $_POST['roles'] ?? '';
if (is_string($rolesInput)) {
    $roles = array_filter(array_map('trim', explode(',', $rolesInput)));
} elseif (is_array($rolesInput)) {
    $roles = $rolesInput;
} else {
    $roles = ['viewer'];
}

$effective = RBACService::getEffectivePermissions($roles);

echo json_encode([
    'status' => 'success',
    'roles' => $roles,
    'perms' => $effective['effective'],
    'details' => $effective['details'],
    'role_breakdown' => $effective['role_breakdown'],
    'total' => count($effective['effective'])
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
