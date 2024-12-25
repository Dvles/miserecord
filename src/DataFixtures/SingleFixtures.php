<?php
namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Single;
use GuzzleHttp\Client; // Importing Guzzle HTTP Client for making API requests to Spotify and other services
use App\DataFixtures\ArtistFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SingleFixtures extends Fixture implements DependentFixtureInterface
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

        // List of artists to fetch singles for
        $artistrep = $manager->getRepository(Artist::class);
        $artists = $artistrep->findAll();

        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // Step 2: Fetch track data for the artist
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

            $data = json_decode($response->getBody(), true); // Deserialize the JSON response body from the Spotify API into an associative arrays

            // Step 3: Validate API response and fetch track data
            if (!isset($data['tracks']['items'][0])) {
                echo "No track data found for artist: $artistName\n";
                continue;
            }

            // Loop through the fetched tracks
            foreach ($data['tracks']['items'] as $track) {
                // Check if the artist is the main artist or featured artist, but not the other way around
                $mainArtistFound = false;
                foreach ($track['artists'] as $index => $trackArtist) {
                    if ($trackArtist['name'] === $artistName) {
                        // Case 1: If the track has only one artist (the artist is the sole artist)
                        if (count($track['artists']) === 1) {
                            $mainArtistFound = true;
                            break;
                        }

                        // Case 2: If the track has multiple artists, ensure the artist is either first or featured with another artist (not the other way around)
                        if (count($track['artists']) === 2 && $index === 0) {
                            // If the artist is first in a track with exactly two artists
                            $mainArtistFound = true;
                            break;
                        }
                    }
                }


                // If the artist is the only one in the track's artists array, create the "Single" entity
                if ($mainArtistFound) {

                    

                    $single = new Single();
                    $single->setTitle($track['name']);
                    $single->setReleaseDate(new \DateTime($track['album']['release_date']));
                    $single->setDuration($track['duration_ms'] / 1000); // Convert milliseconds to seconds
                    $single->setArtwork($track['album']['images'][0]['url']); // Use the first image as artwork
                    $single->setSpotifyLink($track['external_urls']['spotify']);
                    $single->setYoutubeLink(''); // You can integrate YouTube API for this later

                    // Check if the track is part of an album or if it was released as a single
                    $albumType = $track['album']['album_type'];  // Get the album type field
                    if ($albumType === 'single') {
                        $single->SetReleasedAsSingle(true); // Released only as a single
                    } else {
                        $single->SetReleasedAsSingle(false); // Part of an album
                    }

                    $single->setArtist($artist);

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

