<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Single;
use App\Entity\Album;
use GuzzleHttp\Client; // Importing Guzzle HTTP Client for making API requests to Spotify and other services
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

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

        $artists = $artistRepository->findAll();
        $singles = $singleRepository->findAll();

        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // Step 2: Fetch album data for the artist
            $response = $client->get('https://api.spotify.com/v1/search', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken, // Use the token here
                ],
                'query' => [
                    'q' => 'artist:"' . $artistName . '"',
                    'type' => 'album',
                    'limit' => 20,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Add a delay to respect the API rate limit
            usleep(200000); // 200ms delay between requests

            // Step 3: Validate API response and fetch album data
            if (!isset($data['albums']['items']) || empty($data['albums']['items'])) {
                echo "No album data found for artist: $artistName\n";
                continue;
            }

            foreach ($data['albums']['items'] as $albumData) {
                // Check if the artist is the main or a featured artist on the album
                $mainArtistFound = false;
                foreach ($albumData['artists'] as $index => $albumArtist) {
                    if ($albumArtist['name'] === $artistName) {
                        if (count($albumData['artists']) === 1 || $index === 0) {
                            $mainArtistFound = true;
                            break;
                        }
                    }
                }
            
                if ($mainArtistFound) {
                    // Create a new Album entity
                    $album = new Album();
                    $album->setTitle($albumData['name']);
                    $album->setReleaseDate(new \DateTime($albumData['release_date']));
                    $album->setArtwork($albumData['images'][0]['url'] ?? null); // Use the first image as artwork
                    $album->setSpotifyLink($albumData['external_urls']['spotify']);
                    $album->setArtist($artist);
            
                    // Step 1: Fetch tracks for the album
                    $albumTracksResponse = $client->get('https://api.spotify.com/v1/albums/' . $albumData['id'] . '/tracks', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $accessToken,
                        ],
                    ]);
            
                    $albumTracksData = json_decode($albumTracksResponse->getBody(), true);
            
                    // Step 2: Map track names to ensure singles belong to this album
                    $albumTrackNames = array_map(function ($track) {
                        return $track['name'];
                    }, $albumTracksData['items']);
            
                    // Step 3: Link valid singles to the album
                    $numTracks = 0;
                    foreach ($singles as $single) {
                        if ($single->getArtist() === $artist && in_array($single->getTitle(), $albumTrackNames, true)) {
                            $single->setAlbum($album);
                            $album->addSingle($single);
                            $numTracks++;
                        }
                    }
            
                    $album->setNumTracks($numTracks);
            
                    // Persist the album only if it has tracks
                    if ($numTracks > 0) {
                        $manager->persist($album);
                    }
                }
            
                // Add delay to respect rate limit
                usleep(200000); // 200ms delay
            }
            
        }

        // Flush all changes to the database at once
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
        ];
    }
}
