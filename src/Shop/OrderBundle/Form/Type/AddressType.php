<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\Type;

use User\RegistrationBundle\Form\EventListener\AddCountryFieldSubscriber;
use User\RegistrationBundle\Form\EventListener\AddCityFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder->add('realname', 'text', array(
            'label' => 'Имя *:',
            'data' => isset($options['data']) ? $options['data']->getRealname() : NULL,
        ));
        $builder->add('email', 'email', array(
            'label' => 'Email:',
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getEmail() : NULL,
        ));
        $builder->add('street', 'text', array(
            'label' => 'Улица *:',
            'data' => isset($options['data']) ? $options['data']->getStreet() : NULL,
        ));
        $builder->add('home_index', 'number', array(
            'label' => 'Индекс *:',
            'data' => isset($options['data']) ? $options['data']->getHomeIndex() : NULL,
        ));
        $builder->add('phone', 'number', array(
            'label' => 'Телефон*:',
            'data' => isset($options['data']) ? $options['data']->getPhone() : NULL,
        ));
        $builder->add('skype', 'text', array(
            'label' => 'Skype:',
            'required' => false,
            'data' => isset($options['data']) ? $options['data']->getSkype() : NULL,
        ));
        
        $factory = $builder->getFormFactory();
        $countrySubscriber = new AddCountryFieldSubscriber($factory);
        $builder->addEventSubscriber($countrySubscriber);
        $citySubscriber = new AddCityFieldSubscriber($factory);
        $builder->addEventSubscriber($citySubscriber);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\OrderBundle\Entity\Address'
        ));
    }
    
    public function getName() 
    {
        return 'AddAddress';
    }
}
?>
