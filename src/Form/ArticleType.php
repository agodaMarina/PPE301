<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Fournisseur;
use App\Repository\CategorieRepository;
use App\Repository\FournisseurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomArticle', TextType::class
                )
            ->add('description', TextareaType::class
                )

            ->add('prixArticle', MoneyType::class,[
                'currency' => 'XOF'
            ]
                )

            ->add('quantiteArticle',IntegerType::class
                )

            ->add('imageFile',VichImageType::class,[
                'required' => false,
                'download_uri' => true,
                'image_uri' => true,
                'delete_label' => 'supprimer',
                'download_label' => 'télécharger',
                'allow_delete' => true
            ])


            ->add('categorie', EntityType::class, [
               'class' => Categorie::class, 
               'query_builder'=> function(CategorieRepository $cat){
                    return $cat->createQueryBuilder('u')
                        ->orderBy('u.libelle','ASC');
               },
                'choice_label' => 'libelle'
            ])
        
            ->add('fournisseurs', EntityType::class, [
               'class' => Fournisseur::class, 
               'query_builder'=> function(FournisseurRepository $fourni){
                    return $fourni->createQueryBuilder('u')
                        ->orderBy('u.nomFournisseur','ASC');
               },
                'choice_label' => 'nomFournisseur',
                'multiple'=> true,
                'expanded'=>false,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
