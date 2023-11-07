<?php

namespace PDFfiller\LegalCaseChecker\Models;

enum RulePatternType: string
{
    case Word = 'word';
    case WildCard = 'wildcard';
    case Regexp = 'regexp';
}
