<?php

namespace UnitTest\Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAStringValidationException;
use Gnoesiboe\Validator\ValidationMessageManager;
use Gnoesiboe\Validator\Validator\StringValidator;
use Gnoesiboe\Validator\ValidatorInterface;
use UnitTest\Gnoesiboe\Validator\ValidatorTest;

/**
 * Class StringValidatorTest
 */
class StringValidatorTest extends ValidatorTest
{

    public function testDoesNotAllowNonStringValues()
    {
        $nonAllowedValues = array(
            19.992,
            3982,
            new \stdClass(),
            array()
        );

        foreach ($nonAllowedValues as $nonAllowedValue) {
            try {
                $this->createValidator()
                    ->validate(self::VALID_STRING_FIELD_NAME, $nonAllowedValue);

                $this->fail(sprintf('Validation of \'%s\' did not throw an ValidationException', var_export($nonAllowedValue, true)));
            } catch (NotAStringValidationException $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public function testAllowsStringValues()
    {
        $stringValue = 'string_value';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $stringValue);

        $this->assertTrue(true);
    }

    public function testAllowsStringFieldName()
    {
        $validValue = 'valid_string';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue);

        $this->assertTrue(true);
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new StringValidator(new ValidationMessageManager());
    }
}
