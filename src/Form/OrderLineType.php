<?php

namespace App\Form;

use App\Entity\Batch;
use App\Entity\Order;
use App\Entity\OrderLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class OrderLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('kilos', NumberType::class)
            ->add('order', EntityType::class,['class'=>Order::class])
            ->add('batch', EntityType::class,['class'=>Batch::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderLine::class,
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
