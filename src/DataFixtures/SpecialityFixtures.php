<?php

namespace App\DataFixtures;

use App\Entity\Speciality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SpecialityFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $icons = ['fa-address-card-o', 'fa-binoculars', 'fa-bomb', 'fa-desktop', 'fa-drupal',
                'fa-eye', 'fa-eyedropper', 'fa-rocket', 'fa-safari', 'fa-pencil-square-o'                
    ];
        for($i = 1; $i <= 10; $i++) {
            $speciality = new Speciality();
            $speciality->setName('Spécialité_'.$i);
            $speciality->setIcon($icons[$i - 1]);
            $manager->persist($speciality);
            $this->addReference('speciality_'.$i, $speciality);
        }

        $manager->flush();
    }

}
