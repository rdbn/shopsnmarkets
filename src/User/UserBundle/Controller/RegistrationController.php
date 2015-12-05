<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\UserBundle\Controller;

use User\UserBundle\Entity\Users;
use User\UserBundle\Form\Type\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationController extends Controller
{    
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
    
    public function checkEmailAction() 
    {
        $mail = $this->get("request")->request->get('email');
        
        $email = new Email();
        $errors = $this->get('validator')->validateValue($mail, $email);
        
        if (count($errors) == 0) {
            $check = $this->getDoctrine()->getRepository('UserUserBundle:Users')
                ->findOneByEmail($mail);
            
            if ($check == NULL) {
                return new Response('0');
            } else {
                return new Response('1');
            }
        } else {
            return new Response('1');
        }
    }
}
?>
