<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('description', TextareaType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control', 'rows' => '10', 'placeholder' => 'кратко о магазине'],
            'data' => isset($options['data']) ? $options['data']->getDescription() : NULL,
        ]);
        $builder->add("save", SubmitType::class, [
            'label' => 'Сохранить',
            'attr' => ['class' => 'btn btn-success btn-sm'],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\Shops'
        ));
    }
}