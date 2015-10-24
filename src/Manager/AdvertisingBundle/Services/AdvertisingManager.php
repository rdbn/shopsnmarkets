<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Services;

use Doctrine\ORM\EntityManager;

class AdvertisingManager {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function advertising($userID) {
        $shops = $this->em->getRepository('ShopCreateBundle:Shops')
                ->findAllShopsManager($userID);
        
        return $this->getFiles($shops);
    }
    
    private function getFiles($shops) {
        $advertising = array();
        $dir = __DIR__.'/../../../../web/public/xml/Shops';
        
        foreach ($shops as $shop) {
            $dir_slider = $dir.'/'.$shop['unique_name'].'/advertising/slider';
            $dir_side_of = $dir.'/'.$shop['unique_name'].'/advertising/side_of';
            
            $advertising[$shop['id']]['name'] = $shop['shopname'];
            $advertising[$shop['id']]['unique_name'] = $shop['unique_name'];
            
            $advertising[$shop['id']]['slider'] = scandir($dir_slider);
            unset($advertising[$shop['id']]['slider']['0']);
            unset($advertising[$shop['id']]['slider']['1']);
            
            $advertising[$shop['id']]['side_of'] = scandir($dir_side_of);
            unset($advertising[$shop['id']]['side_of']['0']);
            unset($advertising[$shop['id']]['side_of']['1']);
        }
        
        return $advertising;
    }

    public function removeFile($href) {
        $dir = __DIR__.'/../../../../web'.$href;
        
        if (file_exists($dir)) {
            unlink($dir);
        }
    }
}
?>
