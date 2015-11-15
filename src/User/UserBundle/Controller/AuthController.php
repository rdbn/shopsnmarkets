<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use User\UserBundle\Controller\CommonController;
use Symfony\Component\Security\Core\SecurityContext;

class AuthController extends CommonController
{
    public function authFormAction()
    {
        $user = $this->getUser();
        if (gettype($user) == 'string') $user = FALSE;
        
        return $this->render('UserUserBundle:Login:profile_menu.html.twig', array(
            'user' => $user,
        ));
    }
    
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('UserUserBundle:Login:loginForm.html.twig', [
            'login' => true,
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
?>
