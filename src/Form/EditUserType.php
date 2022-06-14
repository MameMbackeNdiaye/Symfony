<?php

namespace App\Form;

use App\Entity\Roles;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            
            'attr' => [
                'class' => 'form-control'
            ]

        ])
        ->add('name',TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Nom et prenom'
        ])
        ->add('roles', ChoiceType::class, [
            'choices' =>[
                'Vendeur' => "ROLE_VENDEUR",
                'Administrateur' => "ROLE_ADMIN",
                'Gestionaire de stock' => "ROLE_GESTION_STOCK",
            ],
            'mapped' => false,
            'expanded' =>true,
            'label' => 'Rôle'
        ])
        ->add('Valider', SubmitType::class, ['attr' => array('class'=>'button button-contactForm boxed-btn mt-4')])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
