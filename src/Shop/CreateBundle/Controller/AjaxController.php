<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Form\Type\DeliveryType;
use Shop\CreateBundle\Form\Type\DescriptionType;
use Shop\CreateBundle\Form\Type\UploadLogoType;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Проверка уникального именни для магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View()
     */
    public function uniqueNameAction() 
    {
        $name = $this->get('request')->request->get('name');
        $uniqueName = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(['uniqueName' => $name]);
        
        if ($uniqueName) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @ApiDoc(
     *     description="Загрузка файла лотипа для магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Rest\View()
     */
    public function descriptionAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(new DescriptionType(), $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return true;
        }

        return $form->getErrors();
    }

    /**
     * @ApiDoc(
     *     description="Загрузка файла лотипа для магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Rest\View()
     */
    public function addLogoAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(new UploadLogoType(), $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $shop->preUpload();
            $shop->upload();

            $em->flush();

            $avalancheService = $this->get('imagine.cache.path.resolver');
            $cachedImage = $avalancheService->getBrowserPath($shop->getPath(), 'logo_shop');

            return [
                "path" => $cachedImage
            ];
        }

        return $form->getErrors();
    }

    /**
     * @ApiDoc(
     *     description="Добавление способа доставки",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Rest\View()
     */
    public function addDeliveryAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(new DeliveryType(), $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return true;
        }

        return $form->getErrors();
    }
}