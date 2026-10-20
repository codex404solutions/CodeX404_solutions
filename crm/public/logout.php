<?php
declare(strict_types=1);

namespace CRM;

require_once dirname(__DIR__) . '/app/Services/AuthService.php';
\CRM\Services\AuthService::startSession();
\CRM\Services\AuthService::logout();
header('Location: login.php');
exit;
