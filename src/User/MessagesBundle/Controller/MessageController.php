<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use User\MessagesBundle\Entity\Messages;
use User\MessagesBundle\Form\Type\MessagesType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MessageController extends Controller
{
    /**
     * Page user messages
     *
     * @Route("/message", name="messages")
     * @Method({"GET"})
     *
     * @return object
     */
    public function dialogAction()
    {
        $id = $this->getUser()->getId();
        $dialogs = $this->getDoctrine()->getRepository('UserMessagesBundle:Dialog')
            ->findByDialog($id, 0);

        return $this->render('UserMessagesBundle:Messages:dialogs.html.twig', [
            'dialogs' => $dialogs,
            'isMessage' => true,
            'id' => $id,
        ]);
    }

    /**
     * Page user dialog
     *
     * @param int $id
     *
     * @Route("/message/dialog/{id}", name="dialog")
     * @Method({"GET"})
     *
     * @return object
     */
    public function messagesAction($id)
    {
        $user = $this->getUser();
        $dialog = $this->getDoctrine()->getRepository('UserMessagesBundle:Dialog')
            ->findOneBy(["id" => $id]);

        $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Messages')
            ->findByUsersMessages($id, 0);

        $form = $this->createForm(MessagesType::class, new Messages());

        return $this->render('UserMessagesBundle:Messages:messages.html.twig', [
            'form' => $form->createView(),
            'path' => $user->getPath(),
            'messages' => $messages,
            'isMessage' => true,
            'dialog' => $dialog,
            'user' => $user,
        ]);
    }
}