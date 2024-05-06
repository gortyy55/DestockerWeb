<?php

namespace App\Form;

use App\Entity\Lot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idenchere', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Enchere id cannot be empty.']),
                    new Assert\Type(['type' => 'integer', 'message' => 'Enchere id must be an integer.']),
                ],
            ])


            ->add('produits', CollectionType::class, [
                'entry_type' => ProduitType::class, // Assurez-vous d'avoir un formulaire ProduitType défini
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }
}
