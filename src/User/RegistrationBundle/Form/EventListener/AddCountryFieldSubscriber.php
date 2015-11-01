<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\RegistrationBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddCountryFieldSubscriber implements EventSubscriberInterface 
{
    private $factory;
    
    public function __construct(FormFactoryInterface $factory) 
    {
        $this->factory = $factory;
    }
    
    public static function getSubscribedEvents() 
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }
    
    public function addCityForm($form, $country)
    {
        $form->add($this->factory->createNamed('country','entity', $country, array(
            'class'         => 'UserRegistrationBundle:Country',
            'label'         => false,
            'empty_value'   => '--- Выберите страну* ---',
            'auto_initialize' => false,
            'mapped'        => false,
            'attr' => ['class' => "form-control"],
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('country');

                return $qb;
            }
        )));
    }
    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data) {
            return;
        }
        
        $country = ($data->getCity()) ? $data->getCity()->getCountry() : null;
        $this->addCityForm($form, $country);
    }
    
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data) {
            return;
        }
        
        $country = array_key_exists('country', $data) ? $data['country'] : null;
        $this->addCityForm($form, $country);
    }
}
?>
