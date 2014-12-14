<?php

namespace UnitTest\Gnoesiboe\Validator\Validator;

use Gnoesiboe\Validator\Exception\Validation\StringIsEmptyValidationException;
use Gnoesiboe\Validator\ValidationMessageManager;
use Gnoesiboe\Validator\Validator\NotEmptyStringValidator;
use Gnoesiboe\Validator\ValidatorInterface;

/**
 * Class NotEmptyStringValidatorTest
 */
final class NotEmptyStringValidatorTest extends StringValidatorTest
{

    public function testDoesNotAllowEmptyStrings()
    {
        $emptyString = '';

        try {
            $this->createValidator()
                ->validate(self::VALID_STRING_FIELD_NAME, $emptyString);

            $this->fail(sprintf('Validation of \'%s\' did not throw an ValidationException', var_export($emptyString, true)));
        } catch (StringIsEmptyValidationException $exception) {
            $this->assertTrue(true);
        }
    }

    public function testAllowsNonEmptyStrings()
    {
        $nonEmptyString = 'non-empty string';

        $this->createValidator()
            ->validate(self::VALID_STRING_FIELD_NAME, $nonEmptyString);

        $this->assertTrue(true);
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator()
    {
        return new NotEmptyStringValidator(new ValidationMessageManager());
    }
}
