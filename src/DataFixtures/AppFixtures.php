<?php

namespace App\DataFixtures;

use App\Entity\Outil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $outil = new Outil();
            $outil->setName($this->faker->word())
                ->setDescription($this->faker->sentence())  // Ajout d'une description
                ->setReference($this->faker->uuid());  // Utilisation d'un UUID pour la référence

            $manager->persist($outil);
        }

        $manager->flush();
    }
}
