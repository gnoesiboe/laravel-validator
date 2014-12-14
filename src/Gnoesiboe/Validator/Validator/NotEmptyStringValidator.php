<?php

namespace Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAStringValidationException;
use Gnoesiboe\Validator\Exception\Validation\StringIsEmptyValidationException;
use Gnoesiboe\Validator\Validator;

/**
 * Class NotEmptyValidator
 */
final class NotEmptyStringValidator extends StringValidator
{

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $parameters
     *
     * @throws StringIsEmptyValidationException
     * @throws NotAStringValidationException
     */
    public function validate($field, $value, array $parameters = array())
    {
        parent::validate($field, $value, $parameters);

        $this->validateIsNotAnEmptyString($field, $value);
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @throws StringIsEmptyValidationException
     */
    private function validateIsNotAnEmptyString($field, $value)
    {
        if (strlen((string)$value) === 0) {
            throw $this->createStringIsEmptyValidationException($field);
        }
    }

    /**
     * @param string $field
     *
     * @return StringIsEmptyValidationException
     */
    private function createStringIsEmptyValidationException($field)
    {
        return new StringIsEmptyValidationException($field, $this->generateMessage(
            StringIsEmptyValidationException::getIdentifier(),
            'The value supplied for field :field is an empty string',
            array(
                'field' => $field
            )
        ));
    }
}
