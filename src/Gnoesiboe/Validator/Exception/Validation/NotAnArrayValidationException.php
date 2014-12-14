<?php

namespace Gnoesiboe\Validator\Exception\Validation;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Class NotAnArrayValidationException
 */
final class NotAnArrayValidationException extends ValidationException
{

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return 'not_an_array';
    }
}
