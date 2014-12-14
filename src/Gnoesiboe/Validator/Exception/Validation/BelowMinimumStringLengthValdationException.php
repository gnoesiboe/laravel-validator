<?php

namespace Gnoesiboe\Validator\Exception\Validation;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Class BelowMinimumStringLengthValdationException
 */
final class BelowMinimumStringLengthValdationException extends ValidationException
{

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return 'below_minimum_string_length';
    }
}
