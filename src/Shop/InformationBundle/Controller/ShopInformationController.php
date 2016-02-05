<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopInformationController extends Controller 
{    
    public function shopAction($shopname)
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(["uniqueName" => $shopname]);
        
        $delivery = $this->getDoctrine()->getRepository('ShopCreateBundle:ShopsDelivery')
                ->findAllShopsDelivery($shopname);
        
        return $this->render('ShopInformationBundle:Shop:shopInformation.html.twig', array(
            'shop' => $shop,
            'delivery' => $delivery,
            'shopname' => $shopname,
        ));
    }
    
    public function ajaxShopAction($shopname)
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(["uniqueName" => $shopname]);
        
        return $this->render('ShopInformationBundle:Fancybox:shopInformation.html.twig', array(
            'shop' => $shop,
        ));
    }
    
    public function deliveryShopAction($shopname)
    {
        $delivery = $this->getDoctrine()->getRepository('ShopCreateBundle:ShopsDelivery')
                ->findAllShopsDelivery($shopname);
        
        return $this->render('ShopInformationBundle:Shop:delivery.html.twig', array(
            'delivery' => $delivery,
        ));
    }
    
    public function paymentShopAction($shopname)
    {
        $this->get('shopInformation');
        $payment = $this->get('shopInformation')->payment($shopname);
        
        return $this->render('ShopInformationBundle:Shop:payment.html.twig', array(
            'payment' => $payment,
        ));
    }
    
    public function partnersShopAction($shopname)
    {
        $shops = $this->getDoctrine()->getRepository('ManagerPartnersBundle:Partners')
                    ->findAllShopsPartners($shopname);
        
        return $this->render('ShopInformationBundle:Shop:partners.html.twig', array(
            'shops' => $shops,
        ));
    }
}
