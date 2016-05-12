<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Список тегов",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View(serializerGroups={"tags"})
    */
    public function hashTagsAction()
    {
        $tags = $this->getDoctrine()->getRepository("ShopProductBundle:HashTags")
            ->findAll();

        return $tags;
    }

    /**
     * @ApiDoc(
     *     description="Лайк товара",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Rest\View()
     * @return mixed
     */
    public function likeAction($id)
    {
        $user = $this->getUser();
        if ($user == null) {
            $view = $this->view("Unique name is used.", 403);
            return $this->handleView($view);
        }

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ShopProductBundle:Product')
            ->findOneByIsLike($id, $user->getId());
        
        if ($product) {
            $view = $this->view("This user is like.", 402);
            return $this->handleView($view);
        }

        $product = $em->getRepository('ShopProductBundle:Product')
            ->findOneBy(['id' => $id]);

        $em->persist($product->addLikeProduct($user));
        $em->flush();

        return $em->getRepository("ShopProductBundle:Product")
            ->findOneByCountLike($id);
    }
}