<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\FormInterface;
use Shop\CreateBundle\Entity\ShopsDelivery;

class AddShopsDeliveryFieldSubscriber implements EventSubscriberInterface
{
    /**
     * @var FormFactoryInterface
    */
    private $factory;

    /**
     * Инициалезируем переменные
     *
     * @param FormFactoryInterface $factory
    */
    public function __construct(FormFactoryInterface $factory) 
    {
        $this->factory = $factory;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
        ];
    }

    /**
     * @param FormInterface $form
     * @param mixed $value
     *
     * @return null
    */
    public function addShopsDeliveryForm($form, $value)
    {
        $form->add($this->factory->createNamed('delivery', EntityType::class, null, [
            'class' => 'ShopCreateBundle:ShopsDelivery',
            'choice_label' => function (ShopsDelivery $shopsDelivery) {
                return $shopsDelivery->getDelivery()->getName();
            },
            'label' => false,
            'attr' => ['class' => "form-control"],
            'auto_initialize' => false,
            'mapped' => false,
            'query_builder' => function (EntityRepository $repository) use ($value) {
                $qb = $repository->createQueryBuilder('sd')
                    ->innerJoin('sd.shops', 's')
                    ->where('s.id = :id')
                    ->setParameter('id', $value);

                return $qb;
            }
        ]));
    }
    
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data->getDelivery()) {
            return;
        }

        $delivery = $data->getDelivery();
        $this->addShopsDeliveryForm($form, $delivery[0]->getShops()->getId());
    }
}