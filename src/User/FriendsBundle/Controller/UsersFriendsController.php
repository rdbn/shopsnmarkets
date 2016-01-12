<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersFriendsController extends Controller {
    
    public function friendsAction() 
    {
        $userID = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
                ->findAllFriends($userID);
        
        return $this->render('UserFriendsBundle:Friends:friends.html.twig', array(
            'resualt' => $users,
        ));
    }
    
    public function userFriendsAction($id) 
    {        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
                ->findAllFriends($id);
        
        return $this->render('UserFriendsBundle:Friends:userFriends.html.twig', array(
            'resualt' => $users,
        ));
    }
    
    public function myApplicationFriendsAction() 
    {
        $userID = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
                ->findAllMyApplication($userID);
        
        return $this->render('UserFriendsBundle:Friends:myApplication.html.twig', array(
            'resualt' => $users,
        ));
    }
    
    public function applicationFriendsAction() 
    {
        $userID = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
                ->findAllApplication($userID);
        
        return $this->render('UserFriendsBundle:Friends:application.html.twig', array(
            'resualt' => $users,
        ));
    }
}