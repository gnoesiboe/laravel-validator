<?php

namespace Gnoesiboe\Validator\Exception;

use Gnoesiboe\Validator\Support\KeyValueBag;
use Illuminate\Support\Contracts\ArrayableInterface;

/**
 * Class ValidationSetException
 */
final class ValidationSetException extends \Exception implements ArrayableInterface
{

    /**
     * @var KeyValueBag
     */
    private $exceptions;

    /**
     * @param KeyValueBag $exceptions
     */
    public function __construct(KeyValueBag $exceptions)
    {
        $this->exceptions = $exceptions;
    }

    /**
     * @param ValidationSetException $validationSetException
     *
     * @return $this
     */
    public function merge(ValidationSetException $validationSetException)
    {
        foreach ($validationSetException->getExceptions() as $field => $exceptionsToMerge) {
            /** @var string $field */
            /** @var ValidationException[]|Array $exceptionsToMerge */

            if ($this->exceptions->has($field) === true) {
                $current = $this->exceptions->get($field);

                $this->exceptions->set($field, array_merge($current, $exceptionsToMerge));
            } else {
                $this->exceptions->set($field, $exceptionsToMerge);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $out = array();

        foreach ($this->exceptions as $field => $exceptions) {
            $out[$field] = array();

            foreach ($exceptions as $identifier => $exception) {
                /** @var ValidationException $exception */

                $out[$field][$identifier] = $exception->getMessage();
            }
        }

        return $out;
    }
}
