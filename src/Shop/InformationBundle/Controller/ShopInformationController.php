<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopInformationController extends Controller 
{    
    public function shopAction($nameShop) 
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneByShopInformation($nameShop);
        
        $delivery = $this->getDoctrine()->getRepository('ShopCreateBundle:ShopsDelivery')
                ->findAllShopsDelivery($nameShop);
        
        $preview = $this->get('shopInformation')->information($nameShop);
        
        return $this->render('ShopInformationBundle:Shop:shopInformation.html.twig', array(
            'shop' => $shop,
            'delivery' => $delivery,
            'preview' => $preview,
            'nameShop' => $nameShop,
        ));
    }
    
    public function ajaxShopAction($nameShop) 
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneByShopInformation($nameShop);
        
        $preview = $this->get('shopInformation')->information($nameShop);
        
        return $this->render('ShopInformationBundle:Fancybox:shopInformation.html.twig', array(
            'shop' => $shop,
            'preview' => $preview,
        ));
    }
    
    public function deliveryShopAction($nameShop) 
    {
        $delivery = $this->getDoctrine()->getRepository('ShopCreateBundle:ShopsDelivery')
                ->findAllShopsDelivery($nameShop);
        
        return $this->render('ShopInformationBundle:Shop:delivery.html.twig', array(
            'delivery' => $delivery,
        ));
    }
    
    public function paymentShopAction($nameShop) 
    {
        $this->get('shopInformation');
        $payment = $this->get('shopInformation')->payment($nameShop);
        
        return $this->render('ShopInformationBundle:Shop:payment.html.twig', array(
            'payment' => $payment,
        ));
    }
    
    public function partnersShopAction($nameShop) 
    {
        $shops = $this->getDoctrine()->getRepository('ManagerPartnersBundle:Partners')
                    ->findAllShopsPartners($nameShop);
        
        return $this->render('ShopInformationBundle:Shop:partners.html.twig', array(
            'shops' => $shops,
        ));
    }
}
?>
