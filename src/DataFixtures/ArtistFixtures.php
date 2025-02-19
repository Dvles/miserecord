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
            ],
            [
                'artistName' => 'Elias Moreno',
                'firstName' => 'Elias',
                'lastName' => 'Moreno',
                'birthDate' => new DateTime('1985-03-15'),
                'bio' => 'Elias Moreno is a Spanish guitarist and singer blending Latin rhythms with modern folk influences.',
                'isBand' => false
            ],
            
            [
                'artistName' => 'The Velvet Echo',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'The Velvet Echo is a dream-pop and shoegaze band known for their ethereal soundscapes and haunting melodies.',
                'isBand' => true
            ],
            
            [
                'artistName' => 'Akari Tanakii',
                'firstName' => 'Akari',
                'lastName' => 'Tanaka',
                'birthDate' => new DateTime('1998-11-30'),
                'bio' => 'Akari Tanaka is a Japanese indie pop artist combining lo-fi beats with heartfelt lyrics and minimalist production.',
                'isBand' => false
            ],
            
            [
                'artistName' => 'Zephyr Collective',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Zephyr Collective is a progressive dub jazz ensemble pushing the boundaries of improvisation and electronic fusion.',
                'isBand' => true
            ],
            [
                'artistName' => 'Lerato Ndlovu',
                'firstName' => 'Lerato Maya',
                'lastName' => 'Ndlovu',
                'birthDate' => new DateTime('1999-01-05'),
                'bio' => 'Lerato Ndlovu is a South African jazz and soul singer known for her rich vocals and fusion of Afro-jazz and contemporary R&B.',
                'isBand' => false
            ], 
            [
                'artistName' => 'DA SHO',
                'firstName' => 'Daniella kim',
                'lastName' => 'Shimuya',
                'birthDate' => new DateTime('2000-04-09'),
                'bio' => 'DA Sho is a young rapper known for giving it straight without saying sorry.',
                'isBand' => false
            ],
            
            [
                'artistName' => 'Sophia Reyes',
                'firstName' => 'Sophia',
                'lastName' => 'Reyes',
                'birthDate' => new DateTime('1997-03-14'),
                'bio' => 'Sophia Reyes is a Mexican-American indie singer-songwriter known for her heartfelt ballads and ethereal vocal style.',
                'isBand' => false
            ],
            
            [
                'artistName' => 'Night Pulse',
                'firstName' => null,
                'lastName' => null,
                'birthDate' => null,
                'bio' => 'Night Pulse is an electronic music duo blending chillwave and downtempo with soulful vocal samples and atmospheric production.',
                'isBand' => true
            ],
            [
                'artistName' => 'Yung KiXX',
                'firstName' => "George Junior",
                'lastName' => "Krayon",
                'birthDate' => new DateTime('2003-08-10'),
                'bio' => 'Yung Kixx, latest winner of Rythm and flow, is a rapper known for his slick lines and flipping classical music samples',
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
