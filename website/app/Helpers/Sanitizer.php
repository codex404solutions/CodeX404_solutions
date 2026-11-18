<?php
declare(strict_types=1);

namespace App\Helpers;

class Sanitizer {
    /**
     * Clean and escape single-line or multi-line text with length restriction and null-byte stripping.
     */
    public static function cleanString(mixed $val, int $maxLength = 5000): string {
        if (!is_string($val)) {
            return '';
        }
        $stripped = str_replace("\0", '', $val);
        $escaped = trim(htmlspecialchars(strip_tags($stripped), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
        return mb_substr($escaped, 0, $maxLength, 'UTF-8');
    }

    /**
     * Sanitize and format email addresses up to RFC maximum length (254 characters).
     */
    public static function cleanEmail(mixed $val, int $maxLength = 254): string {
        if (!is_string($val)) {
            return '';
        }
        $stripped = str_replace(["\0", "\r", "\n"], '', trim($val));
        $clean = filter_var($stripped, FILTER_SANITIZE_EMAIL);
        if (!is_string($clean)) {
            return '';
        }
        return mb_substr(strtolower($clean), 0, $maxLength, 'UTF-8');
    }

    /**
     * Sanitize phone numbers, retaining only valid dialing characters.
     */
    public static function cleanPhone(mixed $val, int $maxLength = 30): string {
        if (!is_string($val)) {
            return '';
        }
        $stripped = str_replace("\0", '', trim($val));
        $clean = preg_replace('/[^0-9+\s\-().]/', '', $stripped) ?? '';
        $clean = trim((string)preg_replace('/\s+/', ' ', $clean));
        return mb_substr($clean, 0, $maxLength, 'UTF-8');
    }

    /**
     * Clean alphanumeric identifier or slug.
     */
    public static function cleanAlphanumeric(?string $val, int $maxLength = 100): string {
        if ($val === null) {
            return '';
        }
        $clean = preg_replace('/[^a-zA-Z0-9_\-]/', '', trim($val)) ?? '';
        return mb_substr($clean, 0, $maxLength, 'UTF-8');
    }
}
