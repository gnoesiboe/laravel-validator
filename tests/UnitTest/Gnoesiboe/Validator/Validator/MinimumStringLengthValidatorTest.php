<?php

namespace UnitTest\Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\BelowMinimumStringLengthValdationException;
use Gnoesiboe\Validator\Exception\Validation\NotAStringValidationException;
use Gnoesiboe\Validator\ValidationMessageManager;
use Gnoesiboe\Validator\Validator\MinimumStringLengthValidator;
use UnitTest\Gnoesiboe\Validator\ValidatorTest;

/**
 * Class MinimumStringLengthValidatorTest
 */
final class MinimumStringLengthValidatorTest extends ValidatorTest
{

    public function testRequiresAFirstParameter()
    {
        $validValue = 'some_valid_value';

        try {
            $this->createValidator()
                ->validate(self::VALID_STRING_FIELD_NAME, $validValue);

            $this->fail(sprintf('Validation of \'%s\' did not throw an UnexpectedValueException', var_export($validValue, true)));
        } catch (\UnexpectedValueException $exception) {
            $this->assertTrue(true);
        }
    }

    public function testDoesNotAllowTheFirstParameterToBeANonIntegerValue()
    {
        $invalidFirstParameters = array(
            123.232,
            'test',
            new \stdClass(),
            array()
        );

        foreach ($invalidFirstParameters as $invalidFirstParameter) {
            try {
                $this->createValidator()
                    ->validate(self::VALID_STRING_FIELD_NAME, $invalidFirstParameter);

                $this->fail(sprintf('Validation of \'%s\' did not throw an UnexpectedValueException', var_export($invalidFirstParameter, true)));
            } catch (\UnexpectedValueException $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public function testAllowsTheFirstParameterToBeAStringInteger()
    {
        $stringIntegerFirstParameter = '1';
        $validValue = 'some_valid_value';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue, array(
                $stringIntegerFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testAllowsTheFirstParameterToBeAnInteger()
    {
        $integerFirstParameter = 1;
        $validValue = 'some_valid_value';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue, array(
                $integerFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testDoesNotAllowAStringValueToBeOneUnderTheMinimumLength()
    {
        $stringValue = 'some_string_value';
        $minimumLength = strlen($stringValue) + 1;

        try {
            $this->createValidator()
                ->validate(self::VALID_STRING_FIELD_NAME, $stringValue, array(
                    $minimumLength
                ));

            $this->fail(sprintf('Validation of \'%s\' did not throw an ValidationException', var_export($stringValue, true)));
        } catch (BelowMinimumStringLengthValdationException $exception) {
            $this->assertTrue(true);
        }
    }

    public function testAllowsAStringValueIfItIsExactlyTheMinimumLength()
    {
        $stringValue = 'some_string_value';
        $minimumLength = strlen($stringValue) ;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $stringValue, array(
                $minimumLength
            ));

        $this->assertTrue(true);
    }

    public function testAllowsAStringValueIfItIsAboveTheMinimumLength()
    {
        $stringValue = 'some_string_value';
        $minimumLength = strlen($stringValue) - 1;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $stringValue, array(
                $minimumLength
            ));

        $this->assertTrue(true);
    }

    public function testAllowsStringValue()
    {
        $validFirstParameter = 2;
        $stringValue = 'string_value_with_a_length_more_then_2';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $stringValue, array(
                $validFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testDoesNotAllowNonStringValues()
    {
        $validFirstParameter = 2;
        $nonAllowedValues = array(
            12.9223,
            12.39283,
            new \stdClass(),
            array()
        );

        foreach ($nonAllowedValues as $nonAllowedValue) {
            try {
                $this->createValidator()
                    ->validate(self::VALID_STRING_FIELD_NAME, $nonAllowedValue, array(
                        $validFirstParameter
                    ));

                $this->fail(sprintf('Validation of \'%s\' did not throw an ValidationException', var_export($nonAllowedValue, true)));
            } catch (NotAStringValidationException $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public function testAllowsStringFieldName()
    {
        $validValue = 'test';
        $validFirstParameter = 2;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue, array(
                $validFirstParameter
            ));

        $this->assertTrue(true);
    }

    /**
     * @return MinimumStringLengthValidator
     */
    protected function createValidator()
    {
        return new MinimumStringLengthValidator(new ValidationMessageManager());
    }
}
