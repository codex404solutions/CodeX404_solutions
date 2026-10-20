<?php
declare(strict_types=1);

namespace CRM;

use CRM\Services\AuthService;
use CRM\Services\CrmSecurity;

$crmRoot = dirname(__DIR__);
require_once $crmRoot . '/app/Services/AuthService.php';
require_once $crmRoot . '/app/Services/CrmSecurity.php';
AuthService::startSession();

if (AuthService::user() !== null) {
    header('Location: index.php');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!CrmSecurity::verifyCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'Security token expired. Refresh and try again.';
    } elseif (AuthService::attempt((string)($_POST['email'] ?? ''), (string)($_POST['password'] ?? ''))) {
        header('Location: index.php');
        exit;
    } else {
        $error = AuthService::isConfigured()
            ? 'Invalid credentials.'
            : 'CRM admin credentials are not configured. Set CRM_ADMIN_EMAIL and CRM_ADMIN_PASSWORD_HASH in crm/.env.';
    }
}
?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>CodeX404 CRM Login</title>
<style>body{margin:0;min-height:100vh;display:grid;place-items:center;background:#0b0f19;color:#f8fafc;font:16px system-ui}.card{width:min(420px,calc(100% - 40px));padding:32px;background:#111827;border:1px solid #334155;border-radius:14px}label{display:block;margin-top:16px;color:#cbd5e1}input{width:100%;margin-top:6px;padding:12px;box-sizing:border-box;border-radius:8px;border:1px solid #475569;background:#0f172a;color:#fff}button{width:100%;margin-top:22px;padding:12px;border:0;border-radius:8px;background:#38bdf8;font-weight:700}.error{margin-top:14px;padding:10px;border-radius:8px;background:#451a1a;color:#fecaca}</style></head>
<body><main class="card"><h1>CodeX404 CRM</h1><p>Private company operations dashboard</p><?php if ($error): ?><div class="error"><?= CrmSecurity::escape($error) ?></div><?php endif; ?><form method="post"><input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape(CrmSecurity::csrfToken()) ?>"><label>Email<input type="email" name="email" required autocomplete="username"></label><label>Password<input type="password" name="password" required autocomplete="current-password"></label><button type="submit">Sign in</button></form></main></body></html>
