<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreviewUserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('text_main', 'textarea', array(
            'required' => false,
            'label' => 'Подробно о себе:',
            'data' => isset($options['data']) ? $options['data']->getTextMain() : '',
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'button'),
            'label' => 'Сохранить'
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\PropertyBundle\Entity\PreviewUser'
        ));
    }
    
    public function getName() 
    {
        return 'AdditionalInformarion';
    }
}
?>
