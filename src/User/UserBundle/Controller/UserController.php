<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use User\UserBundle\Form\Type\UploadLogoType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
    /**
     * Page user
     *
     * @Route("/user", name="user")
     * @Method({"GET"})
     */
    public function userAction()
    {
        $user = $this->getUser();
        $form = $this->createForm(UploadLogoType::class, $user);

        $shops = null;
        if ($this->get('security.authorization_checker')->isGranted("ROLE_MANAGER")) {
            $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findByShopsManager($user->getId());
        }

        return $this->render('UserUserBundle:User:profile.html.twig', [
            'form' => $form->createView(),
            'shops' => $shops,
            'user' => $user,
            'isUser' => true,
        ]);
    }

    /**
     * Page shops
     *
     * @Route("/user/shops", name="user_shops")
     * @Method({"GET"})
     */
    public function shopsAction()
    {
        $user = $this->getUser();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($user->getId());

        return $this->render('UserUserBundle:User:shops.html.twig', array(
            'shops' => $shops,
            'isShops' => true,
        ));
    }
}