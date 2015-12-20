<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Entity\ShopsDelivery;
use Shop\CreateBundle\Form\Type\DeliveryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeliveryController extends Controller 
{    
    public function allAction($shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $shopsDelivery = new ShopsDelivery();
        $shopsDelivery->setShops($shop);
        $form = $this->createForm(new DeliveryType(), $shopsDelivery);

        $delivery = $em->getRepository('ShopCreateBundle:Delivery')
            ->findAll();
        
        return $this->render('ShopCreateBundle:Delivery:all.html.twig', [
            'form' => $form->createView(),
            'delivery' => $delivery,
            'shopname' => $shopname,
        ]);
    }
}