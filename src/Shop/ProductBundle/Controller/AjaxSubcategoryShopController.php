<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxSubcategoryShopController extends Controller
{
    public function accessoriesAction()
    {
        $id = $this->getRequest()->query->get('id');
        
        $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                ->findAllAccessoriesShop($id);
        
        $arSubcategory = array();
        foreach ($subcategory as $key => $value) {
            $arSubcategory[$key] = array(
                'id' => $value['id'], 
                'name' => mb_convert_case($value['name'], MB_CASE_TITLE, "UTF-8"), 
                'unique_name' => $value['unique_name'],
                'floor' => $value['floor'],
            );
        }
        
        return new JsonResponse($arSubcategory);
    }
    
    public function bootsAction()
    {
        $id = $this->getRequest()->query->get('id');
        
        $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                ->findAllBootsShop($id);
        
        $arSubcategory = array();
        foreach ($subcategory as $key => $value) {
            $arSubcategory[$key] = array(
                'id' => $value['id'], 
                'name' => mb_convert_case($value['name'], MB_CASE_TITLE, "UTF-8"), 
                'unique_name' => $value['unique_name'],
                'floor' => $value['floor'],
            );
        }
        
        return new JsonResponse($arSubcategory);
    }
}
?>
