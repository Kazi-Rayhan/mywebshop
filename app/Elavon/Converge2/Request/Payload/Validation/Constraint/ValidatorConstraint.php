<?php

namespace App\Elavon\Converge2\Request\Payload\Validation\Constraint;

use App\Elavon\Converge2\Request\Payload\Validation\ValidatorInterface;

class ValidatorConstraint extends AbstractConstraint
{
    /** @var ValidatorInterface */
    protected $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        parent::__construct();
    }

    public function assert($value)
    {
        return $this->validator->validate($value)->getViolations();
    }

}