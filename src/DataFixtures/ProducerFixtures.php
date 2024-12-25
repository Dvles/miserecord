<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Album;
use App\Entity\Single;
use App\Entity\Producer;
use App\Enum\ProducerRolesEnum;
use App\DataFixtures\AlbumFixtures;
use App\DataFixtures\SingleFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class ProducerFixtures extends Fixture implements DependentFixtureInterface

{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("en_UK");
        $singleRep = $manager->getRepository(Single::class);
        $singles = $singleRep->findAll();
        $albumsRep = $manager->getRepository(Album::class);
        $albums = $albumsRep ->findAll();

        // map all producer 

        $producerRolesEnum = [
            ProducerRolesEnum::SONGWRITER,
            ProducerRolesEnum::MIXING_ENGINEER,
            ProducerRolesEnum::MASTERING_ENGINEER,
            ProducerRolesEnum::RECORDING_ENGINEER,
            ProducerRolesEnum::ARRANGER,
            ProducerRolesEnum::COMPOSER,
            ProducerRolesEnum::CO_PRODUCER,
            ProducerRolesEnum::LYRICIST,
            ProducerRolesEnum::SOUND_DESIGNER,
            ProducerRolesEnum::VOCAL_PRODUCER,
            ProducerRolesEnum::INSTRUMENTALIST,
            ProducerRolesEnum::PRODUCTION_MANAGER,
            ProducerRolesEnum::SESSION_MUSICIANS
        ];


        $mainProducers=[];
        $otherProducers=[];


        // producer role
        for($i = 0; $i < 20; ++$i) {
            $producer = new Producer();
            $producer->setFirstName($faker->firstName);
            $producer->setLastName($faker->lastName);
            $producer->setProdRole(ProducerRolesEnum::PRODUCER);
            $manager->persist($producer);
            $mainProducers[]=$producer;

        }

        // other roles
        for($i = 0; $i < 30; ++$i) {
            $producer = new Producer();
            $producer->setFirstName($faker->firstName);
            $producer->setLastName($faker->lastName);
            $producer->setProdRole($faker->randomElement($producerRolesEnum));
            $manager->persist($producer);
            $otherProducers[]=$producer;
        }

        foreach ($singles as $single) {
            $randProd = random_int(0, count($mainProducers) - 1);
            $single->addProducer($mainProducers[$randProd]);
            $randProd = random_int(0, count($otherProducers) - 1);
            $single->addProducer($otherProducers[$randProd]);
        }
        

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            SingleFixtures::class,
            AlbumFixtures::class
            ];
    }
}

