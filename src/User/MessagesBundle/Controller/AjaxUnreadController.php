<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxUnreadController extends Controller
{
    public function allAction()
    {
        $userID = $this->getUser()->getId();
        
        $em = $this->getDoctrine();        
        $take = $em->getRepository('UserMessagesBundle:Dialog')
                ->findByTake($userID, '0');
        
        $send = $em->getRepository('UserMessagesBundle:Dialog')
                ->findBySend($userID, '0');
        
        return new JsonResponse(array('take' => $take, 'send' => $send));
    }
    
    
    public function inboxAction()
    {
        $userID = $this->getUser()->getId();
        
        $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Dialog')
                ->findBySend($userID, '0');
        
        return new JsonResponse($messages);
    }
    
    public function outboxAction()
    {
        $userID = $this->getUser()->getId();
        
        $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Dialog')
                ->findByTake($userID, '0');
        
        return new JsonResponse($messages);
    }
}
?>
