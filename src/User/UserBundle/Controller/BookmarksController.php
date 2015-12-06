<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BookmarksController extends Controller
{
    public function bookmarksAction() {
        $id = $this->getUser()->getId();

        $shops = $this->get('bookmarks')->getShops($id);

        return $this->render('UserUserBundle:Bookmarks:bookmarks.html.twig', array(
            'shops' => $shops,
        ));
    }

    public function subscribeAction() {
        $user = $this->getUser();
        
        $id = $this->getRequest()->query->get('id');
        
        if ($user == null) {
            return new Response('1');
        }
        
        if ($this->get('shopSubscribe')->isUsers($user->getId(), $id) != null) {
            return new Response('1');
        }
        
        $this->get('shopSubscribe')->addSubscribe($id, $user);
        
        return new Response('0');
    }
}