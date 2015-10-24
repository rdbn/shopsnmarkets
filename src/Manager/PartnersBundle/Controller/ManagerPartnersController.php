<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ManagerPartnersController extends Controller {
    
    public function partnersAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('ManagerPartnersBundle:Partners')
                ->findAllPartners($id);
        
        return $this->render('ManagerPartnersBundle:Partners:partners.html.twig', array(
            'shops' => $shops,
        ));
    }
    
    public function shopPartnersAction($nameShop) {
        $shops = $this->getDoctrine()->getRepository('ManagerPartnersBundle:Partners')
                ->findAllShopsPartners($nameShop);
        
        return $this->render('ManagerPartnersBundle:Partners:partners.html.twig', array(
            'shops' => $shops,
        ));
    }


    public function myApplicationAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('ManagerPartnersBundle:Partners')
                ->findAllMyApplication($id);
        
        return $this->render('ManagerPartnersBundle:Partners:myApplication.html.twig', array(
            'shops' => $shops,
        ));
    }
    
    public function applicationAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('ManagerPartnersBundle:Partners')
                ->findAllApplication($id);
        
        return $this->render('ManagerPartnersBundle:Partners:application.html.twig', array(
            'shops' => $shops,
        ));
    }
}
?>
