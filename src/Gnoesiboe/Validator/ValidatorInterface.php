<?php

namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Exception\ValidationException;

/**
 * Interface ValidatorInterface
 */
interface ValidatorInterface
{

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $parameters
     *
     * @throws ValidationException
     */
    public function validate($field, $value, array $parameters = array());
}
