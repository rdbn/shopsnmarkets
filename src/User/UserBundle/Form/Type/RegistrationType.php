<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

Class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', EmailType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control', 'placeholder' => 'email'],
            'data' => isset($options['data']) ? $options['data']->getUsername() : NULL,
            'invalid_message' => 'Заполните поле: "Email".',
            'error_bubbling'=>true,
        ]);
        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Значение паролей не совпадает.',
            'options' => [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Пароль'
                ]
            ],
            'required' => true,
            'first_options'  => [
                'label' => false
            ],
            'second_options' => [
                'label' => false
            ],
            'error_bubbling'=>true,
        ]);
        $builder->add('save', SubmitType::class, [
            'label' => 'Зарегистрироваться',
            'attr' => ['class' => 'btn btn-success'],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'User\UserBundle\Entity\Users'
        ]);
    }
}
