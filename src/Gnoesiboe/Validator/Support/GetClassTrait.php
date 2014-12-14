<?php

namespace Gnoesiboe\Validator\Support;

/**
 * Trait getClassTrait
 */
trait GetClassTrait
{

    /**
     * @return string
     */
    public static function getClass()
    {
        return get_called_class();
    }
}
