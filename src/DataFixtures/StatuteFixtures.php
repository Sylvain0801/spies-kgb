<?php

namespace App\DataFixtures;

use App\Entity\Statute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatuteFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $statutes = ['En préparation', 'En cours', 'Terminé', 'Echec' ];
        foreach($statutes as $value) {
            $statute = new Statute();
            $statute->setName($value);
            $manager->persist($statute);
        }

        $manager->flush();
    }

}
