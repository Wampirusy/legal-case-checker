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

    public function testValidatorOnLongText(): void
    {
        $validator = new WildCardValidator('l*a');
        $text =
            <<< TEXT
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac mauris at elit pellentesque finibus sit amet ac quam. Nulla vel est a arcu bibendum rhoncus vitae id nisi. In ut pulvinar est, et ullamcorper risus. Mauris eget arcu ut purus molestie porta. Aenean elementum, mi aliquet finibus pharetra, orci tortor venenatis dui, id faucibus ligula lacus in ante. Sed consectetur consectetur ex, sit amet dictum erat dapibus et. Aliquam ut metus sit amet dolor tempus pretium. Sed laoreet rhoncus lorem, tincidunt rutrum orci vestibulum sit amet. Morbi feugiat dignissim ex nec vestibulum. Suspendisse ultricies ut diam id ultrices. Nam vitae justo id nisl scelerisque suscipit. Suspendisse lobortis sodales nisi, congue viverra felis dapibus eu.
                Nullam ac luctus tortor, et luctus velit. Aenean laoreet porttitor sem at porttitor. Maecenas semper dolor varius dui scelerisque, vel finibus massa vestibulum. Nulla facilisi. Aliquam scelerisque auctor ipsum, at semper odio elementum eget. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Cras sit amet ligula at nisl porttitor aliquet. Aenean ipsum ligula, consectetur id turpis ut, bibendum dignissim justo. Sed sed ex arcu.
                Cras blandit luctus fringilla. Quisque quis lorem ut nisl bibendum semper ac eu est. Nam euismod sapien a efficitur aliquet. Praesent dignissim felis vitae enim hendrerit, sed pellentesque massa aliquet. Sed pellentesque tempus lacus, ac luctus turpis placerat et. Proin mauris ipsum, pretium vel cursus et, ullamcorper vitae nisl. Curabitur et blandit lectus. Proin suscipit commodo vehicula. Nullam scelerisque lacinia mattis.
                Morbi ut augue eget magna pellentesque elementum. Cras vehicula tincidunt nisl nec facilisis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque sagittis tellus vitae varius viverra. Etiam cursus, tortor a suscipit egestas, nunc velit scelerisque tortor, tincidunt blandit erat odio eu lectus. Duis congue non nunc vitae lacinia. Fusce massa sapien, ornare eget lobortis sed, venenatis vel sapien. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lobortis leo quis purus molestie viverra. Phasellus ornare metus sit amet metus volutpat euismod.
                Quisque tempor enim elit, a aliquet lorem feugiat et. Aliquam id consequat elit, eu rutrum eros. Proin massa dui, pretium sed tortor vel, semper tempus mauris. Etiam vel dolor et quam placerat fermentum quis et mauris. Vestibulum quam sem, scelerisque id iaculis ac, viverra a libero. Curabitur accumsan enim vel bibendum mattis. Morbi accumsan urna et eleifend cursus. Sed elit ante, viverra at gravida dignissim, venenatis quis libero. Curabitur mollis tempor mi sed faucibus. Donec elementum felis felis, eget tincidunt turpis porta a.
            TEXT;

        $this->assertFalse($validator->validate($text));
        $this->assertCount(158, $validator->getErrors());
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

            ['abcd. o\'prst', 'o\'*', ['o\'prst']],
//            ['abcd. o/prst', 'o/pr?t', ['o/prst']], // invalid regexp
            ['abc. abcdef. abdcefghijklmn. oprst', 'a?c*f', ['abc. abcdef. abdcefghijklmn.']],
        ];
    }
}
