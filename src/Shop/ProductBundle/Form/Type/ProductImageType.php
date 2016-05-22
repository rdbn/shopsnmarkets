<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Shop\ProductBundle\Form\Type\HashTagsType as TagsType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('file', FileType::class, [
            'label' => 'Добавить картинки',
            'label_attr' => [
                'class' => 'btn btn-success',
            ],
            'multiple' => true,
            'attr' => [
                'class' => 'hide',
            ],
            'required' => false,
            'data_class' => null,
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\ProductBundle\Entity\Product'
        ]);
    }
}