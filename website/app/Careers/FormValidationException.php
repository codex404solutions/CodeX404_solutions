<?php
declare(strict_types=1);

namespace App\Careers;

/**
 * Carries per-field server-side validation errors from the dynamic application engine.
 */
final class FormValidationException extends \InvalidArgumentException
{
    /** @var array<string, string> */
    private array $fieldErrors;

    /**
     * @param array<string, string> $fieldErrors
     */
    public function __construct(array $fieldErrors, string $message = 'Please review the highlighted fields below.')
    {
        parent::__construct($message);
        $this->fieldErrors = $fieldErrors;
    }

    /**
     * @return array<string, string>
     */
    public function getFieldErrors(): array
    {
        return $this->fieldErrors;
    }
}
