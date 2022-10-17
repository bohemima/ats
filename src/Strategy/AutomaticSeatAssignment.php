<?php

namespace App\Strategy;

use Doctrine\ORM\EntityManager;

class AutomaticSeatAssignment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $seat_assignment;

    public function __construct(EntityManager $em)
    {
        // Use EntityManager to find the current flight and check for a free seat
        $this->seat_assignment = 0;
    }
}