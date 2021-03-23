<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Agent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $generator = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 40; $i++) {
            $agent = new Agent();
            $agent
                ->setIdentificationCode($generator->numberBetween($min = 100000, $max = 999999))
                ->setFirstname($generator->firstname())
                ->setLastname($generator->lastname)
                ->setDateOfBirth($generator->dateTimeBetween($startDate = '-55 years', $endDate = '-25 years', $timezone = null))
                ->setNationality($generator->country);
            $manager->persist($agent);

            $admin = new Admin();
            $admin
                ->setFirstname($generator->firstname())
                ->setLastname($generator->lastname)
                ->setEmail($generator->email)
                ->setPassword('password')
                ->setIsVerified(1);
            $manager->persist($admin);

        }

        $manager->flush();
    }
}
