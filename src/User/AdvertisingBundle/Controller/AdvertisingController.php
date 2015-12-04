<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\AdvertisingBundle\Controller;

use User\AdvertisingBundle\Entity\AdvertisingPlatform;
use User\AdvertisingBundle\Form\Type\AdvertisingShopType;
use User\AdvertisingBundle\Form\Type\AdvertisingPlatformType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertisingController extends Controller
{
    public function advertisingAction() 
    {
        $id = $this->getUser()->getId();
        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:AdvertisingPlatform')
                ->findByAdvertisingUser($id);
        
        return $this->render('UserAdvertisingBundle:Advertising:advertising.html.twig', array(
            'advertising' => $advertising,
        ));
    }

    public function shopAction()
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($id);

        $form = $this->createForm(new AdvertisingShopType($id), null);

        return $this->render('UserAdvertisingBundle:Form:shop.html.twig', array(
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

        return $this->render('UserAdvertisingBundle:Form:platform.html.twig', array(
            'form' => $form->createView(),
            'shops' => $shops,
        ));
    }
}