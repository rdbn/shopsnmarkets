<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class SearchUsersType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keywords', 'text', array(
            'label' => false,
            'required' => false,
            'mapped' => false,
            'attr' => ['class' => 'form-control'],
        ));
        $builder->add('country', 'entity', array(
            'class' => 'UserUserBundle:Country',
            'property' => 'name',
            'empty_value'   => 'Выберите страну',
            'required' => false,
            'mapped' => false,
            'label' => false,
            'attr' => ['class' => 'form-control'],
        ));
        $builder->add('city', 'entity', array(
            'class' => 'UserUserBundle:City',
            'property' => 'name',
            'empty_value'   => 'Выберите город',
            'required' => false,
            'label' => false,
            'attr' => ['class' => 'form-control'],
        ));        
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\UserBundle\Entity\Users'
        ));
    }

    public function getName()
    {
        return 'SearchUsers';
    }
}
?>
