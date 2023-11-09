<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

abstract class SimpleValidatorAbstract extends ValidatorAbstract
{
    public function __construct(protected string $pattern)
    {
        $pattern = trim(preg_replace('/\s+/', ' ', $pattern));

        parent::__construct($pattern);
    }

    protected function doValidate(string $text): array
    {
        if ($this->pattern) {
            $startText = $this->getStartText();
            $pattern = $this->createRegexp();
            $errors = [];
            $offset = 0;

            while (($position = stripos($text, $startText, $offset)) !== false) {
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

    abstract protected function createRegexp(): string;

    abstract protected function getStartText(): string;
}
