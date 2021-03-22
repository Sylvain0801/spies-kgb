<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $generator = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 20; $i++) {
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
