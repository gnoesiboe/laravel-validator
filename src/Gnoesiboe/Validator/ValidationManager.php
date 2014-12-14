<?php

namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Exception\ValidationException;
use Gnoesiboe\Validator\Exception\ValidationSetException;
use Gnoesiboe\Validator\Exception\ValidatorUnknownException;
use Gnoesiboe\Validator\Support\ArrayHelper;
use Gnoesiboe\Validator\Support\GetClassTrait;
use Gnoesiboe\Validator\Support\KeyValueBag;
use Gnoesiboe\Validator\Support\KeyValueBag\ValidatorConstructorKeyValueBag;

/**
 * Class ValidationManager
 */
final class ValidationManager
{

    use GetClassTrait;

    /**
     * @var KeyValueBag
     */
    private $validatorConstructors;

    /**
     * @var array
     */
    private $validatorInstancesCache = [];

    /**
     * @param ValidatorConstructorKeyValueBag $validatorConstructors
     */
    public function __construct(ValidatorConstructorKeyValueBag $validatorConstructors)
    {
        $this->validatorConstructors = $validatorConstructors;
    }

    /**
     * @param array                  $input
     * @param ConstraintSetInterface $constraintSet
     *
     * @return array
     *
     * @throws ValidationSetException
     * @throws \UnexpectedValueException
     */
    public function validateSet(array $input, ConstraintSetInterface $constraintSet)
    {
        $constraints = $constraintSet->getConstraints();
        $this->validateConstraints($constraints);

        $fieldsUnderValidation = $constraints->getKeys();

        $arrayHelper = new ArrayHelper();
        $defaults = $arrayHelper->ensureKeys(array(), $fieldsUnderValidation);
        $normalizedInput = $arrayHelper->normalize($input, $defaults);

        $exceptions = array();

        foreach ($fieldsUnderValidation as $field) {
            try {
                $this->validate($normalizedInput[$field], $constraints->get($field), $field);
            } catch (ValidationSetException $exception) {
                $exceptions[] = $exception;
            }
        }

        if (count($exceptions) > 0) {
            throw $this->mergeValidationSetExceptions($exceptions);
        }
    }

    /**
     * @param $constraints
     *
     * @throws \UnexpectedValueException
     */
    private function validateConstraints($constraints)
    {
        if (($constraints instanceof KeyValueBag) === false) {
            throw new \UnexpectedValueException('Constraints should be an instance of Gnoesiboe/Validator/Support/KeyValueBag');
        }

        /** @var KeyValueBag $constraints */

        $constraints->each(function ($key, $value) {
            if (($value instanceof ConstraintInterface) === false) {
                throw new \UnexpectedValueException("The key '$key' in this constraint set contains constraints that are not an implementation of Gnoesiboe/Validator/ConstraintInterface");
            }
        });
    }

    /**
     * @param array $validationSetExceptions
     *
     * @return ValidationSetException|null
     */
    private function mergeValidationSetExceptions(array $validationSetExceptions)
    {
        // use the first exception and merge the rest of the exceptions into that

        /** @var ValidationSetException $firstException */
        $firstException = array_shift($validationSetExceptions);

        foreach ($validationSetExceptions as $exception) {
            $firstException->merge($exception);
        }

        return $firstException;
    }

    /**
     * @param mixed               $value
     * @param ConstraintInterface $constraint
     * @param string              $field
     *
     * @throws ValidationSetException
     */
    public function validate($value, ConstraintInterface $constraint, $field)
    {
        $validatorIdentifiers = $constraint->getValidatorIdentifiers();

        $exceptions = array();

        foreach ($validatorIdentifiers as $validatorIdentifierAndParameters) {
            list ($validatorIdentifier, $parameters) = $this->parseValidatorIdentifier($validatorIdentifierAndParameters);

            $validator = $this->get($validatorIdentifier);

            try {
                $validator->validate($field, $value, $parameters);
            } catch (ValidationException $exception) {
                $exceptions[$field][$exception::getIdentifier()] = $exception;
            }
        }

        if (count($exceptions) > 0) {
            throw new ValidationSetException(new KeyValueBag($exceptions));
        }
    }

    /**
     * @param string $validatorIdentifier
     *
     * @return array
     */
    private function parseValidatorIdentifier($validatorIdentifier)
    {
        $identifierParametersSplitted = explode(':', $validatorIdentifier);

        if (count($identifierParametersSplitted) > 2) {
            throw new \UnexpectedValueException('The validator identifier should only contain one \':\' character');
        }

        $identifier = $identifierParametersSplitted[0];
        $parameters = array();

        if (count($identifierParametersSplitted) === 2) {
            $parameters = explode(',', $identifierParametersSplitted[1]);
        }

        return array($identifier, $parameters);
    }

    /**
     * @param string   $identifier
     * @param callable $constructor
     *
     * @return $this
     */
    public function register($identifier, \Closure $constructor)
    {
        $this->validatorConstructors->set($identifier, $constructor);

        return $this;
    }

    /**
     * @param string $identifier
     *
     * @return ValidatorInterface
     *
     * @throws ValidatorUnknownException
     * @throws \UnexpectedValueException
     */
    public function get($identifier)
    {
        if ($this->has($identifier) === false) {
            throw new ValidatorUnknownException("No validator found with identifier: '$identifier'");
        }

        if (array_key_exists($identifier, $this->validatorInstancesCache) === true) {
            return $this->validatorInstancesCache[$identifier];
        }

        /** @var \Closure $constructor */
        $constructor = $this->validatorConstructors->get($identifier);

        $validator = $constructor($this);
        $this->validateValidator($validator, $identifier);

        $this->validatorInstancesCache[$identifier] = $validator;

        return $validator;
    }

    /**
     * @param mixed  $validator
     * @param string $identifier
     *
     * @throws \UnexpectedValueException
     */
    private function validateValidator($validator, $identifier)
    {
        if (($validator instanceof ValidatorInterface) === false) {
            throw new \UnexpectedValueException("Validator '$identifier' should be a concrete implementation of Gnoesiboe\\Validator\\ValidationInterface");
        }
    }

    /**
     * @param string $identifier
     *
     * @return bool
     */
    public function has($identifier)
    {
        return $this->validatorConstructors->has($identifier);
    }
}
