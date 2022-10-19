<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait TimestampableTrait
{
    #[ORM\Column]
    #[Groups(['timestampable'])]
    protected ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['timestampable'])]
    protected ?DateTimeImmutable $updatedAt = null;

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
    }

    #[ORM\PrePersist]
    public function prePersist()
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }
}