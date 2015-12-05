<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use User\MessagesBundle\Entity\Messages;
use User\MessagesBundle\Form\Type\MessagesType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CreateDialogController extends Controller
{   
    public function formAction($id)
    {
        $user = $this->getUser();
        
        $userID = $this->getDoctrine()->getRepository('UserUserBundle:Users')
                ->findOneById($id);
        
        $form = $this->createForm(new MessagesType($userID->getId(), $user->getId()), new Messages());
        
        return $this->render('UserMessagesBundle:Send:message.html.twig', array(
            'form' => $form->createView(),
            'user' => $userID,
        ));
    }
    
    public function addAction()
    {
        $request = $this->getRequest()->request->get('Message');
        
        if (!settype($request['dialog']['take'], 'integer') && !settype($request['dialog']['send'], 'integer')) {
            return new Response('1');
        }
        
        $message = $this->get('sendMessage');
        $message->createForm(new MessagesType($request['dialog']['take'], $request['dialog']['send']), new Messages());
        
        if ($message->add($request)) {
            return new Response('0');
        }
        
        return new Response('1');
    }
}
?>
