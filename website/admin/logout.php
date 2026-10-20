<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

admin_logout();
set_admin_flash('info', 'You have been successfully signed out.');
header('Location: ' . admin_url('login.php'));
exit;
