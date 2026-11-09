<?php
declare(strict_types=1);

require_once __DIR__ . '/Env.php';
CRMEnv::load(dirname(__DIR__) . '/.env');

define('CRM_ROOT', dirname(__DIR__));
define('CRM_STORAGE_PATH', CRM_ROOT . '/storage');

define('CRM_WEBHOOK_SECRET', CRMEnv::get('CRM_WEBHOOK_SECRET', ''));
define('CRM_WEBHOOK_ALLOWED_IPS', CRMEnv::get('CRM_WEBHOOK_ALLOWED_IPS', ''));
define('CRM_ADMIN_EMAIL', CRMEnv::get('CRM_ADMIN_EMAIL', ''));
define('CRM_ADMIN_PASSWORD_HASH', CRMEnv::get('CRM_ADMIN_PASSWORD_HASH', ''));
