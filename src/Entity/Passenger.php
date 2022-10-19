<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PassengerRepository;
use App\Validator\MaxPassengers;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PassengerRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
        new Patch(denormalizationContext: [AbstractNormalizer::GROUPS => ['passengers:write', 'passengers:patch']])
    ],
    normalizationContext: [
        AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
        AbstractNormalizer::GROUPS => ['passengers:read', 'flights:read', 'timestampable']
    ],
    denormalizationContext: [AbstractNormalizer::GROUPS => ['passengers:write']]
)]
#[UniqueEntity(
    fields: ['flight', 'seatAssignment'],
    message: 'This seat has already been taken on this flight.',
    errorPath: 'seatAssignment',
)]
class Passenger implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['passengers:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(min: 2, max: 255)]
    #[Groups(['passengers:read', 'passengers:write'])]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(min: 2, max: 255)]
    #[Groups(['passengers:read', 'passengers:write'])]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Email]
    #[Groups(['passengers:read', 'passengers:write'])]
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'passengers'), ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank, Assert\Valid]
    #[Groups(['passengers:read', 'passengers:write'])]
    #[MaxDepth(1)]
    #[MaxPassengers(max: 32)]
    private ?Flight $flight = null;

    #[ORM\Column(length: 8)]
    #[Groups(['passengers:read', 'passengers:patch'])]
    #[Assert\Range(min: 1, max: 32)]
    private ?int $seatAssignment = null;

    #[ORM\Column(length: 32)]
    #[Assert\NotBlank, Assert\Length(min: 10, max: 32)]
    #[Groups(['passengers:read', 'passengers:write'])]
    private ?string $passportNumber = null;

    /** @return ArrayCollection<int> */
    protected function getAvailableSeats(): ArrayCollection
    {
        $assignedSeats = $this
            ->getFlight()
            ->getPassengers()
            ->map(fn(Passenger $passenger) => $passenger->getSeatAssignment())
            ->getValues();

        return (new ArrayCollection(range(1, 32)))
            ->filter(fn($seat) => !in_array($seat, $assignedSeats));
    }

    #[ORM\PrePersist]
    public function automaticSeatAssignment(LifecycleEventArgs $args)
    {
        $seat = array_rand($this->getAvailableSeats()->toArray());
        $this->setSeatAssignment($seat);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

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

    public function getSeatAssignment(): ?int
    {
        return $this->seatAssignment;
    }

    public function setSeatAssignment(int $seatAssignment): self
    {
        $this->seatAssignment = $seatAssignment;

        return $this;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passportNumber;
    }

    public function setPassportNumber(string $passportNumber): self
    {
        $this->passportNumber = $passportNumber;

        return $this;
    }
}
