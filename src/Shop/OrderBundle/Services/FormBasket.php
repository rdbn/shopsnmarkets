<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Services;

use Shop\OrderBundle\Entity\Order;
use Shop\OrderBundle\Entity\OrderItem;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

class FormBasket
{
    protected $em, $formFactory, $form, $model;
    
    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($type, $order_number, $product) {
        if (null == $order_number) {
            $this->model = new OrderItem();
        } else {
            $id = isset($product['id']) ? $product['id'] : $product['product'];
            $this->model = $this->getModel(array('order' => $order_number, 'product' => $id));
        }
        
        $this->form = $this->formFactory->create($type, $this->model);
        
        return $this->form;
    }
    
    public function add($request, $id_order) {
        if (gettype($request) == 'array') {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {                
                $this->isOrderId($id_order);
                $this->addProduct($id_order);
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    public function getIdOrder() {
        return $this->model->getOrder()->getOrderNumber();
    }

    private function addProduct($id_order) {
        if (null == $id_order) {
            $add = $this->em;
            $add->persist($this->model);
            $add->flush();
        } else {
            $order = $this->model->getId();
            
            if (null == $order) {
                $add = $this->em;
                $add->persist($this->model);
                $add->flush();
            } else {
                $add = $this->em;
                $add->flush();
            }
        }
    }
    
    private function isOrderId($id_order) {
        if (null == $id_order) {
            $order = new Order(null, uniqid());
        } else {
            $order = $this->em->getRepository('ShopOrderBundle:Order')
                    ->findOneBy(array('order_number' => $id_order));
        }
        
        $this->model->setOrder($order);
   }
}