<?php

namespace App\Form;

use App\Entity\Batch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class)
            ->add('priceKilo', NumberType::class)
            ->add('kilos', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Batch::class,
        ]);
    }

    public function getBlockPrefix()
    {
         return '';
    }
    public function getName()
    {
        return '';
    }
}
