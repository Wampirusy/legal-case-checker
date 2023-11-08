<?php

namespace PDFfiller\LegalCaseChecker\RuleChecker;

use PDFfiller\LegalCaseChecker\Models\RulePatternType;
use PDFfiller\LegalCaseChecker\RuleValidation\ValidatorFactory;

class RuleChecker
{
    private ValidatorFactory $validatorFactory;

    public function __construct(private readonly string $text)
    {
        $this->validatorFactory = new ValidatorFactory();
    }

    /**
     * check text according to RulePattern
     * returns array of suspicious texts
     */
    public function check(RulePatternType $patternType, string $pattern): array
    {
        $validator = $this->validatorFactory->createValidator($patternType, $pattern);
        $validator->validate($this->text);

        return $validator->getErrors();
    }
}
