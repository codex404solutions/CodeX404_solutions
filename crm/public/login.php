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
        $error = 'Security validation failed (CSRF token expired). Refresh and try again.';
    } elseif (AuthService::attempt((string)($_POST['email'] ?? ''), (string)($_POST['password'] ?? ''))) {
        header('Location: index.php');
        exit;
    } else {
        $error = AuthService::isConfigured()
            ? 'Invalid credentials. Please verify your email and password.'
            : 'CRM admin credentials are not configured. Set CRM_ADMIN_EMAIL and CRM_ADMIN_PASSWORD_HASH in crm/.env.';
    }
}
?><!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeX404 Solutions — CRM Login</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0B0F19;
            color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #111827;
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 16px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.7);
        }
        .form-control {
            background-color: #0B0F19;
            border-color: rgba(255, 255, 255, 0.15);
            color: #FFF;
            padding: 0.75rem 1rem;
        }
        .form-control:focus {
            background-color: #0E1424;
            border-color: #38BDF8;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
            color: #FFF;
        }
    </style>
</head>
<body>
<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3);">
                        <i class="bi bi-cpu-fill text-info fs-2"></i>
                    </div>
                    <h3 class="fw-bold mb-1">CodeX<span class="text-info">404</span> Solutions</h3>
                    <p class="text-muted small mb-0">Executive CRM & Paperclip Agent Command Center</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2 small py-2 px-3 border-0" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div><?= CrmSecurity::escape($error) ?></div>
                    </div>
                <?php endif; ?>

                <form method="post" class="mt-4">
                    <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape(CrmSecurity::csrfToken()) ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Executive Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" required autocomplete="username" placeholder="admin@codex404solutions.online">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="form-label small text-muted fw-semibold">Master Password</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-key"></i></span>
                            <input type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="••••••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info w-100 py-2 fw-bold text-dark shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Command Center
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-shield-check text-success me-1"></i> OWASP Zero-Trust Hardened &bull; HMAC Replay Safe
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
