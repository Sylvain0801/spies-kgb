<?php

namespace App\DataFixtures;

use App\Entity\Statute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatuteFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $statutes = [
            'En préparation' => 'blue',
            'En cours' => 'orange',
            'Terminé' => 'green',
            'Echec' => 'red'
        ];
        foreach($statutes as $key => $value) {
            $statute = new Statute();
            $statute->setName($key);
            $statute->setColor($value);
            $manager->persist($statute);
        }

        $manager->flush();
    }

}
