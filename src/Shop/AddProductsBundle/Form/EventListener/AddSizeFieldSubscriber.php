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
use Shop\AddProductsBundle\Entity\TypeThing;

class AddSizeFieldSubscriber implements EventSubscriberInterface 
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
    
    public function addSizeForm($form, $size, $typeThing)
    {
        $form->add($this->factory->createNamed('size','entity', $size, array(
            'class'         => 'ShopAddProductsBundle:Size',
            'property' => 'value',
            'label'         => 'Размер:',
            'auto_initialize' => false,
            'expanded' => true,
            'multiple' => true,
            'query_builder' => function (EntityRepository $repository) use ($typeThing) {
                $qb = $repository->createQueryBuilder('size')
                        ->innerJoin('size.type_thing', 'type_thing');
                if ($typeThing instanceof TypeThing) {
                    $qb->where('size.type_thing = :type_thing')
                        ->setParameter('type_thing', $typeThing);
                } elseif (is_numeric($typeThing)) {
                    $qb->where('size.type_thing = :type_thing')
                        ->setParameter('type_thing', $typeThing);
                } else {
                    $qb->where('type_thing.name = :name')
                        ->setParameter('name', null);
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
        
        $arSize = $data->getSize();
        $typeThing = (isset($arSize['0'])) ? $arSize['0']->getTypeThing() : null;
        $size = ($data->getSize()) ? $data->getSize() : null;
        $this->addSizeForm($form, $size, $typeThing);
    }
    
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data) {
            return;
        }
        
        $size = array_key_exists('size', $data) ? $data['size'] : null;
        $typeThing = array_key_exists('typeThing', $data) ? $data['typeThing'] : null;
        $this->addSizeForm($form, $size, $typeThing);
    }
}
?>
