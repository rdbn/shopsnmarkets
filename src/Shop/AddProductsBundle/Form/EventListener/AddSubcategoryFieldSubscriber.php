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
use Shop\AddProductsBundle\Entity\Category;

class AddSubcategoryFieldSubscriber implements EventSubscriberInterface 
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
    
    public function addSubcategoryForm($form, $category)
    {
        $form->add($this->factory->createNamed('subcategory','entity', null, array(
            'class'         => 'ShopAddProductsBundle:Subcategory',
            'label'         => 'Подкатегорию:',
            'empty_value'   => '--- Выберите подкатегорию ---',
            'auto_initialize' => false,
            'query_builder' => function (EntityRepository $repository) use ($category) {
                $qb = $repository->createQueryBuilder('subcategory')
                    ->innerJoin('subcategory.category', 'category');
                if ($category instanceof Category) {
                    $qb->where('subcategory.category = :category')
                    ->setParameter('category', $category);
                } elseif (is_numeric($category)) {
                    $qb->where('category.id = :category')
                    ->setParameter('category', $category);
                } else {
                    $qb->where('category.name = :category')
                    ->setParameter('category', null);
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
        $this->addSubcategoryForm($form, $category);
    }
    
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data) {
            return;
        }
        
        $category = array_key_exists('category', $data) ? $data['category'] : null;
        $this->addSubcategoryForm($form, $category);
    }
}
?>
