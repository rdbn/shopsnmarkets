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
     * Page from User Information
     *
     * @param Request $request
     *
     * @Route("/property/information", name="property")
     * @Method({"GET", "POST"})
     *
     * @return object
     */
    public function formInformationAction(Request $request)
    {        
        $user = $this->getUser();
        $form = $this->createForm(UserInformationType::class, $user, [
            "action" => $this->generateUrl("property")
        ]);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("property");
        }
        
        return $this->render('UserUserBundle:Form:userInformation.html.twig', array(
            'form' => $form->createView(),
            'isProperty' => true,
        ));
    }

    /**
     * Page From User Password
     *
     * @param Request $request
     *
     * @Route("/property/password", name="property_password")
     * @Method({"GET"})
     *
     * @return object
     */
    public function formPasswordAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->redirectToRoute("property");
        }

        return $this->render('UserUserBundle:Form:password.html.twig',array(
            'form' => $form->createView(),
            'isProperty' => true,
        ));
    }
}