<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Form\Type;

use Shop\AddProductsBundle\Form\Type\ProductImageType as ImageType;
use Shop\AddProductsBundle\Form\EventListener\AddCategoryFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('hashTags', 'text', array(
            'label' => false,
            'attr' => [
                "class" => "form-control",
                "placeholder" => "Хеш теги",
                "value" => "одежда,"
            ],
            'data' => isset($options['data']) ? $options['data']->getHashTags() : NULL,
        ));
        $builder->add('name', 'text', array(
            'label' => false,
            'attr' => ["class" => "form-control", "placeholder" => "Название"],
            'data' => isset($options['data']) ? $options['data']->getName() : NULL,
        ));
        $builder->add('price', 'number', array(
            'label' => false,
            'attr' => ["class" => "form-control", "placeholder" => "Цена"],
            'data' => isset($options['data']) ? $options['data']->getPrice() : NULL,
        ));
        $builder->add('text', 'textarea', array(
            'label' => false,
            'required' => false,
            'attr' => ["class" => "form-control", "placeholder" => "Описание", "rows" => 10],
            'data' => isset($options['data']) ? $options['data']->getText() : NULL,
        ));
        $builder->add('image', 'collection', [
            'label' => false,
            "type" => new ImageType(),
            'allow_add' => true,
        ]);
        $builder->add('save', 'submit', array(
            'label' => 'Добавить',
            'attr' => ['class' => 'btn btn-success center-block'],
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
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
