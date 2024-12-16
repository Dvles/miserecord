<?php

namespace App\Entity;

use App\Enum\ProductTypesEnum;
use App\Repository\ProducerRepository;
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
     * @return ProductTypesEnum[]
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
}
