<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Shop\CreateBundle\Form\Type\ShopnameType as UniqueNameType;
use Shop\CreateBundle\Form\Type\DeliveryIdType as EntityDeliveryType;

class ShopDeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('shops', UniqueNameType::class, [
            'attr' => [
                'class' => 'delivery-shops',
            ],
        ]);
        $builder->add('delivery', EntityDeliveryType::class, [
            'attr' => [
                'class' => 'delivery-delivery',
            ],
        ]);
        $builder->add('price', NumberType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Стоимость *',
                'class' => 'form-control delivery-price',
            ],
        ]);
        $builder->add('duration', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Сроки *',
                'class' => 'form-control delivery-duration',
            ],
        ]);
        $builder->add('submit', SubmitType::class, [
            'label' => "Добавить",
            'attr' => [
                'class' => 'btn btn-success add-delivery',
            ],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\CreateBundle\Entity\ShopsDelivery'
        ]);
    }
}