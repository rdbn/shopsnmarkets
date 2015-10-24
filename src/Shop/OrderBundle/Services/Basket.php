<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Services;

use Doctrine\ORM\EntityManager;

class Basket
{
    protected $em, $product;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getProduct($idBasket) {
        $this->product = $this->em->getRepository('ShopOrderBundle:Order')
                ->findAllProduct($idBasket);
        
        return $this->product;
    }

    public function getSum() {        
        $sum = '0';
        
        foreach ($this->product as $value) {
            $sum += $value['price'];
        }
        
        return $sum;
    }
    
    public function getCount() {        
        $count = '0';
        
        foreach ($this->product as $value) {
            $count += $value['number'];
        }
        
        return $count;
    }
}