<?php
declare(strict_types=1);

namespace App\Careers;

/**
 * Handles private candidate document storage (resumes/CVs & attachment fields) outside public web paths.
 */
final class FileStorageService
{
    private const ALLOWED_MIME_MAP = [
        'pdf'  => ['application/pdf'],
        'doc'  => ['application/msword', 'application/octet-stream', 'application/CDFV2'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/octet-stream'],
        'png'  => ['image/png'],
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
    ];

    public static function getBaseStorageDir(): string
    {
        $base = defined('STORAGE_PATH') ? STORAGE_PATH : dirname(__DIR__, 2) . '/storage';
        $dir = rtrim($base, '/\\') . '/careers/resumes';
        if (!is_dir($dir)) {
            @mkdir($dir, 0750, true);
        }
        $careersRoot = rtrim($base, '/\\') . '/careers';
        $htaccess = $careersRoot . '/.htaccess';
        if (!file_exists($htaccess)) {
            @file_put_contents($htaccess, "Order deny,allow\nDeny from all\n<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n");
        }
        return $dir;
    }

    /**
     * Validate and store an uploaded file safely into private storage.
     *
     * @param array<string, mixed> $file $_FILES[$key] entry
     * @param array<int, string> $allowedExts
     * @return array{relative_path:string, original_name:string, mime:string, size_bytes:int}
     */
    public static function storeUploadedFile(array $file, array $allowedExts = [], int $maxMb = 0): array
    {
        $err = (int)($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($err !== UPLOAD_ERR_OK) {
            $msg = match ($err) {
                UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Uploaded file exceeds the allowed size limit.',
                UPLOAD_ERR_NO_FILE => 'Please attach the required file.',
                default => 'File upload failed. Please try again.',
            };
            throw new \RuntimeException($msg);
        }

        $tmpPath = (string)($file['tmp_name'] ?? '');
        if ($tmpPath === '' || !file_exists($tmpPath)) {
            throw new \RuntimeException('Temporary uploaded file is missing.');
        }

        if ($maxMb <= 0) {
            $maxMb = max(1, RecruitmentSettingsService::getInt('max_resume_mb', 5));
        }
        $maxBytes = $maxMb * 1024 * 1024;
        $size = (int)($file['size'] ?? filesize($tmpPath));
        if ($size <= 0 || $size > $maxBytes) {
            throw new \RuntimeException("File size must be between 1 byte and {$maxMb} MB.");
        }

        if (empty($allowedExts)) {
            $cfgExts = RecruitmentSettingsService::getString('allowed_resume_exts', 'pdf,doc,docx');
            $allowedExts = array_values(array_filter(array_map('trim', explode(',', strtolower($cfgExts)))));
        } else {
            $allowedExts = array_values(array_filter(array_map('strtolower', $allowedExts)));
        }

        $originalName = basename((string)($file['name'] ?? 'document'));
        $originalName = (string)preg_replace('/[^a-zA-Z0-9._ -]/', '_', $originalName);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        if ($ext === '' || !in_array($ext, $allowedExts, true) || !isset(self::ALLOWED_MIME_MAP[$ext])) {
            throw new \RuntimeException('Unsupported file format. Allowed formats: ' . strtoupper(implode(', ', $allowedExts)));
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = $finfo ? (string)finfo_file($finfo, $tmpPath) : '';
        if ($finfo) {
            finfo_close($finfo);
        }

        if ($detectedMime !== '' && !in_array($detectedMime, self::ALLOWED_MIME_MAP[$ext], true)) {
            throw new \RuntimeException("Uploaded file content ({$detectedMime}) does not match .{$ext} file signature.");
        }

        // Check file magic signature for strict PDF / DOC / DOCX safety
        $headerBytes = (string)@file_get_contents($tmpPath, false, null, 0, 8);
        if ($ext === 'pdf' && !str_starts_with($headerBytes, '%PDF-')) {
            throw new \RuntimeException('Invalid PDF signature.');
        }
        if ($ext === 'docx' && !str_starts_with($headerBytes, "PK\x03\x04")) {
            throw new \RuntimeException('Invalid DOCX archive signature.');
        }

        $baseDir = self::getBaseStorageDir();
        $subDir = date('Y-m');
        $targetDir = $baseDir . '/' . $subDir;
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0750, true);
        }

        $safeBase = (string)preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
        $safeBase = trim(substr($safeBase, 0, 50), '_') ?: 'resume';
        $storedFilename = bin2hex(random_bytes(12)) . '_' . $safeBase . '.' . $ext;
        $targetPath = $targetDir . '/' . $storedFilename;

        $moved = is_uploaded_file($tmpPath)
            ? @move_uploaded_file($tmpPath, $targetPath)
            : @rename($tmpPath, $targetPath);
        if (!$moved) {
            if (!@copy($tmpPath, $targetPath)) {
                throw new \RuntimeException('Unable to persist uploaded document into private storage.');
            }
            @unlink($tmpPath);
        }
        @chmod($targetPath, 0640);

        return [
            'relative_path' => $subDir . '/' . $storedFilename,
            'original_name' => $originalName,
            'mime'          => $detectedMime ?: 'application/octet-stream',
            'size_bytes'    => $size,
        ];
    }

    /**
     * Resolve relative storage path cleanly preventing directory traversal outside private resume folder.
     */
    public static function resolveSafePath(string $relativePath): ?string
    {
        $clean = str_replace(['\\', "\0"], ['/', ''], ltrim($relativePath, '/\\'));
        if ($clean === '' || str_contains($clean, '..')) {
            return null;
        }
        $baseDir = realpath(self::getBaseStorageDir());
        if ($baseDir === false) {
            return null;
        }
        $fullPath = realpath($baseDir . DIRECTORY_SEPARATOR . $clean);
        if ($fullPath === false || !str_starts_with($fullPath, $baseDir . DIRECTORY_SEPARATOR)) {
            return null;
        }
        return is_file($fullPath) ? $fullPath : null;
    }

    public static function streamProtectedFile(string $relativePath, string $downloadName, ?string $mime = null): void
    {
        $fullPath = self::resolveSafePath($relativePath);
        if (!$fullPath) {
            http_response_code(404);
            exit('Requested document could not be found.');
        }

        $safeName = preg_replace('/[^a-zA-Z0-9._ -]/', '_', basename($downloadName)) ?: basename($fullPath);
        $contentType = $mime && str_contains($mime, '/') ? $mime : 'application/octet-stream';

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: attachment; filename="' . $safeName . '"');
        header('Content-Length: ' . (string)filesize($fullPath));
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, no-store, max-age=0');
        readfile($fullPath);
        exit;
    }
}
