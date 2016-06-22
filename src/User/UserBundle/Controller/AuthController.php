<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use User\UserBundle\Entity\Users;
use User\UserBundle\Form\Type\RegistrationType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AuthController extends Controller
{
    /**
     * Login user
     *
     * @param Request $request
     *
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     *
     * @return object
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user, [
            'action' => $this->generateUrl('register'),
            'method' => 'POST',
        ]);

        return $this->render('UserUserBundle:Form:login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'login' => true,
        ]);
    }

    /**
     * Register user
     *
     * @param Request $request
     *
     * @Route("/register", name="register")
     * @Method({"GET", "POST"})
     *
     * @return object
    */
    public function registrationAction(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(RegistrationType::class, $user, [
            'action' => $this->generateUrl('register'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository("UserUserBundle:Roles")
                ->findOneBy(["role" => "ROLE_USER"]);

            $user->addRole($role);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('main');
        }
        
        return $this->render('UserUserBundle:Form:registration.html.twig', [
            'form' => $form->createView(),
            'email' => false,
        ]);
    }
}