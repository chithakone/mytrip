<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Trip;

class TripFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1;$i <= 5; $i++){
            $trip = new Trip();
            $trip->setTitle("Titre de l'article n°$i")
                ->setDescription("<p>Description de Titre de l'article n°$i</p>")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt(new \Datetime());
            
            $manager->persist($trip);
            
            $manager->flush();
            
        }

        $manager->flush();
    }
}
