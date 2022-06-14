<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom et prenom'
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                            'class' => 'form-control'
                          ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins{{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe'
            ])
    
           // ->add('user_roles')
/*
            ->add('user_roles', EntityType::class,
            ['class' => User::class,
            'attr' => [
                'class' => 'form-control'],
            'label' => 'Role'
            ])

 */           
           
           ->add('Valider', SubmitType::class, [
               'attr' => array('
               class'=>'button button-contactForm boxed-btn mt-4 ')
               ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
