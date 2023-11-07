<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

use PDFfiller\Models\RulePatternType;

class ValidatorFactory
{
    public static function createValidator(RulePatternType $rulePatternType, string $pattern): ValidatorAbstract
    {
        switch ($rulePatternType) {
            case RulePatternType::Word:
                return new WordValidator($pattern);
            case RulePatternType::WildCard:
                return new WildCardValidator($pattern);
            case RulePatternType::Regexp:
                return new RegexpValidator($pattern);
        }

        throw new \Exception('Unknown rule pattern type.');
    }
}
