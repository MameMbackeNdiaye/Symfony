<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class,['label' => 'Libellé du produit', 'attr' => array('require'=>'require','class'=>'form-control')])
            ->add('stock', TextType::class, ['label' => 'Stock du produit', 'attr' => array('require'=>'require','class'=>'form-control')])
            // ->add('slug')
            ->add('categorie', EntityType::class,['class' => \App\Entity\Categorie::class,'label' => 'Categorie', 'attr' => array('require'=>'require','class'=>'form-control')])
           // ->add('user')
           ->add('Valider', SubmitType::class, ['attr' => array('class'=>'button button-contactForm boxed-btn mt-4')])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
