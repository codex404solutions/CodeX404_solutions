<?php
declare(strict_types=1);

namespace App\Careers;

use Database;
use PDO;

require_once dirname(__DIR__, 2) . '/config/database.php';

/**
 * Shared database, reference code, status pipeline, and sanitization helpers for the Careers system.
 */
final class CareersDB
{
    public const PIPELINE_STATUSES = [
        'new'                 => ['label' => 'New',                 'badge' => 'info',      'step' => 1],
        'under_review'        => ['label' => 'Under Review',        'badge' => 'primary',   'step' => 2],
        'shortlisted'         => ['label' => 'Shortlisted',         'badge' => 'warning',   'step' => 3],
        'interview_scheduled' => ['label' => 'Interview Scheduled', 'badge' => 'cyan',      'step' => 4],
        'selected'            => ['label' => 'Selected',            'badge' => 'success',   'step' => 5],
        'offer_sent'          => ['label' => 'Offer Sent',          'badge' => 'success',   'step' => 6],
        'hired'               => ['label' => 'Hired',               'badge' => 'success',   'step' => 7],
        'rejected'            => ['label' => 'Rejected',            'badge' => 'danger',    'step' => 0],
        'withdrawn'           => ['label' => 'Withdrawn',           'badge' => 'secondary', 'step' => 0],
    ];

    public const JOB_STATUSES = [
        'draft'     => ['label' => 'Draft',     'badge' => 'secondary'],
        'scheduled' => ['label' => 'Scheduled', 'badge' => 'info'],
        'published' => ['label' => 'Published', 'badge' => 'success'],
        'closed'    => ['label' => 'Closed',    'badge' => 'warning'],
        'archived'  => ['label' => 'Archived',  'badge' => 'dark'],
    ];

    public const FIELD_TYPES = [
        'short_text' => 'Short Text',
        'long_text'  => 'Long Text (Textarea)',
        'email'      => 'Email',
        'phone'      => 'Phone',
        'number'     => 'Number',
        'dropdown'   => 'Dropdown Select',
        'radio'      => 'Radio Buttons',
        'checkbox'   => 'Checkboxes',
        'file'       => 'File Upload',
        'date'       => 'Date',
        'url'        => 'URL / Link',
    ];

    public static function pdo(): PDO
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            throw new \RuntimeException('MySQL database connection unavailable for Careers system.');
        }
        return $pdo;
    }

    public static function hashIp(?string $ip = null): string
    {
        $raw = $ip ?? (function_exists('get_client_ip') ? get_client_ip() : ($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'));
        $salt = (string)\Env::get('CRM_WEBHOOK_SECRET', 'codex404_salt');
        return hash_hmac('sha256', $raw, $salt);
    }

    public static function slugify(string $value): string
    {
        $slug = strtolower(trim($value));
        $slug = (string)preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug !== '' ? $slug : 'item-' . bin2hex(random_bytes(3));
    }

    public static function generateReferenceCode(PDO $pdo, bool $isGeneral = false): string
    {
        $prefix = $isGeneral ? 'CX-TP-' : 'CX-' . date('Y') . '-';
        for ($i = 0; $i < 10; $i++) {
            $suffix = strtoupper(bin2hex(random_bytes(3)));
            $candidate = $prefix . $suffix;
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `applications` WHERE `reference_code` = ?");
            $stmt->execute([$candidate]);
            if ((int)$stmt->fetchColumn() === 0) {
                return $candidate;
            }
        }
        return $prefix . strtoupper(dechex(time()));
    }

    /**
     * Neutralize spreadsheet formula triggers on CSV exports.
     */
    public static function csvCell(?string $val): string
    {
        $str = (string)($val ?? '');
        if ($str !== '' && preg_match('/^[=+\-@\t\r]/', $str)) {
            return "'" . $str;
        }
        return $str;
    }
}
