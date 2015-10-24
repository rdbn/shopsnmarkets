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
        $userID = $this->getUser();
        
        $shop = $this->get('nameShop');
        
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $user = $shop->isUser($nameShop, $userID);
        }
        
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $manager = $shop->isManager($nameShop, $userID);
        }
        
        return $this->render('ShopMainBundle:Main:index.html.twig', array(
            'nameShop' => $nameShop,
            'preview' => $shop->preview($nameShop),
            'shop' => $shop->value($nameShop),
            'user' => isset($user) ? $user : false,
            'manager' => isset($manager) ? $manager : false,
        ));
    }
}
?>
