<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class FormAddBasketController extends Controller
{
    public function formAction($shopname, $product)
    {
        $cookies = $this->get("request")->cookies;
            
        $id_order = null;
        if ($cookies->has('idOrder')) $id_order = $cookies->get('idOrder');



        return $this->render('ShopOrderBundle:Form:product.html.twig', array(
            'price' => $product['price'],

            'shopname' => $shopname,
        ));
    }
    
    public function addProductAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $request = $this->getRequest()->request->get('OrderItem');
            
            $cookies = $this->getRequest()->cookies;
            
            $id_order = null;
            if ($cookies->has('idOrder')) {
                $id_order = $cookies->get('idOrder');
            }
            
            $basket = $this->get('formBasket');
            $basket->createForm(new OrderItemType($request), $id_order, $request);

            if ($basket->add($request, $id_order)) {
                if (null == $id_order) {
                    $cookie = new Cookie('idOrder', $basket->getIdOrder(), time() + 3600 * 24 * 7);
                    $response = new Response();
                    $response->headers->setCookie($cookie);
                    $response->send();
                }
                
                return new Response('0');
            } else {
                return new Response('1');
            }
        } else {
            return new Response('1');
        }
    }
    
    public function deleteAction()
    {
        $id = $this->getRequest()->query->get('id');
        
        $em = $this->getDoctrine()->getManager();
        
        if (settype($id, 'integer')) {
            $order_item = $em->getRepository('ShopOrderBundle:OrderItem')
                ->findOneById($id);
        } else {
            return new Response('1');
        }
        
        
        if (null != $order_item) {
            $em->remove($order_item);
            $em->flush();
            
            $id_order = $this->getRequest()->cookies->get('idOrder');
            
            $order_item = $em->getRepository('ShopOrderBundle:Order')
                ->isProductOrder($id_order);
            
            if (null == $order_item) {
                $response = new Response();
                $response->headers->clearCookie('idOrder');
                $response->send();
                
                $order_item = $em->getRepository('ShopOrderBundle:Order')
                    ->findOneBy(array('order_number' => $id_order));
                
                $em->remove($order_item);
                $em->flush();
            }
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
}
?>
