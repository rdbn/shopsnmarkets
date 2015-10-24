<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DialogController extends Controller
{
    public function messageAction($id, $users)
    {        
        $user = $this->getUser();
        
        $path = $this->getDoctrine()->getRepository('UserRegistrationBundle:Users')
                ->findOneById($users)->getPath();
        
        $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Messages')
                ->findByMessages($id);
        
        return $this->render('UserMessagesBundle:Take:message.html.twig', array(
            'messages' => $messages,
            'path' => $path,
            'user' => $user,
            'id' => $id,
        ));
    }
}
?>
