<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use Symfony\Component\Validator\Constraints\Email;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxPropertyController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Получаем список гародов по стране",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Rest\View(serializerGroups={"city"})
     */
    public function cityAction($id)
    {
        $city = $this->getDoctrine()->getRepository('UserUserBundle:City')
            ->findByCountry($id);

        return $city;
    }

    /**
     * @ApiDoc(
     *     description="Проверяем своден email или нет",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $mail
     *
     * @Rest\View()
     */
    public function emailAction($mail)
    {
        $email = new Email();
        $errors = $this->get('validator')->validateValue($mail, $email);
        
        if (count($errors) == 0) {
            $check = $this->getDoctrine()->getRepository('UserUserBundle:Users')
                ->findOneByEmail($mail);
            
            if ($check == NULL || $check->getId() == $this->getUser()->getId()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}