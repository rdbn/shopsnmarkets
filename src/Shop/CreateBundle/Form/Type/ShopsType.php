<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use Shop\CreateBundle\Form\Type\ShopsTagsType;
use User\UserBundle\Form\EventListener\AddCityFieldSubscriber;
use User\UserBundle\Form\EventListener\AddCountryFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

Class ShopsType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('uniqueName', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => "form-control",
                "placeholder" => "Адресс магазина *",
            ],
            'data' => isset($options['data']) ? $options['data']->getUniqueName() : NULL,
        ]);
        $builder->add('shopname', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => "form-control",
                "placeholder" => "Название магазина *",
            ],
            'data' => isset($options['data']) ? $options['data']->getShopname() : NULL,
        ]);
        $builder->add('shopTags', ShopsTagsType::class, [
            'label' => false,
            'attr' => [
                'class' => "form-control",
                "placeholder" => "Теги магазина *",
            ],
        ]);
        $builder->add('phone', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => "form-control",
                "placeholder" => "Телефон",
            ],
            'data' => isset($options['data']) ? $options['data']->getPhone() : NULL,
        ]);
        $builder->add('email', EmailType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => "form-control",
                "placeholder" => "email",
            ],
            'data' => isset($options['data']) ? $options['data']->getEmail() : NULL,
        ]);
        $builder->add("save", SubmitType::class, [
            "label" => "Создать",
            'attr' => [
                "class" => "btn btn-success center-block",
            ],
        ]);
        
        $factory = $builder->getFormFactory();
        $citySubscriber = new AddCityFieldSubscriber($factory);
        $countrySubscriber = new AddCountryFieldSubscriber($factory);
        $builder->addEventSubscriber($citySubscriber);
        $builder->addEventSubscriber($countrySubscriber);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\Shops'
        ));
    }
}