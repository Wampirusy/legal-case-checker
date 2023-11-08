<?php

namespace PDFfiller\LegalCaseChecker\Tests\RuleChecker;

use PDFfiller\LegalCaseChecker\Models\RulePatternType;
use PDFfiller\LegalCaseChecker\RuleChecker\RuleChecker;
use PDFfiller\LegalCaseChecker\RuleValidation\ValidatorAbstract;
use PDFfiller\LegalCaseChecker\RuleValidation\ValidatorFactory;
use PHPUnit\Framework\TestCase;

class RuleCheckerTest extends TestCase
{
    public function testNoErrors(): void
    {
        $ruleChecker = $this->createRuleChecker([]);

        $this->assertEquals([], $ruleChecker->check(RulePatternType::Regexp, ''));
    }

    public function testErrors(): void
    {
        $ruleChecker = $this->createRuleChecker([1, 2, 3]);

        $this->assertEquals([1, 2, 3], $ruleChecker->check(RulePatternType::Regexp, ''));
    }

    private function createRuleChecker(array $errors): RuleChecker
    {
        $ruleChecker = new RuleChecker('text');

        $validator = $this->createMock(ValidatorAbstract::class);
        $validator->expects($this->once())->method('validate')->willReturn(empty($errors));
        $validator->expects($this->once())->method('getErrors')->willReturn($errors);

        $validatorFactory = $this->createMock(ValidatorFactory::class);
        $validatorFactory->expects($this->once())->method('createValidator')->willReturn($validator);

        $reflectionClass = new \ReflectionClass($ruleChecker);
        $reflectionProperty = $reflectionClass->getProperty('validatorFactory');
        $reflectionProperty->setValue($ruleChecker, $validatorFactory);

        return $ruleChecker;
    }
}
