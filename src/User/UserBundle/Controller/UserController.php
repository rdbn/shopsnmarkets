<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

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

        if ($this->get('security.authorization_checker')->isGranted("ROLE_MANAGER")) {
            $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findByShopsManager($user->getId());

            return $this->render('UserUserBundle:User:manager.html.twig', array(
                'shops' => $shops,
                'user' => $user,
            ));
        }

        return $this->render('UserUserBundle:User:main.html.twig', array(
            'user' => $user,
        ));
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
            ->findByShopsManager($user);

        return $this->render('UserUserBundle:User:shops.html.twig', array(
            'shops' => $shops
        ));
    }

    /**
     * Page user friends
     *
     * @param int $id
     *
     * @Route("/user/{id}", name="user_friends")
     * @Method({"GET"})
     *
     * @return object
     */
    public function friendsAction($id)
    {
        $userID = $this->getUser()->getId();
        $user = $this->getDoctrine()->getRepository('UserUserBundle:Users')
                ->findOneById($id);
        
        $check = $this->getDoctrine()->getRepository('UserFriendsBundle:Friends')
                ->findOneBy(['friends' => $id, 'users' => $userID]);
        
        return $this->render('UserUserBundle:User:user.html.twig', array(
            'user' => $user,
            'check' => $check,
        ));
    }
}