<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxProductLikeController extends Controller
{    
    public function addLikeAction()
    {
        $user = $this->getUser();
        
        $request = $this->getRequest()->query->get('id');
        
        if ($user == null) {
            return new Response('1');
        }
        
        $ckeck = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->isLikeProduct(array('user' => $user->getId(), 'product' => $request));
        
        if ($ckeck) {
            return new Response('1');
        }
        
        $this->get('productLike')->addLike($request, $user);
        
        return new Response('0');
    }
}
?>
