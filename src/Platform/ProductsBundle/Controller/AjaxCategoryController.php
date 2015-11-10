<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\ProductsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxCategoryController extends Controller {

    public function manAction() {
        $arCategory = array();
        
        $category = $this->getDoctrine()->getRepository('ShopProductBundle:Category')
                ->findByFloor('2');
        
        foreach ($category as $key => $value) {
            $arCategory[$key] = array(
                'id' => $value->getId(), 
                'name' => mb_convert_case($value->getName(), MB_CASE_TITLE, "UTF-8"), 
                'floor' => '2',
                );
        }
        
        return new JsonResponse($arCategory);
    }
    
    public function womenAction() {        
        $arCategory = array();
        
        $category = $this->getDoctrine()->getRepository('ShopProductBundle:Category')
                ->findByFloor('1');
        
        foreach ($category as $key => $value) {
            $arCategory[$key] = array(
                'id' => $value->getId(), 
                'name' => mb_convert_case($value->getName(), MB_CASE_TITLE, "UTF-8"), 
                'floor' => '1',
                );
        }
        
        return new JsonResponse($arCategory);
    }
    
    public function accessoriesAction() {        
        $subcategory = $this->getDoctrine()->getRepository('ShopProductBundle:Subcategory')
                ->findAllAccessoriesPaltform();
        
        return new JsonResponse($subcategory);
    }
    
    public function bootsAction() {
        $subcategory = $this->getDoctrine()->getRepository('ShopProductBundle:Subcategory')
                ->findAllBootsPaltform();
        
        return new JsonResponse($subcategory);
    }
}
?>
