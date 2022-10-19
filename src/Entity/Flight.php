<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\FlightRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FlightRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: [
        AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        AbstractNormalizer::GROUPS => ['flights:read', 'airports:read', 'timestampable']
    ],
    denormalizationContext: [AbstractNormalizer::GROUPS => ['flights:write']],
)]
class Flight implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['flights:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'flights'), ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank, Assert\Valid]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[Groups(['flights:read', 'flights:write'])]
    #[MaxDepth(1)]
    private ?Airport $fromAirport = null;

    #[ORM\ManyToOne, ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank, Assert\Valid]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    #[Groups(['flights:read', 'flights:write'])]
    #[MaxDepth(1)]
    private ?Airport $toAirport = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank, Assert\Type(DateTimeInterface::class)]
    #[ApiFilter(DateFilter::class, strategy: 'range')]
    #[Groups(['flights:read', 'flights:write'])]
    private ?\DateTimeInterface $departureTime = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank, Assert\Type(DateTimeInterface::class)]
    #[ApiFilter(DateFilter::class, strategy: 'range')]
    #[Groups(['flights:read', 'flights:write'])]
    private ?\DateTimeInterface $arrivalTime = null;

    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Passenger::class, orphanRemoval: true)]
    #[Groups(['flights:read'])]
    private Collection $passengers;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromAirport(): ?Airport
    {
        return $this->fromAirport;
    }

    public function setFromAirport(?Airport $fromAirport): self
    {
        $this->fromAirport = $fromAirport;

        return $this;
    }

    public function getToAirport(): ?Airport
    {
        return $this->toAirport;
    }

    public function setToAirport(?Airport $toAirport): self
    {
        $this->toAirport = $toAirport;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeInterface $departureTime): self
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(\DateTimeInterface $arrivalTime): self
    {
        $this->arrivalTime = $arrivalTime;

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
