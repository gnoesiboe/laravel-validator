<?php

namespace Gnoesiboe\Validator\Exception\Validation;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Class StringIsEmptyValidationException
 */
final class StringIsEmptyValidationException extends ValidationException
{

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return 'string_is_empty';
    }
}
