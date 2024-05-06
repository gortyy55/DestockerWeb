<?php

namespace App\Form;

use App\Entity\Dons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', IntegerType::class, [
                'label' => 'Amount', // Customize the label for the amount field
                'attr' => ['min' => 0], // Set a minimum value for the amount
            ])
            ->add('iddemand', HiddenType::class, [
                'data' => $options['iddemand'], // Set the default value for iddemand
                'mapped' => false, // This field is not mapped to the entity
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Donate', // Customize the label of the button
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dons::class,
            'iddemand' => null, // Default value for iddemand
        ]);
    }
}
