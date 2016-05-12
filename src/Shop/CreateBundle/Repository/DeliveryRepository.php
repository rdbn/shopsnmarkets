<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DeliveryRepository extends EntityRepository
{
    /**
     * Все способы доставки кроме тех
     * что уже есть у магазина
     *
     * @param array $id
     *
     * @return array
    */
    public function findByNotShopsDelivery(array $id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT d FROM ShopCreateBundle:Delivery d
                WHERE d.id NOT IN (:id)
            ')
            ->setParameter('id', $id);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}