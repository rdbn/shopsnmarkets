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

class AuthController extends Controller
{
    public function authFormAction()
    {
        $user = $this->getUser();

        return $this->render('UserUserBundle:Login:profile_menu.html.twig', array(
            'user' => $user,
        ));
    }

    public function loginAction()
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

    public function registrationAction(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(new UserType(), $user, [
            'action' => $this->generateUrl('_register'),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $hash = $this->get("hash.password");
            $hash->password($user, $user->getPassword());

            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository("UserUserBundle:Roles")
                ->findOneByRole("ROLE_MANAGER");

            $user->addRole($role);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('_main');
        }
        
        return $this->render('UserUserBundle:Form:registration.html.twig', [
            'email' => false,
            'form' => $form->createView(),
        ]);
    }
}