<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\ShopBundle\Controller;

use Shop\AddProductsBundle\Entity\Product;
use Search\ShopBundle\Form\Type\SearchShopType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchShopController extends Controller 
{
    public function searchShopAction($nameShop)
    {
        $form = $this->createForm(new SearchShopType($nameShop), new Product);
        
        return $this->render('SearchShopBundle:Search:searchForm.html.twig', array(
            'form' => $form->createView(),
            'nameShop' => $nameShop,
        ));
    }
    
    public function resultShopAction(Request $request, $nameShop)
    {        
        $search = $this->get('searchShopProduct');
        $form = $search->createForm(new SearchShopType($nameShop), new Product());
        
        $value = $search->getResult($request->request->get('Search'), $nameShop);
        if ($value) {
            return $this->render('SearchShopBundle:Search:result.html.twig', array(
                'form' => $form->createView(),
                'products' => $value,
                'nameShop' => $nameShop,
            ));
        }
        
        return $this->render('SearchShopBundle:Search:result.html.twig', array(
            'form' => $form->createView(),
            'products' => $value,
            'nameShop' => $nameShop,
        ));
    }
}
?>
