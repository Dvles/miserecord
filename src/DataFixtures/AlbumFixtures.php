<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Artist;
use App\Entity\Single;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use GuzzleHttp\Client; // Importing Guzzle HTTP Client for making API requests to Spotify and other services

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $client = new Client();

        // Step 1: Obtain an Access Token via the Client Credentials Flow
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('cd2eb27b27654d679b3559a4ad052e04:362599bd972946d9995f667178a64e3c'),
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        $accessToken = $data['access_token'];

        // Fetch repositories for Artist and Single entities
        $artistRepository = $manager->getRepository(Artist::class);
        $singleRepository = $manager->getRepository(Single::class);
        $genreRepository = $manager->getRepository(Genre::class);

        // Artist-to-genre mapping
        $artistGenreMap = [
            'Rudimental' => ['Pop', 'Electronic'],
            'Kraftwerk' => ['Electronic'],
            'Tommy Guerrero' => ['Electronic'],
            'Flow Dan' => ['Hip Hop'],
            'Azealia Banks' => ['Hip Hop', 'Electronic'],
            'Dam Swindle' => ['Electronic'],
            'Reinel Bakole' => ['R&B'],
            'Geotheory' => ['Electronic'],
            'Little Dragon' => ['Pop', 'Electronic'],
        ];


        $artists = $artistRepository->findAll();

        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // Fetch the genres for this artist
            $genres = [];
            if (array_key_exists($artistName, $artistGenreMap)) {
                foreach ($artistGenreMap[$artistName] as $genreName) {
                    $genre = $genreRepository->findOneBy(['name' => $genreName]);
                    if ($genre) {
                        $genres[] = $genre;
                    }
                }
            }

            // Fetch album data for the artist
            $response = $client->get('https://api.spotify.com/v1/search', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'query' => [
                    'q' => 'artist:"' . $artistName . '"',
                    'type' => 'album',
                    'limit' => 20,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Add a delay to respect the API rate limit
            usleep(200000);

            if (!isset($data['albums']['items']) || empty($data['albums']['items'])) {
                echo "No album data found for artist: $artistName\n";
                continue;
            }


            foreach ($data['albums']['items'] as $albumData) {

                // Skip items that are not real album
                if ($albumData['album_type'] !== 'album') {
                    continue;
                }
                $mainArtistFound = $this->isMainArtist($albumData['artists'], $artistName);

                if ($mainArtistFound) {
                    // Create a new Album entity
                    $album = new Album();
                    $album->setTitle($albumData['name']);
                    $album->setReleaseDate(new \DateTime($albumData['release_date']));
                    $album->setArtwork($albumData['images'][0]['url'] ?? null);
                    $album->setSpotifyLink($albumData['external_urls']['spotify']);
                    $album->setArtist($artist);

                    // Assign genres to the album
                    foreach ($genres as $genre) {
                        $album->addGenre($genre); // Assuming a ManyToOne or ManyToMany relationship
                    }

                    // Fetch tracks for the album
                    $albumTracksResponse = $client->get('https://api.spotify.com/v1/albums/' . $albumData['id'] . '/tracks', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken,
                        ],
                    ]);

                    $albumTracksData = json_decode($albumTracksResponse->getBody(), true);
                    $numTracks = 0;

                    foreach ($albumTracksData['items'] as $trackData) {
                        // Check if the track already exists in the database
                        $existingSingle = $singleRepository->findOneBy([
                            'title' => $trackData['name'],
                            'artist' => $artist,
                        ]);

                        if (!$existingSingle) {
                            // Create a new Single entity for this track
                            $single = new Single();
                            $single->setTitle($trackData['name']);
                            $single->setReleaseDate(new \DateTime($albumData['release_date']));
                            $single->setDuration($trackData['duration_ms'] / 1000);
                            $single->setArtwork($albumData['images'][0]['url'] ?? null);
                            $single->setSpotifyLink($trackData['external_urls']['spotify']);
                            $single->SetReleasedAsSingle(false); // Part of an album
                            $single->setArtist($artist);

                            // Persist the new Single
                            $manager->persist($single);
                        } else {
                            $single = $existingSingle;
                        }

                        // Associate the single with the album
                        $single->setAlbum($album);
                        $album->addSingle($single);
                        $numTracks++;
                    }

                    $album->setNumTracks($numTracks);

                    // Persist the album if it has tracks
                    if ($numTracks > 0) {
                        $manager->persist($album);
                    }

                    // Respect the API rate limit
                    usleep(200000);
                }
            }
        }

        // Flush all changes to the database
        $manager->flush();
    }

    private function isMainArtist(array $albumArtists, string $artistName): bool
    {
        foreach ($albumArtists as $index => $albumArtist) {
            if ($albumArtist['name'] === $artistName && $index === 0) {
                return true;
            }
        }
        return false;
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
            SingleFixtures::class,
            GenreFixtures::class
        ];
    }
}
