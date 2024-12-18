<?php

namespace App\Entity;

use App\Repository\SingleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SingleRepository::class)]
class Single
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 455)]
    private ?string $artwork = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $spotifyLink = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $youtubeLinke = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $soundcloudLink = null;

    #[ORM\Column]
    private ?bool $isReleasedAsSingle = null;

    #[ORM\ManyToOne(inversedBy: 'singles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    #[ORM\ManyToOne(inversedBy: 'single')]
    private ?Album $album = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

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

    public function setSpotifyLink(?string $spotifyLink): static
    {
        $this->spotifyLink = $spotifyLink;

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLinke;
    }

    public function setYoutubeLink(?string $youtubeLinke): static
    {
        $this->youtubeLinke = $youtubeLinke;

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

    public function isReleasedAsSingle(): ?bool
    {
        return $this->isReleasedAsSingle;
    }

    public function setReleasedAsSingle(bool $isReleasedAsSingle): static
    {
        $this->isReleasedAsSingle = $isReleasedAsSingle;

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): static
    {
        $this->artist = $artist;

        return $this;
    }

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): static
    {
        $this->album = $album;

        return $this;
    }
}
