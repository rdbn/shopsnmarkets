<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddTypeThingFieldSubscriber implements EventSubscriberInterface 
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
    
    public function addTypeThingForm($form, $typeThing)
    {
        $form->add($this->factory->createNamed('typeThing','typeThing', $typeThing, array(
            'auto_initialize' => false,
            'mapped'        => false,
            /*'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('type_thing')
                        ->where('type_thing.name = :name')
                        ->setParameter('name', null);

                return $qb;
            }*/
        )));
    }
    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data) {
            return;
        }
        
        $arSize = $data->getSize();
        $typeThing = (isset($arSize['0'])) ? $arSize['0']->getTypeThing() : null;
        $this->addTypeThingForm($form, $typeThing);
    }
}
?>
