<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Services;

class Advertising 
{        
    public function getImageShopSlider($nameShop)
    {
        $dir = __DIR__.'/../../../../web/public/xml/Shops/'.$nameShop.'/advertising/slider';
        
        return $this->getImagesShop($dir, 'slider', $nameShop);
    }
    
    public function getImageShopSideOf($nameShop)
    {
        $dir = __DIR__.'/../../../../web/public/xml/Shops/'.$nameShop.'/advertising/side_of';
        
        return $this->getImagesShop($dir, 'side_of', $nameShop);
    }
    
    private function getImagesShop($dir, $format, $nameShop)
    {
        $files = scandir($dir);
        unset($files['0']);
        unset($files['1']);
        
        if (isset($files['2'])) {
            $arFiles = array();
            
            foreach ($files as $index => $file) {
                $arFiles[$index] = '/public/xml/Shops/'.$nameShop.'/advertising/'.$format.'/'.$file;
            }
            
            return $arFiles;
        } else {
            return array('/public/images/shop/slider.png');
        }
    }
}
?>
