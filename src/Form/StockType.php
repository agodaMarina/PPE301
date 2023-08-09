<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', IntegerType::class)
            ->add('quantiteAlerte', IntegerType::class)
            ->add('article', EntityType::class, [
                'class'=> Article::class,
                'query_builder'=> function(ArticleRepository $a){
                    return $a->createQueryBuilder('a')
                    ->orderBy('a.nomArticle', 'ASC');
                }, 

                'choice_label'=>'nomArticle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
