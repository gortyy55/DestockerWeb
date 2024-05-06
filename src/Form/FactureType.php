<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
   $builder

            ->add('nameCard', TextType::class, [
                'label' => 'Name on Card',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 100]),
                ],
            ])
            ->add('ccn', IntegerType::class, [
                'label' => 'Credit Card Number',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'integer']),
                    new Assert\Length(['min' => 8, 'max' => 8]),
                ],
            ])
            ->add('expDate', DateType::class, [
                'label' => 'Expiration Date',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'constraints' => [
                    new Assert\NotBlank(),
                   
                ],
            ])
            ->add('securityCode', IntegerType::class, [
                'label' => 'Security Code',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'integer']),
               
                ],
            ])
            ->add('adrress', TextType::class, [
                'label' => 'Address',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 100]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 100]),
                ],
            ])
            ->add('state', TextType::class, [
                'label' => 'State',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 100]),
                ],
            ])
            ->add('zipCode', IntegerType::class, [
                'label' => 'Zip Code',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'integer']),
                  
                ],
            ])
            ->add('country', TextType::class, [
                'label' => 'Country',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => 100]),
                ]
                ]);
           
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
