<?php

namespace App\DataFixtures;

use App\Entity\Hideout;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class HideoutFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 200; $i++) {
            $nationality = $this->getReference('nationality_'.($faker->numberBetween(1, 20) * 6));
            $hideout = new Hideout();
            $hideout
                ->setCode($faker->numberBetween($min = 100000, $max = 999999))
                ->setAddress($faker->address)          
                ->setType('Type_'.$faker->numberBetween($min = 1, $max = 9))
                ->setNationality($nationality);
            $manager->persist($hideout);
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
