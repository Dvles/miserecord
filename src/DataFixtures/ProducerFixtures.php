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
        $albumRep = $manager->getRepository(Album::class);
        $albums = $albumRep->findAll();

        // Define producer roles
        $producerRolesEnum = [
            ProducerRolesEnum::SONGWRITER,
            ProducerRolesEnum::MIXING_ENGINEER,
            ProducerRolesEnum::RECORDING_ENGINEER,
            ProducerRolesEnum::ARRANGER,
            ProducerRolesEnum::COMPOSER,
            ProducerRolesEnum::CO_PRODUCER,
            ProducerRolesEnum::LYRICIST,
            ProducerRolesEnum::SOUND_DESIGNER,
            ProducerRolesEnum::VOCAL_PRODUCER,
            ProducerRolesEnum::INSTRUMENTALIST,
            ProducerRolesEnum::PRODUCTION_MANAGER,
            ProducerRolesEnum::SESSION_MUSICIANS,
        ];
        $masteringProducers=[];

        $mainProducers = [];
        $otherProducers = [];

        // Create main producers with "PRODUCER" role
        for ($i = 0; $i < 20; ++$i) {
            $producer = new Producer();
            $producer->setFirstName($faker->firstName);
            $producer->setLastName($faker->lastName);
            $producer->setProdRole(ProducerRolesEnum::PRODUCER);
            $manager->persist($producer);
            $mainProducers[] = $producer;
        }

        // Create main producers with "MASTERING" role
        for ($i = 0; $i < 10; ++$i) {
            $producer = new Producer();
            $producer->setFirstName($faker->firstName);
            $producer->setLastName($faker->lastName);
            $producer->setProdRole(ProducerRolesEnum::MASTERING_ENGINEER);
            $manager->persist($producer);
            $masteringProducers[] = $producer;
        }

        // Create other producers with diverse roles
        for ($i = 0; $i < 30; ++$i) {
            $producer = new Producer();
            $producer->setFirstName($faker->firstName);
            $producer->setLastName($faker->lastName);

            // Select a random role using mt_rand
            $randomIndex = mt_rand(0, count($producerRolesEnum) - 1);
            $producer->setProdRole([$producerRolesEnum[$randomIndex]]);

            $manager->persist($producer);
            $otherProducers[] = $producer;
        }


        // Assign producers to each single
        foreach ($singles as $single) {
            // Assign one random main producer & mastering engineer
            $single->addProducer($faker->randomElement($mainProducers));
            $single->addProducer($faker->randomElement($masteringProducers));

            // Assign 3 unique random other producers
            $randomProducers = $faker->randomElements($masteringProducers, 3);
            foreach ($randomProducers as $producer) {
                $single->addProducer($producer);
            }
        }

        // Assign producers to each album
        foreach ($albums as $album) {
            // Assign one random main producer
            $album->addProducer($faker->randomElement($mainProducers));
            $album->addProducer($faker->randomElement($masteringProducers));
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SingleFixtures::class,
            AlbumFixtures::class,
        ];
    }
}
