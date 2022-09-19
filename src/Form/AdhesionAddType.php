<?php

namespace App\Form;

use App\Entity\Adhesions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdhesionAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('starting_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début d\'adhésion'
            ])
            ->add('ending_date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin d\'adhésion'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adhesions::class,
        ]);
    }
}
