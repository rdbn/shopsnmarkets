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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PropertyController extends Controller
{
    /**
     * Page User Information
     *
     * @Route("/property", name="property")
     * @Method({"GET"})
    */
    public function propertyAction() 
    {
        $user = $this->getUser();
        
        return $this->render('UserUserBundle:User:property.html.twig',array(
            'user' => $user,
        ));
    }

    /**
     * Page from User Information
     *
     * @param Request $request
     *
     * @Route("/property/information", name="property_information")
     * @Method({"GET", "POST"})
     *
     * @return object
     */
    public function formInformationAction(Request $request)
    {        
        $user = $this->getUser();
        $form = $this->createForm(UserInformationType::class, $user, [
            "action" => $this->generateUrl("property_information")
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("property");
        }
        
        return $this->render('UserUserBundle:Form:userInformation.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Page From User Password
     *
     * @Route("/property/password", name="property_password")
     * @Method({"GET"})
     *
     * @return object
     */
    public function formPasswordAction()
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordType::class, $user);

        return $this->render('UserUserBundle:Form:password.html.twig',array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Page From Preview User
     *
     * @Route("/property/previewInformation", name="property_preview_information")
     * @Method({"GET"})
     *
     * @return object
     */
    public function formPreviewAction()
    {
        $user = $this->getUser();
        $formDescription = $this->createForm(DescriptionType::class, $user);
        $formUpload = $this->createForm(UploadLogoType::class, $user);

        return $this->render('UserUserBundle:Form:addInformation.html.twig',array(
            'formUpload' => $formUpload->createView(),
            'formDescription' => $formDescription->createView(),
            'image' => $user->getPath(),
        ));
    }
}