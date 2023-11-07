<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

class WordValidator extends ValidatorAbstract
{
    private const PATTERN = '\b(%s)\b';

    protected function doValidate(string $text): array
    {
        if ($this->pattern) {
            $pattern = $this->createRegexp();

            if (preg_match_all($pattern, $text, $matches)) {
                return $matches[0];
            }
        }

        return [];
    }

    private function createRegexp(): string
    {
        $pattern = trim(preg_replace('/\s+/', ' ', $this->pattern));
        $pattern = sprintf(self::PATTERN, preg_quote($pattern, '/'));

        return $this->createWrappedRegexp($pattern);
    }
}
