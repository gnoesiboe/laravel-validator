<?php

namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Exception\ValidationException;
use Gnoesiboe\Validator\Support\GetClassTrait;
use Gnoesiboe\Validator\Support\KeyValueBag\MessagesKeyValueBag;

/**
 * Class Validator
 */
abstract class Validator implements ValidatorInterface
{

    use GetClassTrait;

    /**
     * @var ValidationMessageManagerInterface
     */
    protected $messageManager;

    /**
     * @param string $field
     * @param mixed  $value
     * @param array  $parameters
     *
     * @throws ValidationException
     * @throws \UnexpectedValueException
     */
    public function validate($field, $value, array $parameters = array())
    {
        $this->validateField($field);
    }

    /**
     * @param mixed $field
     */
    protected function validateField($field)
    {
        if (is_string($field) === false) {
            throw new \UnexpectedValueException('The supplied field name should be of type string');
        }
    }

    /**
     * @param ValidationMessageManagerInterface $validationMessageManager
     */
    public function __construct(ValidationMessageManagerInterface $validationMessageManager)
    {
        $this->messageManager = $validationMessageManager;
    }

    /**
     * @param string $identifier
     * @param string $default
     * @param array  $replacements
     *
     * @return string
     */
    protected function generateMessage($identifier, $default, $replacements = array())
    {
        return $this->messageManager->get(
            $identifier,
            $default,
            new MessagesKeyValueBag($replacements)
        );
    }

    /**
     * @param int   $index
     * @param array $parameters
     * @param null  $missingMessage
     *
     * @return mixed
     */
    protected function extractRequiredParameter($index, array $parameters, $missingMessage = null)
    {
        if (array_key_exists($index, $parameters) === false) {
            throw new \UnexpectedValueException(is_string($missingMessage) ? $missingMessage : "Missing required parameter at index {$index}");
        }

        return $parameters[$index];
    }
}
