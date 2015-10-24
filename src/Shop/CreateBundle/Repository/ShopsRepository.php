<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShopsRepository extends EntityRepository
{
    public function findAllShops() {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.shopname, s.unique_name, s.rating, s.path, count(DISTINCT sub) as users, count(DISTINCT like) as likes
                    FROM ShopCreateBundle:Shops s
                    LEFT JOIN s.users sub
                    LEFT JOIN s.like_shop like
                    GROUP BY s
                    ORDER BY s.createdAt desc
                ')->getResult();
    }
    
    public function findAllShopsManager($id) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.shopname, s.unique_name, s.rating, s.path, count(DISTINCT sub) as users, count(DISTINCT like) as likes
                    FROM ShopCreateBundle:Shops s
                    LEFT JOIN s.manager u
                    LEFT JOIN s.users sub
                    LEFT JOIN s.like_shop like
                    WHERE u.id = :id
                    GROUP BY s
                ')->setParameter('id', $id)
                ->getResult();
    }
    
    public function findOneByShopInformation($name) {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT s.shopname, c.name as country, ci.name as city, s.street, s.home_index, s.phone, s.fax, s.email, s.path
                    FROM ShopCreateBundle:Shops s
                    LEFT JOIN s.city ci
                    LEFT JOIN ci.country c
                    WHERE s.unique_name = :name
                    GROUP BY s
                ')->setParameter('name', $name)
                ->setFirstResult('0')
                ->setMaxResults('1')
                ->getResult();
        
        if (isset($query['0'])) {
            return $query['0'];
        } else {
            return null;
        }
    }
    
    public function findAllShopnameManager($id)
    {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.shopname FROM ShopCreateBundle:Shops s
                    LEFT JOIN s.manager u
                    WHERE u.id = :id
                    GROUP BY s
                ')->setParameter('id', $id)
                ->getResult();
    }

    public function findOneByShop($name) 
    {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT s.id, s.shopname, s.path, count(DISTINCT u) as users
                    FROM ShopCreateBundle:Shops s
                    LEFT JOIN s.users u
                    WHERE s.unique_name = :name
                    GROUP BY s
                ')->setParameter('name', $name)
                ->getResult();
        
        if (isset($query['0'])) {
            return $query['0'];
        } else {
            return null;
        }
    }
}
?>
