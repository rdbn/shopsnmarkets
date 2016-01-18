<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Controller;

use User\UserBundle\Entity\Users;
use User\FriendsBundle\Form\Type\SearchType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FriendsController extends Controller
{
    public function friendsAction()
    {
        $id = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserFriendsBundle:Friends')
            ->findByFriends($id, 0);
        
        return $this->render('UserFriendsBundle:Friends:friends.html.twig', array(
            'result' => $users,
        ));
    }

    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), new Users());

        return $this->render('UserFriendsBundle:Form:search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function userFriendsAction($id) 
    {        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
                ->findByUserFriends($id, 0);
        
        return $this->render('UserFriendsBundle:Friends:userFriends.html.twig', array(
            'result' => $users,
        ));
    }
    
    public function myApplicationAction()
    {
        $id = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
                ->findByMyApplication($id, 0);

        return $this->render('UserFriendsBundle:Friends:myApplication.html.twig', [
            'result' => $users,
        ]);
    }
    
    public function applicationAction()
    {
        $id = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
            ->findByApplication($id, 0);

        $type = $em->getRepository("UserFriendsBundle:TypeFriends")
            ->findAll();
        
        return $this->render('UserFriendsBundle:Friends:application.html.twig', array(
            'result' => $users,
            'type' => $type,
        ));
    }
}