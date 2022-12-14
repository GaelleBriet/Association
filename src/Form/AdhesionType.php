<?php

namespace App\Form;

use App\Entity\Adhesions;
use App\Entity\Adherents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdhesionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('starting_date', DateType::class, [
                'label' => 'Date de début d\'adhésion'
            ])
            ->add('ending_date', DateType::class, [
                'label' => 'Date de fin d\'adhésion'
            ]);
        // ->add('adherent', EntityType::class, [
        //     'label' => false,
        //     'class' => Adherents::class,
        //     'multiple' => true
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adhesions::class,
        ]);
    }
}
