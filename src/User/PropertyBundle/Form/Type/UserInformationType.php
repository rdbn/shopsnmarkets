<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Form\Type;

use User\RegistrationBundle\Form\EventListener\AddCountryFieldSubscriber;
use User\RegistrationBundle\Form\EventListener\AddCityFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserInformationType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('realname', 'text', array(
            'label' => 'Фамилия/Имя *:',
            'data' => isset($options['data']) ? $options['data']->getRealname() : NULL,
        ));
        $builder->add('email', 'email', array(
            'label' => 'Email *:',
            'data' => isset($options['data']) ? $options['data']->getEmail() : NULL,
        ));
        $builder->add('street', 'text', array(
            'label' => 'Улица:',
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getStreet() : NULL,
        ));
        $builder->add('home_index', 'number', array(
            'label' => 'Индекс:',
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getHomeIndex() : NULL,
        ));
        $builder->add('phone', 'number', array(
            'label' => 'Телефон:',
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getPhone() : NULL,
        ));
        $builder->add('skype', 'text', array(
            'label' => 'Skype:',
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getSkype() : NULL,
        ));
        $builder->add('captcha', 'captcha', array(
            'quality' => '30',
            'auto_initialize' => false,
            'mapped' => false,
            'label' => false,
        ));
        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'button'),
            'label' => 'Сохранить'
        ));
        
        $factory = $builder->getFormFactory();
        $countrySubscriber = new AddCountryFieldSubscriber($factory);
        $builder->addEventSubscriber($countrySubscriber);
        $citySubscriber = new AddCityFieldSubscriber($factory);
        $builder->addEventSubscriber($citySubscriber);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'User\RegistrationBundle\Entity\Users'
        ));
    }
    
    public function getName()
    {
        return 'UserInformation';
    }
}
?>
