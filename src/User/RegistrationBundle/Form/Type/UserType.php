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
            'label' => false,
            'attr' => ["class" => "form-control", "placeholder" => "Фамилия, Имя"],
            'data' => isset($options['data']) ? $options['data']->getRealname() : NULL,
            'invalid_message' => 'Заполните поле: "Фамилия, Имя".',
            'error_bubbling' => true,
        ));
        $builder->add('email', 'email', array(
            'label' => false,
            'attr' => ["class" => "form-control", "placeholder" => "email"],
            'data' => isset($options['data']) ? $options['data']->getEmail() : NULL,
            'invalid_message' => 'Заполните поле: "Email".',
            'error_bubbling'=>true,
        ));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Значение паролей не совпадает.',
            'options' => array('attr' => array('class' => 'form-control', "placeholder" => "Пароль")),
            'required' => true,
            'first_options'  => array('label' => false),
            'second_options' => array('label' => false),
            'error_bubbling'=>true,
        ));
        $builder->add('captcha', 'captcha', array(
            'auto_initialize' => false,
            'mapped' => false,
            'label' => false,
            'error_bubbling' => true,
            'attr' => ["class" => "form-control", "placeholder" => "Введите значение с картинки"],
        ));
        $builder->add("save", "submit", [
            "label" => "Зарегистрироваться",
            'attr' => ["class" => "btn btn-success"],
        ]);
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
