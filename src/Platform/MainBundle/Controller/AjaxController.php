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
     * @Rest\View()
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
     * @Rest\View()
     */
    public function productsAction($count)
    {
        $result = $this->getDoctrine()->getRepository("ShopProductBundle:Product")
            ->findByProductPlatform($count);

        $avalancheService = $this->get('imagine.cache.path.resolver');
        $result = array_map(function ($data) use ($avalancheService) {
            $data['path'] = $avalancheService->getBrowserPath($data['path'], 'product_image');

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
     * @Rest\View()
     */
    public function resultAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new SearchType(), $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            return [];
        }
        
        return $form->getErrors();
    }
}