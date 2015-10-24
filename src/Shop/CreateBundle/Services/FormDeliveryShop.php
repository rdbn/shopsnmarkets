<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Services;

use Shop\CreateBundle\Entity\ShopsDelivery;
use Shop\CreateBundle\Form\Type\ShopsDeliveryType;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;

Class FormDeliveryShop {
    
    protected $em, $model, $formFactory, $form, $check;

    public function __construct(EntityManager $em, FormFactoryInterface $formFactory) {
        $this->em = $em;
        $this->formFactory = $formFactory;
    }
    
    public function createForm($request) {
        $this->model = $this->em->getRepository('ShopCreateBundle:ShopsDelivery')
                ->findOneByShopsDelivery($request);
        
        $this->check = false;
        if ($this->model == null) {
            $this->check = true;
            $this->model = new ShopsDelivery();
        }
        
        $this->form = $this->formFactory->create(new ShopsDeliveryType($request['shops'], $request['delivery']), $this->model);
        
        return $this->form;
    }

    public function addDelivery($request) {
        if (gettype($request) == 'array') {
            $this->form->bind($request);
            
            if ($this->form->isValid()) {
                $addDelivery = $this->em;
                if ($this->check) {
                    $addDelivery->persist($this->model);
                }
                $addDelivery->flush();
                
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>
