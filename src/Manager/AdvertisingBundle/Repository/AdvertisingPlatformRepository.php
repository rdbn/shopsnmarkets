<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AdvertisingPlatformRepository extends EntityRepository
{
    /**
     * Реклама на платформе
     *
     * @param array $data
     *
     * @return array
    */
    public function findByAdvertising(array $data) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ap.path FROM ManagerAdvertisingBundle:AdvertisingPlatform ap
                WHERE ap.date_start <= :date AND ap.date_end >= :date AND ap.format = :id
            ')
            ->setParameters($data);

        return $query->getResult();
    }

    /**
     * Реклама в магазине
     *
     * @param array $data
     *
     * @return array
     */
    public function findByAdvertisingShop(array $data) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ap.path FROM ManagerAdvertisingBundle:AdvertisingPlatform ap
                LEFT JOIN ap.shops s
                WHERE ap.manager = :user AND ap.adformat = :adFormat
            ')
            ->setParameters($data);

        return $query->getResult();
    }

    /**
     * Реклама котроя заарегистрирована
     * пользоватеоем на платформе
     *
     * @param array $data
     *
     * @return array
     */
    public function findByAdvertisingManager(array $data) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ap.id, ap.date_start, ap.date_end, f.id as format, f.name, s.shopname
                FROM ManagerAdvertisingBundle:AdvertisingPlatform ap
                LEFT JOIN ap.format f
                LEFT JOIN ap.shops s
                WHERE ap.date_start <= :date AND ap.date_end >= :date AND s.manager = :user
            ')
            ->setParameters($data);

        return $query->getResult();
    }
}
