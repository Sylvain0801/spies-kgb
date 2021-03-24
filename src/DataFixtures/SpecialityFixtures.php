<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpecialityFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 10; $i++) {
            $speciality = new Speciality();
            $speciality->setName('Spécialité_'.$i);
            $manager->persist($speciality);
        }

        $manager->flush();
    }

}
