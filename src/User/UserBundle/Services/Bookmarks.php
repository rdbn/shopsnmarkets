<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class Bookmarks {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getShops($id) {
        $repository = $this->em->getRepository('ShopCreateBundle:Shops');
        $query = $repository->createQueryBuilder('s')
                ->select('s.unique_name, s.shopname, s.rating, s.path, count(DISTINCT u) as users, count(shop) as like_shop')
                ->leftJoin('s.users', 'u')
                ->leftJoin('s.like_shop', 'shop')
                ->innerJoin('s.users', 'user')
                ->where('user.id = :id')
                ->setParameter('id', $id)
                ->groupBy('s');
        
        $shops = $query->getQuery()->getResult();
        
        return $shops;
    }
}
