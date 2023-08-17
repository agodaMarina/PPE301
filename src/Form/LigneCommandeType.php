<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\LigneCommande;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => Article::class,
                'query_builder' => function (ArticleRepository $art) {
                    return $art->createQueryBuilder('u')
                        ->orderBy('u.nomArticle', 'ASC');
                },
                'choice_label' => 'nomArticle',
                'attr'=>[
                    'class'=> 'form-control'
                ]
            ])

            ->add('quantite')
            ->add('prixUnitaire');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneCommande::class,
        ]);
    }
}
