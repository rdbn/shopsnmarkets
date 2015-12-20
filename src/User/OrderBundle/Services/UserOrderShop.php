<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\OrderBundle\Services;

use Doctrine\ORM\EntityManager;

class UserOrderShop
{
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getShop($shopname) {
        return $this->getQueryShop($shopname);
    }
    
    private function getQueryShop($shopname) {
        if (isset($shopname['0'])) {
            $repository = $this->em->getRepository('ShopCreateBundle:Shops');
            $query = $repository->createQueryBuilder('s')
                    ->select('s.id, s.uniqueName, s.shopname, s.path, u.realname, u.email, u.phone')
                    ->innerJoin('s.manager', 'u');

            if (count($shopname) > 1) {
                $query->where('s.uniqueName IN (:name)')
                        ->setParameter('name', $shopname);
            } else {
                $query->where('s.uniqueName = :name')
                        ->setParameter('name', $shopname);
            }

            $shop = $query->getQuery()->getResult();

            return $shop;
        } else {
            return false;
        }
    }
}
?>
