<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GenreFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $genres = [
            ['name' => 'Electronic', 'description' => 'Electronic music uses digital instruments and technology for sound production, including genres like house, techno, and dubstep.'],
            ['name' => 'Hip-hop', 'description' => 'Hip-hop music features rhythmic and rhyming speech, commonly known as rapping, over beats and samples.'],
            ['name' => 'Rock', 'description' => 'Rock music is characterized by a strong rhythm and the use of electric guitars, typically blending with various other musical influences.'],
            ['name' => 'Pop', 'description' => 'Pop music is known for its catchy melodies, simple structure, and mainstream appeal, often designed for mass radio play.'],
            ['name' => 'R&B', 'description' => 'Rhythm and blues (R&B) is known for soulful vocals and a mix of jazz, blues, and gospel influences, with an emphasis on groove and melody.'],
            ['name' => 'Jazz', 'description' => 'Jazz is an improvisational style of music that blends African rhythms with European harmony, often featuring brass and woodwind instruments.'],
        ];

        foreach ($genres as $genreData) {
            $genre = new Genre();
            $genre->setName($genreData['name']);
            $genre->setDescription($genreData['description']);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}
