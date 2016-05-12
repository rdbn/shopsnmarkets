<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Form\Type;

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
            'attr' => ["class" => "form-control", "placeholder" => "Кратко о себе", "rows" => "5"],
            'data' => isset($options['data']) ? $options['data']->getDescription() : '',
        ]);
        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success btn-sm top20'],
            'label' => 'Сохранить'
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'User\UserBundle\Entity\Users'
        ]);
    }
}