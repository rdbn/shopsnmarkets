<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PartnersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserPartnersController extends Controller
{
    public function partnersAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('UserPartnersBundle:Partners')
                ->findAllPartners($id);
        
        return $this->render('UserPartnersBundle:Partners:partners.html.twig', array(
            'shops' => $shops,
        ));
    }
    
    public function shopPartnersAction($shopname) {
        $shops = $this->getDoctrine()->getRepository('UserPartnersBundle:Partners')
                ->findAllShopsPartners($shopname);
        
        return $this->render('UserPartnersBundle:Partners:partners.html.twig', array(
            'shops' => $shops,
        ));
    }


    public function myApplicationAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('UserPartnersBundle:Partners')
                ->findAllMyApplication($id);
        
        return $this->render('UserPartnersBundle:Partners:myApplication.html.twig', array(
            'shops' => $shops,
        ));
    }
    
    public function applicationAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('UserPartnersBundle:Partners')
                ->findAllApplication($id);
        
        return $this->render('UserPartnersBundle:Partners:application.html.twig', array(
            'shops' => $shops,
        ));
    }
}
?>
