<?php

namespace Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAnIntegerValidationException;
use Gnoesiboe\Validator\Exception\Validation\NotAStringValidationException;
use Gnoesiboe\Validator\Exception\ValidationException;
use Gnoesiboe\Validator\Support\KeyValueBag;
use Gnoesiboe\Validator\Validator;

/**
 * Class StringValidator
 */
class StringValidator extends Validator
{

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $parameters
     *
     * @throws ValidationException
     */
    public function validate($field, $value, array $parameters = array())
    {
        parent::validate($field, $value, $parameters);

        $this->validateIsString($field, $value);
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @throws NotAStringValidationException
     */
    private function validateIsString($field, $value)
    {
        if (is_string($value) === false) {
            throw $this->createNotAStringValidationException($field);
        }
    }

    /**
     * @param string $field
     *
     * @return NotAStringValidationException
     */
    private function createNotAStringValidationException($field)
    {
        return new NotAStringValidationException($field, $this->generateMessage(
            NotAnIntegerValidationException::getIdentifier(),
            'The value supplied for :field should be of type string',
            array(
                'field' => $field
            )
        ));
    }
}
