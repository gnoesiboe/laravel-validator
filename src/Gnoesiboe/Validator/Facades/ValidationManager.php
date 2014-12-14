<?php

namespace Gnoesiboe\Validator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ValidationManager
 */
final class ValidationManager extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'validation_manager';
    }
}
