<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /*
     * return all Products Platform
     */
    public function findAllProductPlatform() {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT count(p.id) as id, p.id, p.name, p.price, p.path, sub.id as subcategory, c.id as category, f.id as floor
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.like_product like
                    LEFT JOIN p.floor f
                    LEFT JOIN p.subcategory sub
                    LEFT JOIN sub.category c
                    GROUP BY p
                ')
                ->setFirstResult(0)
                ->setMaxResults(15)
                ->getResult();
    }
    
    /*
     * return all Products Category Platform
     */
    public function findAllProductCategoryPlatform($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT count(p.id) as id, p.id, p.name, p.price, p.path, sub.id as subcategory, c.id as category, f.id as floor
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.floor f
                    LEFT JOIN p.subcategory sub
                    LEFT JOIN sub.category c
                    WHERE c.id = :id
                    GROUP BY p
                ')->setParameter('id', $value)
                ->setFirstResult(0)
                ->setMaxResults(15)
                ->getResult();
    }
    
    /*
     * return all Products Subcategory Platform
     */
    public function findAllProductSubcategoryPlatform($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT count(p.id) as id, p.id, p.name, p.price, p.path, sub.id as subcategory, c.id as category, f.id as floor
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.floor f
                    LEFT JOIN p.subcategory sub
                    LEFT JOIN sub.category c
                    WHERE sub.id = :id
                    GROUP BY p
                ')->setParameter('id', $value)
                ->setFirstResult(0)
                ->setMaxResults(15)
                ->getResult();
    }
    
    /*
     * return Subcategory Products inner card of product Platform
     */
    public function findByProductSubcategoryPlatform(array $value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT count(p.id) as id, p.id, p.name, p.price, p.path, sub.id as subcategory, c.id as category, f.id as floor
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.floor f
                    LEFT JOIN p.subcategory sub
                    LEFT JOIN sub.category c
                    WHERE sub.id = :id AND p.id <> :product
                    GROUP BY p
                ')->setParameters($value)
                ->setFirstResult(0)
                ->setMaxResults(3)
                ->getResult();
    }
    
    /*
     * return Product Platform
     */
    public function findOneByProductPlatform($value) {
        $query = $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.price, p.path, p.text, 
                    s.id as shop, s.unique_name, s.shopname, s.rating, s.path as logo, 
                    count(DISTINCT u) as users, count(DISTINCT like) as likes
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.shops s
                    LEFT JOIN s.users u
                    LEFT JOIN s.like_shop like
                    WHERE p.id = :id
                    GROUP BY p
                ')->setParameter('id', $value)
                ->setFirstResult(0)
                ->setMaxResults(1)
                ->getResult();
        
        return $query['0'];
    }
    
    /*
     * return All Product Shop
     */
    public function findAllProductShop($name) {
        return $this->getEntityManager()
            ->createQuery('
                SELECT p.id, p.name, p.price, p.path, sub.id as subcategory, c.id as category, f.id as floor, count(likeProduct) as likes
                FROM ShopAddProductsBundle:Product p
                LEFT JOIN p.like_product likeProduct
                LEFT JOIN p.shops s
                LEFT JOIN p.floor f
                LEFT JOIN p.subcategory sub
                LEFT JOIN sub.category c
                WHERE s.unique_name = :name
                GROUP BY p
                ')->setParameter('name', $name)
                ->setFirstResult(0)
                ->setMaxResults(16)
                ->getResult();
    }

    /*
     * return All Product Shop category
     */
    public function findAllProductCategoryShop(array $value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.price, p.path, c.name as title, sub.id as subcategory, count(like) as likes 
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.like_product like
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.shops
                    LEFT JOIN ShopAddProductsBundle:Subcategory sub WITH sub.id = p.subcategory
                    LEFT JOIN ShopAddProductsBundle:Category c WITH c.id = sub.category
                    WHERE s.unique_name = :name AND c.id = :category
                    GROUP BY p
                ')->setParameters($value)
                ->setFirstResult(0)
                ->setMaxResults(15)
                ->getResult();
    }
    
    /*
     * return All Product Shop subcategory
     */
    public function findAllProductSubcategoryShop(array $value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.price, p.path, sub.name as title, sub.id as subcategory, count(like) as likes 
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.like_product like
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.shops
                    LEFT JOIN ShopAddProductsBundle:Subcategory sub WITH sub.id = p.subcategory
                    WHERE s.unique_name = :name AND sub.id = :subcategory
                    GROUP BY p
                ')->setParameters($value)
                ->setFirstResult(0)
                ->setMaxResults(15)
                ->getResult();
    }
    
    /*
     * return four Product subcategory product Shop
     */
    public function findByProductSubcategoryShop(array $value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT p.id, p.name, p.price, p.path, sub.name as title, sub.id as subcategory, count(like) as likes 
                    FROM ShopAddProductsBundle:Product p
                    LEFT JOIN p.like_product like
                    LEFT JOIN p.shops s
                    LEFT JOIN p.subcategory sub
                    WHERE s.unique_name = :name AND sub.id = :subcategory AND p.id <> :product
                    GROUP BY p
                ')->setParameters($value)
                ->setFirstResult(0)
                ->setMaxResults(3)
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
