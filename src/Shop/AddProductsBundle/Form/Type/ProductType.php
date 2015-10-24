<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Form\Type;

use Shop\AddProductsBundle\Form\EventListener\AddCategoryFieldSubscriber;
use Shop\AddProductsBundle\Form\EventListener\AddSubcategoryFieldSubscriber;
use Shop\AddProductsBundle\Form\EventListener\AddSizeFieldSubscriber;
use Shop\AddProductsBundle\Form\EventListener\AddTypeThingFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType {
    
    private $shop_name;
    
    public function __construct($shop_name) {
        $this->shop_name = $shop_name;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('shops', 'shopname', array(
            'data' => $this->shop_name,
        ));
        $builder->add('floor', 'entity', array(
            'class' => 'ShopAddProductsBundle:Floor',
            'property' => 'name',
            'label' => 'Пол:',
            'empty_value'   => '--- Выберите пол ---',
        ));
        $builder->add('keywords', 'text', array(
            'label' => 'Для поиска:',
            'data' => isset($options['data']) ? $options['data']->getKeywords() : NULL,
        ));
        $builder->add('name', 'text', array(
            'label' => 'Название:',
            'data' => isset($options['data']) ? $options['data']->getName() : NULL,
        ));
        $builder->add('price', 'number', array(
            'label' => 'Цена:',
            'data' => isset($options['data']) ? $options['data']->getPrice() : NULL,
        ));
        $builder->add('text', 'textarea', array(
            'label' => 'Описание:',
        ));
        $builder->add('save', 'submit', array(
            'label' => 'Добавить',
            'attr' => array('class' => 'button'),
        ));
        
        $factory = $builder->getFormFactory();
        $categorySubscriber = new AddCategoryFieldSubscriber($factory);
        $builder->addEventSubscriber($categorySubscriber);
        $subcategorySubscriber = new AddSubcategoryFieldSubscriber($factory);
        $builder->addEventSubscriber($subcategorySubscriber);
        $sizeSubscriber = new AddSizeFieldSubscriber($factory);
        $builder->addEventSubscriber($sizeSubscriber);
        $typeThingSubscriber = new AddTypeThingFieldSubscriber($factory);
        $builder->addEventSubscriber($typeThingSubscriber);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\AddProductsBundle\Entity\Product'
        ));
    }
    
    public function getName() 
    {
        return 'Product';
    }
}
?>
