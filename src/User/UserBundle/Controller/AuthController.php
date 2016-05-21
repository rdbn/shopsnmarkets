<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use User\UserBundle\Entity\Users;
use User\UserBundle\Form\Type\UserType;

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

        return $this->render('UserUserBundle:Login:loginForm.html.twig', [
            'login' => true,
            'last_username' => $lastUsername,
            'error'         => $error,
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
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('register'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $hash = $this->get("hash.password");
            $hash->password($user, $user->getPassword());

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