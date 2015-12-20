<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShopsDeliveryRepository extends EntityRepository
{
    public function findAllShopsDelivery($name) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT sd.price, sd.duration, d.name, d.image FROM ShopCreateBundle:ShopsDelivery sd
                LEFT JOIN sd.delivery d
                LEFT JOIN sd.shops s
                WHERE s.uniqueName = :name
            ')
            ->setParameter('name', $name)
            ->getResult();
    }
    
    public function findOneByShopsDelivery(array $value) 
    {
        $repository = $this->getEntityManager()->getRepository('ShopCreateBundle:ShopsDelivery');
        $query = $repository->createQueryBuilder('sd')
            ->innerJoin('sd.shops', 's')
            ->where('s.uniqueName = :name')
            ->setParameter('name', $value['shops'])
            ->andWhere('sd.delivery = :delivery')
            ->setParameter('delivery', $value['delivery']);
        
        $shopsDelivery = $query->getQuery()->getResult();
        
        if (isset($shopsDelivery['0'])) {
            return $shopsDelivery['0'];
        } else {
            return false;
        }
    }
}