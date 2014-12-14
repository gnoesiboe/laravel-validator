<?php

namespace Gnoesiboe\Validator\Exception;

use Gnoesiboe\Validator\Exception\Validation\ValidationExceptionInterface;

/**
 * Class ValidationException
 */
abstract class ValidationException extends \Exception implements ValidationExceptionInterface
{

    /**
     * @var string
     */
    protected $field;

    /**
     * @param string $field
     * @param int    $message
     */
    public function __construct($field, $message)
    {
        $this->field = $field;

        parent::__construct($message);
    }
}
