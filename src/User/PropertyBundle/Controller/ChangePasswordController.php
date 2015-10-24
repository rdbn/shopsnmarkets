<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Controller;

use User\PropertyBundle\Form\Type\PasswordType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChangePasswordController extends Controller 
{    
    public function formPasswordAction() 
    {
        $user = $this->getUser();
        
        $form = $this->createForm(new PasswordType, $user);
        
        return $this->render('UserPropertyBundle:Form:password.html.twig',array(
            'form' => $form->createView(),
        ));
    }
    
    public function changePasswordAction() 
    {
        $request = $this->getRequest()->request->get();
        
        $user = $this->getUser();
        
        $password = $this->get('changePassword');
        $password->createForm(new PasswordType, $user);
        
        if ($password->changePassword($request)) {
            return new Response('0');
        }
        
        return new JsonResponse($password->getError());
    }
}
?>
