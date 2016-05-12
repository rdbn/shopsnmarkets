<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

Class NewsType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextareaType::class, [
            'label' => 'Текст:',
            'data' => isset($options['data']) ? $options['data']->getText() : NULL,
        ]);
        $builder->add('file', FileType::class, [
            'label' => 'Добавить картику:',
            'data' => isset($options['data']) ? $options['data']->getFile() : NULL,
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'Shop\InformationBundle\Entity\News'
        ]);
    }
}
