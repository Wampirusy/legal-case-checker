<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

class WildCardValidator extends ValidatorAbstract
{
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
        $pattern = preg_quote($this->pattern, '/');
        $pattern = preg_replace(['/([^\\\])\\\\\?/', '/([^\\\])\\\\\*/'], ['\1.', '\1.*'], $pattern);
        // todo: it doesn't replace two \? consecutively
        $pattern = preg_replace(['/([^\\\])\\\\\?/', '/([^\\\])\\\\\*/'], ['\1.', '\1.*'], $pattern);

        return $this->createWrappedRegexp($pattern);
    }
}
