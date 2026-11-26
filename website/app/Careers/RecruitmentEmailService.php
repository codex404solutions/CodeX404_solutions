<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Editable template engine, SMTP/mail transport, and DB email logging.
 */
final class RecruitmentEmailService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function listTemplates(): array
    {
        $pdo = CareersDB::pdo();
        return $pdo->query("SELECT * FROM `email_templates` ORDER BY `id` ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTemplate(string $key): ?array
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("SELECT * FROM `email_templates` WHERE `template_key` = ? LIMIT 1");
        $stmt->execute([$key]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function updateTemplate(int $id, string $subject, string $bodyHtml, string $bodyText, bool $isActive, string $actorName): void
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            UPDATE `email_templates`
            SET `subject` = ?, `body_html` = ?, `body_text` = ?, `is_active` = ?, `updated_by` = ?
            WHERE `id` = ?
        ");
        $stmt->execute([trim($subject), trim($bodyHtml), trim($bodyText), $isActive ? 1 : 0, $actorName, $id]);
        ActivityLogService::log('admin', $actorName, $actorName, 'email.template_updated', 'email_template', (string)$id, "Updated email template #{$id}");
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function listLogs(int $limit = 100): array
    {
        $pdo = CareersDB::pdo();
        $limit = max(1, min(300, $limit));
        return $pdo->query("SELECT * FROM `email_logs` ORDER BY `id` DESC LIMIT {$limit}")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Replace template placeholders safely.
     * Supports {{candidate_name}}, {{job_title}}, {{application_id}}, {{company_name}}, {{interview_date}}, {{recruiter_name}}, etc.
     */
    public static function renderPlaceholders(string $template, array $vars, bool $escapeHtml = false): string
    {
        $defaults = [
            'company_name'   => RecruitmentSettingsService::getString('company_name', 'CodeX404 Solutions'),
            'recruiter_name' => RecruitmentSettingsService::getString('sender_name', 'CodeX404 Recruitment Team'),
            'portal_url'     => function_exists('url') ? url('careers/candidate-portal') : '/careers/candidate-portal',
            'candidate_name' => 'Candidate',
            'job_title'      => 'Open Position',
            'application_id' => 'N/A',
            'interview_date' => 'To Be Confirmed',
            'interview_link' => '',
            'otp_code'       => '',
        ];
        $merged = array_merge($defaults, $vars);

        return (string)preg_replace_callback('/\{\{\s*([a-z0-9_]+)\s*\}\}/i', function (array $m) use ($merged, $escapeHtml): string {
            $k = strtolower($m[1]);
            $val = (string)($merged[$k] ?? '');
            return $escapeHtml ? htmlspecialchars($val, ENT_QUOTES, 'UTF-8') : $val;
        }, $template);
    }

    /**
     * Dispatch a templated recruitment email and log the delivery record in email_logs.
     *
     * @return array{ok:bool, transport:string, status:string, error:?string}
     */
    public static function sendTemplate(
        string $templateKey,
        string $toEmail,
        string $toName,
        array $vars = [],
        ?int $applicationId = null,
        ?int $candidateId = null,
        ?string $sentBy = 'system'
    ): array {
        $tpl = self::getTemplate($templateKey);
        if (!$tpl || empty($tpl['is_active'])) {
            return ['ok' => false, 'transport' => 'local_log', 'status' => 'failed', 'error' => 'Template missing or inactive'];
        }

        $subject = self::renderPlaceholders((string)$tpl['subject'], $vars, false);
        $bodyHtml = self::renderPlaceholders((string)$tpl['body_html'], $vars, true);
        $bodyText = self::renderPlaceholders((string)$tpl['body_text'], $vars, false);

        return self::sendRaw($toEmail, $toName, $subject, $bodyHtml, $bodyText, $templateKey, $applicationId, $candidateId, $sentBy);
    }

    /**
     * Send email via SMTP if credentials exist, PHP mail() on production, or structured local log otherwise.
     */
    public static function sendRaw(
        string $toEmail,
        string $toName,
        string $subject,
        string $bodyHtml,
        string $bodyText,
        ?string $templateKey = null,
        ?int $applicationId = null,
        ?int $candidateId = null,
        ?string $sentBy = 'system'
    ): array {
        $cleanTo = strtolower(trim($toEmail));
        $fromEmail = RecruitmentSettingsService::getString('sender_email', (string)\Env::get('MAIL_USERNAME', 'info@codex404solutions.com'));
        $fromName = RecruitmentSettingsService::getString('sender_name', 'CodeX404 Recruitment Team');

        $smtpHost = (string)\Env::get('MAIL_HOST', '');
        $smtpPort = (int)\Env::get('MAIL_PORT', '587');
        $smtpUser = (string)\Env::get('MAIL_USERNAME', '');
        $smtpPass = (string)\Env::get('MAIL_PASSWORD', '');
        $smtpEnc  = strtolower((string)\Env::get('MAIL_ENCRYPTION', 'tls'));

        $transport = 'local_log';
        $status = 'simulated_local';
        $errorMsg = null;

        if ($smtpHost !== '' && $smtpUser !== '' && $smtpPass !== '') {
            $transport = 'smtp';
            try {
                self::smtpSend($smtpHost, $smtpPort, $smtpUser, $smtpPass, $smtpEnc, $fromEmail, $fromName, $cleanTo, $toName, $subject, $bodyHtml, $bodyText);
                $status = 'sent';
            } catch (\Throwable $e) {
                $status = 'failed';
                $errorMsg = $e->getMessage();
            }
        } elseif (defined('ENVIRONMENT') && ENVIRONMENT === 'production' && function_exists('mail')) {
            $transport = 'php_mail';
            $headers = [
                'MIME-Version: 1.0',
                'Content-Type: text/html; charset=UTF-8',
                'From: ' . self::encodeHeaderName($fromName) . " <{$fromEmail}>",
                'Reply-To: ' . $fromEmail,
            ];
            $ok = @mail($cleanTo, $subject, $bodyHtml, implode("\r\n", $headers));
            $status = $ok ? 'sent' : 'failed';
            if (!$ok) {
                $errorMsg = 'PHP mail() returned false';
            }
        } else {
            // Dev/local environment without SMTP password: record safely in app log (mask OTP codes!)
            $maskedText = preg_replace('/\b\d{6}\b/', '******', $bodyText);
            if (defined('LOGS_PATH') && is_dir(LOGS_PATH)) {
                @file_put_contents(
                    LOGS_PATH . '/careers_mail.log',
                    sprintf("[%s] TO=%s TEMPLATE=%s SUBJECT=%s\n%s\n---\n", date('c'), $cleanTo, $templateKey ?? 'custom', $subject, (string)$maskedText),
                    FILE_APPEND | LOCK_EX
                );
            }
        }

        // Persist delivery log in MySQL (never log plain 6-digit OTPs in email_logs)
        $safePreview = (string)preg_replace('/\b\d{6}\b/', '[OTP-REDACTED]', strip_tags($bodyText ?: $bodyHtml));
        $safePreview = mb_substr($safePreview, 0, 500);

        try {
            $pdo = CareersDB::pdo();
            $stmt = $pdo->prepare("
                INSERT INTO `email_logs`
                    (`template_key`, `application_id`, `candidate_id`, `recipient_email`, `recipient_name`, `subject`, `body_preview`, `transport`, `status`, `error_message`, `sent_by`)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $templateKey,
                $applicationId,
                $candidateId,
                $cleanTo,
                substr($toName, 0, 160),
                substr($subject, 0, 220),
                $safePreview,
                $transport,
                $status,
                $errorMsg,
                $sentBy,
            ]);
        } catch (\Throwable $e) {
            error_log('Careers email log write failure: ' . $e->getMessage());
        }

        return [
            'ok'        => $status !== 'failed',
            'transport' => $transport,
            'status'    => $status,
            'error'     => $errorMsg,
        ];
    }

    private static function encodeHeaderName(string $name): string
    {
        $clean = str_replace(["\r", "\n"], '', trim($name));
        return '"' . addcslashes($clean, '"\\') . '"';
    }

    /**
     * Minimal zero-dependency RFC-5321 SMTP socket sender with STARTTLS / SMTPS AUTH LOGIN support.
     */
    private static function smtpSend(
        string $host,
        int $port,
        string $username,
        string $password,
        string $encryption,
        string $fromEmail,
        string $fromName,
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlBody,
        string $textBody
    ): void {
        $scheme = $encryption === 'ssl' ? 'ssl://' : '';
        $ctx = stream_context_create([
            'ssl' => ['verify_peer' => true, 'verify_peer_name' => true, 'allow_self_signed' => false],
        ]);
        $fp = @stream_socket_client($scheme . $host . ':' . $port, $errno, $errstr, 12, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) {
            throw new \RuntimeException("SMTP connect failed ({$errno}): {$errstr}");
        }

        try {
            self::expectSmtpCode($fp, 220);
            $ehloHost = $_SERVER['SERVER_NAME'] ?? 'localhost';
            self::writeSmtp($fp, "EHLO {$ehloHost}");
            self::expectSmtpCode($fp, 250);

            if ($encryption === 'tls') {
                self::writeSmtp($fp, 'STARTTLS');
                self::expectSmtpCode($fp, 220);
                if (!@stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT)) {
                    throw new \RuntimeException('Unable to negotiate STARTTLS.');
                }
                self::writeSmtp($fp, "EHLO {$ehloHost}");
                self::expectSmtpCode($fp, 250);
            }

            self::writeSmtp($fp, 'AUTH LOGIN');
            self::expectSmtpCode($fp, 334);
            self::writeSmtp($fp, base64_encode($username));
            self::expectSmtpCode($fp, 334);
            self::writeSmtp($fp, base64_encode($password));
            self::expectSmtpCode($fp, 235);

            self::writeSmtp($fp, "MAIL FROM:<{$fromEmail}>");
            self::expectSmtpCode($fp, 250);
            self::writeSmtp($fp, "RCPT TO:<{$toEmail}>");
            self::expectSmtpCode($fp, 250);
            self::writeSmtp($fp, 'DATA');
            self::expectSmtpCode($fp, 354);

            $boundary = 'bnd_' . bin2hex(random_bytes(12));
            $safeSubject = '=?UTF-8?B?' . base64_encode(str_replace(["\r", "\n"], '', $subject)) . '?=';
            $headers = [
                'Date: ' . date('r'),
                'From: ' . self::encodeHeaderName($fromName) . " <{$fromEmail}>",
                'To: ' . self::encodeHeaderName($toName ?: $toEmail) . " <{$toEmail}>",
                "Subject: {$safeSubject}",
                'MIME-Version: 1.0',
                "Content-Type: multipart/alternative; boundary=\"{$boundary}\"",
            ];
            $message = implode("\r\n", $headers) . "\r\n\r\n"
                . "--{$boundary}\r\n"
                . "Content-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
                . chunk_split(base64_encode($textBody)) . "\r\n"
                . "--{$boundary}\r\n"
                . "Content-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: base64\r\n\r\n"
                . chunk_split(base64_encode($htmlBody)) . "\r\n"
                . "--{$boundary}--\r\n.";

            self::writeSmtp($fp, $message);
            self::expectSmtpCode($fp, 250);
            self::writeSmtp($fp, 'QUIT');
        } finally {
            fclose($fp);
        }
    }

    private static function writeSmtp($fp, string $cmd): void
    {
        fwrite($fp, $cmd . "\r\n");
    }

    private static function expectSmtpCode($fp, int $expected): void
    {
        $response = '';
        while (($line = fgets($fp, 515)) !== false) {
            $response .= $line;
            if (strlen($line) < 4 || $line[3] === ' ') {
                break;
            }
        }
        $code = (int)substr($response, 0, 3);
        if ($code !== $expected) {
            throw new \RuntimeException("SMTP expected {$expected}, got {$code}: " . trim($response));
        }
    }
}
