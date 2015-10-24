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
        
        if (gettype($user) == 'string') {
            $user = FALSE;
        }
        
        return $this->render('UserUserBundle:Login:profile_menu.html.twig', array(
            'user' => $user,
        ));
    }
    
    public function enterAction()
    {
        return $this->render('UserUserBundle:Login:login_form.html.twig', array());
    }
    
    public function loginAction()
    {        
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
		->add('captcha', 'captcha', array(
                    'auto_initialize' => false,
                    'mapped' => false,
                    'label' => false,
                    'error_bubbling' => true,
                ))
		->getForm();
        
        return $this->render('UserUserBundle:Login:loginForm.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
            'form' => $form->createView(),
        ));
    }
}
?>
