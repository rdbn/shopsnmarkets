<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

Class NewsType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('text', 'textarea', array(
            'label' => 'Текст:',
            'data' => isset($options['data']) ? $options['data']->getText() : NULL,
        ));
        $builder->add('file', 'file', array(
            'label' => 'Добавить картику:',
            'data' => isset($options['data']) ? $options['data']->getFile() : NULL,
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\NewsBundle\Entity\News'
        ));
    }
    
    public function getName() {
        return 'News';
    }
}
?>
