<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType as Password;

class PasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('old_password', Password::class, array(
            'label' => false,
            "attr" => ["class" => "form-control", "placeholder" => "Старый пароль*"],
            'mapped' => false,
        ));
        $builder->add('password', RepeatedType::class, array(
            'type' => Password::class,
            'invalid_message' => 'Ошибка введите парольеще раз!',
            'required' => true,
            'first_options'  => [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Пароль*"],
            ],
            'second_options' => [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Повторить*"],
            ],
        ));
        $builder->add('save', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-success  center-block'],
            'label' => 'Сохранить'
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\UserBundle\Entity\Users'
        ));
    }
}