<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i <= 5; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $category->setColor($faker->hexColor);
            $this->addReference('category_' .$i, $category); //dès qu'une category est créée avec les fixtures, la catgeory prendar le nom de l'objet
            $manager->persist($category);
        }

        $manager->flush();
    }
}
