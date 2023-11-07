<?php

namespace PDFfiller\LegalCaseChecker\RuleValidation;

use PDFfiller\LegalCaseChecker\Exceptions\InvalidRuleException;

class RegexpValidator extends ValidatorAbstract
{
    private const PREG_MATCH_ERROR_PREFIX = 'preg_match_all(): ';

    /**
     * @throws InvalidRuleException
     */
    protected function doValidate(string $text): array
    {
        if ($this->pattern) {
            $pattern = $this->createRegexp();

            try {
                if (preg_match_all($pattern, $text, $matches)) {
                    return $matches[0];
                }

                if (preg_last_error()) {
                    throw new \ErrorException(preg_last_error_msg());
                }
            } catch (\ErrorException $exception) {
                $this->throwInvalidRuleException($exception);
            }
        }

        return [];
    }

    private function createRegexp(): string
    {
        if (
            strlen($this->pattern) > 3
            && $this->pattern[0] === '/'
            && ($lastDelimiter = strrpos($this->pattern, '/')) > 0
        ) { // probably it is the completed regexp
            $pattern = substr($this->pattern, 1, $lastDelimiter - 1);
            $options = substr($this->pattern, $lastDelimiter + 1);

            return $this->createWrappedRegexp($pattern).$options;
        }

        return $this->createWrappedRegexp(preg_quote($this->pattern, '/'));
    }

    /**
     * @throws InvalidRuleException
     */
    private function throwInvalidRuleException(\Exception|\ErrorException $exception)
    {
        if (str_starts_with($exception->getMessage(), self::PREG_MATCH_ERROR_PREFIX)) {
            $message = str_replace(self::PREG_MATCH_ERROR_PREFIX, '', $exception->getMessage());
        } else {
            $message = 'invalid regexp';
        }

        throw new InvalidRuleException($message);
    }
}
