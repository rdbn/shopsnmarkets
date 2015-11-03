<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\ShopBundle\Controller;

use Shop\AddProductsBundle\Entity\Product;
use Search\ShopBundle\Form\Type\SearchShopType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxSearchShopController extends Controller 
{    
    public function searchShopAction($shopname)
    {
        $form = $this->createForm(new SearchShopType($shopname), new Product);
        
        return $this->render('SearchShopBundle:Shop:search.html.twig', array(
            'form' => $form->createView(),
            'shopname' => $shopname,
        ));
    }
    
    public function resultShopAction()
    {
        $request = $this->getRequest()->request->get('Search');
        
        $search = $this->get('searchShopProduct');
        $search->createForm(new SearchShopType($request['shops']), new Product());
        
        $valid = $search->getResult($request);
        if ($valid) {
            return new JsonResponse($valid);
        }
        
        return new JsonResponse('');
    }
}
?>
