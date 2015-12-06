<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\UserBundle\Controller;

use User\UserBundle\Form\Type\DescriptionType;
use User\UserBundle\Form\Type\UploadLogoType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
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
    public function checkEmailAction()
    {
        $mail = $this->get("request")->request->get('email');

        $email = new Email();
        $errors = $this->get('validator')->validateValue($mail, $email);

        if (count($errors) == 0) {
            $check = $this->getDoctrine()->getRepository('UserUserBundle:Users')
                ->findOneByEmail($mail);

            if ($check == NULL) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @ApiDoc(
     *     description="Загружаем аватар пользользователя",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Rest\View()
     */
    public function descriptionAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new DescriptionType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return true;
        }

        return $form->getErrors();
    }

    /**
     * @ApiDoc(
     *     description="Загружаем аватар пользользователя",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Rest\View()
     */
    public function uploadAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(new UploadLogoType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->preUpload();
            $user->upload();

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $avalancheService = $this->get('imagine.cache.path.resolver');
            $cachedImage = $avalancheService->getBrowserPath($user->getPath(), 'avatar');

            return [
                "path" => $cachedImage
            ];
        }

        return $form->getErrors();
    }
}