<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertisingController extends Controller
{
    public function sliderShopAction($nameShop)
    {
        $images = $this->get('advertising')->getImageShopSlider($nameShop);
        
        return $this->render('ManagerAdvertisingBundle:AdvertisingShop:advertisingSlider.html.twig', array(
            'images' => $images,
        ));
    }
}

?>
