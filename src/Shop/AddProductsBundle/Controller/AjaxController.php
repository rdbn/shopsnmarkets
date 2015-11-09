<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Controller;

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
        $tags = $this->getDoctrine()->getRepository("ShopAddProductsBundle:HashTags")
            ->findAll();

        return $tags;
    }

    /**
     * @ApiDoc(
     *     description="Список тегов",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View()
     */
    public function likeAction()
    {
        $user = $this->getUser();
        if ($user == null) return false;

        $id = $this->get("request")->query->get('id');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ShopAddProductsBundle:Product')
                ->findOneBy(['user' => $user->getId(), 'product' => $id]);
        
        if ($product) return false;

        $em->persist($product->addLikeProduct($user));
        $em->flush();

        return true;
    }
}
?>
