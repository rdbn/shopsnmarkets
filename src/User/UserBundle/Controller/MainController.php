<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function managerAction()
    {
        $user = $this->getUser();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($user->getId());

        return $this->render('UserUserBundle:User:manager.html.twig', array(
            'shops' => $shops,
            'user' => $user,
        ));
    }

    public function shopsAction()
    {
        $user = $this->getUser();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShopsManager($user);

        return $this->render('UserUserBundle:User:shops.html.twig', array(
            'shops' => $shops
        ));
    }

    public function userAction()
    {
        $user = $this->getUser();

        return $this->render('UserUserBundle:User:main.html.twig', array(
            'user' => $user,
        ));
    }
    
    public function userFriendsAction($id)
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