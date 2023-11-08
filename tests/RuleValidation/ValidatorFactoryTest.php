<?php

namespace PDFfiller\LegalCaseChecker\Tests\RuleValidation;

use PDFfiller\LegalCaseChecker\Models\RulePatternType;
use PDFfiller\LegalCaseChecker\RuleValidation\RegexpValidator;
use PDFfiller\LegalCaseChecker\RuleValidation\ValidatorFactory;
use PDFfiller\LegalCaseChecker\RuleValidation\WildCardValidator;
use PDFfiller\LegalCaseChecker\RuleValidation\WordValidator;
use PHPUnit\Framework\TestCase;

class ValidatorFactoryTest extends TestCase
{
    public function testFactory(): void
    {
        $factory = new ValidatorFactory();

        $this->assertInstanceOf(RegexpValidator::class, $factory->createValidator(RulePatternType::Regexp, ''));
        $this->assertInstanceOf(WordValidator::class, $factory->createValidator(RulePatternType::Word, ''));
        $this->assertInstanceOf(WildCardValidator::class, $factory->createValidator(RulePatternType::WildCard, ''));
    }
}
