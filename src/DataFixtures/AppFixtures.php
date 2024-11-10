<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct() {
        $this->faker = Factory::create("fr_FR");
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        // Users
        for ($i=0; $i < 10; $i++) { 
            $user =  new User();
            $user->setFullName($this->faker->name());
            $user->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->firstName() : null);
            $user->setEmail($this->faker->email());
            $user->setRoles(["ROLE_USER"]);
            $user->setClearPassword("password");

            $manager->persist($user);
        }

        $manager->flush();
    }
}
