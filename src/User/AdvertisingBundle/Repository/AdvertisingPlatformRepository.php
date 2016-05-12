<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\AdvertisingBundle\Repository;

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
    public function findByAdvertising(array $data) 
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ap.path FROM UserAdvertisingBundle:AdvertisingPlatform ap
                WHERE ap.date_start <= :date AND ap.date_end >= :date AND ap.format = :id
            ')
            ->setParameters($data);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Реклама в магазине
     *
     * @param array $data
     *
     * @return array
     */
    public function findByAdvertisingShop(array $data) 
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ap.path FROM UserAdvertisingBundle:AdvertisingPlatform ap
                LEFT JOIN ap.shops s
                WHERE ap.manager = :user AND ap.adformat = :adFormat
            ')
            ->setParameters($data);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Реклама котроя заарегистрирована
     * пользоватеоем на платформе
     *
     * @param int $id
     *
     * @return array
     */
    public function findByAdvertisingUser($id) 
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT ap.id, ap.date_start, ap.date_end, f.id as format, f.name, s.shopname, ap.path
                FROM UserAdvertisingBundle:AdvertisingPlatform ap
                LEFT JOIN ap.format f
                LEFT JOIN ap.shops s
                WHERE s.manager = :user
            ')
            ->setParameter("user", $id);

        try {
            return $query->getResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
