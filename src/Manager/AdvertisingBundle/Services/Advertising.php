<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Services;

class Advertising 
{        
    public function getImageShopSlider($shopname)
    {
        $dir = __DIR__.'/../../../../web/public/advertising';
        
        return $this->getImagesShop($dir, 'slider', $shopname);
    }
    
    public function getImageShopSideOf($shopname)
    {
        $dir = __DIR__.'/../../../../web/public/xml/Shops/'.$shopname.'/advertising/side_of';
        
        return $this->getImagesShop($dir, 'side_of', $shopname);
    }
    
    private function getImagesShop($dir, $format, $shopname)
    {
        $files = scandir($dir);
        unset($files['0']);
        unset($files['1']);
        
        if (isset($files['2'])) {
            $arFiles = array();
            
            foreach ($files as $index => $file) {
                $arFiles[$index] = '/public/xml/Shops/'.$shopname.'/advertising/'.$format.'/'.$file;
            }
            
            return $arFiles;
        } else {
            return array('/public/images/shop/slider.png');
        }
    }
}
?>
