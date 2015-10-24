<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxCategoryShopController extends Controller
{    
    public function manAction()
    {
        $id = $this->getRequest()->query->get('id');
        
        $category = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Category')
                ->findAllCategoryShopId(array('id' => $id, 'floor' => '2'));
        
        $arCategory = array();
        foreach ($category as $key => $value) {
            $arCategory[$key] = array(
                'id' => $value['id'], 
                'name' => mb_convert_case($value['name'], MB_CASE_TITLE, "UTF-8"), 
                'unique_name' => $value['unique_name'],
                'floor' => $value['floor'],
            );
        }
        
        return new JsonResponse($arCategory);
    }
    
    public function womenAction()
    {
        $id = $this->getRequest()->query->get('id');
        
        $category = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Category')
                ->findAllCategoryShopId(array('id' => $id, 'floor' => '1'));
        
        $arCategory = array();
        foreach ($category as $key => $value) {
            $arCategory[$key] = array(
                'id' => $value['id'], 
                'name' => mb_convert_case($value['name'], MB_CASE_TITLE, "UTF-8"), 
                'unique_name' => $value['unique_name'],
                'floor' => $value['floor'],
            );
        }
        
        return new JsonResponse($arCategory);
    }
}
?>
