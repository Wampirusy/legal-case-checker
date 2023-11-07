<?php

namespace PDFfiller\LegalCaseChecker\RuleChecker;

use PDFfiller\LegalCaseChecker\Models\RulePatternType;
use PDFfiller\RuleValidation\ValidatorFactory;

class RuleChecker
{
    public function __construct(private readonly string $text)
    {
    }

    /**
     * check text according to RulePattern
     * returns array of suspicious texts
     */
    public function check(RulePatternType $patternType, string $pattern): array
    {
        $validator = ValidatorFactory::createValidator($patternType, $pattern);
        $validator->validate($this->text);

        return $validator->getErrors();
    }
}
