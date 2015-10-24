<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxShopLikeController extends Controller 
{
    public function addLikeAction() {
        $user = $this->getUser();
        
        $id = $this->getRequest()->query->get('id');
        
        if ($user == null) {
            return new Response('1');
        }
        
        if ($this->get('shopLike')->isUsers($user->getId(), $id) != null) {
            return new Response('1');
        }
        
        $this->get('shopLike')->addLike($id, $user);
        
        return new Response('0');
    }
}
?>
