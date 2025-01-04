<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Album::class, inversedBy: 'genres')]
    private Collection $albums;

    #[ORM\ManyToMany(targetEntity: Single::class, inversedBy: 'genres')]
    private Collection $singles;

    public function __construct()
        {
            $this->albums = new ArrayCollection();
            $this->singles = new ArrayCollection();
        }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAlbums(): Collection
    {
        return $this->albums;
    }
    
    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->addGenre($this);
        }
    
        return $this;
    }
    
    public function removeAlbum(Album $album): static
    {
        if ($this->albums->removeElement($album)) {
            $album->removeGenre($this);
        }
    
        return $this;
    }

    public function getSingle(): Collection
{
    return $this->singles;
}

public function addSingle(Single $single): static
{
    if (!$this->singles->contains($single)) {
        $this->singles->add($single);
        $single->addGenre($this);
    }

    return $this;
}

public function removeSingle(Single $single): static
{
    if ($this->singles->removeElement($single)) {
        $single->removeGenre($this);
    }

    return $this;
}
}
