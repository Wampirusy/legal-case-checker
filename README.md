# Legal Case Checker

<img src="./resources/logo.png" alt="Legal Case Checker"/>

## Installation

Add repository to the composer.json

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:Wampirusy/legal-case-checker.git"
    }
]
```

Run the composer installer:

```bash
php composer require wampirusy/legal-case-checker
```

## Using

```php
$ruleChecker = new RuleChecker('some text');

$errors = $ruleChecker->check(RulePatternType::Word, 'text');
$errors = $ruleChecker->check(RulePatternType::WildCard, 't*t');
$errors = $ruleChecker->check(RulePatternType::Regexp, '/t[ex]{1,2}t/');
```