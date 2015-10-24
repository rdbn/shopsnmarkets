<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function findAllProduct($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.path, p.price, oi.id as num_order, f.id as floor,
                    c.id as category, sub.id as subcategory, count(size) as number, size.value
                    FROM ShopOrderBundle:OrderItem oi
                    LEFT JOIN oi.order o
                    LEFT JOIN oi.size size
                    LEFT JOIN oi.product p
                    LEFT JOIN p.floor f
                    LEFT JOIN p.subcategory sub
                    LEFT JOIN sub.category c
                    WHERE o.order_number = :order
                    GROUP BY p, size
                ')->setParameter('order', $value)
                ->getResult();
    }
    
    public function isProductOrder($value) {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT oi.id FROM ShopOrderBundle:OrderItem oi
                    LEFT JOIN oi.order o
                    WHERE o.order_number = :order
                    GROUP BY oi
                ')->setParameter('order', $value)
                ->getResult();
        
        if (!isset($query['0'])) {
            return null;
        } else {
            return $query;
        }
    }
}