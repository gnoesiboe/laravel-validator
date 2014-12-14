<?php

namespace UnitTest\Gnoesiboe\Validator;

use Gnoesiboe\Validator\ValidatorInterface;

/**
 * Class ValidatorTest
 */
abstract class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /** @var string */
    const VALID_STRING_FIELD_NAME = 'valid_field_name';

    public function testNonStringFieldNameIsNotAllowed()
    {
        $nonStringFieldValues = array(
            12323.2323,
            22382,
            array(),
            new \stdClass()
        );

        $value = 'test_value';

        foreach ($nonStringFieldValues as $nonStringFieldValue) {
            try {
                $this->createValidator()->validate($nonStringFieldValue, $value);

                $this->fail(sprintf('Applying of \'%s\' as field did not throw an UnexpectedValueException', var_export($nonStringFieldValue, true)));
            } catch (\UnexpectedValueException $exception) {
                $this->assertTrue(true);
            } catch (\Exception $exception) {
                $this->assertTrue(true);
            }
        }
    }

    public abstract function testAllowsStringFieldName();

    /**
     * @return ValidatorInterface
     */
    protected abstract function createValidator();
}
