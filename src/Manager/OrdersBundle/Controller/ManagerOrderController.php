<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\OrdersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManagerOrderController extends Controller
{
    public function managerOrderAction()
    {
        $user = $this->getUser();
        
        $orders = $this->get('managerOrders')->getOrdersShops($user->getId());
        
        return $this->render('ManagerOrdersBundle:ManagerOrder:orderProduct.html.twig',array(
            'orders' => $orders,
        ));
    }
}
?>
