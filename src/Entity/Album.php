<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 355)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(length: 850)]
    private ?string $artwork = null;

    #[ORM\Column(length: 650)]
    private ?string $spotifyLink = null;

    #[ORM\Column(length: 650, nullable: true)]
    private ?string $youtubeLink = null;

    #[ORM\Column(length: 650, nullable: true)]
    private ?string $soundcloudLink = null;

    #[ORM\Column]
    private ?int $numTracks = null;

    /**
     * @var Collection<int, Single>
     */
    #[ORM\OneToMany(targetEntity: Single::class, mappedBy: 'album')]
    private Collection $single;

    #[ORM\ManyToOne(inversedBy: 'album')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $artist = null;

    /**
     * @var Collection<int, Producer>
     */
    #[ORM\ManyToMany(targetEntity: Producer::class, mappedBy: 'albums')]
    private Collection $producers;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'albums')]
    private Collection $genres;

    public function __construct()
    {
        $this->single = new ArrayCollection();
        $this->producers = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Single>
     */
    public function getSingle(): Collection
    {
        return $this->single;
    }

    public function addSingle(Single $single): static
    {
        if (!$this->single->contains($single)) {
            $this->single->add($single);
            $single->setAlbum($this);
        }

        return $this;
    }

    public function removeSingle(Single $single): static
    {
        if ($this->single->removeElement($single)) {
            // set the owning side to null (unless already changed)
            if ($single->getAlbum() === $this) {
                $single->setAlbum(null);
            }
        }

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

    /**
     * @return Collection<int, Producer>
     */
    public function getProducers(): Collection
    {
        return $this->producers;
    }

    public function addProducer(Producer $producer): static
    {
        if (!$this->producers->contains($producer)) {
            $this->producers->add($producer);
            $producer->addAlbum($this);
        }

        return $this;
    }

    public function removeProducer(Producer $producer): static
    {
        if ($this->producers->removeElement($producer)) {
            $producer->removeAlbum($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addAlbum($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeAlbum($this);
        }

        return $this;
    }
}
