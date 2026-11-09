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
    header('Location: ./');
    exit;
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorReason = null;
    if (!CrmSecurity::verifyCsrf($_POST['csrf_token'] ?? null)) {
        $error = 'Security validation failed (CSRF token expired). Refresh and try again.';
    } elseif (AuthService::attempt((string)($_POST['email'] ?? ''), (string)($_POST['password'] ?? ''), $errorReason)) {
        header('Location: ./');
        exit;
    } else {
        if (!empty($errorReason)) {
            $error = $errorReason;
        } else {
            $error = AuthService::isConfigured()
                ? 'Invalid credentials. Please verify your email and password.'
                : 'CRM admin credentials are not configured. Set CRM_ADMIN_EMAIL and CRM_ADMIN_PASSWORD_HASH in crm/.env.';
        }
    }
}
?><!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeX404 Solutions — CRM Login</title>

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_crm_theme');
            const theme = storedTheme ? storedTheme : (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo/favicon-16x16.png">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #070B14;
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(34, 211, 238, 0.12) 0%, rgba(99, 102, 241, 0.08) 50%, rgba(7, 11, 20, 0.98) 85%);
            color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: 
                linear-gradient(to right, rgba(56, 189, 248, 0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(56, 189, 248, 0.03) 1px, transparent 1px);
            background-size: 36px 36px;
            pointer-events: none;
            z-index: 1;
        }
        .text-gradient-rainbow {
            background: linear-gradient(135deg, #38BDF8 0%, #818CF8 35%, #F472B6 70%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .text-gradient-cyan {
            background: linear-gradient(135deg, #22D3EE 0%, #3B82F6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(17, 24, 39, 0.85);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7), 0 0 35px rgba(56, 189, 248, 0.15);
            backdrop-filter: blur(18px);
            position: relative;
            z-index: 10;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
        }
        .login-card:hover {
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.8), 0 0 45px rgba(56, 189, 248, 0.22);
        }
        .form-control {
            background-color: rgba(11, 15, 25, 0.7);
            border-color: rgba(148, 163, 184, 0.25);
            color: #FFF;
            padding: 0.75rem 1rem;
            border-radius: 10px;
        }
        .form-control:focus {
            background-color: rgba(14, 20, 36, 0.95);
            border-color: #38BDF8;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.2);
            color: #FFF;
        }
        .btn-command {
            background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%);
            border: none;
            color: #FFF;
            font-weight: 700;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
            transition: all 0.25s ease;
        }
        .btn-command:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
            color: #FFF;
        }

        /* Light Mode Styles */
        [data-bs-theme="light"] body {
            background-color: #F8FAFC;
            background-image: radial-gradient(circle at 50% 0%, rgba(14, 165, 233, 0.08) 0%, rgba(241, 245, 249, 0.95) 70%);
            color: #0F172A;
        }
        [data-bs-theme="light"] body::before {
            background-image: 
                linear-gradient(to right, rgba(14, 165, 233, 0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(14, 165, 233, 0.05) 1px, transparent 1px);
        }
        [data-bs-theme="light"] .login-card {
            background: #FFFFFF;
            border-color: rgba(14, 165, 233, 0.3);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
        }
        [data-bs-theme="light"] .form-control {
            background-color: #FFFFFF;
            border-color: #CBD5E1;
            color: #0F172A;
        }
        [data-bs-theme="light"] .form-control:focus {
            background-color: #FFFFFF;
            border-color: #0284C7;
            color: #0F172A;
        }
        [data-bs-theme="light"] .bg-dark {
            background-color: #F1F5F9 !important;
            color: #0F172A !important;
        }
        [data-bs-theme="light"] .border-secondary {
            border-color: #CBD5E1 !important;
        }
        [data-bs-theme="light"] .input-group-text {
            background-color: #F1F5F9 !important;
            border-color: #CBD5E1 !important;
            color: #475569 !important;
        }
        [data-bs-theme="light"] .dropdown-menu {
            background-color: #FFFFFF;
            border-color: #CBD5E1;
        }
        [data-bs-theme="light"] .dropdown-item {
            color: #0F172A;
        }
        [data-bs-theme="light"] .dropdown-item:hover,
        [data-bs-theme="light"] .dropdown-item:focus {
            background-color: #F1F5F9;
            color: #0284C7;
        }
    </style>
</head>
<body>
<div class="container p-3">
    <!-- Top Theme Switcher Bar -->
    <div class="d-flex justify-content-end mb-3">
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1 shadow-sm" id="bd-theme-login" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-circle-half theme-icon-active text-info"></i>
                <span class="small" id="bd-theme-login-text">Theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-login">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark">
                        <i class="bi bi-moon-stars-fill text-info"></i> Dark
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light">
                        <i class="bi bi-sun-fill text-warning"></i> Light
                    </button>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto">
                        <i class="bi bi-circle-half text-secondary"></i> System Auto
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <div class="login-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" class="img-fluid mb-2" style="max-height: 56px; object-fit: contain;">
                    <h4 class="fw-bold mb-1 text-gradient-rainbow">Company Command Center</h4>
                    <p class="text-muted small mb-0">Executive CRM &amp; Business Intelligence</p>
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

                    <button type="submit" class="btn btn-command w-100 py-2 fw-bold text-white shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Command Center
                    </button>
                </form>

                <div class="text-center mt-4 pt-3 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <small class="text-muted d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="d-inline-block rounded-circle bg-success" style="width: 7px; height: 7px; box-shadow: 0 0 8px rgba(34, 197, 94, 0.8);"></span>
                        <i class="bi bi-shield-check text-success ms-1 me-1"></i> OWASP Zero-Trust Hardened &bull; HMAC Replay Safe
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap 5.3.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const getStoredTheme = () => localStorage.getItem('codex_crm_theme');
    const setStoredTheme = theme => localStorage.setItem('codex_crm_theme', theme);
    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        if (storedTheme) return storedTheme;
        return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    };

    const updateThemeUI = (theme) => {
        const textEl = document.getElementById('bd-theme-login-text');
        const iconEl = document.querySelector('#bd-theme-login .theme-icon-active');
        if (textEl) textEl.textContent = theme === 'auto' ? 'Auto' : (theme === 'light' ? 'Light' : 'Dark');
        if (iconEl) {
            if (theme === 'light') iconEl.className = 'bi bi-sun-fill text-warning theme-icon-active';
            else if (theme === 'dark') iconEl.className = 'bi bi-moon-stars-fill text-info theme-icon-active';
            else iconEl.className = 'bi bi-circle-half text-secondary theme-icon-active';
        }
    };

    const applyTheme = (theme) => {
        if (theme === 'auto') {
            const autoTheme = window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', autoTheme);
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme);
        }
        updateThemeUI(theme);
    };

    applyTheme(getPreferredTheme());

    document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
        btn.addEventListener('click', () => {
            const selected = btn.getAttribute('data-bs-theme-value');
            setStoredTheme(selected);
            applyTheme(selected);
        });
    });
</script>
</body>
</html>
