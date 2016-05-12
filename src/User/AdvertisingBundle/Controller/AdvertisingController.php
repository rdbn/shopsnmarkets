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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AdvertisingController extends Controller
{
    /**
     * advertising page
     *
     * @Route("/advertising", name="advertising")
     * @Method({"GET"})
     */
    public function advertisingAction() 
    {
        $id = $this->getUser()->getId();
        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:AdvertisingPlatform')
                ->findByAdvertisingUser($id);
        
        return $this->render('UserAdvertisingBundle:Advertising:advertising.html.twig', array(
            'advertising' => $advertising,
        ));
    }

    /**
     * advertising shop page
     *
     * @Route("/advertising/shop", name="advertising_shop")
     * @Method({"GET"})
     */
    public function shopAction()
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($id);

        $form = $this->createForm(AdvertisingShopType::class, null);

        return $this->render('UserAdvertisingBundle:Form:shop.html.twig', array(
            'form' => $form->createView(),
            'shops' => $shops,
        ));
    }

    /**
     * advertising platform page
     *
     * @Route("/advertising/platform", name="advertising_platform")
     * @Method({"GET"})
     */
    public function platformAction()
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($id);

        $form = $this->createForm(AdvertisingPlatformType::class, new AdvertisingPlatform());

        return $this->render('UserAdvertisingBundle:Form:platform.html.twig', array(
            'form' => $form->createView(),
            'shops' => $shops,
        ));
    }
}