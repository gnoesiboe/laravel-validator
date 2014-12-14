<?php

namespace Gnoesiboe\Validator;

use Gnoesiboe\Validator\Support\KeyValueBag;

/**
 * Interface ConstraintSetInterface
 */
interface ConstraintSetInterface
{

    /**
     * @return ConstraintInterface[]|KeyValueBag
     */
    public function getConstraints();
}
