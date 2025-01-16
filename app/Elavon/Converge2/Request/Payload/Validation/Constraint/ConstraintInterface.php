<?php

namespace App\Elavon\Converge2\Request\Payload\Validation\Constraint;

use App\Elavon\Converge2\Request\Payload\Validation\Constraint\Violation\ViolationInterface;

interface ConstraintInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getErrorMessageTemplate();

    /**
     * @param mixed $value
     * @return ViolationInterface[]
     */
    public function assert($value);
}
