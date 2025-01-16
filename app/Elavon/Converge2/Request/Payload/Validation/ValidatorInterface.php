<?php

namespace App\Elavon\Converge2\Request\Payload\Validation;

use App\Elavon\Converge2\Request\Payload\Validation\Constraint\ConstraintCollectionInterface;
use App\Elavon\Converge2\Request\Payload\Validation\Constraint\ConstraintInterface;
use App\Elavon\Converge2\Request\Payload\Validation\Constraint\Violation\ViolationInterface;
use App\Elavon\Converge2\Request\Payload\Validation\Constraint\Violation\ViolationRendererInterface;

interface ValidatorInterface
{
    /**
     * @param ConstraintCollectionInterface $constraintCollection
     * @return ValidatorInterface
     */
    public function setConstraintCollection(ConstraintCollectionInterface $constraintCollection);

    /**
     * @param ConstraintInterface $constraint
     * @param string $key
     * @return ValidatorInterface
     */
    public function addConstraint(ConstraintInterface $constraint, $key = null);

    /**
     * @param string $key
     * @return ValidatorInterface
     */
    public function removeConstraint($key = null);

    /**
     * @param mixed $value
     * @return ValidatorInterface
     */
    public function validate($value);

    /**
     * @return ViolationInterface[]
     */
    public function getViolations();

    /**
     * @return bool
     */
    public function hasViolations();

    /**
     * @return string[]
     */
    public function getErrorMessages();

    /**
     * @param ViolationRendererInterface|null $renderer
     * @return ValidatorInterface
     */
    public function setViolationRenderer(ViolationRendererInterface $renderer = null);
}
