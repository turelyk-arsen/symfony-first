<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie->setTitle('The dark knight');
        $movie->setReleasedYear(2008);
        $movie->setDescription('This is the description');
        $movie->setImagePath('https://cdn.pixabay.com/photo/2023/07/04/21/55/ai-generated-8107148_1280.jpg');
        // add data to pivot table
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));
        $manager->persist($movie);
        // $product = new Product();
        // $manager->persist($product);
        // $manager->flush();

        $movie2 = new Movie();
        $movie2->setTitle('Avengers: Endgame');
        $movie2->setReleasedYear(2019);
        $movie2->setDescription('This is the description Avengers');
        $movie2->setImagePath('https://cdn.pixabay.com/photo/2023/09/10/22/41/ai-generated-8245764_1280.png');
                // add data to pivot table
                $movie2->addActor($this->getReference('actor_3'));
                $movie2->addActor($this->getReference('actor_4'));
        $manager->persist($movie2);

        $manager->flush();
    }
}