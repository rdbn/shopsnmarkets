<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeliveryController extends Controller 
{    
    public function allAction($nameShop) {
        $delivery = $this->getDoctrine()->getRepository('ShopCreateBundle:Delivery')
                ->findAll();
        
        return $this->render('ShopCreateBundle:Delivery:all.html.twig', array(
            'delivery' => $delivery,
            'nameShop' => $nameShop,
        ));
    }
    
    public function formAction()
    {        
        $request = $this->getRequest()->query->get('id');
        
        $delivery = $this->get('formDeliveryShop');
        $form = $delivery->createForm($request);
        
        return $this->render('ShopCreateBundle:Delivery:deliveryForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function saveAction() 
    {
        $request = $this->getRequest()->request->get('ShopsDelivery');
        
        $delivery = $this->get('formDeliveryShop');
        $delivery->createForm($request);
        
        if ($delivery->addDelivery($request)) {
            return new Response('0');
        }
        
        return new Response('');
    }
}
?>
