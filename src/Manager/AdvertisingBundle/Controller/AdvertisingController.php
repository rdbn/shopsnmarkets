<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\AdvertisingBundle\Controller;

use Manager\AdvertisingBundle\Entity\AdvertisingPlatform;
use Manager\AdvertisingBundle\Form\Type\AdvertisingShopType;
use Manager\AdvertisingBundle\Form\Type\AdvertisingPlatformType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertisingController extends Controller
{
    public function advertisingAction() 
    {
        $id = $this->getUser()->getId();
        $advertising = [];/*$this->getDoctrine()->getRepository('ManagerAdvertisingBundle:AdvertisingPlatform')
                ->findByAdvertisingManager(['date' => date("Y-m-d H:i:s"), 'user' => $userID]);*/
        
        return $this->render('ManagerAdvertisingBundle:Advertising:advertising.html.twig', array(
            'advertising' => $advertising,
        ));
    }

    public function shopAction()
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($id);

        $form = $this->createForm(new AdvertisingShopType($id), null);

        return $this->render('ManagerAdvertisingBundle:Form:shop.html.twig', array(
            'form' => $form->createView(),
            'shops' => $shops,
        ));
    }

    public function platformAction()
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($id);

        $form = $this->createForm(new AdvertisingPlatformType($id), new AdvertisingPlatform());

        return $this->render('ManagerAdvertisingBundle:Form:platform.html.twig', array(
            'form' => $form->createView(),
            'shops' => $shops,
        ));
    }
}