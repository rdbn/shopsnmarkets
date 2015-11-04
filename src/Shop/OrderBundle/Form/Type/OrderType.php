<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use Shop\OrderBundle\Form\Type\AddressType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('address', new AddressType());
        $builder->add('save', 'submit', array(
            'label' => 'Перейти к оплате',
            'attr' => array('class' => 'check'),
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\OrderBundle\Entity\Order',
            'cascade_validation' => true,
        ));
    }
    
    public function getName() 
    {
        return 'Order';
    }
}
?>
