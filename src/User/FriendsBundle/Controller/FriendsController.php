<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Controller;

use User\UserBundle\Entity\Users;
use User\FriendsBundle\Form\Type\SearchType;

use User\MessagesBundle\Entity\Messages;
use User\MessagesBundle\Form\Type\MessagesType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class FriendsController extends Controller
{
    /**
     * Page user friends
     *
     * @Route("/firends", name="friends")
     * @Method({"GET"})
     *
     * @return object
     */
    public function friendsAction()
    {
        $id = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserFriendsBundle:Friends')
            ->findByFriends($id, 0);

        $form = $this->createForm(MessagesType::class, new Messages());
        
        return $this->render('UserFriendsBundle:Friends:friends.html.twig', [
            'form' => $form->createView(),
            'isFriends' => true,
            'result' => $users,
        ]);
    }

    /**
     * Page search user friends
     *
     * @Route("/friends/search", name="search_users")
     * @Method({"GET"})
     *
     * @return object
     */
    public function searchAction()
    {
        $search = $this->createForm(SearchType::class, new Users());
        $form = $this->createForm(MessagesType::class, new Messages());

        return $this->render('UserFriendsBundle:Form:search.html.twig', [
            'search' => $search->createView(),
            'form' => $form->createView(),
            'isFriends' => true,
        ]);
    }

    /**
     * Page users friends
     *
     * @param int $id
     *
     * @Route("/friends/user/{id}", name="friends_users")
     * @Method({"GET"})
     *
     * @return object
     */
    public function friendsUsersAction($id)
    {        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
            ->findByUserFriends($id, 0);

        $form = $this->createForm(MessagesType::class, new Messages());
        
        return $this->render('UserFriendsBundle:Friends:userFriends.html.twig', [
            'form' => $form->createView(),
            'isFriends' => true,
            'result' => $users,
        ]);
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
    public function userFriendsAction($id)
    {
        $userID = $this->getUser()->getId();
        $user = $this->getDoctrine()->getRepository('UserUserBundle:Users')
            ->findOneBy(["id" => $id]);

        $check = $this->getDoctrine()->getRepository('UserFriendsBundle:Friends')
            ->findOneBy(['friends' => $id, 'users' => $userID]);

        $form = $this->createForm(MessagesType::class, new Messages());

        return $this->render('UserUserBundle:User:user.html.twig', [
            'form' => $form->createView(),
            'isFriends' => true,
            'check' => $check,
            'user' => $user,
        ]);
    }

    /**
     * Page my application
     *
     * @Route("/firends/myApplication", name="my_application_friends")
     * @Method({"GET"})
     *
     * @return object
     */
    public function myApplicationAction()
    {
        $id = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
            ->findByMyApplication($id, 0);

        $form = $this->createForm(MessagesType::class, new Messages());

        return $this->render('UserFriendsBundle:Friends:myApplication.html.twig', [
            'form' => $form->createView(),
            'isFriends' => true,
            'result' => $users,
        ]);
    }

    /**
     * Page application
     *
     * @Route("/firends/application", name="application_friends")
     * @Method({"GET"})
     *
     * @return object
     */
    public function applicationAction()
    {
        $id = $this->getUser()->getId();
        
        $em = $this->getDoctrine()->getManager();        
        $users = $em->getRepository('UserFriendsBundle:Friends')
            ->findByApplication($id, 0);

        $type = $em->getRepository("UserFriendsBundle:TypeFriends")
            ->findAll();

        $form = $this->createForm(MessagesType::class, new Messages());
        
        return $this->render('UserFriendsBundle:Friends:application.html.twig', [
            'form' => $form->createView(),
            'isFriends' => true,
            'result' => $users,
            'type' => $type,
        ]);
    }
}