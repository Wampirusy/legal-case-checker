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
            ['text', '', []],
            ['one two tree', 'zero', []],
            ['one two tree. for five.', 'TWO', ['one two tree.']],
            ['one two tree. for five.', 'one|TWO', ['one two tree.']],
            ['one two tree. for five.', 'two|five', ['one two tree.', 'for five.']],
        ];
    }

    public function testValidatorException(): void
    {
        $validator = new RegexpValidator('/\/\/');

        $this->expectException(InvalidRuleException::class);
        $validator->validate('text');
    }

    public function testValidatorExceptionMessage(): void
    {
        $validator = new RegexpValidator('/\/\/');

        set_error_handler(function (int $errno, string $errstr) {
            throw new \ErrorException($errstr);
        });

        $this->expectException(InvalidRuleException::class);
        $this->expectExceptionMessage("Unknown modifier '\'");
        $validator->validate('text');
    }
}
