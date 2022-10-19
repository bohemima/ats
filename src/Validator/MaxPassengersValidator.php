<?php

namespace App\Validator;

use App\Entity\Flight;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MaxPassengersValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function validate($flight, Constraint $constraint)
    {
        /* @var MaxPassengers $constraint */

        if (!$flight instanceof Flight) {
            return;
        }

        if ($flight->getPassengers()->count() > $constraint->max)
        {
            $this->context->addViolation($constraint->message, [
                '%max%' => $constraint->max
            ]);
        }
    }
}
