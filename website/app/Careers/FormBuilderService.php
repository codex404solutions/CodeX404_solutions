<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Reusable Dynamic Application Form Builder & Validation Engine supporting 11 field types.
 */
final class FormBuilderService
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function listTemplates(): array
    {
        $pdo = CareersDB::pdo();
        return $pdo->query("
            SELECT t.*,
                   (SELECT COUNT(*) FROM `application_form_fields` f WHERE f.template_id = t.id AND f.is_enabled = 1) AS active_field_count
            FROM `application_form_templates` t
            ORDER BY t.id ASC
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createTemplate(string $name, string $type, string $description, string $actorId, string $actorName, ?int $cloneFromId = null): int
    {
        $pdo = CareersDB::pdo();
        $cleanName = trim($name);
        if ($cleanName === '') {
            throw new \InvalidArgumentException('Template name is required.');
        }
        $slug = CareersDB::slugify($cleanName);
        $base = $slug;
        $n = 2;
        while (true) {
            $c = $pdo->prepare("SELECT COUNT(*) FROM `application_form_templates` WHERE `slug` = ?");
            $c->execute([$slug]);
            if ((int)$c->fetchColumn() === 0) {
                break;
            }
            $slug = $base . '-' . $n++;
        }

        $allowedType = in_array($type, ['default', 'marketing', 'sales', 'internship', 'fellowship', 'custom'], true) ? $type : 'custom';
        $ins = $pdo->prepare("
            INSERT INTO `application_form_templates` (`slug`, `name`, `template_type`, `description`, `is_system`, `is_active`, `created_by`)
            VALUES (?, ?, ?, ?, 0, 1, ?)
        ");
        $ins->execute([$slug, $cleanName, $allowedType, trim($description), $actorId]);
        $newId = (int)$pdo->lastInsertId();

        if ($cloneFromId && $cloneFromId > 0) {
            $srcFields = self::getFieldsByTemplate($cloneFromId, false);
            foreach ($srcFields as $f) {
                self::saveField([
                    'template_id'      => $newId,
                    'field_key'        => $f['field_key'],
                    'label'            => $f['label'],
                    'field_type'       => $f['field_type'],
                    'placeholder'      => $f['placeholder'],
                    'help_text'        => $f['help_text'],
                    'options_raw'      => implode("\n", $f['options']),
                    'validation_rules' => $f['validation_rules'],
                    'is_required'      => $f['is_required'],
                    'is_enabled'       => $f['is_enabled'],
                    'is_system_core'   => $f['is_system_core'],
                    'step_section'     => $f['step_section'],
                    'width_col'        => $f['width_col'],
                    'sort_order'       => $f['sort_order'],
                ], $actorId, $actorName);
            }
        }

        ActivityLogService::log('admin', $actorId, $actorName, 'form.template_created', 'form_template', (string)$newId, "Created form template '{$cleanName}'");
        return $newId;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getFieldsByTemplate(int $templateId, bool $onlyEnabled = true): array
    {
        $pdo = CareersDB::pdo();
        $sql = "SELECT * FROM `application_form_fields` WHERE `template_id` = ?";
        if ($onlyEnabled) {
            $sql .= " AND `is_enabled` = 1";
        }
        $sql .= " ORDER BY `sort_order` ASC, `id` ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$templateId]);
        return self::hydrateFields($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function getFieldsByJob(int $jobId, bool $onlyEnabled = true): array
    {
        $pdo = CareersDB::pdo();
        $sql = "SELECT * FROM `application_form_fields` WHERE `job_opening_id` = ?";
        if ($onlyEnabled) {
            $sql .= " AND `is_enabled` = 1";
        }
        $sql .= " ORDER BY `sort_order` ASC, `id` ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$jobId]);
        return self::hydrateFields($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Resolve effective active fields for a vacancy (or General Talent Pool when $job === null).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getEffectiveFields(?array $job): array
    {
        if ($job === null) {
            $pdo = CareersDB::pdo();
            $defaultId = (int)$pdo->query("SELECT `id` FROM `application_form_templates` WHERE `slug` = 'default' LIMIT 1")->fetchColumn();
            return $defaultId > 0 ? self::getFieldsByTemplate($defaultId, true) : [];
        }

        $jobId = (int)$job['id'];
        if (!empty($job['use_custom_form'])) {
            $jobFields = self::getFieldsByJob($jobId, true);
            if (!empty($jobFields)) {
                return $jobFields;
            }
        }

        $tplId = (int)($job['form_template_id'] ?? 0);
        if ($tplId <= 0) {
            $pdo = CareersDB::pdo();
            $tplId = (int)$pdo->query("SELECT `id` FROM `application_form_templates` WHERE `slug` = 'default' LIMIT 1")->fetchColumn();
        }
        return $tplId > 0 ? self::getFieldsByTemplate($tplId, true) : [];
    }

    public static function ensureJobHasCustomFieldsFromTemplate(int $jobId, int $templateId): void
    {
        $existing = self::getFieldsByJob($jobId, false);
        if (!empty($existing)) {
            return;
        }
        $src = self::getFieldsByTemplate($templateId, false);
        $pdo = CareersDB::pdo();
        $ins = $pdo->prepare("
            INSERT INTO `application_form_fields`
                (`template_id`, `job_opening_id`, `field_key`, `label`, `field_type`, `placeholder`, `help_text`, `default_value`, `options_json`, `validation_rules_json`, `is_required`, `is_enabled`, `is_system_core`, `step_section`, `width_col`, `sort_order`)
            VALUES
                (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        foreach ($src as $f) {
            $ins->execute([
                $jobId, $f['field_key'], $f['label'], $f['field_type'], $f['placeholder'], $f['help_text'],
                $f['default_value'], $f['options_json'], $f['validation_rules_json'],
                $f['is_required'], $f['is_enabled'], $f['is_system_core'], $f['step_section'], $f['width_col'], $f['sort_order'],
            ]);
        }
    }

    public static function copyJobFields(int $fromJobId, int $toJobId): void
    {
        $src = self::getFieldsByJob($fromJobId, false);
        if (empty($src)) {
            return;
        }
        $pdo = CareersDB::pdo();
        $ins = $pdo->prepare("
            INSERT INTO `application_form_fields`
                (`template_id`, `job_opening_id`, `field_key`, `label`, `field_type`, `placeholder`, `help_text`, `default_value`, `options_json`, `validation_rules_json`, `is_required`, `is_enabled`, `is_system_core`, `step_section`, `width_col`, `sort_order`)
            VALUES
                (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        foreach ($src as $f) {
            $ins->execute([
                $toJobId, $f['field_key'], $f['label'], $f['field_type'], $f['placeholder'], $f['help_text'],
                $f['default_value'], $f['options_json'], $f['validation_rules_json'],
                $f['is_required'], $f['is_enabled'], $f['is_system_core'], $f['step_section'], $f['width_col'], $f['sort_order'],
            ]);
        }
    }

    public static function saveField(array $input, string $actorId, string $actorName): int
    {
        $pdo = CareersDB::pdo();
        $id = (int)($input['id'] ?? 0);
        $label = trim((string)($input['label'] ?? ''));
        if ($label === '') {
            throw new \InvalidArgumentException('Field label is required.');
        }

        $type = (string)($input['field_type'] ?? 'short_text');
        if (!isset(CareersDB::FIELD_TYPES[$type])) {
            throw new \InvalidArgumentException('Invalid field type: ' . $type);
        }

        $rawKey = trim((string)($input['field_key'] ?? ''));
        $fieldKey = preg_replace('/[^a-z0-9_]/', '_', strtolower($rawKey !== '' ? $rawKey : $label));
        $fieldKey = trim((string)$fieldKey, '_');
        if ($fieldKey === '') {
            $fieldKey = 'field_' . bin2hex(random_bytes(3));
        }

        $optionsRaw = trim((string)($input['options_raw'] ?? ''));
        $optionsArr = [];
        if ($optionsRaw !== '') {
            foreach (preg_split('/\R|,/', $optionsRaw) ?: [] as $opt) {
                $o = trim($opt);
                if ($o !== '') {
                    $optionsArr[] = $o;
                }
            }
        }
        $optionsJson = !empty($optionsArr) ? json_encode(array_values($optionsArr), JSON_UNESCAPED_UNICODE) : null;

        $rules = is_array($input['validation_rules'] ?? null) ? $input['validation_rules'] : [];
        if (isset($input['min_length']) && $input['min_length'] !== '') {
            $rules['min_length'] = (int)$input['min_length'];
        }
        if (isset($input['max_length']) && $input['max_length'] !== '') {
            $rules['max_length'] = (int)$input['max_length'];
        }
        if (isset($input['min_val']) && $input['min_val'] !== '') {
            $rules['min'] = (float)$input['min_val'];
        }
        if (isset($input['max_val']) && $input['max_val'] !== '') {
            $rules['max'] = (float)$input['max_val'];
        }
        $rulesJson = !empty($rules) ? json_encode($rules, JSON_UNESCAPED_UNICODE) : null;

        $templateId = !empty($input['template_id']) ? (int)$input['template_id'] : null;
        $jobId = !empty($input['job_opening_id']) ? (int)$input['job_opening_id'] : null;
        $isReq = !empty($input['is_required']) ? 1 : 0;
        $isEnabled = isset($input['is_enabled']) ? (!empty($input['is_enabled']) ? 1 : 0) : 1;
        $isCore = !empty($input['is_system_core']) ? 1 : 0;
        $stepSection = trim((string)($input['step_section'] ?? 'Application Details')) ?: 'Application Details';
        $widthCol = ($input['width_col'] ?? 'full') === 'half' ? 'half' : 'full';
        $sortOrder = (int)($input['sort_order'] ?? 100);
        $placeholder = trim((string)($input['placeholder'] ?? '')) ?: null;
        $helpText = trim((string)($input['help_text'] ?? '')) ?: null;

        if ($id > 0) {
            $stmt = $pdo->prepare("
                UPDATE `application_form_fields`
                SET `field_key` = ?, `label` = ?, `field_type` = ?, `placeholder` = ?, `help_text` = ?,
                    `options_json` = ?, `validation_rules_json` = ?, `is_required` = ?, `is_enabled` = ?,
                    `step_section` = ?, `width_col` = ?, `sort_order` = ?
                WHERE `id` = ?
            ");
            $stmt->execute([$fieldKey, $label, $type, $placeholder, $helpText, $optionsJson, $rulesJson, $isReq, $isEnabled, $stepSection, $widthCol, $sortOrder, $id]);
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO `application_form_fields`
                    (`template_id`, `job_opening_id`, `field_key`, `label`, `field_type`, `placeholder`, `help_text`, `options_json`, `validation_rules_json`, `is_required`, `is_enabled`, `is_system_core`, `step_section`, `width_col`, `sort_order`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$templateId, $jobId, $fieldKey, $label, $type, $placeholder, $helpText, $optionsJson, $rulesJson, $isReq, $isEnabled, $isCore, $stepSection, $widthCol, $sortOrder]);
            $id = (int)$pdo->lastInsertId();
        }

        ActivityLogService::log('admin', $actorId, $actorName, 'form.field_saved', 'form_field', (string)$id, "Saved form field '{$label}' ({$type})");
        return $id;
    }

    public static function deleteField(int $fieldId, string $actorId, string $actorName): void
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("SELECT `is_system_core`, `label` FROM `application_form_fields` WHERE `id` = ?");
        $stmt->execute([$fieldId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return;
        }
        if (!empty($row['is_system_core'])) {
            throw new \RuntimeException('Core system fields cannot be deleted (you can disable or edit their label).');
        }
        $pdo->prepare("DELETE FROM `application_form_fields` WHERE `id` = ?")->execute([$fieldId]);
        ActivityLogService::log('admin', $actorId, $actorName, 'form.field_deleted', 'form_field', (string)$fieldId, "Deleted custom form field '{$row['label']}'");
    }

    /**
     * Validate every dynamic form field strictly on the server before accepting an application.
     *
     * @return array{ok:bool, errors:array<string,string>, answers:array<string,mixed>, files:array<string,array<string,mixed>>}
     */
    public static function validateSubmission(array $fields, array $postData, array $filesData): array
    {
        $errors = [];
        $answers = [];
        $storedFiles = [];

        foreach ($fields as $field) {
            $key = (string)$field['field_key'];
            $label = (string)$field['label'];
            $type = (string)$field['field_type'];
            $required = !empty($field['is_required']);
            $options = $field['options'] ?? [];
            $rules = $field['validation_rules'] ?? [];

            if ($type === 'file') {
                $fileEntry = $filesData['fields']['name'][$key] ?? null;
                if ($fileEntry !== null) {
                    $singleFile = [
                        'name'     => $filesData['fields']['name'][$key] ?? '',
                        'type'     => $filesData['fields']['type'][$key] ?? '',
                        'tmp_name' => $filesData['fields']['tmp_name'][$key] ?? '',
                        'error'    => $filesData['fields']['error'][$key] ?? UPLOAD_ERR_NO_FILE,
                        'size'     => $filesData['fields']['size'][$key] ?? 0,
                    ];
                } elseif (isset($filesData[$key]) && is_array($filesData[$key])) {
                    $singleFile = $filesData[$key];
                } else {
                    $singleFile = ['error' => UPLOAD_ERR_NO_FILE];
                }

                $errCode = (int)($singleFile['error'] ?? UPLOAD_ERR_NO_FILE);
                if ($errCode === UPLOAD_ERR_NO_FILE) {
                    if ($required) {
                        $errors[$key] = "{$label} is required.";
                    }
                    continue;
                }

                try {
                    $allowedExts = isset($rules['allowed_exts']) && is_array($rules['allowed_exts']) ? $rules['allowed_exts'] : [];
                    $maxMb = isset($rules['max_mb']) ? (int)$rules['max_mb'] : 0;
                    $storedFiles[$key] = FileStorageService::storeUploadedFile($singleFile, $allowedExts, $maxMb);
                    $answers[$key] = $storedFiles[$key]['original_name'];
                } catch (\Throwable $e) {
                    $errors[$key] = $e->getMessage();
                }
                continue;
            }

            $raw = $postData['fields'][$key] ?? ($postData[$key] ?? null);

            if ($type === 'checkbox') {
                $selected = is_array($raw) ? array_values(array_filter(array_map('trim', $raw))) : ($raw !== null && $raw !== '' ? [trim((string)$raw)] : []);
                if (!empty($options)) {
                    $selected = array_values(array_intersect($selected, $options));
                }
                if ($required && empty($selected)) {
                    $errors[$key] = "Please complete {$label}.";
                } elseif (!empty($rules['require_all']) && count($selected) < count($options)) {
                    $errors[$key] = "All checkboxes under {$label} must be checked.";
                }
                $answers[$key] = $selected;
                continue;
            }

            $val = trim((string)($raw ?? ''));
            if ($val === '') {
                if ($required) {
                    $errors[$key] = "{$label} is required.";
                }
                $answers[$key] = '';
                continue;
            }

            switch ($type) {
                case 'email':
                    $val = strtolower($val);
                    if (!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                        $errors[$key] = "Please enter a valid email address for {$label}.";
                    }
                    break;
                case 'phone':
                    if (!preg_match('/^[0-9+()\-\s]{7,25}$/', $val)) {
                        $errors[$key] = "Please enter a valid phone number for {$label}.";
                    }
                    break;
                case 'number':
                    if (!is_numeric($val)) {
                        $errors[$key] = "{$label} must be a valid number.";
                    } else {
                        $num = (float)$val;
                        if (isset($rules['min']) && $num < (float)$rules['min']) {
                            $errors[$key] = "{$label} must be at least {$rules['min']}.";
                        }
                        if (isset($rules['max']) && $num > (float)$rules['max']) {
                            $errors[$key] = "{$label} cannot exceed {$rules['max']}.";
                        }
                    }
                    break;
                case 'url':
                    if (!filter_var($val, FILTER_VALIDATE_URL) || !preg_match('#^https?://#i', $val)) {
                        $errors[$key] = "Please enter a valid http/https URL for {$label}.";
                    }
                    break;
                case 'date':
                    $ts = strtotime($val);
                    if ($ts === false) {
                        $errors[$key] = "Please enter a valid date for {$label}.";
                    } else {
                        $val = date('Y-m-d', $ts);
                    }
                    break;
                case 'dropdown':
                case 'radio':
                    if (!empty($options) && !in_array($val, $options, true)) {
                        $errors[$key] = "Invalid selection for {$label}.";
                    }
                    break;
                case 'short_text':
                case 'long_text':
                default:
                    $len = mb_strlen($val);
                    if (isset($rules['min_length']) && $len < (int)$rules['min_length']) {
                        $errors[$key] = "{$label} must be at least {$rules['min_length']} characters.";
                    }
                    if (isset($rules['max_length']) && $len > (int)$rules['max_length']) {
                        $errors[$key] = "{$label} must not exceed {$rules['max_length']} characters.";
                    }
                    break;
            }

            $answers[$key] = $val;
        }

        return [
            'ok'      => empty($errors),
            'errors'  => $errors,
            'answers' => $answers,
            'files'   => $storedFiles,
        ];
    }

    /**
     * Render dynamic form fields grouped cleanly into sections for public application forms.
     */
    public static function renderFormSectionsHtml(array $fields, array $oldValues = [], array $errors = []): string
    {
        $grouped = [];
        foreach ($fields as $f) {
            $sec = (string)($f['step_section'] ?: 'Application Details');
            $grouped[$sec][] = $f;
        }

        $html = '';
        foreach ($grouped as $sectionName => $secFields) {
            $html .= '<div class="careers-form-section">';
            $html .= '<h4 class="careers-form-section-title">' . htmlspecialchars($sectionName, ENT_QUOTES, 'UTF-8') . '</h4>';
            $html .= '<div class="careers-form-grid">';

            foreach ($secFields as $f) {
                $key = (string)$f['field_key'];
                $idAttr = 'cf_' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                $nameAttr = 'fields[' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ']';
                $label = htmlspecialchars((string)$f['label'], ENT_QUOTES, 'UTF-8');
                $type = (string)$f['field_type'];
                $req = !empty($f['is_required']);
                $ph = htmlspecialchars((string)($f['placeholder'] ?? ''), ENT_QUOTES, 'UTF-8');
                $help = htmlspecialchars((string)($f['help_text'] ?? ''), ENT_QUOTES, 'UTF-8');
                $colClass = ($f['width_col'] ?? 'full') === 'half' ? 'careers-field-half' : 'careers-field-full';
                $err = $errors[$key] ?? '';
                $val = $oldValues[$key] ?? ($f['default_value'] ?? '');

                $html .= '<div class="careers-field ' . $colClass . ($err !== '' ? ' has-error' : '') . '">';
                if ($type !== 'checkbox') {
                    $html .= '<label class="careers-label" for="' . $idAttr . '">' . $label . ($req ? ' <span class="req-star">*</span>' : '') . '</label>';
                } else {
                    $html .= '<span class="careers-label">' . $label . ($req ? ' <span class="req-star">*</span>' : '') . '</span>';
                }

                $reqAttr = $req ? ' required' : '';
                switch ($type) {
                    case 'long_text':
                        $html .= '<textarea class="careers-input careers-textarea" id="' . $idAttr . '" name="' . $nameAttr . '" rows="4" placeholder="' . $ph . '"' . $reqAttr . '>' . htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8') . '</textarea>';
                        break;
                    case 'dropdown':
                        $html .= '<select class="careers-input" id="' . $idAttr . '" name="' . $nameAttr . '"' . $reqAttr . '>';
                        $html .= '<option value="">Select an option...</option>';
                        foreach ($f['options'] ?? [] as $opt) {
                            $sel = ((string)$val === (string)$opt) ? ' selected' : '';
                            $safeOpt = htmlspecialchars((string)$opt, ENT_QUOTES, 'UTF-8');
                            $html .= '<option value="' . $safeOpt . '"' . $sel . '>' . $safeOpt . '</option>';
                        }
                        $html .= '</select>';
                        break;
                    case 'radio':
                        $html .= '<div class="careers-choice-group">';
                        foreach ($f['options'] ?? [] as $idx => $opt) {
                            $checked = ((string)$val === (string)$opt) ? ' checked' : '';
                            $safeOpt = htmlspecialchars((string)$opt, ENT_QUOTES, 'UTF-8');
                            $rid = $idAttr . '_' . $idx;
                            $html .= '<label class="careers-choice-item" for="' . $rid . '"><input type="radio" id="' . $rid . '" name="' . $nameAttr . '" value="' . $safeOpt . '"' . $checked . ($idx === 0 && $req ? ' required' : '') . '> <span>' . $safeOpt . '</span></label>';
                        }
                        $html .= '</div>';
                        break;
                    case 'checkbox':
                        $selectedArr = is_array($val) ? $val : [];
                        $html .= '<div class="careers-choice-group">';
                        foreach ($f['options'] ?? [] as $idx => $opt) {
                            $checked = in_array((string)$opt, $selectedArr, true) ? ' checked' : '';
                            $safeOpt = htmlspecialchars((string)$opt, ENT_QUOTES, 'UTF-8');
                            $cid = $idAttr . '_' . $idx;
                            $html .= '<label class="careers-choice-item" for="' . $cid . '"><input type="checkbox" id="' . $cid . '" name="' . $nameAttr . '[]" value="' . $safeOpt . '"' . $checked . '> <span>' . $safeOpt . '</span></label>';
                        }
                        $html .= '</div>';
                        break;
                    case 'file':
                        $html .= '<input type="file" class="careers-input careers-file-input" id="' . $idAttr . '" name="' . $nameAttr . '" accept=".pdf,.doc,.docx"' . $reqAttr . '>';
                        break;
                    case 'email':
                    case 'phone':
                    case 'number':
                    case 'date':
                    case 'url':
                    case 'short_text':
                    default:
                        $htmlType = match ($type) {
                            'email'  => 'email',
                            'phone'  => 'tel',
                            'number' => 'number',
                            'date'   => 'date',
                            'url'    => 'url',
                            default  => 'text',
                        };
                        $stepAttr = $type === 'number' ? ' step="0.5" min="0"' : '';
                        $html .= '<input type="' . $htmlType . '" class="careers-input" id="' . $idAttr . '" name="' . $nameAttr . '" value="' . htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8') . '" placeholder="' . $ph . '"' . $stepAttr . $reqAttr . '>';
                        break;
                }

                if ($help !== '') {
                    $html .= '<small class="careers-help">' . $help . '</small>';
                }
                if ($err !== '') {
                    $html .= '<div class="careers-field-error">' . htmlspecialchars((string)$err, ENT_QUOTES, 'UTF-8') . '</div>';
                }
                $html .= '</div>';
            }

            $html .= '</div></div>';
        }
        return $html;
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return array<int, array<string, mixed>>
     */
    private static function hydrateFields(array $rows): array
    {
        foreach ($rows as &$r) {
            $opts = !empty($r['options_json']) ? json_decode((string)$r['options_json'], true) : [];
            $rules = !empty($r['validation_rules_json']) ? json_decode((string)$r['validation_rules_json'], true) : [];
            $r['options'] = is_array($opts) ? $opts : [];
            $r['validation_rules'] = is_array($rules) ? $rules : [];
        }
        return $rows;
    }
}
