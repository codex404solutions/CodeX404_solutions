<?php
declare(strict_types=1);

namespace App\Helpers;

class Sanitizer {
    public static function cleanString(?string $val): string {
        if ($val === null) return '';
        return trim(htmlspecialchars(strip_tags($val), ENT_QUOTES, 'UTF-8'));
    }

    public static function cleanEmail(?string $val): string {
        if ($val === null) return '';
        $clean = filter_var(trim($val), FILTER_SANITIZE_EMAIL);
        return is_string($clean) ? $clean : '';
    }

    public static function cleanPhone(?string $val): string {
        if ($val === null) return '';
        return preg_replace('/[^0-9+\s\-()]/', '', trim($val));
    }
}
