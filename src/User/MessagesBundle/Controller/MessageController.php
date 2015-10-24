<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessageController extends Controller
{
    public function allAction()
    {
        $userID = $this->getUser()->getId();
        
        $em = $this->getDoctrine();        
        $take = $em->getRepository('UserMessagesBundle:Dialog');
        $send = $em->getRepository('UserMessagesBundle:Dialog');
        
        return $this->render('UserMessagesBundle:All:message.html.twig', array(
            'take' => $take->findBySend($userID),
            'send' => $send->findByTake($userID),
            'id' => $userID,
        ));
    }
    
    public function inboxAction()
    {
        $userID = $this->getUser()->getId();
        
        $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Dialog')
                ->findBySend($userID);
        
        return $this->render('UserMessagesBundle:All:box.html.twig', array(
            'messages' => $messages,
            'id' => $userID,
        ));
    }
    
    public function outboxAction()
    {
        $userID = $this->getUser()->getId();
        
        $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Dialog')
                ->findByTake($userID);
        
        return $this->render('UserMessagesBundle:All:box.html.twig', array(
            'messages' => $messages,
            'id' => $userID,
        ));
    }
    
    public function deleteAction()
    {
        $userID = $this->getUser()->getId();
        
        $em = $this->getDoctrine();        
        $repository = $em->getRepository('UserMessagesBundle:Dialog');
        
        return $this->render('UserMessagesBundle:All:basket.html.twig', array(
            'take' => $repository->findBySend($userID, '2'),
            'send' => $repository->findByTake($userID, '2'),
            'id' => $userID,
        ));
    }
}
?>
