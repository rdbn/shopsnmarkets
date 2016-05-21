<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class OrderRepository extends EntityRepository
{
    /**
     * Товары что заказаны пользователей
     *
     * @param int $id
     *
     * @return array
     */
    public function findByUsersOrder($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT 
                  o, oi, p, s, m, sd, d, u, ct, co
                FROM ShopOrderBundle:Order o
                  LEFT JOIN o.users u
                  LEFT JOIN u.city ct
                  LEFT JOIN ct.country co
                  LEFT JOIN o.shops s
                  LEFT JOIN s.manager m
                  LEFT JOIN o.delivery sd
                  LEFT JOIN sd.delivery d
                  LEFT JOIN o.orderItem oi
                  LEFT JOIN oi.product p
                WHERE 
                  o.users = :id
                  AND o.isCreateOrder = \'t\'
                  AND o.isPay = \'f\' 
            ')
            ->setParameter("id", $id);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Товары что заказаны магазинах
     *
     * @param int $id
     *
     * @return array
     */
    public function findByManagerOrder($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT 
                  o, oi, p, s, m, sd, d, u, ct, co
                FROM ShopOrderBundle:Order o
                  LEFT JOIN o.users u
                  LEFT JOIN u.city ct
                  LEFT JOIN ct.country co
                  LEFT JOIN o.shops s
                  LEFT JOIN s.manager m
                  LEFT JOIN o.delivery sd
                  LEFT JOIN sd.delivery d
                  LEFT JOIN o.orderItem oi
                  LEFT JOIN oi.product p
                WHERE 
                  s.manager = :id
                  AND o.isCreateOrder = \'t\'
                  AND o.isPay = \'f\' 
            ')
            ->setParameter("id", $id);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}