<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //faker
        $faker = Factory::create('fr_FR');
        
        for ($i = 0; $i < 25; $i++) {
            $categorie = new Categorie();
            $categorie->setLibelle($faker->word(5));
            
            $categories[]=$categorie;
            $manager->persist($categorie);
        } 

        for ($i = 0; $i < 20; $i++) {
            $fournisseur = new Fournisseur();
            $fournisseur->setNomFournisseur($faker->company())
                ->setContactFournisseur($faker->phoneNumber())
                ->setEmailFournisseur($faker->email())
                ->setAdresseFournisseur($faker->address());
           
            $manager->persist($fournisseur);
        }

        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setNomArticle($faker->word())
                ->setPrixArticle(mt_rand(1,10000))
                ->setQuantiteArticle(mt_rand(2,100))
                ->setDescription($faker->sentence(5))
                ->setImageName( $faker->imageUrl('animals', true)
        );
           

            $article->setCategorie($categories[$i]);
           
            $manager->persist($article);
        }

        $manager->flush();
    }
}
