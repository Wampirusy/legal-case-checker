<?php

namespace PDFfiller\LegalCaseChecker\Tests\RuleValidation;

use PDFfiller\LegalCaseChecker\RuleValidation\WildCardValidator;
use PHPUnit\Framework\TestCase;

class WildCardValidatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testValidator(string $text, string $pattern, array $errors): void
    {
        $validator = new WildCardValidator($pattern);

        $this->assertEquals(empty($errors), $validator->validate($text));
        $this->assertEquals($errors, $validator->getErrors());
    }

    public static function dataProvider(): array
    {
        return [
            ['abc', '', []],
            ['abc', 'd', []],

            ['abc', 'a?', ['abc']],
            ['abc', 'b?', ['abc']],
            ['abc', 'a?c', ['abc']],
            ['abc', 'a?b', []],
            ['abc', 'a?d', []],
            ['abbc', 'a?c', []],
            ['abbc', 'a??c', ['abbc']],

            ['abc', 'a*', ['abc']],
            ['abc', 'b*', ['abc']],
            ['abc', 'c*', ['abc']],
            ['abc', 'd*', []],

            ['abc def. ghijk lmn. oprst', 'd*f', ['abc def.']],
            ['abc def. ghijk lmn. oprst', 'f*k', ['abc def. ghijk lmn.']],
            ['abc def. ghijk lmn. oprst', 'f*', ['abc def. ghijk lmn. oprst']],
        ];
    }
}
