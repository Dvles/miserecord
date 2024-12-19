<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $artistName = null;

    #[ORM\Column(length: 255, nullable: true)]  
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]  
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]  
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 350)]
    private ?string $bio = null;


    #[ORM\Column(type: Types::BOOLEAN)] 
    private bool $isBand = false;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'artists')]
    private Collection $artistProduct;

    public function __construct()
    {
        $this->artistProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistName(): ?string
    {
        return $this->artistName;
    }

    public function setArtistName(string $artistName): static
    {
        $this->artistName = $artistName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static  // Nullable setter
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static  // Nullable setter
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static  // Nullable setter
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }


    public function getIsBand(): bool
    {
        return $this->isBand;
    }

    public function setIsBand(bool $isBand): static
    {
        $this->isBand = $isBand;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getArtistProduct(): Collection
    {
        return $this->artistProduct;
    }

    public function addArtistProduct(Product $artistProduct): static
    {
        if (!$this->artistProduct->contains($artistProduct)) {
            $this->artistProduct->add($artistProduct);
        }

        return $this;
    }

    public function removeArtistProduct(Product $artistProduct): static
    {
        $this->artistProduct->removeElement($artistProduct);

        return $this;
    }
}

