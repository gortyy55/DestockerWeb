<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du produit',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez saisir un nom de produit.']),
                    new Assert\Length(['max' => 255, 'maxMessage' => 'Le nom du produit ne peut pas dépasser {{ limit }} caractères.']),
                ],
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix du produit',
                'scale' => 2,
                'html5' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez saisir un prix.']),
                    new Assert\Type(['type' => 'numeric', 'message' => 'Le prix doit être un nombre.']),
                    new Assert\PositiveOrZero(['message' => 'Le prix doit être positif ou nul.']),
                ],
            ])
        ->add('prixActuel', NumberType::class, [
        'label' => 'Prix du produit actuel',
        'scale' => 2,
        'html5' => true,
        'constraints' => [
            new Assert\NotBlank(['message' => 'Veuillez saisir un prix.']),
            new Assert\Type(['type' => 'numeric', 'message' => 'Le prix doit être un nombre.']),
            new Assert\PositiveOrZero(['message' => 'Le prix doit être positif ou nul.']),
        ],
    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
