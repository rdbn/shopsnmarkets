<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Platform\MainBundle\Form\Type\SearchType;

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
     *     description="Пагинация магазинов",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $count
     *
     * @Route("/showShops/{count}", name="show_shops", defaults={"_format": "json"}, requirements={
     *     "count": "\d+"
     * })
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return array
     */
    public function shopsAction($count)
    {
        $result = $this->getDoctrine()->getRepository("ShopCreateBundle:Shops")
            ->findByShops($count);

        return $result;
    }

    /**
     * @ApiDoc(
     *     description="Пагинация товаров",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $count
     *
     * @Route("/showProducts/{count}", name="show_products", defaults={"_format": "json"}, requirements={
     *     "count": "\d+"
     * })
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return array
     */
    public function productsAction($count)
    {
        $result = $this->getDoctrine()->getRepository("ShopProductBundle:Product")
            ->findByProductPlatform($count);

        $avalancheService = $this->get('liip_imagine.cache.manager');
        $result = array_map(function ($data) use ($avalancheService) {
            $data['image'][0]['path'] = $avalancheService->getBrowserPath($data['image'][0]['path'], 'product_image');

            return $data;
        }, $result);

        return $result;
    }

    /**
     * @ApiDoc(
     *     description="Поиск товаров по всем магазинам",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Route("/resultSearch", name="search_platform", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     *
     * @return array
     */
    public function searchAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(SearchType::class, $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            return [];
        }

        return $form->getErrors();
    }
}