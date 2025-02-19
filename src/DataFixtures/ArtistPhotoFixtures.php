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
        $customArtists = [
            'Elias Moreno' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974094/elias_rw1b0g.jpg',
            'The Velvet Echo' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974094/velvet_echo_oufqz5.png',
            'Lerato Ndlovu' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974094/openart-image_h1621Lkw_1739972604685_raw_ed7o1u.png',
            'Akari Tanakii' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739975403/akari_tanakii_tuklyx.jpg', 
            'Zephyr Collective' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974093/zephyr_colllective_tkdxgm.jpg',
            'Flow Dan' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739975171/flowdan_zdenoe.jpg',
            'DA SHO' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982445/openart-image_lSZ6QBaq_1739972516158_raw_uri3bg.jpg',
            'Sophia Reyes' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982446/sophia_fnui1k.png',
            'Night Pulse' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982446/night_pulse_u6y7qa.png',
            'Yung KiXX' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982445/yung_qs31es.png'
        ];
        
        
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
        
            // If the artist is in our predefined list, use our custom image
            if (array_key_exists($artistName, $customArtists)) {
                echo "Assigning custom image for: $artistName\n";
        
                $artistPhoto = new ArtistPhoto();
                $artistPhoto->setFilePath($customArtists[$artistName]); 
                $artistPhoto->setCaption($artistName . ' - Custom Image');
                $artistPhoto->setUploadedAt(new \DateTimeImmutable());
                $artistPhoto->setArtist($artist);
        
                $manager->persist($artistPhoto);
                continue; // Skip Spotify lookup for this artist
            }
        
            // Continue with Spotify API for other artists
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
            usleep(200000); // Delay to respect API rate limits
        
            if (isset($data['artists']['items'][0]['images']) && !empty($data['artists']['items'][0]['images'])) {
                $images = $data['artists']['items'][0]['images'];
                $largeImages = array_filter($images, fn($image) => $image['height'] > 500);
                $imagesToSave = array_slice($largeImages, 0, 5);
        
                foreach ($imagesToSave as $image) {
                    $artistPhoto = new ArtistPhoto();
                    $artistPhoto->setFilePath($image['url']); 
                    $artistPhoto->setCaption($artistName);
                    $artistPhoto->setUploadedAt(new \DateTimeImmutable());
                    $artistPhoto->setArtist($artist);
        
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
