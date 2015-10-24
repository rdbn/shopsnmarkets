<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PartnersRepository extends EntityRepository
{
    public function findAllMyApplication($id) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.unique_name, s.shopname, s.rating, s.path, count(DISTINCT user) as users, 
                    count(DISTINCT like) as likes, shop.id as shops
                    FROM ManagerPartnersBundle:Partners p
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.id
                    LEFT JOIN s.users user
                    LEFT JOIN s.like_shop like
                    LEFT JOIN p.shops shop
                    LEFT JOIN shop.manager u
                    WHERE u.id = :id AND p.check_partners = 0
                    GROUP BY s
                ')->setParameter('id', $id)
                ->setFirstResult('0')
                ->setMaxResults('10')
                ->getResult();
    }
    
    public function findAllApplication($id) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.unique_name, s.shopname, s.rating, s.path, count(DISTINCT user) as users, 
                    count(DISTINCT like) as likes, shop.id as shops
                    FROM ManagerPartnersBundle:Partners p
                    LEFT JOIN p.shops s
                    LEFT JOIN s.users user
                    LEFT JOIN s.like_shop like
                    LEFT JOIN ShopCreateBundle:Shops shop WITH shop.id = p.id
                    LEFT JOIN shop.manager u
                    WHERE u.id = :id AND p.check_partners = 0
                    GROUP BY s
                ')->setParameter('id', $id)
                ->setFirstResult('0')
                ->setMaxResults('10')
                ->getResult();
    }
    
    public function findAllShopsPartners($name) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.unique_name, s.shopname, s.rating, s.path, count(DISTINCT user) as users,
                    count(DISTINCT like) as likes, shop.id as shops
                    FROM ManagerPartnersBundle:Partners p
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.id
                    LEFT JOIN s.users user
                    LEFT JOIN s.like_shop like
                    LEFT JOIN p.shops shop
                    WHERE shop.unique_name = :name AND p.check_partners = 1
                    GROUP BY s
                ')->setParameter('name', $name)
                ->setFirstResult('0')
                ->setMaxResults('10')
                ->getResult();
    }
    
    public function findAllPartners($id) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.unique_name, s.shopname, s.rating, s.path, count(DISTINCT user) as users,
                    count(DISTINCT like) as likes, shop.id as shops
                    FROM ManagerPartnersBundle:Partners p
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.id
                    LEFT JOIN s.users user
                    LEFT JOIN s.like_shop like
                    LEFT JOIN p.shops shop
                    LEFT JOIN shop.manager u
                    WHERE u.id = :id AND p.check_partners = 1
                    GROUP BY s
                ')->setParameter('id', $id)
                ->setFirstResult('0')
                ->setMaxResults('10')
                ->getResult();
    }
}
?>
