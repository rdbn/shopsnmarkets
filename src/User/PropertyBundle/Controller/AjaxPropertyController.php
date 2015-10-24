<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxPropertyController extends Controller 
{    
    public function cityAction() 
    {
        $country = $this->getRequest()->request->get('country');
        
        if (settype($country, 'integer')) {
            $city = $this->getDoctrine()->getRepository('UserRegistrationBundle:City')
                ->findByCountry($country);
            
            $arValue = array();
            foreach ($city as $index => $name) {
                $arValue[$index] = array('id' => $name->getId(), 'name' => $name->getName());
            }
            
            return new JsonResponse($arValue);
        } else {
            return new Response('');
        }   
    }
    
    public function emailAction()
    {
        $mail = $this->getRequest()->request->get('email');
        
        $email = new Email();
        $errors = $this->get('validator')->validateValue($mail, $email);
        
        if (count($errors) == 0) {
            $check = $this->getDoctrine()->getRepository('UserRegistrationBundle:Users')
                ->findOneByEmail($mail);
            
            if ($check == NULL || $check->getId() == $this->getUser()->getId()) {
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
