<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

class WordValidator extends SimpleValidatorAbstract
{
    private const PATTERN = '\b(%s)\b';

    protected function createRegexp(): string
    {
        $pattern = sprintf(self::PATTERN, preg_quote($this->pattern, '/'));
        $pattern = str_replace(' ', '\s+', $pattern);

        return $this->createWrappedRegexp($pattern);
    }

    protected function getStartText(): string
    {
        return strtok($this->pattern, ' ');
    }
}
