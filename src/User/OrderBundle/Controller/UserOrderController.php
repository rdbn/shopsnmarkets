<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserOrderController extends Controller
{
    public function orderAction()
    {
        $userID = $this->getUser()->getId();
        
        $order = $this->get('userOrder');
        
        return $this->render('UserOrderBundle:Order:all.html.twig', array(
            'orders' => $order->getOrder($userID),
            'shops' => $order->getShopName($userID),
        ));
    }
}
