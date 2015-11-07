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

    public function likeAction()
    {
        $user = $this->getUser();
        $request = $this->get("request")->query->get('id');
        
        if ($user == null) return false;

        $check = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->isLikeProduct(['user' => $user->getId(), 'product' => $request]);
        
        if ($check) return true;
        $this->get('productLike')->addLike($request, $user);

        return true;
    }
}
?>
