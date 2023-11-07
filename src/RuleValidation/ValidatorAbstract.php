<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

abstract class ValidatorAbstract
{
    protected const WRAPPED_PATTERN = '/\b[^.!?]{0,50}(%s)[^.!?]{0,50}[.!?\s]?/i';

    protected array $errors = [];

    public function __construct(protected string $pattern)
    {
    }

    public function validate(string $text): bool
    {
        $this->errors = $this->doValidate($text);

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    abstract protected function doValidate(string $text): array;

    protected function createWrappedRegexp(string $regexp): string
    {
        return sprintf(self::WRAPPED_PATTERN, $regexp);
    }
}
