<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        
        for ($i=0; $i < 5; $i++){
            $user = new User;
            $user -> setEmail('user' . $i . "@miserecord.com");
            $user->setRoles(['ROLE_USER']); 
            $hashedPassword = $this->passwordHasher->hashPassword($user, '0000');
            $user->setPassword($hashedPassword);
            $user->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
