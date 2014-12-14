<?php

namespace Gnoesiboe\Validator\Support\KeyValueBag;

use Gnoesiboe\Validator\Support\KeyValueBag;

/**
 * Class ValidatorConstructorKeyValueBag
 */
final class ValidatorConstructorKeyValueBag extends KeyValueBag
{

    /**
     * @param string $value
     * @param string $key
     *
     * @throws \UnexpectedValueException
     */
    protected function validateValue($value, $key)
    {
        if (($value instanceof \Closure) === false) {
            throw new \UnexpectedValueException("The value with key {$key} should be an instance of \\Closure");
        }
    }
}
