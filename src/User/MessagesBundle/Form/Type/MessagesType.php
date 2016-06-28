<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

Class MessagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextareaType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'Сообщение *',
                'rows' => '5',
            ]
        ]);
        $builder->add('save', SubmitType::class, [
            "label" => "Отправить сообщение",
            'attr' => [
                "class" => "btn btn-success",
                "data-dismiss" => "modal",
            ],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'User\MessagesBundle\Entity\Messages'
        ]);
    }
}
