<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller {

    public function indexAction() {        
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShops();
        
        return $this->render('PlatformMainBundle:Main:index.html.twig', array(
            'shops' => $shops,
        ));
    }
}
?>
