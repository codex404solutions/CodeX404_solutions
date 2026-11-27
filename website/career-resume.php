<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/config/Env.php';
Env::load(__DIR__ . '/.env');

use App\Careers\ApplicationService;
use App\Careers\CareersDB;
use App\Careers\FileStorageService;
use App\Careers\RecruitmentAuthService;

try {
    $applicant = RecruitmentAuthService::requireApplicantAuth();
    $appId = (int)($_GET['application_id'] ?? 0);

    // Strictly enforce ownership: applicant can only download files from THEIR OWN application
    $app = $appId > 0 ? ApplicationService::getApplicantApplicationByRef((int)$applicant['id'], (string)$appId) : null;
} catch (\Throwable $e) {
    CareersDB::logError($e, 'career-resume');
    http_response_code(503);
    exit('Resume service is temporarily unavailable.');
}
if (!$app || empty($app['resume_path'])) {
    http_response_code(403);
    exit('Access denied or resume unavailable.');
}

FileStorageService::streamProtectedFile(
    (string)$app['resume_path'],
    (string)($app['resume_original_name'] ?: $app['reference_code'] . '_Resume.pdf'),
    $app['resume_mime'] ?? null
);
