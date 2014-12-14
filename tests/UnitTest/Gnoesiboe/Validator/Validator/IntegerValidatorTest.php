<?php

namespace UnitTest\Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAnIntegerValidationException;
use Gnoesiboe\Validator\ValidationMessageManager;
use Gnoesiboe\Validator\Validator\IntegerValidator;
use UnitTest\Gnoesiboe\Validator\ValidatorTest;

/**
 * Class IntegerValidatorTest
 */
class IntegerValidatorTest extends ValidatorTest
{

    public function testDoesNotAllowNonIntegerValues()
    {
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
                    ->validate(self::VALID_STRING_FIELD_NAME, $nonAllowedValue);

                $this->fail(sprintf('Validation of \'%s\' did not throw an NotAnIntegerValidationException', var_export($nonAllowedValue, true)));
            } catch (NotAnIntegerValidationException $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public function testAllowsStringIntegerValues()
    {
        $stringIntegerValue = '12345';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $stringIntegerValue);

        $this->assertTrue(true);
    }

    public function testAllowsIntegerValues()
    {
        $integerValue = 12345;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $integerValue);

        $this->assertTrue(true);
    }

    public function testAllowsStringFieldName()
    {
        $validValue = 12345;

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue);

        $this->assertTrue(true);
    }

    /**
     * @return IntegerValidator
     */
    protected function createValidator()
    {
        return new IntegerValidator(new ValidationMessageManager());
    }
}
