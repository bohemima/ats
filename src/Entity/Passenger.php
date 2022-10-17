<?php

namespace App\Entity;

use App\Repository\PassengerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PassengerRepository::class)]
class Passenger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $given_name = null;

    #[ORM\Column(length: 255)]
    private ?string $family_name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'passengers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Flight $flight = null;

    #[ORM\Column(length: 8)]
    private ?string $seat_assigment = null;

    #[ORM\Column(length: 32)]
    private ?string $passport_number = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->given_name;
    }

    public function setGivenName(string $given_name): self
    {
        $this->given_name = $given_name;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->family_name;
    }

    public function setFamilyName(string $family_name): self
    {
        $this->family_name = $family_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    public function getSeatAssigment(): ?string
    {
        return $this->seat_assigment;
    }

    public function setSeatAssigment(string $seat_assigment): self
    {
        $this->seat_assigment = $seat_assigment;

        return $this;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passport_number;
    }

    public function setPassportNumber(string $passport_number): self
    {
        $this->passport_number = $passport_number;

        return $this;
    }
}
