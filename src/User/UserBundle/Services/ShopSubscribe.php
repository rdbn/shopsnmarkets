<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class ShopSubscribe {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function isUsers($idUser, $idShop) {
        $repository = $this->em->getRepository('ShopCreateBundle:Shops');
        $query = $repository->createQueryBuilder('s')
                ->select('u.id')
                ->innerJoin('s.users', 'u')
                ->where('u.id = :user')
                ->setParameter('user', $idUser)
                ->andWhere('s.id = :shop')
                ->setParameter('shop', $idShop);
        
        $user = $query->getQuery()->getResult();
        
        return $user;
    }

    public function addSubscribe($idShop, $user) {
        $shop = $this->em->getRepository('ShopCreateBundle:Shops')
                ->findOneById($idShop);
        
        $addLike = $this->em;
        $addLike->persist($shop->addUser($user));
        $addLike->flush();
    }
}
?>