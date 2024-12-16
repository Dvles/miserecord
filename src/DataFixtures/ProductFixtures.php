<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Product;
use App\Enum\ProductTypesEnum;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;



class ProductFixtures extends Fixture implements DependentFixtureInterface

{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create("en_UK");
        $artistrep = $manager->getRepository(Artist::class);
        $artists = $artistrep->findAll();
        $productTypesEnum = [ProductTypesEnum::ARTWORK, ProductTypesEnum::VINYL, ProductTypesEnum::MERCH];

        for($i = 0; $i < 20; ++$i) {

            $price = rand(5,85);
            $type = $productTypesEnum[rand(0, 2)];
            $artist = $artists[rand(0,count($artists)-1)];
            $artistName = $artist->getArtistName();
            $productName = $artistName . " " .  $type->value ; 

            $product = new Product();
            $product->setName($productName);
            $product->setType($type);
            $product->setDescription($faker->paragraph(3));
            $product->setPrice($price);
            $product->setImg("https://via.placeholder.com/500x720");
 
            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            ArtistFixtures::class
            ];
    }
}

