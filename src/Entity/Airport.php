<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\AirportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: [
        AbstractNormalizer::GROUPS => ['airports:read', 'flights:read', 'timestampable'],
        AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true
    ],
    denormalizationContext: [AbstractNormalizer::GROUPS => ['airports:write']],
)]
class Airport implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['airports:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 2)]
    #[Assert\NotBlank]
    #[Groups(['airports:read', 'airports:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $countryCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['airports:read', 'airports:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $city = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank]
    #[Groups(['airports:read', 'airports:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $iataCode = null;

    #[ORM\Column(length: 4)]
    #[Assert\NotBlank]
    #[Groups(['airports:read', 'airports:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $icaoCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['airports:read', 'airports:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'fromAirport', targetEntity: Flight::class)]
    #[Groups(['airports:read'])]
    #[MaxDepth(1)]
    private Collection $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self
    {
        $this->countryCode = $countryCode;

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
        return $this->iataCode;
    }

    public function setIataCode(string $iataCode): self
    {
        $this->iataCode = $iataCode;

        return $this;
    }

    public function getIcaoCode(): ?string
    {
        return $this->icaoCode;
    }

    public function setIcaoCode(string $icaoCode): self
    {
        $this->icaoCode = $icaoCode;

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
