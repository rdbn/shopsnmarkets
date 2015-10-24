<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertisingController extends Controller
{
    public function sliderPlatformAction()
    {        
        $advertising = $this->getDoctrine()->getRepository('ManagerAdvertisingBundle:Advertising')
                ->findByAdvertising(array('date' => date("Y-m-d H:i:s"), 'id' => '1'));
        
        if (null == $advertising) {
            $advertising['0']['path'] = '/public/images/shop/slider.png';
        }
        
        return $this->render('ManagerAdvertisingBundle:AdvertisingPlatform:advertisingSlider.html.twig', array(
            'advertising' => $advertising,
        ));
    }
    
    public function sliderShopAction($nameShop)
    {
        $images = $this->get('advertising')->getImageShopSlider($nameShop);
        
        return $this->render('ManagerAdvertisingBundle:AdvertisingShop:advertisingSlider.html.twig', array(
            'images' => $images,
        ));
    }
}

?>
