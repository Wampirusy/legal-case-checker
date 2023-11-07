<?php

namespace PDFfiller\LegalCaseChecker\Tests\RuleValidation;

use PDFfiller\LegalCaseChecker\Exceptions\InvalidRuleException;
use PDFfiller\LegalCaseChecker\RuleValidation\RegexpValidator;
use PHPUnit\Framework\TestCase;

class RegexpValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testValidator(string $text, string $pattern, array $errors): void
    {
        $validator = new RegexpValidator($pattern);

        $this->assertEquals(empty($errors), $validator->validate($text));
        $this->assertEquals($errors, $validator->getErrors());
    }

    public static function dataProvider(): array
    {
        return [
            ['one two tree', 'zero', []],
            ['one two tree. for five.', 'TWO', ['one two tree.']],
            ['text', '', []],
            ['one two tree. for five.', '/TWO/', ['one two tree.']], // it is insensitive
            ['one two tree. for five.', '/FOR/i', ['for five.']],
            ['one two tree. for five.', '/one|TWO/i', ['one two tree.']],
            ['one two tree. for five.', '/two|five/i', ['one two tree.', 'for five.']],
        ];
    }

    public function testValidatorException(): void
    {
        $validator = new RegexpValidator('/\/\/');

        $this->expectException(InvalidRuleException::class);
        $this->assertEquals(empty($errors), $validator->validate('text'));
    }
}
