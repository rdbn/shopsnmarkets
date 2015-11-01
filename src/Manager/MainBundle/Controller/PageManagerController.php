<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageManagerController extends Controller {
    
    public function managerAction() {
        $user = $this->getUser();
        
        $file = __DIR__.'/../../../../../Symfony/web/public/xml/Users/'.$user->getId().'/preview.xml';
        $preview = NULL;
        if (file_exists($file)) {
            $preview = simplexml_load_file($file);
        }
        
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShopsManager($user->getId());
       
        return $this->render('ManagerMainBundle:Page:manager.html.twig', array(
            'shops' => $shops,
            'user' => $user,
            'preview' => $preview,
        ));
    }

    public function shopsAction()
    {
        $user = $this->getUser();

        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findAllShopsManager($user);

        return $this->render('ManagerMainBundle:Page:shops.html.twig', array(
            'shops' => $shops
        ));
    }
}
?>
