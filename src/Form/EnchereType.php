<?php

namespace App\Form;

use App\Entity\Enchere2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EnchereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateduree', DateTimeType::class, [
                'widget' => 'choice', // Utiliser le widget 'choice'
                'format' => 'dd/MM/yyyy HH:mm', // Format de date et d'heure souhaité
                'html5' => false, // Désactiver l'input HTML5 pour utiliser votre propre timepicker
                'attr' => [
                    'class' => 'datetimepicker', // Classe CSS pour le datetimepicker
                ],

            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enchere2::class,
        ]);
    }
}
