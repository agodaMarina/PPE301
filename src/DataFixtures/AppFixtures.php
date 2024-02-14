<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Entity\Article;
use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function __construct( private ArticleRepository $articleRepository)
    {
       
    }
    
        
    
    public function load(ObjectManager $manager): void
    {
        //faker
        $faker = Factory::create('fr_FR');
        
       
        for ($i = 0; $i < 15; $i++) {
            $categorie = new Categorie();
            $categorie->setLibelle($faker->word(5));
            
            $categories[]=$categorie;
            $manager->persist($categorie);
        } 

        for ($i = 0; $i <10 ; $i++) {
            $fournisseur = new Fournisseur();
            $fournisseur->setNomFournisseur($faker->company())
                ->setContactFournisseur($faker->phoneNumber())
                ->setEmailFournisseur($faker->email())
                ->setAdresseFournisseur($faker->address());
           
            $manager->persist($fournisseur);
            $fournisseurs[] = $fournisseur;
        }

       
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setNomArticle($faker->word())
                ->setPrixArticle(mt_rand(1,10000))
                ->setDescription($faker->sentence(5))
                ->setImageName('https://img.freepik.com/psd-gratuit/presentoir-maquette-podium-pour-presentation-du-produit-decore-jolies-feuilles-tropicales_103373-1786.jpg?w=740&t=st=1691433020~exp=1691433620~hmac=957ec8f649fad493a82a2b49d4aa09f613a728cf21acccd943d8dea6a742de6f');
           
        

            $article->addFournisseur(
                $fournisseurs[mt_rand(0, count($fournisseurs)-1)]
            );

            $article->setCategorie($categories[$i]);
           

            $manager->persist($article);


        }


        
       
        $manager->flush();
    }
}
