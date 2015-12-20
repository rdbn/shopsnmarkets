<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('shops', 'shopname');
        $builder->add('delivery', 'delivery');
        $builder->add('price', 'number', [
            'label' => false,
            'attr' => [
                'placeholder' => 'Стоимость'
            ],
            'data' => isset($options['data']) ? $options['data']->getPrice() : NULL,
        ]);
        $builder->add('duration', 'text', [
            'label' => false,
            'attr' => [
                'placeholder' => 'Сроки'
            ],
            'data' => isset($options['data']) ? $options['data']->getDuration() : NULL,
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\CreateBundle\Entity\ShopsDelivery'
        ]);
    }
    
    public function getName() 
    {
        return 'ShopsDelivery';
    }
}