<?php

namespace Gnoesiboe\Validator\Exception\Validation;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Class NotAnIntegerException
 */
final class NotAnIntegerValidationException extends ValidationException
{

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return 'not_an_integer';
    }
}
