<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class MaxPassengers extends Constraint
{
    public string $message = 'There can be a maximum of %max% passengers on this flight.';

    public function __construct(public int $max = 12, mixed $options = null, array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);
    }
}
