<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ProductRepository extends EntityRepository
{
    /**
     * Товары на платформе
     *
     * @param int $count
     *
     * @return array
     */
    public function findByProductPlatform($count)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());

        $rsm->addEntityResult("ShopProductBundle:Product", "p");
        $rsm->addFieldResult("p", "id", "id");
        $rsm->addFieldResult("p", "price", "price");

        $rsm->addJoinedEntityResult("UserUserBundle:Users", "u", "p", "likeProduct");
        $rsm->addFieldResult("u", "likes", "id");

        $rsm->addJoinedEntityResult("ShopProductBundle:ProductImage", "pi", "p", "image");
        $rsm->addFieldResult("pi", "image_id", "id");
        $rsm->addFieldResult("pi", "path", "path");

        $query = $this->getEntityManager()
            ->createNativeQuery('
                SELECT DISTINCT ON (p.id) p.id, p.price, count(u.id) as likes, pi.id as image_id, pi.path
                FROM product p
                  LEFT JOIN product_image pi ON pi.product_id = p.id
                  LEFT JOIN product_like pl ON pl.product_id = p.id
                  LEFT JOIN users u ON pl.users_id = u.id
                  LEFT JOIN shops s ON s.id = p.shops_id
                GROUP BY p.id, p.price, pi.id, pi.path
                LIMIT 16 OFFSET ?
            ', $rsm)
            ->setParameter(1, $count);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Карточка продукта
     *
     * @param int $id
     *
     * @return array
     */
    public function findOneByProductPlatform($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT 
                  p.id, p.price, p.text, s.id as shop, s.uniqueName, s.shopname, s.rating, s.path as logo,
                  m.id as shopManager, count(DISTINCT u) as users, count(DISTINCT likeShop) as likes
                FROM ShopProductBundle:Product p
                LEFT JOIN p.shops s
                LEFT JOIN s.manager m
                LEFT JOIN s.users u
                LEFT JOIN s.likeShop likeShop
                WHERE p.id = :id
                GROUP BY p, s, m
            ')
            ->setParameter('id', $id);

        try {
            $result = $query->getResult();

            return $result["0"];
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * return All Product Shop
     *
     * @param string $name
     * @param int $count
     *
     * @return array
     */
    public function findByProductShop($name, $count)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());

        $rsm->addEntityResult("ShopProductBundle:Product", "p");
        $rsm->addFieldResult("p", "id", "id");
        $rsm->addFieldResult("p", "price", "price");

        $rsm->addJoinedEntityResult("UserUserBundle:Users", "u", "p", "likeProduct");
        $rsm->addFieldResult("u", "likes", "id");

        $rsm->addJoinedEntityResult("ShopProductBundle:ProductImage", "pi", "p", "image");
        $rsm->addFieldResult("pi", "image_id", "id");
        $rsm->addFieldResult("pi", "path", "path");

        $query = $this->getEntityManager()
            ->createNativeQuery('
                SELECT DISTINCT ON (p.id) p.id, p.price, count(u.id) as likes, pi.id as image_id, pi.path
                FROM product p
                  LEFT JOIN product_image pi ON pi.product_id = p.id
                  LEFT JOIN product_like pl ON pl.product_id = p.id
                  LEFT JOIN users u ON pl.users_id = u.id
                  LEFT JOIN shops s ON s.id = p.shops_id
                WHERE s.unique_name = ?
                GROUP BY p.id, p.price, pi.id, pi.path
                LIMIT 16 OFFSET ?
            ', $rsm)
            ->setParameters([1 => $name, 2 => $count]);

        try {
            return $query->getArrayResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * return Product Shop
     *
     * @param int $id
     *
     * @return array
     */
    public function findOneByProductId($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.price, p.text, count(likeProduct) as likes
                FROM ShopProductBundle:Product p
                LEFT JOIN p.likeProduct likeProduct
                WHERE p.id = :id
                GROUP BY p.id, p.price, p.text
            ')
            ->setParameter('id', $id);

        try {
            $result = $query->getResult();

            return $result["0"];
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Проверяем наличие лайка от пользователя
     *
     * @param int $product
     * @param int $user
     *
     * @return array
     */
    public function findOneByIsLike($product, $user)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p FROM ShopProductBundle:Product p
                  LEFT JOIN p.likeProduct u
                WHERE p.id = :product AND u.id = :users
            ')
            ->setParameters(['product' => $product, 'users' => $user]);

        try {
            return $query->getSingleResult();
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Кол-во лайков у продукта
     *
     * @param int $id
     *
     * @return array
     */
    public function findOneByCountLike($id)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT count(u.id) as likes FROM ShopProductBundle:Product p
                  LEFT JOIN p.likeProduct u
                WHERE p.id = :product
            ')
            ->setParameter('product', $id);

        try {
            $result = $query->getResult();

            return $result[0]["likes"];
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    /**
     * Кол-во лайков у продукта
     *
     * @return integer
     */
    public function findOneByCountProducts()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT count(p.id) as count_product FROM ShopProductBundle:Product p
            ');

        try {
            $result = $query->getResult();

            return $result[0]["count_product"];
        } catch(\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}