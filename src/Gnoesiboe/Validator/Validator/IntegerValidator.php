<?php

namespace Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAnIntegerValidationException;
use Gnoesiboe\Validator\Exception\ValidationException;
use Gnoesiboe\Validator\Support\KeyValueBag;
use Gnoesiboe\Validator\Validator;

/**
 * Class IntegerValidator
 */
class IntegerValidator extends Validator
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

        $this->validateIsInteger($field, $value);
    }

    /**
     * @param string $field
     * @param mixed $value
     *
     * @throws NotAnIntegerValidationException
     */
    private function validateIsInteger($field, $value)
    {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw $this->createNotAnIntegerValidationException($field);
        }
    }

    /**
     * @param string $field
     *
     * @return NotAnIntegerValidationException
     */
    private function createNotAnIntegerValidationException($field)
    {
        return new NotAnIntegerValidationException($field, $this->generateMessage(
            NotAnIntegerValidationException::getIdentifier(),
            'The supplied value is not an integer',
            array(
                'field' => $field
            )
        ));
    }
}
