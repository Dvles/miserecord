<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTime;

class ArtistFixtures extends Fixture

{
    public function load(ObjectManager $manager): void
    {
        // Array of artist data
        $artists = [
            [
                'artistName' => 'Rudimental',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Rudimental is a British drum and bass band known for their eclectic mix of genres including electronic, soul, and jazz.',
                'isBand' => true
            ],
            [
                'artistName' => 'Kraftwerk',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Kraftwerk is a German electronic band widely considered to be pioneers of electronic music and influential in the genre.',
                'isBand' => true
            ],
            [
                'artistName' => 'Tommy Guerrero',
                'firstName' => 'Tommy',
                'lastName' => 'Guerrero',
                'birthDate' => new DateTime('1966-09-09'),
                'bio' => 'Tommy Guerrero is an American skateboarder and musician, known for his instrumental hip hop and soulful sound.',
                'isBand' => false
            ],
            [
                'artistName' => 'Flow Dan',
                'firstName' => 'Daniel',
                'lastName' => 'Lowe',
                'birthDate' => new DateTime('1987-07-03'),
                'bio' => 'Flow Dan is a British grime artist and one of the pioneers of the UK grime scene.',
                'isBand' => false
            ],
            [
                'artistName' => 'Azealia Banks',
                'firstName' => 'Azealia',
                'lastName' => 'Banks',
                'birthDate' => new DateTime('1991-05-31'),
                'bio' => 'Azealia Banks is an American rapper, singer, and songwriter known for her bold, unique style and often controversial lyrics.',
                'isBand' => false
            ],
            [
                'artistName' => 'Dam Swindle',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Dam Swindle is a Dutch duo producing deep house, disco, and soulful house music.',
                'isBand' => true
            ],
            [
                'artistName' => 'Reinel Bakole',
                'firstName' => 'Reinel',
                'lastName' => 'Bakole',
                'birthDate' => new DateTime('1994-12-14'),
                'bio' => 'Reinel Bakole is a young African artist known for her work blending afrobea and soul with contemporary music.',
                'isBand' => false
            ],
            [
                'artistName' => 'Geotheory',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Geotheory is an electronic music producer known for ambient and cinematic compositions with organic sound design.',
                'isBand' => true
            ],
            [
                'artistName' => 'Little Dragon',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Little Dragon is a Swedish electronic music band blending synth-pop, R&B, and jazz influences.',
                'isBand' => true
            ]
        ];

        // Loop through each artist and persist them
        foreach ($artists as $artistData) {
            $artist = new Artist();
            $artist->setArtistName($artistData['artistName']);
            $artist->setFirstName($artistData['firstName']);
            $artist->setLastName($artistData['lastName']);
            $artist->setBirthdate($artistData['birthDate']);
            $artist->setBio($artistData['bio']);
            $artist->setIsBand($artistData['isBand']);
            $manager->persist($artist);
        }

        // Flush to save to database
        $manager->flush();
    }
}
