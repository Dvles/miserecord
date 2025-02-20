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
        //Featured products

        $artistrep = $manager->getRepository(Artist::class);
        $artists = $artistrep->findAll();
        $faker = Factory::create("en_UK");

        $featuredProducts = [
            [
                'name' => 'We the generation (Rudimental) Vinyl',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Rudimental',
                'price' => 40,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740068107/vinly_rudimental_yya17n.png',
            ],
            [
                'name' => 'Soul Food Taqueria Vinly',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Tommy Guerrero',
                'price' => 30,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740068107/vinly_tommy_mxubxq.png',
            ],
            [
                'name' => 'Radioactivity Vinyl',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Kraftwerk',
                'price' => 40,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740068106/vinly_kraftwerk_tso4nj.png',
            ],
            [
                'name' => '10 Year Anniversiray - Collectors Vinyl',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Krafwerk',
                'price' => 30,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740068106/vinly_collector_sjvutj.png',
            ],

            [
                'name' => 'VIVADLY Vinyl',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'DA SHO',
                'price' => 40,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740066763/vinly_dasho_rae6s0.png',
            ],
            [
                'name' => 'Sacred Bond Vinly',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Night Pulse',
                'price' => 30,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740066722/vinly_night_derx9i.png',
            ],
            [
                'name' => 'Malachai',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Malachai Blade',
                'price' => 18,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740066805/vinly_malachai_mzhypg.png',
            ],

            
            [
                'name' => 'Invisible vinly',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Da SHO',
                'price' => 28,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740069606/vinly_dasho2_vaiedy.png',
            ],
            [
                'name' => 'Undefined Orbit Vinly',
                'type' => ProductTypesEnum::VINYL,
                'artist' => 'Echoes of Orion',
                'price' => 28,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740066845/vinly_echoes_xy2cae.png',
            ],
            [
                'name' => 'VIVADLY T-shirt',
                'type' => ProductTypesEnum::MERCH,
                'artist' => 'DA SHO',
                'price' => 20,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740067607/app_dasho_kp1jhu.png',
            ],
            [
                'name' => 'Sacred Bond (Night Pulse) T-shirt',
                'type' => ProductTypesEnum::MERCH,
                'artist' => 'Night Pulse',
                'price' => 20,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740067607/app_nightpulse_zxli0k.png',
            ],
            [
                'name' => 'The Velvet Growl T-shirt',
                'type' => ProductTypesEnum::MERCH,
                'artist' => 'The Velvet Growl',
                'price' => 20,
                'img' => 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740067607/app_velvetechoes_nr585s.png',
            ],
        ];

        // Loop through each product and create Product entities dynamically
        foreach ($featuredProducts as $productData) {
            $artist = $artistrep->findOneBy(['artistName' => $productData['artist']]);

            if (!$artist) {
                continue; 
            }

            $product = new Product();
            $product->setName($productData['name']);
            $product->setType($productData['type']);
            $product->addArtist($artist);
            $product->setDescription($faker->paragraph(3)); // Random description
            $product->setPrice($productData['price']);
            $product->setImg($productData['img']);

            $manager->persist($product); // Persist product
        }



        
        // Random products
        
        $productTypesEnum = [ProductTypesEnum::ARTWORK, ProductTypesEnum::VINYL, ProductTypesEnum::MERCH];
        $productExtra = ["collector", "XXL", "limited edition", "signed", "unplugged"];

        // Image mappings
        $vinylImages = [
            'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060646/vinly_miserecord6_onlat3.png',
            'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060645/vinly_miserecord7_hbdffl.png',
            'https://res.cloudinary.com/dzqge7ico/image/upload/v1740060645/vinly_miserecord8_b2s3ql.png',
        ];
        $artworkImage  = 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740066121/merch_miserecord_ztqqy7.png';
        $merchImage = 'https://res.cloudinary.com/dzqge7ico/image/upload/v1740066121/merch_miserecord_ztqqy7.png';

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
