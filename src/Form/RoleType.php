<?php

namespace App\Form;

use App\Entity\Roles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
           // ->add('nom',TextType::class,['label' => 'Nom', 'attr' => array('require'=>'require','class'=>'form-control')])
           // ->add('Valider', SubmitType::class, ['attr' => array('class'=>'button button-contactForm boxed-btn mt-4')])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Roles::class,
        ]);
    }
}
