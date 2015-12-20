<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\OrdersBundle\Services;

use Doctrine\ORM\EntityManager;

class ManagerOrders
{
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function getOrdersShops($id)
    {
        $order = array();
        foreach ($this->getShops($id) as $index => $name) {
            $dir = __DIR__.'/../../../../../Symfony/web/public/xml/Shops/'.$name['uniqueName'].'/checkout';
            $order = $this->getOrders($dir, $index);
        }
        
        return $order;
    }
    
    private function getShops($id)
    {
        $repository = $this->em->getRepository('ShopCreateBundle:Shops');
        $query = $repository->createQueryBuilder('s')
                ->select('s.uniqueName')
                ->innerJoin('s.manager', 'u')
                ->where('u.id = :id')
                ->setParameter('id', $id);
        
        $shops = $query->getQuery()->getResult();
        
        return $shops;
    }
    
    private function getFiles($dir)
    {
        $arFile = scandir($dir);
        unset($arFile['0']);
        unset($arFile['1']);
        
        if (isset($arFile['2'])) {
            return $arFile;
        } else {
            return false;
        }
    }
    
    private function getOrders($dir, $index)
    {
        $order = array();
        if ($this->getFiles($dir)) {
            $count = 0;
            foreach ($this->getFiles($dir) as $index => $name) {
                $order[$index][$count] = simplexml_load_file($dir.'/'.$name);
                $count++;
            }
        }
        
        return $order;
    }
}
?>
