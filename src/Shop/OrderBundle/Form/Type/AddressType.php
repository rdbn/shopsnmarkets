<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use Shop\OrderBundle\Form\Type\OrderType as MainOrderType;
use User\UserBundle\Form\EventListener\AddCountryFieldSubscriber;
use User\UserBundle\Form\EventListener\AddCityFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('realname', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control', 'placeholder' => 'Имя *',
            ],
        ]);
        $builder->add('email', EmailType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => 'form-control', 'placeholder' => 'Email',
            ],
        ]);
        $builder->add('street', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control', 'placeholder' => 'Улица *',
            ],
        ]);
        $builder->add('home_index', NumberType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control', 'placeholder' => 'Индекс *',
            ],
        ]);
        $builder->add('phone', NumberType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control', 'placeholder' => 'Телефон *',
            ],
        ]);
        $builder->add('skype', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'class' => 'form-control', 'placeholder' => 'Skype',
            ],
        ]);
        $builder->add('order', CollectionType::class, [
            'label' => false,
            'entry_type' => MainOrderType::class,
        ]);
        $builder->add('save', SubmitType::class, [
            'label' => 'Оформить заказ',
            'attr' => [
                'class' => 'btn btn-success bottom20'
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
        $resolver->setDefaults([
            'data_class' => 'Shop\OrderBundle\Entity\Address'
        ]);
    }
}
