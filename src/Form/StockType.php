<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setAttribute('novalidate', 'novalidate');
        $builder
            ->add('produitname')
            ->add('quantite')
            ->add('mail')
            ->add('id_cat', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'category_name', // Display category_name field as options
                'placeholder' => 'Select a category', // Optional placeholder
            ])
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
