<?php

namespace App\Form;

use App\Entity\Moto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $options['user'];
        $builder
            ->add('motos', EntityType::class,[
                'class' => Moto::class,
                'choices' => $user->getMotos(),
                'multiple' => false,
                'expanded' => true,
                'label' => false,
            ])
            ->add('passengers', IntegerType::class, [
                'label' => 'Nombre de passager,Maximum : 2 (+ 50,00€)',
                'attr' => [
                    'placeholder' => 'Merci de saisir le nombre de passager',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider ma commande',
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => array(),
        ]);
    }
}
