<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubcategoryRepository extends EntityRepository
{    
    /*
     * return all Subcategory category platform
     */
    public function findAllSubcategoryPlatform($value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT sub.id, sub.name, c.id as category FROM ShopAddProductsBundle:Subcategory sub
                    LEFT JOIN sub.category c
                    WHERE sub.category = :category
                    GROUP BY sub
                ')->setParameter('category', $value)
                ->getResult();
    }
    
    /*
     * return all Subcategory Accessories Platform
     */
    public function findAllAccessoriesPaltform() {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT sub.id, sub.name, c.id as category, f.id as floor FROM ShopAddProductsBundle:Subcategory sub
                    LEFT JOIN sub.category c
                    LEFT JOIN c.floor f
                    WHERE sub.category IN (13, 45)
                    GROUP BY sub
                ')
                ->getResult();
    }
    
    /*
     * return all Subcategory boots Platform
     */
    public function findAllBootsPaltform() {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT sub.id, sub.name, c.id as category, f.id as floor FROM ShopAddProductsBundle:Subcategory sub
                    LEFT JOIN sub.category c
                    LEFT JOIN c.floor f
                    WHERE sub.category IN (9, 44)
                    GROUP BY sub
                ')
                ->getResult();
    }
    
    /*
     * return all Subcategory Accessories Shop name
     */
    public function findAllAccessoriesShop($value) {
        $repository = $this->getEntityManager()->getRepository('ShopAddProductsBundle:Product');
        $query = $repository->createQueryBuilder('p')
                ->select('sub.id, sub.name, s.unique_name, f.id as floor')
                ->leftJoin('p.floor', 'f')
                ->leftJoin('p.subcategory', 'sub')
                ->leftJoin('p.shops', 's');
        
        if (is_numeric($value)) {
            $query = $query->where('s.id = :id')
                    ->setParameter('id', $value);
        } else {
            $query = $query->where('s.unique_name = :name')
                    ->setParameter('name', $value);
        }
        
        $query = $query->andWhere('sub.category IN (13, 45)')
                ->orderBy('sub.id', 'DESC')
                ->groupBy('sub');
        
        $subcategory = $query->getQuery()->getResult();
        
        return $subcategory;
    }
    
    /*
     * return all Subcategory Boots Shop
     */
    public function findAllBootsShop($value) {
        $repository = $this->getEntityManager()->getRepository('ShopAddProductsBundle:Product');
        $query = $repository->createQueryBuilder('p')
                ->select('sub.id, sub.name, s.unique_name, f.id as floor')
                ->leftJoin('p.floor', 'f')
                ->leftJoin('p.subcategory', 'sub')
                ->leftJoin('p.shops', 's');
        
        if (is_numeric($value)) {
            $query = $query->where('s.id = :id')
                    ->setParameter('id', $value);
        } else {
            $query = $query->where('s.unique_name = :name')
                    ->setParameter('name', $value);
        }
        
        $query = $query->andWhere('sub.category IN (9, 44)')
                ->orderBy('sub.id', 'DESC')
                ->groupBy('sub');
        
        $subcategory = $query->getQuery()->getResult();
        
        return $subcategory;
    }
    
    /*
     * return all Subcategory category shop
     */
    public function findAllSubcategoryShop(array $value) {
        return $this->getEntityManager()
                ->createQuery('
                    SELECT sub.id, sub.name, f.id as floor FROM ShopAddProductsBundle:Product p
                    LEFT JOIN ShopCreateBundle:Shops s WITH s.id = p.shops
                    LEFT JOIN ShopAddProductsBundle:Floor f WITH f.id = p.floor
                    LEFT JOIN ShopAddProductsBundle:Subcategory sub WITH sub.id = p.subcategory
                    WHERE s.unique_name = :name AND sub.category = :category
                    GROUP BY sub
                ')->setParameters($value)
                ->getResult();
    }
}
?>
