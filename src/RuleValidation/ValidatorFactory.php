<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

use PDFfiller\LegalCaseChecker\Models\RulePatternType;

class ValidatorFactory
{
    public function createValidator(RulePatternType $rulePatternType, string $pattern): ValidatorAbstract
    {
        return match ($rulePatternType) {
            RulePatternType::Regexp => new RegexpValidator($pattern),
            RulePatternType::WildCard => new WildCardValidator($pattern),
            default => new WordValidator($pattern),
        };
    }
}
