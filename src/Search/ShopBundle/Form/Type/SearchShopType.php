<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

Class SearchShopType extends AbstractType 
{
    private $shopname;
    
    public function __construct($nameShop) {
        $this->shopname = $nameShop;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('shops', 'shopname', array(
            'data' => $this->shopname,
        ));
        $builder->add('keywords', 'text', array(
            'label' => false,
            'data' => isset($options['data']) ? $options['data']->getKeywords() : NULL,
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\AddProductsBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'Search';
    }
}

