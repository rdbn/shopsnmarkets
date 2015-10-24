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
use Shop\AddProductsBundle\Entity\Floor;

class AddCategoryFieldSubscriber implements EventSubscriberInterface 
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
    
    public function addCategoryForm($form, $floor, $category)
    {
        $form->add($this->factory->createNamed('category','entity', $category, array(
            'class'         => 'ShopAddProductsBundle:Category',
            'label'         => 'Категория:',
            'empty_value'   => '--- Выберите категорию ---',
            'auto_initialize' => false,
            'mapped'        => false,
            'query_builder' => function (EntityRepository $repository) use ($floor) {
                $qb = $repository->createQueryBuilder('category')
                    ->innerJoin('category.floor', 'floor');
                if ($floor instanceof Floor) {
                    $qb->where('category.floor = :floor')
                        ->setParameter('floor', $floor);
                } elseif (is_numeric($floor)) {
                    $qb->where('floor.id = :floor')
                        ->setParameter('floor', $floor);
                } else {
                    $qb->where('floor.name = :floor')
                        ->setParameter('floor', null);
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
        
        $category = ($data->getSubcategory()) ? $data->getSubcategory()->getCategory() : null;
        $floor = ($data->getFloor()) ? $data->getFloor() : null;
        $this->addCategoryForm($form, $floor, $category);
    }
    
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data) {
            return;
        }
        
        $floor = array_key_exists('floor', $data) ? $data['floor'] : null;
        $category = array_key_exists('category', $data) ? $data['category'] : null;
        $this->addCategoryForm($form, $floor, $category);
    }
}
?>
