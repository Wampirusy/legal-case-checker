<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

class WordValidator extends ValidatorAbstract
{
    private const PATTERN = '\b(%s)\b';

    public function __construct(protected string $pattern)
    {
        $pattern = trim(preg_replace('/\s+/', ' ', $pattern));

        parent::__construct($pattern);
    }

    protected function doValidate(string $text): array
    {

        if ($this->pattern) {
            $pattern = $this->createRegexp();
            $errors = [];
            $offset = 0;

            while (($position = stripos($text, $this->pattern, $offset)) !== false) {
                $partial = substr($text, $position - 100, 200);
                $offset = $position + 1;

                if (preg_match_all($pattern, $partial, $matches)) {
                    $errors[] = $matches[0];
                }
            }

            if ($errors) {
               return array_values(array_unique(array_merge(...$errors)));
            }
        }

        return [];
    }

    private function createRegexp(): string
    {
        $pattern = sprintf(self::PATTERN, preg_quote($this->pattern, '/'));

        return $this->createWrappedRegexp($pattern);
    }
}
