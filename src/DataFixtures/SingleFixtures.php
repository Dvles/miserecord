<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Genre;
use App\Entity\Artist;
use App\Entity\Single;
use App\DataFixtures\ArtistFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use GuzzleHttp\Client; 

class SingleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("en_UK");
        
        // Fake custom artist data
        $customArtists = [
            'Elias Moreno' => 'https://placekitten.com/200/300',
            'Lerato Ndlovu' => 'https://placekitten.com/200/300',
            'Akari Tanakii' => 'https://placekitten.com/200/300', 
            'Zephyr Collective' => 'https://placekitten.com/200/300',
        ];

        // Initialize Spotify client
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

        // Step 2: Process artists and create Singles
        $artistRepository = $manager->getRepository(Artist::class);
        $genreRepository = $manager->getRepository(Genre::class);

        // Get all artists
        $artists = $artistRepository->findAll();
        
        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // Check if the artist is a custom artist
            if (array_key_exists($artistName, $customArtists)) {
                echo "Assigning custom image for: $artistName\n";

                // Create a new single for the custom artist
                $single = new Single();
                $single->setTitle($faker->sentence)
                       ->setReleaseDate(new \DateTime())
                       ->setDuration(rand(180, 300)) // Random duration between 3 and 5 minutes
                       ->setArtwork($customArtists[$artistName]) // Custom artwork URL
                       ->setSpotifyLink('')
                       ->setYoutubeLink('');

                // Assign genres to the single (you can pick some random genres here)
                $genres = $genreRepository->findBy([], null, 3); // Pick 3 random genres for each custom single
                foreach ($genres as $genre) {
                    $single->addGenre($genre);
                }

                $single->setReleasedAsSingle($albumType === 'single');

                // Set the artist
                $single->setArtist($artist);

                $manager->persist($single);
                continue; // Skip Spotify lookup for custom artists
            }

            // Step 3: Fetch track data for non-custom artists
            $response = $client->get('https://api.spotify.com/v1/search', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken, // Use the token here
                ],
                'query' => [
                    'q' => 'artist:"' . $artistName . '"',
                    'type' => 'track',
                    'limit' => 20,
                ],
            ]);

            $data = json_decode($response->getBody(), true); // Deserialize the JSON response body from the Spotify API

            // Add a delay to respect the API rate limit
            usleep(200000);

            // Check if the artist has any tracks
            if (!isset($data['tracks']['items'][0])) {
                echo "No track data found for artist: $artistName\n";
                continue;
            }

            // Loop through the fetched tracks
            foreach ($data['tracks']['items'] as $track) {
                // Check if the artist is the main artist or featured artist
                $mainArtistFound = false;
                foreach ($track['artists'] as $index => $trackArtist) {
                    if ($trackArtist['name'] === $artistName) {
                        // If the artist is the main artist or featured, create a single
                        $mainArtistFound = true;
                        break;
                    }
                }

                // If the artist is the main artist, create the "Single" entity
                if ($mainArtistFound) {
                    $single = new Single();
                    $single->setTitle($track['name'])
                           ->setReleaseDate(new \DateTime($track['album']['release_date']))
                           ->setDuration($track['duration_ms'] / 1000) // Convert milliseconds to seconds
                           ->setArtwork($track['album']['images'][0]['url']) // Use the first image as artwork
                           ->setSpotifyLink($track['external_urls']['spotify'])
                           ->setYoutubeLink(''); // You can integrate YouTube API for this later

                    // Add genres (can be defined based on your genre mapping logic)
                    $genres = $genreRepository->findBy([], null, 3); // Pick 3 random genres
                    foreach ($genres as $genre) {
                        $single->addGenre($genre);
                    }

                    // Set the artist
                    $single->setArtist($artist);

                    // Check if the track is a single or part of an album
                    $albumType = $track['album']['album_type'];  // Get the album type field
                    $single->setReleasedAsSingle($albumType === 'single'); // If it's a single

                    $manager->persist($single);
                }
            }
        }

        // Step 4: Save all persisted data to the database
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ArtistFixtures::class];
    }
}

