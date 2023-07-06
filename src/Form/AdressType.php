<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class)
            ->add('number', TextType::class)
            ->add('name', TextType::class)
            ->add('citty', TextType::class)
            ->add('postalCode', TextType::class)
            ->add('floor', TextType::class)
            ->add('doorNumber',TextType::class)
            ->add('client', EntityType::class,['class'=>Client::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
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
