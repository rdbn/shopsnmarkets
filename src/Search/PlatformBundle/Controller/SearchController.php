<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Search\PlatformBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Search\PlatformBundle\Form\Type\SearchType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function searchFormAction()
    {
        $form = $this->createForm(new SearchType(), new Product());
        
        return $this->render('SearchPlatformBundle:Form:searchForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), new Product());
        
        return $this->render('SearchPlatformBundle:Search:product.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function resultAction()
    {
        $request = $this->getRequest()->request->get('Search');
        
        $search = $this->get('searchProduct');
        $search->createForm(new SearchType(), new Product());
        
        $valid = $search->getResult($request);
        if ($valid) {
            return new JsonResponse($valid);
        }
        
        return new JsonResponse('');
    }
}
?>
