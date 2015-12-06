<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use User\UserBundle\Form\Type\PasswordType;
use User\UserBundle\Form\Type\UserInformationType;

use User\UserBundle\Form\Type\UploadLogoType;
use User\UserBundle\Form\Type\DescriptionType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserInformationController extends Controller 
{    
    public function propertyAction() 
    {
        $user = $this->getUser();
        
        return $this->render('UserUserBundle:User:property.html.twig',array(
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
        
        return $this->render('UserUserBundle:Form:userInformation.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function formPasswordAction()
    {
        $user = $this->getUser();
        $form = $this->createForm(new PasswordType, $user);

        return $this->render('UserUserBundle:Form:password.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    public function formPreviewAction()
    {
        $user = $this->getUser();
        $formDescription = $this->createForm(new DescriptionType(), $user);
        $formUpload = $this->createForm(new UploadLogoType(), $user);

        return $this->render('UserUserBundle:Form:addInformation.html.twig',array(
            'formUpload' => $formUpload->createView(),
            'formDescription' => $formDescription->createView(),
            'image' => $user->getPath(),
        ));
    }
}