<?php

namespace App\Form;

use App\Entity\Moto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand', TextType::class, [
                'label' => 'Marque de la moto',
                'attr' => [
                    'placeholder' => 'Merci de saisir la marque de la moto',
                ]
            ])
            ->add('model', TextType::class, [
                'label' => 'Modèle de la moto',
                'attr' => [
                    'placeholder' => 'Merci de saisir le modèle de la moto',
                ]
            ])
            ->add('matriculation', TextType::class, [
                'label' => 'Immatriculation de la moto',
                'attr' => [
                    'placeholder' => 'Merci de saisir l\'immatriculation de la moto',
                ]
            ])
            ->add('weight', IntegerType::class, [
                'label' => 'Poids de la moto',
                'attr' => [
                    'placeholder' => 'Merci de saisir le poids de la moto',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter ma moto',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moto::class,
        ]);
    }
}
