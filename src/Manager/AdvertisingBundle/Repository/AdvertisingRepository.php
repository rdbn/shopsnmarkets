<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AdvertisingRepository extends EntityRepository 
{
    public function findByAdvertising($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT a.path FROM ManagerAdvertisingBundle:Advertising a
                    WHERE a.date_start <= :date AND a.date_end >= :date AND a.format = :id
                ')->setParameters($value)
                ->execute();
    }
    
    public function findByAdvertisingManager($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT a.id, a.path, a.date_start, a.date_end, f.id as format, f.name, s.shopname FROM ManagerAdvertisingBundle:Advertising a
                    LEFT JOIN a.format f
                    LEFT JOIN a.shops s
                    LEFT JOIN s.manager m
                    WHERE a.date_start <= :date AND a.date_end >= :date AND m.id = :user AND a.shops = s.id
                ')->setParameters($value)
                ->execute();
    }
}
