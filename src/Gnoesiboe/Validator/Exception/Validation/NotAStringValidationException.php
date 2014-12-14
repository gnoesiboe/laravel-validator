<?php

namespace Gnoesiboe\Validator\Exception\Validation;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Class NotAStringException
 */
final class NotAStringValidationException extends ValidationException
{

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return 'not_a_string';
    }
}
