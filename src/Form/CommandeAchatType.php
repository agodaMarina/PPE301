<?php

namespace App\Form;

use App\Entity\CommandeAchat;

use App\Entity\Tva;

use App\Repository\TvaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
           
            ->add('MontantTotalEnLettre',TextType::class, [
                'required'=>false,
            ])
            ->add('ConditionDeReglement', TextareaType::class, [
                'required'=>false
            ])
           
           

            ->add('ligneCommande', CollectionType::class, [
                'entry_type' => LigneCommandeType::class,
                'by_reference'=>false,
                'allow_add'=>true,
                'allow_delete'=>true

             ])
             
            ->add('Tva',EntityType::class, [
                'class' => Tva::class, 
                'query_builder'=> function(TvaRepository $tva){
                     return $tva->createQueryBuilder('u')
                         ->where('u.Statut>0')
                         ->orderBy('u.valeur');
                },
                'choice_label' => 'Valeur',
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
