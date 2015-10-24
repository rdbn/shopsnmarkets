<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommonController extends Controller
{    
    protected function before() {
        $user = $this->getUser();
        
        if (gettype($user) == 'object') {
            return $this->redirect($this->generateUrl('_main'));
        } else {
            return FALSE;
        }
        
        return $this->render('UserUserBundle:Login:authForm.html.twig', array(
            'user' => $user,
        ));
    }
}
?>
