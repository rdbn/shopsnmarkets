<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Controller;

use User\PropertyBundle\Form\Type\UserInformationType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserInformationController extends Controller 
{    
    public function propertyAction() 
    {
        $user = $this->getUser();
        
        return $this->render('UserPropertyBundle:User:property.html.twig',array(
            'user' => $user,
        ));
    }
    
    public function formInformationAction() 
    {        
        $user = $this->getUser();
        $form = $this->createForm(new UserInformationType(), $user);
        
        return $this->render('UserPropertyBundle:Form:userInformationForm.html.twig',array(
            'form' => $form->createView(),
        ));
    }
    
    public function addInformationAction() 
    {
        $request = $this->getRequest()->request->get('UserInformation');
        
        $user = $this->getUser();
        
        $information = $this->get('formUserInformation');
        $information->createForm(new UserInformationType(), $user);
        
        if ($information->add($request)) {
            return new Response('0');
        }
        
        return new JsonResponse($information->getError());
    }
}
?>
