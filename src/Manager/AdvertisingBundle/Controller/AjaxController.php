<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\AdvertisingBundle\Controller;

use Manager\AdvertisingBundle\Entity\AdvertisingPlatform;
use Manager\AdvertisingBundle\Form\Type\AdvertisingPlatformType;

use Manager\AdvertisingBundle\Entity\AdvertisingShop;
use Manager\AdvertisingBundle\Form\Type\AdvertisingShopType;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Реклама на плаформе",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View()
     */
    public function platformAction() 
    {
        $userID = $this->getUser()->getId();
        $advertising = $this->getDoctrine()->getRepository('ManagerAdvertisingBundle:Advertising')
                ->findByAdvertisingManager(['date' => date("Y-m-d H:i:s"), 'user' => $userID]);
        
        return $advertising;
    }

    /**
     * @ApiDoc(
     *     description="Реклама в магазине",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View()
     */
    public function shopsAction() 
    {
        $userID = $this->getUser()->getId();
        $advertising = $this->getDoctrine()->getRepository('ManagerAdvertisingBundle:Advertising')
            ->findByAdvertisingShop(['user' => $userID, "adFormat" => 1]);
        
        return $advertising;
    }

    /**
     * @ApiDoc(
     *     description="Удаление файлов",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View()
     */
    public function removeAction() {
        $href = $this->get("request")->query->get('href');
        
        return true;
    }

    /**
     * @ApiDoc(
     *     description="Создание рекламы для магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Rest\View()
     */
    public function addShopAction(Request $request)
    {
        $id = $this->getUser()->getId();
        $form = $this->createForm(new AdvertisingShopType($id), null);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $result = [];
            $data = $form->getData();
            foreach ($data->getFiles() as $key => $item) {
                $advertising = new AdvertisingShop();
                $advertising->setShops($data->getShops());
                $advertising->setFormat($data->getFormat());

                $advertising->setFile($item);
                $advertising->preUpload();
                $advertising->upload();

                $result[] = $advertising->getPath();
                $em->persist($advertising);
            }

            $em->flush();

            return $result;
        }

        return $form->getErrors();
    }

    /**
     * @ApiDoc(
     *     description="Создание рекламы на платформе",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Rest\View()
     */
    public function addPlatformAction(Request $request)
    {
        $id = $this->getUser()->getId();
        $advertising = new AdvertisingPlatform();
        $form = $this->createForm(new AdvertisingPlatformType($id), $advertising);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $advertising->preUpload();
            $advertising->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($advertising);
            $em->flush();

            return [
                'shop' => $advertising->getShops()->getShopname(),
                'format' => $advertising->getFormat()->getName(),
                'path' => $advertising->getPath(),
            ];
        }

        return $form->getErrors();
    }
}