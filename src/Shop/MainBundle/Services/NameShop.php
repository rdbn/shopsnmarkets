<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\MainBundle\Services;

use Doctrine\ORM\EntityManager;

class NameShop {
    
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function value($nameShop) {
        $shop = $this->em->getRepository('ShopCreateBundle:Shops')
                ->findOneByShop($nameShop);
        
        return $shop;
    }
    
    public function preview($nameShop) {
        $file = __DIR__.'/../../../../../Symfony/web/public/xml/Shops/'.$nameShop.'/preview.xml';
        
        if (file_exists($file)) {
            return simplexml_load_file($file);
        } else {
            return '';
        }
    }

    public function isUser($nameShop, $idUser) {
        if ($idUser != null) {
            $repository = $this->em->getRepository('ShopCreateBundle:Shops');
            $query = $repository->createQueryBuilder('s')
                    ->select('u.id')
                    ->innerJoin('s.users', 'u')
                    ->where('u.id = :user')
                    ->setParameter('user', $idUser->getId())
                    ->andWhere('s.unique_name = :name')
                    ->setParameter('name', $nameShop);

            $user = $query->getQuery()->getResult();
            
            if ($user != null) {
                return false;
            } else {
                return true;
            }
        }
    }
    
    public function isManager($nameShop, $idUser) {
        if ($idUser != null) {
            $repository = $this->em->getRepository('ShopCreateBundle:Shops');
            $query = $repository->createQueryBuilder('s')
                    ->select('u.id')
                    ->innerJoin('s.manager', 'u')
                    ->where('u.id = :user')
                    ->setParameter('user', $idUser->getId())
                    ->andWhere('s.unique_name = :name')
                    ->setParameter('name', $nameShop);
            
            $user = $query->getQuery()->getResult();
            
            if ($user['0'] == null) {
                return false;
            } else {
                return true;
            }
        }
    }
}
?>
