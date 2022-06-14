<?php

namespace App\Form;

use App\Entity\Entree;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite', TextType::class,['label' => 'Quantité', 'attr' => array('require'=>'require','class'=>'form-control')])
            ->add('prix', TextType::class,['label' => 'Prix', 'attr' => array('require'=>'require','class'=>'form-control')])
            ->add('date', DateType::class,['label' => 'Date d\'entree', 'attr' => array('require'=>'require','class'=>'form-control')])
            ->add('produit', EntityType::class,['class' => \App\Entity\Produit::class,'label' => 'Produit', 'attr' => array('require'=>'require','class'=>'form-control')])
            ->add('Valider', SubmitType::class, ['attr' => array('class'=>'button button-contactForm boxed-btn mt-4')])

            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
