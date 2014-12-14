<?php

namespace UnitTest\Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\BelowMinimumIntegerValueValidationException;
use Gnoesiboe\Validator\Exception\Validation\NotAnIntegerValidationException;
use Gnoesiboe\Validator\ValidationMessageManager;
use Gnoesiboe\Validator\Validator\MinimumIntegerValueValidator;
use UnitTest\Gnoesiboe\Validator\ValidatorTest;

/**
 * Class MinimumIntegerValueValidator
 */
final class MinimumIntegerValueValidatorTest extends ValidatorTest
{

    public function testRequiresAFirstParameter()
    {
        $validValue = 132;

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
        $validValue = 2;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue, array(
                $stringIntegerFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testAllowsTheFirstParameterToBeAnInteger()
    {
        $integerFirstParameter = 1;
        $validValue = 2;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue, array(
                $integerFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testDoesNotAllowAnIntegerValueToBeOneUnderTheMinimumValue()
    {
        $minimumValue = 10;
        $integerValue = $minimumValue - 1;

        try {
            $this->createValidator()
                ->validate(self::VALID_STRING_FIELD_NAME, $integerValue, array(
                    $minimumValue
                ));

            $this->fail(sprintf('Validation of \'%s\' did not throw an ValidationException', var_export($integerValue, true)));
        } catch (BelowMinimumIntegerValueValidationException $exception) {
            $this->assertTrue(true);
        }
    }

    public function testAllowsAnIntegerValueToBeOneOnTheMinimumValue()
    {
        $minimumValue = 5;
        $integerValue = $minimumValue;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $integerValue, array(
                $minimumValue
            ));

        $this->assertTrue(true);
    }

    public function testAllowsAnIntegerValueToBeOneAboveTheMinimumValue()
    {
        $minimumValue = 5;
        $integerValue = $minimumValue + 1;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $integerValue, array(
                $minimumValue
            ));

        $this->assertTrue(true);
    }

    public function testAllowsStringIntegerValues()
    {
        $validFirstParameter = 0;
        $stringIntegerValue = '12345';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $stringIntegerValue, array(
                $validFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testAllowsIntegerValues()
    {
        $validFirstParameter = 0;
        $integerValue = 12345;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $integerValue, array(
                $validFirstParameter
            ));

        $this->assertTrue(true);
    }

    public function testDoesNotAllowNonIntegerValues()
    {
        $validFirstParameter = 0;
        $nonAllowedValues = array(
            12.9223,
            '12.39283',
            'some string',
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
            } catch (NotAnIntegerValidationException $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public function testAllowsStringFieldName()
    {
        $validValue = 12345;
        $validFirstParameter = 0;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue, array(
                $validFirstParameter
            ));

        $this->assertTrue(true);
    }

    /**
     * @return MinimumIntegerValueValidator
     */
    protected function createValidator()
    {
        return new MinimumIntegerValueValidator(new ValidationMessageManager());
    }
}
