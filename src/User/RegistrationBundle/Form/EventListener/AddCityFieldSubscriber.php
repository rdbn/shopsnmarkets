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
use User\RegistrationBundle\Entity\Country;

class AddCityFieldSubscriber implements EventSubscriberInterface 
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
            FormEvents::PRE_BIND     => 'preBind',
        );
    }
    
    public function addCityForm($form, $country)
    {
        $form->add($this->factory->createNamed('city','entity', null, array(
            'class'         => 'UserRegistrationBundle:City',
            'label'         => false,
            'attr' => ['class' => "form-control"],
            'empty_value'   => '--- Выберите город* ---',
            'auto_initialize' => false,
            'query_builder' => function (EntityRepository $repository) use ($country) {
                $qb = $repository->createQueryBuilder('city')
                    ->innerJoin('city.country', 'country');
                if ($country instanceof Country) {
                    $qb->where('city.country = :country')
                    ->setParameter('country', $country);
                } elseif (is_numeric($country)) {
                    $qb->where('country.id = :country')
                    ->setParameter('country', $country);
                } else {
                    $qb->where('country.name = :country')
                    ->setParameter('country', null);
                }

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
