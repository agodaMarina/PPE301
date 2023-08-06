<?php

namespace App\Form;

use App\Entity\CommandeAchat;
use App\Entity\Article;
use App\Entity\Fournisseur;
use App\Entity\Tva;
use App\Repository\ArticleRepository;
use App\Repository\FournisseurRepository;
use App\Repository\TvaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeAchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumeroCommande', NumberType::class)
            ->add('dateCommande',DateType::class)
            ->add('TotalHT',NumberType::class)
            ->add('TotalTVA', NumberType::class)
            ->add('TotalTTC',NumberType::class)
            ->add('MontantTotalEnLettre',TextType::class)
            ->add('ConditionDeReglement', TextareaType::class, [
                'required'=>false
            ])
           

            ->add('articles', EntityType::class, [
                'class' => Article::class, 
                'query_builder'=> function(ArticleRepository $article){
                     return $article->createQueryBuilder('a')
                         ->orderBy('a.nomArticle','ASC');
                },
                 'choice_label' => 'nomArticle',
                 'multiple'=> true,
                 'expanded'=>false,
                 'placeholder' => 'Choisissez un ou plusieurs articles',
                
                 
             ])
            ->add('Tva',EntityType::class, [
                'class' => Tva::class, 
                'query_builder'=> function(TvaRepository $tva){
                     return $tva->createQueryBuilder('u')
                         ->orderBy('u.valeur');
                },
                'choice_label' => 'Valeur',
                'placeholder' => 'Choisissez une option',
                ])

            ->add('fournisseur', EntityType::class, [
               'class' => Fournisseur::class, 
               'query_builder'=> function(FournisseurRepository $fourni){
                    return $fourni->createQueryBuilder('u')
                        ->orderBy('u.nomFournisseur','ASC');
               },
                'choice_label' => 'nomFournisseur',
                'placeholder' => 'Choisissez une option',
                
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CommandeAchat::class,
        ]);
    }
}
