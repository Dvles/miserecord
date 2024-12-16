<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(length: 255)]
    private ?string $artwork = null;

    #[ORM\Column(length: 255)]
    private ?string $spotifyLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtubeLink = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $soundcloudLink = null;

    #[ORM\Column]
    private ?int $numTracks = null;

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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getArtwork(): ?string
    {
        return $this->artwork;
    }

    public function setArtwork(string $artwork): static
    {
        $this->artwork = $artwork;

        return $this;
    }

    public function getSpotifyLink(): ?string
    {
        return $this->spotifyLink;
    }

    public function setSpotifyLink(string $spotifyLink): static
    {
        $this->spotifyLink = $spotifyLink;

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): static
    {
        $this->youtubeLink = $youtubeLink;

        return $this;
    }

    public function getSoundcloudLink(): ?string
    {
        return $this->soundcloudLink;
    }

    public function setSoundcloudLink(?string $soundcloudLink): static
    {
        $this->soundcloudLink = $soundcloudLink;

        return $this;
    }

    public function getNumTracks(): ?int
    {
        return $this->numTracks;
    }

    public function setNumTracks(int $numTracks): static
    {
        $this->numTracks = $numTracks;

        return $this;
    }
}
