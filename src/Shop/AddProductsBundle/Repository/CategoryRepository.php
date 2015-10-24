<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{    
    /*
     * return all category shop
     */
    public function findAllCategoryShopId($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT c.id, c.name, s.unique_name, f.id as floor, s.id as shops FROM ShopAddProductsBundle:Product p
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.shops
                    LEFT JOIN ShopAddProductsBundle:Floor f WITH f.id = p.floor
                    LEFT JOIN ShopAddProductsBundle:Subcategory sub WITH sub.id = p.subcategory
                    LEFT JOIN ShopAddProductsBundle:Category c WITH c.id = sub.category
                    WHERE s.id = :id AND p.floor = :floor
                    GROUP BY c
                ')->setParameters($value)
                ->getResult();
    }
    
    public function findAllCategoryShopName($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT c.id, c.name, s.unique_name, f.id as floor, s.id as shops FROM ShopAddProductsBundle:Product p
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.shops
                    LEFT JOIN ShopAddProductsBundle:Floor f WITH f.id = p.floor
                    LEFT JOIN ShopAddProductsBundle:Subcategory sub WITH sub.id = p.subcategory
                    LEFT JOIN ShopAddProductsBundle:Category c WITH c.id = sub.category
                    WHERE s.unique_name = :name AND p.floor = :floor
                    GROUP BY c
                ')->setParameters($value)
                ->getResult();
    }
}
?>
