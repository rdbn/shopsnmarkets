<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Search\PlatformBundle\Controller;

use Shop\AddProductsBundle\Entity\Product;
use Search\PlatformBundle\Form\Type\SearchMainType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchMainController extends Controller
{ 
    public function searchTopAction()
    {
        $form = $this->createForm(new SearchMainType(), new Product());
        
        return $this->render('SearchPlatformBundle:Form:searchFormTop.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function resultAction(Request $request)
    {        
        $search = $this->get('searchProduct');
        $form = $search->createForm(new SearchMainType(), new Product());
        
        $valid = $search->getResult($request);
        if ($valid) {
            return $this->render('SearchPlatformBundle:Result:product.html.twig', array(
                'form' => $form->createView(),
                'products' => $valid,
            ));
        }
        
        return $this->render('SearchPlatformBundle:Result:product.html.twig', array(
            'form' => $form->createView(),
            'products' => '',
        ));
    }
}
?>
