<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

class WildCardValidator extends SimpleValidatorAbstract
{
    protected function createRegexp(): string
    {
        $pattern = str_replace(['?', '*'], ['.', '.*'], $this->pattern);

        return $this->createWrappedRegexp($pattern);
    }

    protected function getStartText(): string
    {
        return strtok($this->pattern, '?*');
    }
}
