<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller 
{
    public function mainShopAction($nameShop)
    {        
        $user = $this->getUser();
        $shop = $this->getDoctrine()->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["unique_name" => $nameShop]);

        
        return $this->render('ShopMainBundle:Main:index.html.twig', [
            'nameShop' => $nameShop,
            'shop' => $shop,
        ]);
    }
}
?>