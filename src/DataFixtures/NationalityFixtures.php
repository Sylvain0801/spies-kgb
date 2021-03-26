<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $file = json_decode(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'nationalities.json'), true);
        $nationalities = $file["pays"];
        foreach ($nationalities as $key => $value) {
            $nationality = new Nationality();
            $nationality->setName($value['nationalite']);
            $nationality->setCountry($value['libelle']);
            $manager->persist($nationality);
            $this->addReference('nationality_'.$key, $nationality);
        }

        $manager->flush();
    }
}
