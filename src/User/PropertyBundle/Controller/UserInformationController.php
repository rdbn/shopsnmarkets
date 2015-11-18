<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Controller;

use User\PropertyBundle\Form\Type\PasswordType;
use User\PropertyBundle\Form\Type\UserInformationType;

use Symfony\Component\HttpFoundation\Request;
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
    
    public function formInformationAction(Request $request)
    {        
        $user = $this->getUser();
        $form = $this->createForm(new UserInformationType(), $user, [
            "action" => $this->generateUrl("_formInformation")
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("_property");
        }
        
        return $this->render('UserPropertyBundle:Form:userInformation.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function formPasswordAction()
    {
        $user = $this->getUser();
        $form = $this->createForm(new PasswordType, $user);

        return $this->render('UserPropertyBundle:Form:password.html.twig',array(
            'form' => $form->createView(),
        ));
    }
}
?>
