<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\RegistrationBundle\Controller;

use User\RegistrationBundle\Entity\Users;
use User\RegistrationBundle\Form\Type\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationController extends Controller
{    
    public function registrationAction()
    {       
        $form = $this->createForm(new UserType(), new Users());
        
        return $this->render('UserRegistrationBundle:Form:registration.html.twig', array(
            'email' => true,
            'form' => $form->createView(),
        ));
    }
    
    public function createAction(Request $request)
    {        
        $addInformation = $this->get('register');
        $form = $addInformation->createForm(new UserType(), new Users());
        
        if ($addInformation->addUser($request)) {
            return $this->redirectToRoute('_main');
        }
        
        return $this->render('UserRegistrationBundle:Form:registration.html.twig', array(
            'form' => $form->createView(),
            'email' => $addInformation->isEmail(),
        ));
    }
    
    public function checkEmailAction() 
    {
        $mail = $this->get("request")->request->get('email');
        
        $email = new Email();
        $errors = $this->get('validator')->validateValue($mail, $email);
        
        if (count($errors) == 0) {
            $check = $this->getDoctrine()->getRepository('UserRegistrationBundle:Users')
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
