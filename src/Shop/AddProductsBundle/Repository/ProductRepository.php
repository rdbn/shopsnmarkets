<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * return all Products Platform
     */
    public function findAllProductPlatform() {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT count(p.id) as id, p.id, p.name, p.price, count(likeProduct) as likes
                    FROM ShopAddProductsBundle:Product p
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
     * @param int $value
     *
     * @return array
     */
    public function findOneByProductPlatform($value) {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.price, p.path, p.text,
                    s.id as shop, s.unique_name, s.shopname, s.rating, s.path as logo,
                    count(DISTINCT u) as users, count(DISTINCT likeShop) as likes
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.shops s
                    LEFT JOIN s.users u
                    LEFT JOIN s.like_shop likeShop
                    WHERE p.id = :id
                    GROUP BY p
                ')->setParameter('id', $value)
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
    public function findAllProductShop($name) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.name, p.price, count(likeProduct) as likes FROM ShopAddProductsBundle:Product p
                LEFT JOIN p.like_product likeProduct
                LEFT JOIN p.shops s
                WHERE s.unique_name = :name
                GROUP BY p
                ')->setParameter('name', $name)
                ->setFirstResult(0)
                ->setMaxResults(16)
                ->getResult();
    }

    /*
     * return information product shop
     */
    public function findOneByProductShop($id) {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.price, p.path, p.text,
                    count(product_like) as product_likes, s.unique_name as shops
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.like_product product_like
                    LEFT JOIN p.shops s
                    WHERE p.id = :id
                    GROUP BY p
                ')->setParameter('id', $id)
                ->setFirstResult(0)
                ->setMaxResults(1)
                ->getResult();

        return $query['0'];
    }

    public function isLikeProduct(array $value) {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT p.id FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.like_product u
                    WHERE u.id = :user AND p.id = :product
                ')->setParameters($value)
                ->getResult();

        if (isset($query['0'])) {
            return $query['0'];
        } else {
            return false;
        }

    }
}
?>
