<?php

namespace Gnoesiboe\Validator\Exception\Validation;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Class BelowMinimumValidationException
 */
final class BelowMinimumIntegerValueValidationException extends ValidationException
{

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return 'below_minimum_integer_value';
    }
}
