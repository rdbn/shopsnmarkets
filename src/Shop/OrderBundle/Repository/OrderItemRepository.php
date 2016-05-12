<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class OrderItemRepository extends EntityRepository
{
    /**
     * Корзина не зарегистрированного пользователя
     *
     * @param int $id
     *
     * @return array
     */
    public function findByProductsBasket($id)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());

        $rsm->addEntityResult("ShopOrderBundle:OrderItem", "oi");
        $rsm->addFieldResult("oi", "id", "id");
        $rsm->addFieldResult("oi", "number", "number");

        $rsm->addJoinedEntityResult("ShopProductBundle:Product", "p", "oi", "product");
        $rsm->addFieldResult("p", "product", "id");
        $rsm->addFieldResult("p", "price", "price");

        $rsm->addJoinedEntityResult("ShopProductBundle:ProductImage", "pi", "p", "image");
        $rsm->addFieldResult("pi", "image_id", "id");
        $rsm->addFieldResult("pi", "path", "path");

        $query = $this->getEntityManager()
            ->createNativeQuery('
                SELECT 
                  DISTINCT ON (oi.id) oi.id,
                  oi.product_id,
                  oi.number,
                  p.id as product,
                  p.price,
                  pi.id as image_id,
                  pi.path
                FROM order_item oi
                  LEFT JOIN product p ON oi.product_id = p.id
                  LEFT JOIN product_image pi ON p.id = pi.product_id
                WHERE 
                  oi.id IN (?)
                  AND oi.order_id IS NULL 
            ', $rsm)
            ->setParameter(1, $id);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Финальная цена незарегистрированного пользователя
     *
     * @param int $id
     *
     * @return array
     */
    public function getValueSumBasket($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT 
                  count(oi.id) as count_product,
                  sum(p.price) as sum_price
                FROM ShopOrderBundle:OrderItem oi
                  LEFT JOIN oi.product p
                  LEFT JOIN oi.order o
                WHERE 
                  o.id IN (?)
                  AND o.checkPay = \'f\' 
            ')
            ->setParameter("id", $id);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Корзина пользователя
     *
     * @param int $id
     *
     * @return array
     */
    public function findByProductsUsersBasket($id)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());

        $rsm->addEntityResult("ShopOrderBundle:OrderItem", "oi");
        $rsm->addFieldResult("oi", "id", "id");
        $rsm->addFieldResult("oi", "number", "number");

        $rsm->addJoinedEntityResult("ShopOrderBundle:Order", "o", "oi", "order");
        $rsm->addJoinedEntityResult("ShopProductBundle:Product", "p", "oi", "product");
        $rsm->addFieldResult("p", "product", "id");
        $rsm->addFieldResult("p", "price", "price");

        $rsm->addJoinedEntityResult("ShopProductBundle:ProductImage", "pi", "p", "image");
        $rsm->addFieldResult("pi", "image_id", "id");
        $rsm->addFieldResult("pi", "path", "path");

        $query = $this->getEntityManager()
            ->createNativeQuery('
                SELECT 
                  DISTINCT ON (oi.id) oi.id,
                  oi.product_id,
                  oi.number,
                  p.id as product,
                  p.price,
                  pi.id as image_id,
                  pi.path
                FROM order_item oi
                  LEFT JOIN "order" o ON oi.order_id = o.id
                  LEFT JOIN product p ON oi.product_id = p.id
                  LEFT JOIN product_image pi ON p.id = pi.product_id
                WHERE 
                  o.users_id = ? 
                  AND o.check_pay = \'f\'
            ', $rsm)
            ->setParameter(1, $id);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Финальная цена незарегистрированного пользователя
     *
     * @param int $id
     *
     * @return array
     */
    public function getValueUsersBasket($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT 
                  count(oi.id) as count_product,
                  sum(p.price) as sum_price
                FROM ShopOrderBundle:OrderItem oi
                  LEFT JOIN oi.product p
                  LEFT JOIN oi.order o
                WHERE 
                  o.users = :id
                  AND o.checkPay = \'f\' 
            ')
            ->setParameter("id", $id);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}