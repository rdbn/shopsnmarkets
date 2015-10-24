<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DeliveryController extends Controller
{
    public function formAction($orderNumber) 
    {
        $idOrder = $this->getRequest()->cookies->get('idOrder');
        
        $basket = $this->get('basket');
        $basket->getProduct($idOrder);
        
        $delivery = $this->get('formDelivery');
        $form = $delivery->createForm($idOrder);        
        
        return $this->render('ShopOrderBundle:Order:delivery.html.twig', array(
            'orderNumber' => $orderNumber,
            'formOrder' => $form['order'],
            'formDelivery' => $form['delivery'],
            'count' => $basket->getCount(),
            'sum' => $basket->getSum(),
        ));
    }
    
    public function addAction(Request $request, $orderNumber) 
    {
        $idOrder = $this->getRequest()->cookies->get('idOrder');
        
        $basket = $this->get('basket');
        $basket->getProduct($idOrder);
        
        $delivery = $this->get('formDelivery');
        $form = $delivery->createForm($idOrder);
        
        if ($delivery->add($request, $idOrder)) {
            return $this->redirect($this->generateUrl('_payment_details', array('orderNumber' => $orderNumber)));
        }
        
        return $this->render('ShopOrderBundle:Order:delivery.html.twig', array(
            'orderNumber' => $orderNumber,
            'formOrder' => $form['order'],
            'formDelivery' => $form['delivery'],
            'count' => $basket->getCount(),
            'sum' => $basket->getSum(),
        ));
    }
}
?>
