<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxMessageController extends Controller
{  
     public function allMessageAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'integer')) {
            $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Messages')
                    ->findByMessages($request);
            
            return new JsonResponse($messages);
        } else {
            return new Response('1');
        }
    }
    
    public function basketMessageAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'integer')) {
            $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Messages')
                    ->findByMessagesFlags(array('id' => $request, 'flags' => '2'));
            
            return new JsonResponse($messages);
        } else {
            return new Response('1');
        }
    }
    
    public function checkAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'integer')) {
            $this->get('dialog')->updateMessage($request, '1');
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
    
    public function checkAllAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'array')) {
            foreach ($request as $value) {
                if (settype($value, 'integer')) {
                    $this->get('dialog')->updateMessage($value, '1');
                }
            }
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
    
    public function basketAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'array')) {
            foreach ($request as $value) {
                if (settype($value, 'integer')) {
                    $this->get('dialog')->updateMessage($request, '2');
                }
            }
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
    
    public function deleteAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'array')) {
            foreach ($request as $value) {
                if (settype($value, 'integer')) {
                    $this->get('dialog')->deleteMessage($value, '1');
                }
            }
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
}
?>