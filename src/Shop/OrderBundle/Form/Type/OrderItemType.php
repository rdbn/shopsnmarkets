<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('save', 'submit', array(
            'label' => 'Купить товар',
            'attr' => array('class' => 'btn btn-success'),
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\OrderBundle\Entity\OrderItem'
        ]);
    }
    
    public function getName()
    {
        return 'OrderItem';
    }
}