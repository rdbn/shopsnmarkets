<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller {

    public function indexAction() {        
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShops();

        $advertising = $this->getDoctrine()->getRepository('ManagerAdvertisingBundle:Advertising')
            ->findByAdvertising(array('date' => date("Y-m-d H:i:s"), 'id' => '1'));

        if (null == $advertising) {
            $advertising['0']['path'] = '/public/images/shop/slider.png';
        }
        
        return $this->render('PlatformMainBundle:Page:index.html.twig', array(
            'shops' => $shops,
            'advertising' => $advertising,
        ));
    }

    public function shopsAction()
    {
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findAllShops();

        return $this->render('PlatformMainBundle:Page:shops.html.twig', array(
            'shops' => $shops,
        ));
    }

    public function newsAction()
    {
        $name = 'Страница новостей';

        return $this->render('PlatformMainBundle:Page:news.html.twig', array(
            'name' => $name,
        ));
    }
}
?>
