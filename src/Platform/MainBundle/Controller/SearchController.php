<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\MainBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Platform\MainBundle\Form\Type\SearchType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function searchFormAction()
    {
        $form = $this->createForm(new SearchType(), new Product());
        
        return $this->render('PlatformMainBundle:Form:searchForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), new Product());
        
        return $this->render('PlatformMainBundle:Search:product.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function resultAction()
    {
        $request = $this->get("request")->request->get('Search');
        
        $search = $this->get('searchProduct');
        $search->createForm(new SearchType(), new Product());
        
        $valid = $search->getResult($request);
        if ($valid) {
            return new JsonResponse($valid);
        }
        
        return new JsonResponse('');
    }
}