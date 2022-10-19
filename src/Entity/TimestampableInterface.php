<?php

namespace App\Entity;

use DateTimeInterface;

interface TimestampableInterface
{
    public function getCreatedAt(): ?DateTimeInterface;

    public function getUpdatedAt(): ?DateTimeInterface;
}