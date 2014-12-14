<?php

namespace Gnoesiboe\Validator\Support\KeyValueBag;

use Gnoesiboe\Validator\Support\KeyValueBag;

/**
 * Class MessagesKeyValueBag
 */
final class MessagesKeyValueBag extends KeyValueBag
{

    /**
     * @param string $value
     * @param string $key
     *
     * @throws \UnexpectedValueException
     */
    protected function validateValue($value, $key)
    {
        if (is_string($value) === false) {
            throw new \UnexpectedValueException("Value of field {$key} should be of type string");
        }
    }
}
