<?php

namespace App\Entity;

use App\Repository\FlightRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
class Flight
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'flights')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Airport $from_airport = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Airport $to_airport = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $departure_time = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $arrival_time = null;

    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Passenger::class, orphanRemoval: true)]
    private Collection $passengers;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function get(): ?int
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

    public function getFromAirport(): ?Airport
    {
        return $this->from_airport;
    }

    public function setFromAirportId(?Airport $from_airport_id): self
    {
        $this->from_airport_id = $from_airport;

        return $this;
    }

    public function getToAirport(): ?Airport
    {
        return $this->to_airport;
    }

    public function setToAirportId(?Airport $to_airport_id): self
    {
        $this->to_airport_id = $to_airport;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeImmutable
    {
        return $this->departure_time;
    }

    public function setDepartureTime(\DateTimeImmutable $departure_time): self
    {
        $this->departure_time = $departure_time;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeImmutable
    {
        return $this->arrival_time;
    }

    public function setArrivalTime(\DateTimeImmutable $arrival_time): self
    {
        $this->arrival_time = $arrival_time;

        return $this;
    }

    /**
     * @return Collection<int, Passenger>
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(Passenger $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers->add($passenger);
            $passenger->setFlight($this);
        }

        return $this;
    }

    public function removePassenger(Passenger $passenger): self
    {
        if ($this->passengers->removeElement($passenger)) {
            // set the owning side to null (unless already changed)
            if ($passenger->getFlight() === $this) {
                $passenger->setFlight(null);
            }
        }

        return $this;
    }
}