<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class SearchType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('hashTags', 'text', array(
            'label' => false,
            'attr' => ["class" => "form-control"],
            'data' => isset($options['data']) ? $options['data']->getHashTags() : NULL,
        ));
        $builder->add('save', 'submit', array(
            'label' => "Go!",
            'attr' => ["class" => "btn btn-default"],
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\ProductBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'Search';
    }
}

