<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

Class UserType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('realname', 'text', array(
            'label' => 'Фамилия, Имя *:',
            'data' => isset($options['data']) ? $options['data']->getRealname() : NULL,
            'invalid_message' => 'Заполните поле: "Фамилия, Имя".',
            'error_bubbling' => true,
        ));
        $builder->add('email', 'email', array(
            'label' => 'email *:',
            'data' => isset($options['data']) ? $options['data']->getEmail() : NULL,
            'invalid_message' => 'Заполните поле: "Email".',
            'error_bubbling'=>true,
        ));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Значение паролей не совпадает.',
            'options' => array('attr' => array('class' => 'input')),
            'required' => true,
            'first_options'  => array('label' => 'Пароль *:'),
            'second_options' => array('label' => 'Повторить *:'),
            'error_bubbling'=>true,
        ));
        $builder->add('captcha', 'captcha', array(
            'auto_initialize' => false,
            'mapped' => false,
            'label' => false,
            'error_bubbling' => true,
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
        return 'Registration';
    }
}
?>
