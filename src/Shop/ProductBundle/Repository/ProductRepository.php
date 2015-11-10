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
    public function findAllProductPlatform() {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT count(p.id) as id, p.id, p.price, count(likeProduct) as likes
                    FROM ShopProductBundle:Product p
                    LEFT JOIN p.like_product likeProduct
                    GROUP BY p
                ')
                ->setFirstResult(0)
                ->setMaxResults(15)
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
                    SELECT p.id, p.price, p.path, p.text,
                    s.id as shop, s.unique_name, s.shopname, s.rating, s.path as logo,
                    count(DISTINCT u) as users, count(DISTINCT likeShop) as likes
                    FROM ShopProductBundle:Product p
                    LEFT JOIN p.shops s
                    LEFT JOIN s.users u
                    LEFT JOIN s.like_shop likeShop
                    WHERE p.id = :id
                    GROUP BY p
                ')->setParameter('id', $id)
                ->setFirstResult(0)
                ->setMaxResults(1)
                ->getSingleResult();

        return $query['0'];
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
                SELECT p.id, p.price, count(likeProduct) as likes FROM ShopProductBundle:Product p
                LEFT JOIN p.like_product likeProduct
                LEFT JOIN p.shops s
                WHERE s.unique_name = :name
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
    public function findOneById($id) {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.price, p.text, count(likes) as likes, s.unique_name as shops
                FROM ShopProductBundle:Product p
                LEFT JOIN p.like_product likes
                LEFT JOIN p.shops s
                WHERE p.id = :id
            ')
            ->setParameter('id', $id)
            ->setFirstResult(0)
            ->setMaxResults(1);

        $query = $query->getResult();
        return $query['0'];
    }
}