<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Services;

use Doctrine\ORM\EntityManager;

class ShopLike
{
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function isUsers($idUser, $idShop) {
        $repository = $this->em->getRepository('ShopCreateBundle:Shops');
        $query = $repository->createQueryBuilder('s')
                ->select('u.id')
                ->innerJoin('s.like_shop', 'u')
                ->where('u.id = :user')
                ->setParameter('user', $idUser)
                ->andWhere('s.id = :shop')
                ->setParameter('shop', $idShop);
        
        $user = $query->getQuery()->getResult();
        
        return $user;
    }
    
    public function addLike($id, $user) {
        $shop = $this->em->getRepository('ShopCreateBundle:Shops')
                ->findOneById($id);
        
        $addLike = $this->em;
        $addLike->persist($shop->addLikeShop($user));
        $addLike->flush();
    }
}
?>
