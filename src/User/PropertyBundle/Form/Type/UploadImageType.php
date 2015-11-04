<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('file', 'file', array(
            'label' => 'Загрузить аватарку',
            'data' => isset($options['data']) ? $options['data']->getFile() : NULL,
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\RegistrationBundle\Entity\Users'
        ));
    }
    
    public function getName() 
    {
        return 'Upload';
    }
}
?>
