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
        
        $file = __DIR__.'/../../../../web/public/xml/Users/'.$user->getId().'/preview.xml';
        $preview = NULL;
        if (file_exists($file)) {
            $preview = simplexml_load_file($file);
        }
        
        return $this->render('UserUserBundle:User:main.html.twig', array(
            'user' => $user,
            'preview' => $preview,
        ));
    }
    
    public function userAction($id) 
    {
        $userID = $this->getUser()->getId();
        
        $user = $this->getDoctrine()->getRepository('UserRegistrationBundle:Users')
                ->findOneById($id);
        
        $check = $this->getDoctrine()->getRepository('UserFriendsBundle:Friends')
                ->checkFriends(array('id' => $id, 'user' => $userID));
        
        $file = __DIR__.'/../../../../web/public/xml/Users/'.$user->getId().'/preview.xml';
        $preview = NULL;
        if (file_exists($file)) {
            $preview = simplexml_load_file($file);
        }
        
        return $this->render('UserUserBundle:User:user.html.twig', array(
            'user' => $user,
            'check' => $check,
            'preview' => $preview,
        ));
    }
}
?>
