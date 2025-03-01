<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Album;
use App\Entity\Genre;
use App\Entity\Artist;
use App\Entity\Single;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use GuzzleHttp\Client;

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("en_UK");

        // Custom artists and their images
        $customArtists = [
            'Elias Moreno' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974094/elias_rw1b0g.jpg',
            'The Velvet Growl' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974094/velvet_echo_oufqz5.png',
            'Lerato Ndlovu' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974094/openart-image_h1621Lkw_1739972604685_raw_ed7o1u.png',
            'DA SHO' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739975403/akari_tanakii_tuklyx.jpg',
            'Zephyr Collective' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739974093/zephyr_colllective_tkdxgm.jpg',
            'Flow Dan' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739975171/flowdan_zdenoe.jpg',
            'Akari Tanakii' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982445/openart-image_lSZ6QBaq_1739972516158_raw_uri3bg.jpg',
            'Sophia Reyes' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982446/sophia_fnui1k.png',
            'Night Pulse' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740053874/night_xoywpz.jpg',
            'Yung KiXX' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1739982445/yung_qs31es.png',
            'Luna Jadis' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052883/luna_uru4zq.jpg',
            'The Hollow Pines' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052883/hollow_keihov.jpg',
            'Dante Flux' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740053286/Dante2_xp14tl.png',
            'Eclipse District' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052884/Eclipse_lfq91t.png',
            'Juno Starlight' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052883/juno_bbvt3k.png',
            'Ghost Circuit' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052884/ghost_eojrm7.png',
            'Malachai Blade' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052883/Malachai_e2nweg.png',
            'Echoes of Orion' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052883/echoes_kfefrs.jpg',
            'Velvet Hush' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052884/velvethush_cl8gyc.png',
            'Solar Flux' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740052884/Solarflux_dopbet.png',
            'The Obsidian Owls' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740299126/owls_ynoqwp.png',
            'Cece' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740299125/cece_xtmwma.png',
            'T-Droplets' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740299125/drop_ssahrn.jpg',
            'N.D.R.P' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740299126/NDRO_nekbcb.jpg',
            'Neon Mirage' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740299126/neon_q8drxx.png',
            'Kay' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740340742/kayy_kutppe.png',
            'Bizzo' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740340682/Bizza_ldvbih.png',
            'Sir Lorem' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740340682/Sir_Lorem_roicxx.png',
        ];

        // Custom artist genre assignments
        $customArtistGenres = [
            'Elias Moreno' => ['Pop'],
            'The Velvet Growl' => ['Pop'],
            'Lerato Ndlovu' => ['Jazz', 'R&B'],
            'DA SHO' => ['Pop'],
            'Zephyr Collective' => ['Pop', 'Hip-hop'],
            'Flow Dan' => ['Hip-hop'],
            'Akari Tanakii' => ['Hip-hop'],
            'Sophia Reyes' => ['Pop', 'R&B'],
            'Night Pulse' => ['Pop'],
            'Yung KiXX' => ['Hip-hop'],
            'Luna Jadis' => ['Pop'],
            'The Hollow Pines' => ['Rock', 'Electronic'],
            'Dante Flux' => ['R&B', 'Hip-hop'],
            'Eclipse District' => ['Rock', 'Electronic'],
            'Juno Starlight' => ['Pop'],
            'Ghost Circuit' => ['Electronic'],
            'Malachai Blade' => ['Rock'],
            'Echoes of Orion' => ['Rock'],
            'Velvet Hush' => ['Pop', 'R&B'],
            'Solar Flux' => ['Jazz'],
            'The Obsidian Owls' => ['Rock', 'Electronic'],
            'Cece' => ['Pop'],
            'T-Droplets' => ['Pop', 'Hip-hop'],
            'N.D.R.P' => ['Rock', 'Hip-hop'],
            'Neon Mirage' => ['Pop','Electronic'],
            'Kay' => ['Pop', 'R&B'],
            'Bizzo' => ['Hip-hop'],
            'Sir Lorem' => ['Rock', 'Hip-hop']
            
        ];

        // Existing artist genres mapping
        $existingArtistGenres = [
            'Rudimental' => ['Pop', 'Electronic'],
            'JRSK BOYZ' => ['Hip-hop', 'Electronic'],
            'Tommy guerrero' => ['Electronic', 'Pop'],
            'Dam Swindle' => ['Electronic'],
            'Kraftwerk' => ['Electronic'],
            'Little Dragon' => ['Pop'],
            'Flow Dan' => ['Hip-hop'],
            'Reinel Bakole' => ['R&B'],
            'Geotheory' => ['Electronic'],
        ];

        $client = new Client();

        // Step 1: Obtain an Access Token via the Client Credentials Flow
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('98e4731639834084a03f720d67200774:ee5679fed4184a7bb842bcfdfa291424'),
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

        $artists = $artistRepository->findAll();

        foreach ($artists as $artist) {
            $artistName = $artist->getArtistName();

            // Check if the artist is a custom artist
            if (array_key_exists($artistName, $customArtists)) {
                echo "Assigning custom image for: $artistName\n";

                // Create a new album for the custom artist
                $album = new Album();
                $album->setTitle(ucwords(implode(' ', $faker->words(3))))
                    ->setReleaseDate(new \DateTime())
                    ->setArtwork($customArtists[$artistName]) // Custom artwork URL
                    ->setSpotifyLink('')
                    ->setYoutubeLink('');

                // Assign genres based on the customArtistGenres mapping
                if (isset($customArtistGenres[$artistName])) {
                    foreach ($customArtistGenres[$artistName] as $genreName) {
                        $genre = $genreRepository->findOneBy(['name' => $genreName]);
                        if ($genre) {
                            $album->addGenre($genre);
                        }
                    }
                }

                // Set the artist
                $album->setArtist($artist);
                $album->setNumTracks(10);

                $manager->persist($album);
                continue; // Skip Spotify lookup for custom artists
            }

            // Assign genres for real artists from the existingArtistGenres list
            $genres = [];
            if (array_key_exists($artistName, $existingArtistGenres)) {
                foreach ($existingArtistGenres[$artistName] as $genreName) {
                    $genre = $genreRepository->findOneBy(['name' => $genreName]);
                    if ($genre) {
                        $genres[] = $genre;
                    }
                }
            }

            // Fetch album data for the artist (only if it's not a custom artist)
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
                if ($albumData['album_type'] !== 'album') {
                    continue;
                }
                $mainArtistFound = $this->isMainArtist($albumData['artists'], $artistName);

                if ($mainArtistFound) {
                    $album = new Album();
                    $album->setTitle($albumData['name']);
                    $album->setReleaseDate(new \DateTime($albumData['release_date']));
                    $album->setArtwork($albumData['images'][0]['url'] ?? null);
                    $album->setSpotifyLink($albumData['external_urls']['spotify']);
                    $album->setArtist($artist);

                    // Add genres for album (from existingArtistGenres or customArtistGenres)
                    foreach ($genres as $genre) {
                        $album->addGenre($genre);
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
                        $existingSingle = $singleRepository->findOneBy([
                            'title' => $trackData['name'],
                            'artist' => $artist,
                        ]);

                        if (!$existingSingle) {
                            $single = new Single();
                            $single->setTitle($trackData['name']);
                            $single->setReleaseDate(new \DateTime($albumData['release_date']));
                            $single->setDuration($trackData['duration_ms'] / 1000);
                            $single->setArtwork($albumData['images'][0]['url'] ?? null);
                            $single->setSpotifyLink($trackData['external_urls']['spotify']);
                            $single->SetReleasedAsSingle(false); // Part of an album
                            $single->setArtist($artist);

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

                    if ($numTracks > 0) {
                        $manager->persist($album);
                    }

                    // Respect the API rate limit
                    usleep(200000);
                }
            }
        }

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
