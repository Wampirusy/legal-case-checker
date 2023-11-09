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
            $pattern = $this->createWrappedRegexp($this->pattern);

            try {
                if (@preg_match_all($pattern, $text, $matches)) {
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
