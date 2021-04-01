<?php

namespace App\DataFixtures;

use App\Entity\Target;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class TargetFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 200; $i++) {
            $nationality = $this->getReference('nationality_'.($faker->numberBetween(1, 20) * 6));
            $target = new Target();
            $target
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname)
                ->setCodeName($faker->word)
                ->setDateOfBirth($faker->dateTimeBetween($startDate = '-55 years', $endDate = '-25 years', $timezone = null))
                ->setNationality($nationality);
            $manager->persist($target);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            NationalityFixtures::class,
        ];
    }
}
