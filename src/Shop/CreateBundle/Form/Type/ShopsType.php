<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Form\Type;

use User\RegistrationBundle\Form\EventListener\AddCityFieldSubscriber;
use User\RegistrationBundle\Form\EventListener\AddCountryFieldSubscriber;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

Class ShopsType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('rating', 'hidden', array(
            'data' => 0,
        ));
        $builder->add('keywords', 'text', array(
            'label' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Для поиска *"],
            'data' => isset($options['data']) ? $options['data']->getKeywords() : NULL,
        ));
        $builder->add('uniqueName', 'text', array(
            'label' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Адресс магазина *"],
            'data' => isset($options['data']) ? $options['data']->getUniqueName() : NULL,
        ));
        $builder->add('shopname', 'text', array(
            'label' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Название магазина *"],
            'data' => isset($options['data']) ? $options['data']->getShopname() : NULL,
        ));
        $builder->add('street', 'text', array(
            'label' => false,
            'required' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Улица"],
            'data' => isset($options['data']) ? $options['data']->getStreet() : NULL,
        ));
        $builder->add('home_index', 'number', array(
            'label' => false,
            'required' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Индекс"],
            'data' => isset($options['data']) ? $options['data']->getHomeIndex() : NULL,
        ));
        $builder->add('phone', 'number', array(
            'label' => false,
            'required' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Телефон"],
            'data' => isset($options['data']) ? $options['data']->getPhone() : NULL,
        ));
        $builder->add('fax', 'number', array(
            'label' => false,
            'required' => false,
            'attr' => ['class' => "form-control", "placeholder" => "Fax"],
            'data' => isset($options['data']) ? $options['data']->getFax() : NULL,
        ));
        $builder->add('url', 'text', array(
            'label' => false,
            'required' => false,
            'attr' => ['class' => "form-control", "placeholder" => "url"],
            'data' => isset($options['data']) ? $options['data']->getUrl() : NULL,
        ));
        $builder->add('email', 'email', array(
            'label' => false,
            'required' => false,
            'attr' => ['class' => "form-control", "placeholder" => "email"],
            'data' => isset($options['data']) ? $options['data']->getEmail() : NULL,
        ));
        $builder->add("save", "submit", [
            "label" => "Создать",
            'attr' => ["class" => "btn btn-success center-block"],
        ]);
        
        $factory = $builder->getFormFactory();
        $citySubscriber = new AddCityFieldSubscriber($factory);
        $countrySubscriber = new AddCountryFieldSubscriber($factory);
        $builder->addEventSubscriber($citySubscriber);
        $builder->addEventSubscriber($countrySubscriber);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\CreateBundle\Entity\Shops'
        ));
    }
    
    public function getName() {
        return 'shops';
    }
}
?>
