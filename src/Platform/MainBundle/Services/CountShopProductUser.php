<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Services;

use Doctrine\ORM\EntityManager;

class CountShopProductUser {
    
    public $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function count()
    {
        $em = $this->em->getRepository('PlatformMainBundle:Count')
                ->find('1');
        
        return $em;
    }
}