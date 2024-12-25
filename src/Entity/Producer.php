<?php

namespace App\Entity;

use App\Enum\ProducerRolesEnum;
use App\Repository\ProducerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProducerRepository::class)]
class Producer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: ProducerRolesEnum::class)]
    private array $prodRole = [];

    /**
     * @var Collection<int, Single>
     */
    #[ORM\ManyToMany(targetEntity: Single::class, inversedBy: 'producers')]
    private Collection $singles;

    /**
     * @var Collection<int, Album>
     */
    #[ORM\ManyToMany(targetEntity: Album::class, inversedBy: 'producers')]
    private Collection $albums;

    public function __construct()
    {
        $this->singles = new ArrayCollection();
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return ProducerRolesEnum[]
     */
    public function getProdRole(): array
    {
        return $this->prodRole;
    }

    public function setProdRole(array $prodRole): static
    {
        $this->prodRole = $prodRole;

        return $this;
    }

    /**
     * @return Collection<int, Single>
     */
    public function getSingles(): Collection
    {
        return $this->singles;
    }

    public function addSingle(Single $single): static
    {
        if (!$this->singles->contains($single)) {
            $this->singles->add($single);
        }

        return $this;
    }

    public function removeSingle(Single $single): static
    {
        $this->singles->removeElement($single);

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        $this->albums->removeElement($album);

        return $this;
    }
}
