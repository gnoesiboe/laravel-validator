<?php

namespace UnitTest\Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\NotAnArrayValidationException;
use Gnoesiboe\Validator\ValidationMessageManager;
use Gnoesiboe\Validator\Validator\ArrayValidator;
use Gnoesiboe\Validator\ValidatorInterface;
use UnitTest\Gnoesiboe\Validator\ValidatorTest;

/**
 * Class ArrayValidatorTest
 */
final class ArrayValidatorTest extends ValidatorTest
{

    public function testDoesNotAllowNonArrayValues()
    {
        $nonAllowedValues = array(
            new \stdClass(),
            'a string',
            1232.21,
            '1232.294',
            192382,
            '291839'
        );

        foreach ($nonAllowedValues as $nonAllowedValue) {
            try {
                $this->createValidator()
                    ->validate(self::VALID_STRING_FIELD_NAME, $nonAllowedValue);

                    $this->fail(sprintf('Validation of \'%s\' did not throw an NotAnArrayValidationException', var_export($nonAllowedValue, true)));
            } catch (NotAnArrayValidationException $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public function testAllowsArrayValue()
    {
        $allowedValue = array();

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $allowedValue);

        $this->assertTrue(true);
    }

    public function testAllowsStringFieldName()
    {
        $validValue = array();

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $validValue);

        $this->assertTrue(true);
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new ArrayValidator(new ValidationMessageManager());
    }
}
