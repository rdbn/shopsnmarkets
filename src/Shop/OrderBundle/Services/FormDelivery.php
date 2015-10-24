<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Services;

use Shop\OrderBundle\Entity\Address;
use Shop\OrderBundle\Entity\OrderDelivery;
use Shop\OrderBundle\Form\Type\OrderType;
use Shop\OrderBundle\Form\Type\OrderDeliveryType;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class FormDelivery
{
    protected $em, $formFactory, $formOrder, $formDelivry, $model_order, $model_order_delivery;
    
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($orderNumber) {
        $formOrder = $this->createFormOrder($orderNumber);
        $formOrderDelivery = $this->createFormDelivery($orderNumber);
        
        $formDelivery = array();
        foreach ($formOrderDelivery as $key => $form) {
            $formDelivery[$key] = $form->createView();
        }
        
        return array(
            'order' => $formOrder->createView(),
            'delivery' => $formDelivery,
        );
    }
    
    private function getOrder($orderNumber) {
        $repository = $this->em->getRepository('ShopOrderBundle:Order');
        $query = $repository->createQueryBuilder('o')
                ->where('o.order_number = :order')
                ->setParameter('order', $orderNumber);
        
        $model = $query->getQuery()->getResult();
        
        return $model['0'];
    }

    public function createFormOrder($orderNumber) {
        $this->model_order = $this->getOrder($orderNumber);        
        $this->model_order->setAddress(new Address());
        
        $this->formOrder = $this->formFactory->create(new OrderType(), $this->model_order);
        
        return $this->formOrder;
    }
    
    private function getOrderItem($orderNumber) {
        $repository = $this->em->getRepository('ShopCreateBundle:Shops');
        $query = $repository->createQueryBuilder('s')
                ->innerJoin('ShopOrderBundle:OrderItem', 'oi', 'WITH', 'oi.shops = s.id')
                ->innerJoin('oi.order', 'o')
                ->where('o.order_number = :order')
                ->groupBy('s')
                ->setParameter('order', $orderNumber);
        
        $model = $query->getQuery()->getResult();
        
        return $model;
    }
    
    public function createFormDelivery($orderNumber) {
        $this->form = array();
        $this->model_order_delivery = new OrderDelivery();
        
        foreach ($this->getOrderItem($orderNumber) as $key => $shop) {
            $this->model_order_delivery = new OrderDelivery();
            $this->formDelivry[$key] = $this->formFactory->createNamed(
                    'form_'.$shop->getUniqueName(),
                    new OrderDeliveryType($shop),
                    $this->model_order_delivery
            );
        }
        
        return $this->formDelivry;
    }
    
    public function add($request, $orderNumber) {
        if ($request->getMethod('POST')) {
            $this->formBind($request);
            
            if ($this->formOrder->isValid()) {
                $this->save();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    private function formBind($request) {
        $order = $request->request->get('Order');
        $this->formOrder->bind($order);

        foreach ($this->formDelivry as $value) {
            $delivery = $request->request->get($value->getName());
            $value->bind($delivery);
        }
    }
    
    private function save() {
        foreach ($this->formDelivry as $value) {
            $delivery = $value->getData();
            $delivery->setOrder($this->model_order);
            $this->model_order->addDelivery($delivery);
        }
        
        $add = $this->em;
        $add->persist($this->model_order);
        $add->flush();
    }
}