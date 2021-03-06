<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i = 0; $i < 200; $i++) {
            $nationality = $this->getReference('nationality_'.($faker->numberBetween(1, 20) * 6));
            $contact = new Contact();
            $contact
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname)          
                ->setCodeName($faker->word)
                ->setDateOfBirth($faker->dateTimeBetween($startDate = '-55 years', $endDate = '-25 years', $timezone = null))
                ->setNationality($nationality);
            $manager->persist($contact);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            NationalityFixtures::class,
        ];
    }
}
