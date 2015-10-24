<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\PartnersBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

Class SearchPartnersType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keywords', 'text', array(
            'label' => FALSE,
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getKeywords() : NULL,
        ));
        $builder->add('country', 'entity', array(
            'class' => 'UserRegistrationBundle:Country',
            'property' => 'name',
            'mapped'        => false,
            'empty_value'   => '--- Выберите страну ---',
            'required' => false,
            'label' => 'Страна:',
        ));
        $builder->add('city', 'entity', array(
            'class' => 'UserRegistrationBundle:City',
            'property' => 'name',
            'empty_value'   => '--- Выберите город ---',
            'required' => false,
            'label' => 'Город:',
        ));        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\Shops'
        ));
    }

    public function getName()
    {
        return 'SearchPartners';
    }
}
?>
