<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use User\MessagesBundle\Entity\Messages;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AjaxMessageController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Сообщения пользователя",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     * @param int $count
     *
     * @Route("/message/messages/{id}/{count}", name="messages_all", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return array
     */
     public function allAction($id, $count)
     {
         $messages = $this->getDoctrine()->getRepository('UserMessagesBundle:Messages')
             ->findByUsersMessages($id, $count);
            
         return $messages;
    }

    /**
     * @ApiDoc(
     *     description="Обновляем флаг сообщения пользователя",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/message/messages/check/{id}", name="messages_check", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return string
     */
    public function checksAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('UserMessagesBundle:Messages')
            ->findByCheckMessages($id);

        foreach ($messages as $message) {
            /** @var Messages $message */
            $message->setFlags(true);
        }

        $em->flush();

        return "successful";
    }

    /**
     * @ApiDoc(
     *     description="Удалить сообщения пользователя",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Route("/message/messages/remove", name="messages_remove", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return string
     */
    public function removeAction(Request $request)
    {
        $id = $request->request->get("id");

        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('UserMessagesBundle:Messages')
            ->findByCheckMessages($id);

        foreach ($messages as $message) {
            $em->remove($message);
        }

        $em->flush();

        return "successful";
    }
}
