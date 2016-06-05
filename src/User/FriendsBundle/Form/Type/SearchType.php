<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Form\Type;

use User\UserBundle\Form\EventListener\AddCountryFieldSubscriber;
use User\UserBundle\Form\EventListener\AddCityFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

Class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('realname', TextType::class, [
            'label' => false,
            'attr' => ['class' => 'form-control', 'placeholder' => 'Фамилия, Имя'],
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