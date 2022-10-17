<?php

namespace App\Entity;

use App\Repository\AirportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
class Airport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 2)]
    private ?string $country_code = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 3)]
    private ?string $iata_code = null;

    #[ORM\Column(length: 4)]
    private ?string $icao_code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'from_airport_id', targetEntity: Flight::class)]
    private Collection $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

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

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getIataCode(): ?string
    {
        return $this->iata_code;
    }

    public function setIataCode(string $iata_code): self
    {
        $this->iata_code = $iata_code;

        return $this;
    }

    public function getIcaoCode(): ?string
    {
        return $this->icao_code;
    }

    public function setIcaoCode(string $icao_code): self
    {
        $this->icao_code = $icao_code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Flight>
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights->add($flight);
            $flight->setFromAirportId($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->removeElement($flight)) {
            // set the owning side to null (unless already changed)
            if ($flight->getFromAirportId() === $this) {
                $flight->setFromAirportId(null);
            }
        }

        return $this;
    }
}
