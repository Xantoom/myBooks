<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Commentary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager) {
        $faker = Factory::create();

        // Book
        for($i = 0; $i < 4; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence(rand(1, 4)))
                ->setAuthor($faker->name)
                ->setPublishedAt(new \DateTime())
                ->setSummary($faker->text(120))
                ->setPicture("https://picsum.photos/300");
            // Commentary
            for($k = 0; $k < rand(1, 3); $k++) {
                $commentary = new Commentary();
                $commentary->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setCreatedAt(new \DateTime())
                    ->setText($faker->text(120))
                    ->setBook($book);
                $book->addCommentary($commentary);
                $manager->persist($commentary);
            }
            $manager->persist($book);
        }
        $manager->flush();
    }
}
