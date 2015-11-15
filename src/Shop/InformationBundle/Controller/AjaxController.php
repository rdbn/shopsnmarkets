<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Лайк магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View(serializerGroups={"tags"})
     */
    public function addLikeAction() {
        $user = $this->getUser();
        $id = $this->get("request")->query->get('id');

        if ($user == null) return false;
        
        if ($this->get('shopLike')->isUsers($user->getId(), $id) != null) {
            return false;
        }
        
        $this->get('shopLike')->addLike($id, $user);
        
        return true;
    }
}
?>
