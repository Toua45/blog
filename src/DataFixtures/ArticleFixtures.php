<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->realText(100));
            $article->setContent($faker->paragraph());
            $article->setDate($faker->dateTime);
            $article->setUpdatedAt(new \DateTime());
            $article->setImageName('');
            $article->setCategory($this->getReference('category_' . rand(0,5))); // permet de récupérer les références créées dans CategoryFixtures aléatoirement avec le rand de 0 à 5
//            $article->setTitle('mon article ' . $i); // permet d'indiquer des numéro
//            $article->setContent('lorem');
//            $article->setDate(new \DateTime()); // donne la date du moment
            $manager->persist($article);
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return class-string[]
     */
    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
