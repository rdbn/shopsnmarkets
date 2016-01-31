<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\PartnersBundle\Controller;

use Shop\CreateBundle\Entity\Shops;
use Shop\PartnersBundle\Form\Type\SearchType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartnersController extends Controller
{
    public function partnersAction() 
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopPartnersBundle:Partners')
                ->findByPartners($id, 0);
        
        return $this->render('ShopPartnersBundle:Partners:partners.html.twig', [
            'shops' => $shops,
        ]);
    }

    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), new Shops());

        return $this->render('ShopPartnersBundle:Form:search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function shopPartnersAction($shopname)
    {
        $shops = $this->getDoctrine()->getRepository('ShopPartnersBundle:Partners')
                ->findAllShopsPartners($shopname);
        
        return $this->render('ShopPartnersBundle:Partners:partners.html.twig', array(
            'shops' => $shops,
        ));
    }


    public function myApplicationAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('ShopPartnersBundle:Partners')
                ->findAllMyApplication($id);
        
        return $this->render('ShopPartnersBundle:Partners:myApplication.html.twig', array(
            'shops' => $shops,
        ));
    }
    
    public function applicationAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('ShopPartnersBundle:Partners')
                ->findAllApplication($id);
        
        return $this->render('ShopPartnersBundle:Partners:application.html.twig', array(
            'shops' => $shops,
        ));
    }
}