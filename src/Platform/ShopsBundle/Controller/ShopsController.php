<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\ShopsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopsController extends Controller
{
    public function shopsPlatformAction()
    {
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShops();
        
        return $this->render('PlatformShopsBundle:Shops:allShops.html.twig', array(
            'shops' => $shops,
        ));
    }
}

