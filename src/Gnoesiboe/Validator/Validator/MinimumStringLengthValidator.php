<?php

namespace Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\BelowMinimumStringLengthValdationException;
use Gnoesiboe\Validator\Exception\ValidationException;
use Gnoesiboe\Validator\Validator;

/**
 * Class MinimumStringLengthValidator
 */
final class MinimumStringLengthValidator extends StringValidator
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
        $minimumStringLength = $this->extractMinimumStringLengthFromParameters($parameters);

        parent::validate($field, $value, $parameters);

        $this->validateMinimumStringLength($field, $value, $minimumStringLength);
    }

    /**
     * @param string $field
     * @param string $value
     * @param int    $minimumStringLength
     *
     * @throws BelowMinimumStringLengthValdationException
     */
    private function validateMinimumStringLength($field, $value, $minimumStringLength)
    {
        if (strlen((string)$value) < (int)$minimumStringLength) {
            throw $this->createBelowMinimumStringLengthValdationException($field, $minimumStringLength);
        }
    }

    /**
     * @param string $field
     * @param int    $minimumStringLength
     *
     * @return BelowMinimumStringLengthValdationException
     */
    private function createBelowMinimumStringLengthValdationException($field, $minimumStringLength)
    {
        return new BelowMinimumStringLengthValdationException($field, $this->generateMessage(
            BelowMinimumStringLengthValdationException::getIdentifier(),
            'The supplied value for field :field has a length below the minimum required value of :min_string_length',
            array(
                'field'             => $field,
                'min_string_length' => (string)$minimumStringLength,
            )
        ));
    }

    /**
     * @param array $parameters
     *
     * @return int
     */
    private function extractMinimumStringLengthFromParameters(array $parameters)
    {
        $minimumStringLength = $this->extractRequiredParameter(0, $parameters, 'No minimum value supplied as parameter');

        if (filter_var($minimumStringLength, FILTER_VALIDATE_INT) === false) {
            throw new \UnexpectedValueException('First parameter should be an integer');
        }

        return (int)$minimumStringLength;
    }
}
