<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use GuzzleHttp\Client;
use App\Entity\ArtistPhoto;
use App\DataFixtures\ArtistFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistPhotoFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $client = new Client();

        // Get Spotify access token
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('cd2eb27b27654d679b3559a4ad052e04:362599bd972946d9995f667178a64e3c'),
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $accessToken = $data['access_token'];

        // Fetch all artists from the database
        $artistRepository = $manager->getRepository(Artist::class);
        $artists = $artistRepository->findAll(); 

        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // Request artist data from Spotify API
            $response = $client->get('https://api.spotify.com/v1/search', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'query' => [
                    'q' => 'artist:"' . $artistName . '"',
                    'type' => 'artist', 
                    'limit' => 1, 
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Add a delay to respect the API rate limit
            usleep(200000);

            // Ensure artist images exist in response
            if (isset($data['artists']['items'][0]['images'])) {
                $images = $data['artists']['items'][0]['images'];

                $largeImages = array_filter($images, function ($image) {
                    return $image['height'] > 500 ; // Only select images with width greater than 300px
                });

                $imagesToSave = array_slice($largeImages, 0, 5);

                foreach ($imagesToSave as $image) {
                    $artistPhoto = new ArtistPhoto();
                    $artistPhoto->setFilePath($image['url']); 
                    $artistPhoto->setCaption($artistName);
                    $artistPhoto->setUploadedAt(new \DateTimeImmutable());
                    $artistPhoto->setArtist($artist); // Associate with the artist

                    $manager->persist($artistPhoto);
                }
            } else {
                echo "No image found for artist: $artistName\n";
            }
        }

        
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ArtistFixtures::class];
    }

}
