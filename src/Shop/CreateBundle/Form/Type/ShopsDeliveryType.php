<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShopsDeliveryType extends AbstractType {

    protected $shops, $id;

    public function __construct($shopsname, $id) {
        $this->shops = $shopsname;
        $this->id = $id;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('shops', 'shopname', array(
            'data' => $this->shops,
        ));
        $builder->add('delivery', 'deliveryId', array(
            'data' => $this->id,
        ));
        $builder->add('price_duration', 'number', array(
            'label' => 'Стоимость:',
            'data' => isset($options['data']) ? $options['data']->getPriceDuration() : NULL,
        ));
        $builder->add('duration', 'text', array(
            'label' => 'Сроки:',
            'data' => isset($options['data']) ? $options['data']->getDuration() : NULL,
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\ShopsDelivery'
        ));
    }
    
    public function getName() 
    {
        return 'ShopsDelivery';
    }
}
?>
