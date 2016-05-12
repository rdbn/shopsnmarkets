<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\AdvertisingBundle\Controller;

use User\AdvertisingBundle\Entity\AdvertisingPlatform;
use User\AdvertisingBundle\Form\Type\AdvertisingPlatformType;

use User\AdvertisingBundle\Entity\AdvertisingShop;
use User\AdvertisingBundle\Form\Type\AdvertisingShopType;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/advertising/platform", name="api_advertising_platform", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     */
    public function platformAction() 
    {
        $userID = $this->getUser()->getId();
        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:Advertising')
                ->findByAdvertisingUser(['date' => date("Y-m-d H:i:s"), 'user' => $userID]);
        
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
     * @Route("/advertising/shops", name="api_advertising_shops", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     */
    public function shopsAction() 
    {
        $userID = $this->getUser()->getId();
        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:Advertising')
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
     * @Route("/advertising/remove", name="api_advertising_remove", defaults={"_format": "json"})
     * @Method({"GET"})
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
     * @Route("/advertising/createShop", name="api_create_advertising_platform", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     * @return array
     */
    public function addShopAction(Request $request)
    {
        $form = $this->createForm(AdvertisingShopType::class, null);
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
     *     description="Создание рекламы в магазине",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Route("/advertising/createPlatform", name="api_create_advertising_shop", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     * @return array
     */
    public function addPlatformAction(Request $request)
    {
        $advertising = new AdvertisingPlatform();
        $form = $this->createForm(AdvertisingPlatformType::class, $advertising);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $end = $form->getData()->getDateEnd() + $form->getData()->getDateStart();

            $date_start = new \DateTime();
            $date_start->setTime($form->getData()->getDateStart(), "00", "00");

            if ($end > 24) {
                $date_end = new \DateTime();
                $date_end->modify("+1 day");
                $date_end->setTime(($end - 24), "00", "00");
            } else {
                $date_end = new \DateTime();
                $date_end->setTime($end, "00", "00");
            }

            $advertising->setDateStart($date_start);
            $advertising->setDateEnd($date_end);
            $advertising->preUpload();
            $advertising->upload();

            $em = $this->getDoctrine()->getManager();
            $em->persist($advertising);
            $em->flush();

            return [
                'shop' => $advertising->getShops()->getShopname(),
                'format' => $advertising->getFormat()->getName(),
                'start' => $advertising->getDateStart()->format("Y-m-d H-i-s"),
                'end' => $advertising->getDateEnd()->format("Y-m-d H-i-s"),
                'path' => $advertising->getPath(),
            ];
        }

        return $form->getErrors();
    }
}