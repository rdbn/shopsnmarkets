<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BasketController extends Controller
{
    public function basketAction()
    {
        $cookies = $this->getRequest()->cookies;
        
        $products = $sum = $count = $orderNumber = '';
        if ($cookies->has('idOrder')) {
            $basket = $this->get('basket');
            $products = $basket->getProduct($cookies->get('idOrder'));
            $sum = $basket->getSum();
            $count = $basket->getCount();
        }
        
        return $this->render('ShopOrderBundle:Basket:product.html.twig', array(
            'orderNumber' => $cookies->get('idOrder'),
            'products' => $products,
            'count' => $count,
            'sum' => $sum,
        ));
    }
}
?>
