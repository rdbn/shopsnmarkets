<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Form\Type\DeliveryType;
use Shop\CreateBundle\Form\Type\DescriptionType;
use Shop\CreateBundle\Form\Type\UploadLogoType;

use Doctrine\Common\Collections\ArrayCollection;
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
     *     description="Проверка уникального именни для магазина",
     *     statusCodes={
     *         200="Нормальный ответ",
     *         403="Unique name is used"
     *     }
     * )
     *
     * @param string $shopname
     *
     * @Route("/user/shop/uniqueName/{shopname}", name="unique_name", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return mixed
     */
    public function uniqueNameAction($shopname)
    {
        $uniqueName = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(['uniqueName' => $shopname]);

        if (!$uniqueName) {
            return "successful";
        } else {
            $view = $this->view("Unique name is used", 403);
            return $this->handleView($view);
        }
    }

    /**
     * @ApiDoc(
     *     description="Описание для магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Route("/user/shop/addDescription/{shopname}", name="add_description", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     *
     * @return mixed
     */
    public function addDescriptionAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(DescriptionType::class, $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            return "successful";
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
     * @Route("/user/shop/addLogo/{shopname}", name="add_logo", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     *
     * @return mixed
     */
    public function addLogoAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(UploadLogoType::class, $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $shop->preUpload();
            $shop->upload();

            $em->flush();

            $avalancheService = $this->get('liip_imagine.cache.manager');
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
     * @Route("/user/shop/addDelivery/{shopname}", name="add_delivery", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     *
     * @return mixed
     */
    public function addDeliveryAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $originalShopsDelivery = new ArrayCollection();
        foreach ($shop->getShopsDelivery() as $shopsDelivery) {
            $originalShopsDelivery->add($shopsDelivery);
        }
        
        $form = $this->createForm(DeliveryType::class, $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($originalShopsDelivery as $shopsDelivery) {
                if (false === $shop->getShopsDelivery()->contains($shopsDelivery)) {
                    $shopsDelivery->setShops(null);
                    $em->persist($shopsDelivery);
                }
            }

            $em->persist($shop);
            $em->flush();

            return "successful";
        }

        return $form->getErrors();
    }
}