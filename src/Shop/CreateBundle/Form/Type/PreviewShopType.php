<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreviewShopType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('shopname', 'hidden', array(
            'data' => isset($options['data']) ? $options['data']->getShopname() : NULL,
        ));
        $builder->add('description', 'textarea', array(
            'label' => false,
            'attr' => ['class' => 'form-control', 'rows' => '10', 'placeholder' => 'кратко о магазине'],
            'data' => isset($options['data']) ? $options['data']->getDescription() : NULL,
        ));
        $builder->add("save", "submit", [
            'label' => 'Сохранить',
            'attr' => ['class' => 'btn btn-success btn-sm'],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\Shops'
        ));
    }
    
    public function getName() 
    {
        return 'PreviewShop';
    }
}
?>
