<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\ShopsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopsManagerController extends Controller
{    
    public function allShopsManagerAction()
    {
        $user = $this->getUser();
        
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShopsManager($user);
        
        return $this->render('ManagerShopsBundle:Shops:allShopsManager.html.twig', array(
            'shops' => $shops
        ));
    }
}
?>