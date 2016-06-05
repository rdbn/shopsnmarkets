<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Form\Type;

use User\UserBundle\Form\EventListener\AddCountryFieldSubscriber;
use User\UserBundle\Form\EventListener\AddCityFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserInformationType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('realname', TextType::class, [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Фамилия/Имя*"],
                'data' => isset($options['data']) ? $options['data']->getRealname() : NULL,
            ])
            ->add('username', EmailType::class, [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Email*"],
                'data' => isset($options['data']) ? $options['data']->getUsername() : NULL,
            ])
            ->add('phone', NumberType::class, [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Телефон"],
                'required' => false,
                'data' => isset($options['data']) ? $options['data']->getPhone() : NULL,
            ])
            ->add('skype', TextType::class, [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Skype"],
                'required' => false,
                'data' => isset($options['data']) ? $options['data']->getSkype() : NULL,
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                "attr" => ["class" => "form-control", "placeholder" => "Подробное описание", "rows" => 10],
                'required' => false,
                'data' => isset($options['data']) ? $options['data']->getSkype() : NULL,
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success  center-block'],
                'label' => 'Сохранить',
            ]);
        
        $factory = $builder->getFormFactory();
        $countrySubscriber = new AddCountryFieldSubscriber($factory);
        $builder->addEventSubscriber($countrySubscriber);
        $citySubscriber = new AddCityFieldSubscriber($factory);
        $builder->addEventSubscriber($citySubscriber);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'User\UserBundle\Entity\Users'
        ]);
    }
}