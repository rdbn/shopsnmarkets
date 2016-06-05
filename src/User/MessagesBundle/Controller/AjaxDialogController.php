<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use User\MessagesBundle\Entity\Dialog;
use User\MessagesBundle\Entity\Messages;
use User\MessagesBundle\Form\Type\MessagesType;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AjaxDialogController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Добавить диалог",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     * @param int $id
     *
     * @Route("/message/dialog/add/{id}", name="dialog_add", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     *
     * @return string
     */
    public function addAction(Request $request, $id)
    {
        $messages = new Messages();
        $form = $this->createForm(MessagesType::class, $messages);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');

            $em = $this->getDoctrine()->getManager();
            $to = $em->getRepository('UserUserBundle:Users')
                ->findOneBy(['id' => $id]);

            $message = [
                'from' => 'username_'.$this->getUser()->getId(),
                'to' => 'username_'.$to->getId(),
                'message' => $form->getData()->getText(),
                'date' => $date,
            ];

            $this->get('old_sound_rabbit_mq.message_user_producer')
                ->publish(json_encode($message));

            return "successful";
        }

        return $form->getErrors();
    }

    /**
     * @ApiDoc(
     *     description="Удалить диалог",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/message/dialog/remove/{id}", name="dialog_remove", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return string
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $dialog = $em->getRepository("UserMessagesBundle:Dialog")
            ->findOneBy(["id" => $id]);

        $em->remove($dialog);
        $em->flush();

        return "successful";
    }
}