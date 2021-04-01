<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MissionFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $type = ['Surveillance', 'Assassinat', 'Infiltration', 'Autre'];
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 200; $i++) {
            $nationality = $this->getReference('nationality_'.($faker->numberBetween(1, 20) * 6));
            $speciality = $this->getReference('speciality_'.$faker->numberBetween(1, 10));
            $statute = $this->getReference('statute_'.$faker->numberBetween(1, 4));
            $date = $faker->dateTimeBetween('-5 years', '+5 years', null);
            $interval = $faker->numberBetween(50, 600);
            $start_date = clone $date;
            $end_date = $date->modify('+'.$interval.' days');
            $mission = new Mission();
            $mission
                ->setTitle($faker->domainWord)
                ->setDescription($faker->paragraph(12, false))
                ->setCodeName($faker->word)
                ->setType($type[$faker->numberBetween(0, 3)])
                ->setStartDate($start_date)
                ->setEndDate($end_date)
                ->setSpeciality($speciality)
                ->setStatute($statute)
                ->setNationality($nationality);
            $manager->persist($mission);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            NationalityFixtures::class,
            StatuteFixtures::class,
            SpecialityFixtures::class
        ];
    }
}
