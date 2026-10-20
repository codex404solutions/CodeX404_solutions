<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

// If already logged in, send directly to dashboard
if (is_admin_logged_in()) {
    header('Location: ' . admin_url('index.php'));
    exit;
}

$error = '';
$usernameVal = 'admin';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Rate limiting on login attempts (both session & persistent IP-based)
    if (!check_rate_limit('admin_login_submit', 10, 300)) {
        $error = 'Too many sign-in attempts from this location. Please wait a few minutes before trying again.';
    } else {
        $token = $_POST['csrf_token'] ?? '';
        if (!verify_csrf_token($token)) {
            $error = 'Security session expired. Please refresh and try again.';
        } else {
            $username = trim((string)($_POST['username'] ?? ''));
            $password = (string)($_POST['password'] ?? '');
            $usernameVal = $username;

            if ($username === '' || $password === '') {
                $error = 'Please enter both username and password.';
            } elseif (is_admin_locked_out($username)) {
                $remaining = get_admin_lockout_remaining($username);
                $minutes = max(1, (int)ceil($remaining / 60));
                $error = "Account or IP temporarily locked due to multiple failed attempts. Please try again in {$minutes} minute(s).";
            } elseif (authenticate_admin($username, $password)) {
                $return = (string)($_GET['return'] ?? '');
                $parsedReturn = parse_url($return);
                $isLocalReturn = $return !== ''
                    && str_starts_with($return, '/')
                    && !str_starts_with($return, '//')
                    && ($parsedReturn === false || !isset($parsedReturn['scheme'], $parsedReturn['host']));
                header('Location: ' . ($isLocalReturn ? $return : admin_url('index.php')));
                exit;
            } else {
                // If this failure triggered a lockout, notify user
                if (is_admin_locked_out($username)) {
                    $remaining = get_admin_lockout_remaining($username);
                    $minutes = max(1, (int)ceil($remaining / 60));
                    $error = "Too many failed attempts. Access has been temporarily suspended for {$minutes} minute(s).";
                } else {
                    // Generic message prevents username enumeration
                    $error = 'Invalid credentials. Please verify your username and password.';
                }
            }
        }
    }
}

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login — CodeX404 Solutions</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 50% 0%, rgba(34, 211, 238, 0.08) 0%, rgba(3, 7, 18, 0.98) 70%), var(--bg-dark);
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 1.25rem;
            padding: 2.5rem 2.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 30px rgba(56, 189, 248, 0.1);
            backdrop-filter: blur(16px);
            position: relative;
            z-index: 10;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.85rem;
            background: rgba(34, 211, 238, 0.1);
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--cyan);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .login-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }
        .login-subtitle {
            font-size: 0.875rem;
            color: var(--slate);
        }
        .form-group {
            margin-bottom: 1.35rem;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #E2E8F0;
            margin-bottom: 0.5rem;
        }
        .input-wrapper {
            position: relative;
        }
        .form-control {
            width: 100%;
            background: rgba(3, 7, 18, 0.65);
            border: 1px solid rgba(148, 163, 184, 0.25);
            border-radius: 0.65rem;
            padding: 0.8rem 1rem;
            color: #F8FAFC;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-sizing: border-box;
            outline: none;
        }
        .form-control:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.15);
            background: rgba(3, 7, 18, 0.9);
        }
        .password-toggle {
            position: absolute;
            right: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--slate);
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .password-toggle:hover {
            color: var(--cyan);
        }
        .btn-submit {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.85rem 1.25rem;
            border-radius: 0.65rem;
            background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%);
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);
            transition: all 0.2s ease;
            margin-top: 1rem;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.5);
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #FCA5A5;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .alert-success {
            background: rgba(52, 211, 153, 0.12);
            border: 1px solid rgba(52, 211, 153, 0.3);
            color: #6EE7B7;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
        .login-footer {
            margin-top: 1.75rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(148, 163, 184, 0.12);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--slate);
        }
        .login-footer a {
            color: var(--cyan);
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .credential-helper {
            background: rgba(56, 189, 248, 0.06);
            border: 1px dashed rgba(56, 189, 248, 0.25);
            border-radius: 0.5rem;
            padding: 0.65rem 0.85rem;
            margin-top: 1.25rem;
            font-size: 0.775rem;
            color: #94A3B8;
            line-height: 1.5;
        }
        .credential-helper code {
            color: #38BDF8;
            font-family: var(--font-mono);
            background: rgba(15, 23, 42, 0.6);
            padding: 0.1rem 0.35rem;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="brand-badge">
            <span style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#22D3EE;"></span>
            CodeX404 Engineering
        </div>
        <h1 class="login-title">Admin Sign In</h1>
        <p class="login-subtitle">Project Showcase & Work Portfolio Management</p>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert-<?= htmlspecialchars($flash['type']) ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert-error" role="alert">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= admin_url('login.php' . (!empty($_GET['return']) ? '?return=' . urlencode($_GET['return']) : '')) ?>" autocomplete="off">
        <?= csrf_input_field() ?>

        <div class="form-group">
            <label class="form-label" for="username">Admin Username</label>
            <div class="input-wrapper">
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-control" 
                    value="<?= htmlspecialchars($usernameVal) ?>" 
                    required 
                    autofocus
                    placeholder="admin">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrapper">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required 
                    placeholder="Enter admin password">
                <button type="button" class="password-toggle" id="togglePassBtn" aria-label="Toggle password visibility">
                    <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <span>Sign In to Admin Panel</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
    </form>

    <div class="login-footer">
        <a href="<?= url('index.php') ?>">← Return to Live Website</a>
        <span>&copy; <?= date('Y') ?> CodeX404</span>
    </div>
</div>

<script>
document.getElementById('togglePassBtn').addEventListener('click', function() {
    const passInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    if (passInput.type === 'password') {
        passInput.type = 'text';
        eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
    } else {
        passInput.type = 'password';
        eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
    }
});
</script>

</body>
</html>
