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
        $productExtra = ["collector", "XXL", "limited edition", "signed", "unplugged"];

        // Image mappings
        $vinylImages = [
            'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060646/vinly_miserecord6_onlat3.png',
            'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060645/vinly_miserecord7_hbdffl.png',
            'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060645/vinly_miserecord8_b2s3ql.png',
        ];
        $merchImage = 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060994/app_miser_qmphg4.webp';
        $artworkImage = 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060994/merch_miserecord_ztqqy7.webp';

        for ($i = 0; $i < 20; ++$i) {
            $price = rand(5, 85);
            $type = $productTypesEnum[rand(0, 2)];
            $artist = $artists[rand(0, count($artists) - 1)];
            $artistName = $artist->getArtistName();
            $productName = $artistName . " " . $type->value;

            if ($i % 3 == 0) {
                $rnd = rand(0, 4);
                $productName .= " (" . $productExtra[$rnd] . ")";
            }

            // Assign images based on product type
            $image = "https://via.placeholder.com/500x720"; // Default placeholder
            if ($type === ProductTypesEnum::VINYL) {
                $image = $vinylImages[array_rand($vinylImages)];
            } elseif ($type === ProductTypesEnum::MERCH) {
                $image = $merchImage;
            } elseif ($type === ProductTypesEnum::ARTWORK) {
                $image = $artworkImage;
            }

            $product = new Product();
            $product->setName($productName);
            $product->setType($type);
            $product->addArtist($artist);
            $product->setDescription($faker->paragraph(3));
            $product->setPrice($price);
            $product->setImg($image);

            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class
        ];
    }
}
