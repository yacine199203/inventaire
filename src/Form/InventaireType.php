<?php

namespace App\Form;

use App\Entity\Inventaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InventaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('libelle',TextType::class,[
            'label'=>'Libellé :',
            'attr'=>[
                'placeholder'=>'Libellé'
            ]
        ])
        ->add('traitePar',TextType::class,[
            'label'=>'Traité par :',
            'attr'=>[
                'placeholder'=>'Traité par'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inventaire::class,
        ]);
    }
}
