<?php
declare(strict_types=1);

/**
 * CodeX404 CRM — Live Exchange Rates API Endpoint
 * Provides real-time currency exchange rates for CRM & Website Frontends
 */

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: public, max-age=3600');

$crmRoot = dirname(__DIR__, 2);
require_once $crmRoot . '/app/Services/StorageService.php';
require_once $crmRoot . '/app/Services/CurrencyService.php';

use CRM\Services\StorageService;
use CRM\Services\CurrencyService;

StorageService::init($crmRoot . '/storage');
$rates = CurrencyService::getRates();

echo json_encode([
    'result' => 'success',
    'base' => 'USD',
    'timestamp' => time(),
    'currencies' => CurrencyService::CURRENCIES,
    'rates' => $rates
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
