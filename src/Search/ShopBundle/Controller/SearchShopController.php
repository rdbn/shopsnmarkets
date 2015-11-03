<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\ShopBundle\Controller;



use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchShopController extends Controller 
{
    public function resultShopAction(Request $request, $shopname)
    {        
        $search = $this->get('searchShopProduct');
        $form = $search->createForm(new SearchShopType($shopname), new Product());
        
        $value = $search->getResult($request->request->get('Search'), $shopname);
        if ($value) {
            return $this->render('SearchShopBundle:Search:result.html.twig', array(
                'form' => $form->createView(),
                'products' => $value,
                'shopname' => $shopname,
            ));
        }
        
        return $this->render('SearchShopBundle:Search:result.html.twig', array(
            'form' => $form->createView(),
            'products' => $value,
            'shopname' => $shopname,
        ));
    }
}
?>
