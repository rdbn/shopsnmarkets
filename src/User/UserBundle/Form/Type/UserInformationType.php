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

class UserInformationType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('realname', TextType::class, [
            'label' => false,
            "attr" => ["class" => "form-control", "placeholder" => "Фамилия/Имя*"],
            'data' => isset($options['data']) ? $options['data']->getRealname() : NULL,
        ]);
        $builder->add('username', EmailType::class, [
            'label' => false,
            "attr" => ["class" => "form-control", "placeholder" => "Email*"],
            'data' => isset($options['data']) ? $options['data']->getUsername() : NULL,
        ]);
        $builder->add('phone', NumberType::class, [
            'label' => false,
            "attr" => ["class" => "form-control", "placeholder" => "Телефон"],
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getPhone() : NULL,
        ]);
        $builder->add('skype', TextType::class, [
            'label' => false,
            "attr" => ["class" => "form-control", "placeholder" => "Skype"],
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getSkype() : NULL,
        ]);
        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success btn-sm center-block'],
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