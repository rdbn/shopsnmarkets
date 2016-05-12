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

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('hashTags', TagsType::class, [
            'label' => false,
            'attr' => [
                "class" => "form-control",
                "placeholder" => "Хеш теги",
            ],
        ]);
        $builder->add('price', NumberType::class, [
            'label' => false,
            'attr' => [
                "class" => "form-control",
                "placeholder" => "Цена",
            ],
            'data' => isset($options['data']) ? $options['data']->getPrice() : NULL,
        ]);
        $builder->add('text', TextareaType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                "class" => "form-control",
                "placeholder" => "Описание",
                "rows" => 10,
            ],
            'data' => isset($options['data']) ? $options['data']->getText() : NULL,
        ]);
        $builder->add('file', FileType::class, [
            'label' => "Добавить картинки",
            "label_attr" => [
                "class" => "btn btn-success",
            ],
            "multiple" => true,
            'attr' => [
                "class" => "hide",
            ],
            'data_class' => null,
        ]);
        $builder->add('save', SubmitType::class, [
            'label' => 'Добавить',
            'attr' => [
                'class' => 'btn btn-success center-block',
            ],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\ProductBundle\Entity\Product'
        ]);
    }
}