<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr'=>[
                    'class'=> 'form-control'
                    ,'placeholder' => 'Entrer une adresse valide',
                    
                ]
                ])
            ->add('nom', TextType::class,[
                'attr'=>[
                    'class'=> 'form-control'
                    ,'placeholder' => 'Entrer le nom',
                    
                ]
                ])
            ->add('prenom',TextType::class,[
                'attr'=>[
                    'class'=> 'form-control',
                    'placeholder' => 'Entrer le prenom',
                    
                ]
                ])

            ->add('contact', TelType::class,[
                'attr'=>[
                    'class'=> 'form-control'
                    ,
                    'placeholder' => 'Entrer le contact',
                    
                ]])

            ->add('username',TextType::class,[
                'attr'=>[
                    'class'=> 'form-control',
                    'placeholder' => 'Entrer le nom d\'utilisateur',
                    
                ]
                ])

            ->add('genre', ChoiceType::class,[
                'attr'=>[
                    'class'=> 'selectpicker form-control'
                    
                ],
                'choices' => [
                    'Homme' => true,
                    'Femme' => false,
                ],
                'placeholder' => 'Choisissez une option',
                'required'=> true,])
            
            ->add('Fonction', ChoiceType::class,[
                'attr'=>[
                    'class'=> 'selectpicker form-control'
                    
                ],
                'choices' => [
                    'Gestionnaire de Stock' => true,
                    'Gestionnaire d\'achat' => false,
                ],
                'placeholder' => 'Choisissez une fonction',

                'required'=> true,
                'mapped'=>false
                ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                            'class'=> 'form-control'
                        ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
