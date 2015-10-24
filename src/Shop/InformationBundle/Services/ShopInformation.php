<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Services;

use Doctrine\ORM\EntityManager;

class ShopInformation {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function information($nameShop) {
        if ($nameShop != NULL && $nameShop != '') {            
            return $this->textXML($nameShop);
        } else {
            return false;
        }
    }
    
    private function textXML($nameShop) {
        $file = __DIR__.'/../../../../../Symfony/web/public/xml/Shops/'.$nameShop.'/preview.xml';
        
        if (file_exists($file)) {
            return simplexml_load_file($file);
        } else {
            return '';
        }
    }
    
    public function payment($nameShop) {
        $file = __DIR__.'/../../../../web/public/xml/Shops/'.$nameShop.'/preview.xml';
        
        $payment = '';
        if (file_exists($file)) {
            $payment = simplexml_load_file($file)->payment;
        }
        
        return $payment;
    }
}
?>
