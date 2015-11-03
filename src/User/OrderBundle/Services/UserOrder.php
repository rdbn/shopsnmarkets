<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\OrderBundle\Services;

use User\OrderBundle\Services\UserOrderShop;

class UserOrder
{
    protected $orderShop;
    
    public function __construct(UserOrderShop $orderShop) {
        $this->orderShop = $orderShop;
    }

    public function getOrder($userID) {
        $dir = __DIR__.'/../../../../web/public/xml/Users/'.$userID.'/order';
        
        if ($this->getArrayOrder($dir)) {
            return $this->getArrayOrder($dir);
        }
        
        return $this->getArrayOrder($dir);
    }
    
    public function getShopName($userID) {
        $arName = array();
        $value = $this->getOrder($userID);
        
        if (!$value) {
            return $value;
        }
        
        foreach ($value as $key => $product) {
            $arName[$key] = $product['products']->product->shopname;
        }
        
        return $this->orderShop->getShop($arName);
    }

    private function getArrayOrder($dir) {
        $file = scandir($dir);
        unset($file['0']);
        unset($file['1']);
        
        if (isset($file['2'])) {
            return $this->getXML($dir, $file);
        } else {
            return false;
        }
    }
    
    private function getXML($dir, $file) {
        $arValue = array();
        
        foreach ($file as $index => $name) {
            $xml = simplexml_load_file($dir.'/'.$name);
            $arValue[$index] = (array)$xml;
        }
        
        return $arValue;
    }
}
?>
