<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Trip;
use App\Entity\Category;
use App\Entity\Comment;

class TripFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        // créer 3 catérogries fakers
            for($i = 1;$i <= 2;$i++){
                $category = new Category();
                $category->setTitle($faker->country)
                        ->setDescription($faker->paragraph());

                $manager->persist($category);

                // créer des trips
                for($j = 1;$j <= 2;$j++){
                    $trip = new Trip();

                    $content = '<p>' . join($faker->paragraphs(2), '</p><P>') . '</p>';

                    $trip->setTitle($faker->sentence())
                            ->setDescription($content)
                            ->setImage("http://placehold.it/350x150")
                            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                            ->setCategory($category);

                    $manager->persist($trip);

                    // créer des comments
                    for($k = 1;$k <= mt_rand(2,5);$k++){
                        $comment = new Comment();

                        $content = '<p>' . join($faker->paragraphs(2), '</p><P>') . '</p>';

                        $days = (new \DateTime())->diff($trip->getCreatedAt())->days;

                        $comment->setAuthor($faker->name)
                                ->setContent($content)
                                ->setCreatedAt($faker->dateTimeBetween('-' . $days . ' days'))
                                ->setTrip($trip);

                        $manager->persist($comment);
                    }
                }


            }

        $manager->flush();
    }
}
