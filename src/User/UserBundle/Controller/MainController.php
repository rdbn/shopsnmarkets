<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{    
    public function mainAction() 
    {
        $user = $this->getUser();

        return $this->render('UserUserBundle:User:main.html.twig', array(
            'user' => $user,
        ));
    }
    
    public function userAction($id) 
    {
        $userID = $this->getUser()->getId();
        $user = $this->getDoctrine()->getRepository('UserUserBundle:Users')
                ->findOneById($id);
        
        $check = $this->getDoctrine()->getRepository('UserFriendsBundle:Friends')
                ->checkFriends(array('id' => $id, 'user' => $userID));
        
        return $this->render('UserUserBundle:User:user.html.twig', array(
            'user' => $user,
            'check' => $check,
        ));
    }
}