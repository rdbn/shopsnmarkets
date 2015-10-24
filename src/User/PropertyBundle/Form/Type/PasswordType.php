<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PasswordType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('old_password', 'password', array(
            'label' => 'старый пароль',
            'mapped' => false,
        ));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Ошибка введите парольеще раз!',
            'options' => array('attr' => array('class' => 'input')),
            'required' => true,
            'first_options'  => array('label' => 'Пароль:'),
            'second_options' => array('label' => 'Повторить:'),
        ));
        $builder->add('captcha', 'captcha', array(
            'quality' => '30',
            'auto_initialize' => false,
            'mapped' => false,
            'label' => false,
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'button'),
            'label' => 'Сохранить'
        ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\RegistrationBundle\Entity\Users'
        ));
    }
    
    public function getName() 
    {
        return 'Password';
    }
}
?>
