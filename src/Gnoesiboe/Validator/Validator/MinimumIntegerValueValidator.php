<?php

namespace Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\BelowMinimumIntegerValueValidationException;
use Gnoesiboe\Validator\Exception\ValidationException;
use Gnoesiboe\Validator\Support\KeyValueBag;
use Gnoesiboe\Validator\Validator;

/**
 * Class MinValidator
 */
final class MinimumIntegerValueValidator extends IntegerValidator
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
        $minimumValue = $this->extractMinimumValueFromParameters($parameters);

        parent::validate($field, $value, $parameters);

        $this->validateMinimumValue($field, $value, $minimumValue);
    }

    /**
     * @param array $parameters
     *
     * @return int
     */
    private function extractMinimumValueFromParameters(array $parameters)
    {
        $minimumValue = $this->extractRequiredParameter(0, $parameters, 'No minimum value supplied as parameter');

        if (filter_var($minimumValue, FILTER_VALIDATE_INT) === false) {
            throw new \UnexpectedValueException('Minimum value should be of type integer');
        }

        return (int)$minimumValue;
    }

    /**
     * @param string $field
     * @param mixed  $value
     * @param int    $minimumValue
     *
     * @throws ValidationException
     */
    private function validateMinimumValue($field, $value, $minimumValue)
    {
        if ((int)$value < (int)$minimumValue) {
            throw $this->createBelowMinimumIntegerValueValidationException($field, $minimumValue);
        }
    }

    /**
     * @param string  $field
     * @param integer $minimumValue
     *
     * @return BelowMinimumIntegerValueValidationException
     */
    private function createBelowMinimumIntegerValueValidationException($field, $minimumValue)
    {
        return new BelowMinimumIntegerValueValidationException($field, $this->generateMessage(
            BelowMinimumIntegerValueValidationException::getIdentifier(),
            'The value supplied for :field is below the minimum integer value of :minimum',
            array(
                'field'   => $field,
                'minimum' => (string)$minimumValue
            )
        ));
    }
}
