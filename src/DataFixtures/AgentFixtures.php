<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AgentFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 200; $i++) {
            $nationality = $this->getReference('nationality_'.($faker->numberBetween(1, 20) * 6));
            $speciality = $this->getReference('speciality_'.$faker->numberBetween(1, 10));
            $agent = new Agent();
            $agent
                ->setIdentificationCode($faker->numberBetween($min = 100000, $max = 999999))
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname)
                ->setDateOfBirth($faker->dateTimeBetween($startDate = '-55 years', $endDate = '-25 years', $timezone = null))
                ->setNationality($nationality)
                ->addSpeciality($speciality);
            $manager->persist($agent);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            NationalityFixtures::class,
            SpecialityFixtures::class
        ];
    }
}
