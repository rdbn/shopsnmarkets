<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Shop\InformationBundle\Form\Type\UserIDType as UsersIdType;
use Shop\CreateBundle\Form\Type\ShopnameType as UniqueNameType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('users', UsersIdType::class);
        $builder->add('shops', UniqueNameType::class);
        $builder->add('text', TextareaType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control', 'row' => '4', 'placeholder' => 'Коментарий...',
            ],
        ]);
        $builder->add('save', SubmitType::class, [
            'label' => 'Добавить',
            'attr' => [
                'class' => 'btn btn-success right',
            ],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Shop\InformationBundle\Entity\Comments'
        ]);
    }
}