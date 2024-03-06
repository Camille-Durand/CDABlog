<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $faker = Faker\Factory::create('fr_FR');

        $tabCat = [];
        $tabGens = [];

        for ($i = 0; $i < 30 ; $i++) { 
            $categorie = new Category();
            $categorie->setName($faker->jobTitle());
            $tabCat[] = $categorie;
            $manager->persist($categorie);
        }

        for ($i = 0; $i < 50 ; $i++) { 
            $gens = new User();
            $gens->setName($faker->lastName(null))
                    ->setFirstName($faker->firstName(null))
                    ->setMail($faker->email())
                    ->setPssword($faker->md5())
                    ->setImg($faker->imageUrl(200,200,"animals",true));
            $tabGens[] = $gens;
            $manager->persist($gens);
        }

        for ($i = 0; $i < 200 ; $i++) { 
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($faker->text())
                    ->setCreateAt(new \DateTimeImmutable($faker->date('Y-m-d')))
                    ->setUser($tabGens[$faker->numberBetween(0,49)])
                    ->addCategory($tabCat[$faker->numberBetween(0,9)])
                    ->addCategory($tabCat[$faker->numberBetween(10,19)])
                    ->addCategory($tabCat[$faker->numberBetween(20,29)])
                    ->setImgArticle($faker->imageUrl(200,200,"animals",true));
            $manager->persist($article);
        }

        $manager->flush();
    }
}
