<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Genre;
use App\Entity\Artist;
use App\Entity\Single;
use GuzzleHttp\Client;
use App\DataFixtures\ArtistFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SingleFixtures extends Fixture implements DependentFixtureInterface
{
    private string $clientId;
    private string $clientSecret;

    public function __construct(ParameterBagInterface $params)
    {
        $this->clientId = $params->get('spotify_client_id');
        $this->clientSecret = $params->get('spotify_client_secret');
    }

    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("en_UK");

        // Fake custom artist data
        $customArtists = [
            'Elias Moreno' => 'https://placekitten.com/200/300',
            'Lerato Ndlovu' => 'https://placekitten.com/200/300',
            'Akari Tanakii' => 'https://placekitten.com/200/300',
            'Zephyr Collective' => 'https://placekitten.com/200/300',
            'DA SHO' => 'https://placekitten.com/200/300',
            'Sophia Reyes' => 'https://placekitten.com/200/300',
            'Night Pulse' => 'https://placekitten.com/200/300',
            'Yung KiXX' => 'https://placekitten.com/200/300',
            'Luna Vérité' => 'https://placekitten.com/200/300',
            'The Hollow Pines' => 'https://placekitten.com/200/300',
            'Dante Flux' => 'https://placekitten.com/200/300',
            'Eclipse District' => 'https://placekitten.com/200/300',
            'Juno Starlight' => 'https://placekitten.com/200/300',
            'Ghost Circuit' => 'https://placekitten.com/200/300',
            'Malachai Blade' => 'https://placekitten.com/200/300',
            'Echoes of Orion' => 'https://placekitten.com/200/300',
            'Velvet Hush' => 'https://placekitten.com/200/300',
            'Solar Flux' => 'https://placekitten.com/200/300',
        ];

        // Initialize Spotify client
        $client = new Client();

        // Step 1: Obtain an Access Token via the Client Credentials Flow
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        $accessToken = $data['access_token'] ?? null;

        if (!$accessToken) {
            throw new \Exception("Failed to retrieve Spotify access token.");
        }

        // Step 2: Process artists and create Singles
        $artistRepository = $manager->getRepository(Artist::class);
        $genreRepository = $manager->getRepository(Genre::class);

        $artists = $artistRepository->findAll();

        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // If artist is in the custom list, assign custom image
            if (array_key_exists($artistName, $customArtists)) {
                echo "Assigning custom image for: $artistName\n";

                $single = new Single();
                $single->setTitle(ucwords(implode(' ', $faker->words(3))))
                    ->setReleaseDate(new \DateTime())
                    ->setDuration(rand(180, 300))
                    ->setArtwork($customArtists[$artistName])
                    ->setSpotifyLink('')
                    ->setYoutubeLink('');

                // Assign random genres
                $genres = $genreRepository->findBy([], null, 3);
                foreach ($genres as $genre) {
                    $single->addGenre($genre);
                }

                $single->setReleasedAsSingle(true);
                $single->setArtist($artist);

                $manager->persist($single);
                continue; // Skip Spotify lookup for custom artists
            }

            // Step 3: Fetch track data for non-custom artists
            $response = $client->get('https://api.spotify.com/v1/search', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'query' => [
                    'q' => 'artist:"' . $artistName . '"',
                    'type' => 'track',
                    'limit' => 20,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Delay to avoid hitting API rate limits
            usleep(200000);

            if (empty($data['tracks']['items'])) {
                echo "No track data found for artist: $artistName\n";
                continue;
            }

            foreach ($data['tracks']['items'] as $track) {
                // Check if the artist is in the track's artist list
                $mainArtistFound = false;
                foreach ($track['artists'] as $trackArtist) {
                    if ($trackArtist['name'] === $artistName) {
                        $mainArtistFound = true;
                        break;
                    }
                }

                if ($mainArtistFound) {
                    $artworkUrl = isset($track['album']['images'][0]) ? $track['album']['images'][0]['url'] : 'https://via.placeholder.com/300';

                    $single = new Single();
                    $single->setTitle($track['name'])
                        ->setReleaseDate(new \DateTime($track['album']['release_date'] ?? 'now'))
                        ->setDuration(($track['duration_ms'] ?? 0) / 1000)
                        ->setArtwork($artworkUrl)
                        ->setSpotifyLink($track['external_urls']['spotify'] ?? '')
                        ->setYoutubeLink('');

                    // Assign random genres
                    $genres = $genreRepository->findBy([], null, 3);
                    foreach ($genres as $genre) {
                        $single->addGenre($genre);
                    }

                    // Ensure 'album_type' exists before using it
                    $albumType = $track['album']['album_type'] ?? 'unknown';
                    $single->setReleasedAsSingle($albumType === 'single');

                    $single->setArtist($artist);

                    $manager->persist($single);
                }
            }
        }

        // Save all persisted data to the database
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ArtistFixtures::class];
    }
}
