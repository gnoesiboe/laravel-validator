<?php

namespace Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAnArrayValidationException;
use Gnoesiboe\Validator\Validator;

/**
 * Class ArrayValidator
 */
final class ArrayValidator extends Validator
{

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $parameters
     *
     * @throws NotAnArrayValidationException
     */
    public function validate($field, $value, array $parameters = array())
    {
        parent::validate($field, $value, $parameters);

        $this->validateIsArray($field, $value);
    }

    /**
     * @param string $field
     * @param mixed  $value
     *
     * @throws NotAnArrayValidationException
     */
    private function validateIsArray($field, $value)
    {
        if (is_array($value) === false) {
            throw $this->createNotAnArrayValidationException($field);
        }
    }

    /**
     * @param string $field
     *
     * @return NotAnArrayValidationException
     */
    private function createNotAnArrayValidationException($field)
    {
        return new NotAnArrayValidationException($field, $this->generateMessage(
            NotAnArrayValidationException::getIdentifier(),
            'The value supplied for field :field is not an array',
            array(
                'field' => $field
            )
        ));
    }
}
