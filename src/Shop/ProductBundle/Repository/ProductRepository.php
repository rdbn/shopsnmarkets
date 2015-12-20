<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * return all Products Platform
     */
    public function findByProductPlatform() {
        return $this->getEntityManager()
            ->createQuery('
                SELECT count(p.id) as id, p.id, p.price, count(likeProduct) as likes, img.path
                FROM ShopProductBundle:Product p
                LEFT JOIN p.likeProduct likeProduct
                LEFT JOIN p.image img
                GROUP BY p
            ')
            ->setFirstResult(0)
            ->setMaxResults(16)
            ->getResult();
    }

    /**
     * return Product Platform
     *
     * @param int $id
     *
     * @return array
     */
    public function findOneByProductPlatform($id) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.price, p.text, s.id as shop, s.uniqueName, s.shopname, s.rating, s.path as logo,
                count(DISTINCT u) as users, count(DISTINCT likeShop) as likes
                FROM ShopProductBundle:Product p
                LEFT JOIN p.shops s
                LEFT JOIN s.users u
                LEFT JOIN s.likeShop likeShop
                WHERE p.id = :id
                GROUP BY p
            ')
            ->setParameter('id', $id)
            ->setFirstResult(0)
            ->setMaxResults(1);

        return $query->getSingleResult();
    }

    /**
     * return All Product Shop
     *
     * @param string $name
     *
     * @return array
     */
    public function findByProductShop($name) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.price, count(likeProduct) as likes, im.path FROM ShopProductBundle:Product p
                LEFT JOIN p.likeProduct likeProduct
                LEFT JOIN p.shops s
                LEFT JOIN p.image im
                WHERE s.uniqueName = :name
                GROUP BY p
            ')
            ->setParameter('name', $name)
            ->setFirstResult(0)
            ->setMaxResults(16);

        return $query->getResult();
    }

    /**
     * return Product Shop
     *
     * @param int $id
     *
     * @return array
     */
    public function findOneByProductId($id) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.price, p.text, count(likeProduct) as likes
                FROM ShopProductBundle:Product p
                LEFT JOIN p.likeProduct likeProduct
                WHERE p.id = :id
            ')
            ->setParameter('id', $id)
            ->setFirstResult(0)
            ->setMaxResults(1);

        $query = $query->getResult();
        return $query['0'];
    }
}