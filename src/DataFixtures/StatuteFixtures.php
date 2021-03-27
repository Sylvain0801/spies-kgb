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
            'En préparation' => '#1408bf',
            'En cours' => '#ec6f09',
            'Terminé' => '#15f312',
            'Echec' => '#f70202'
        ];
        $i = 0;
        foreach($statutes as $key => $value) {
            $i++;
            $statute = new Statute();
            $statute->setName($key);
            $statute->setColor($value);
            $manager->persist($statute);
            $this->addReference('statute_'.$i, $statute);
        }

        $manager->flush();
    }

}
