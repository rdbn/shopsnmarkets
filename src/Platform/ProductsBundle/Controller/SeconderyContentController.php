<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\ProductsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeconderyContentController extends Controller
{
    public function menuAction($idFloor, $idCategory) 
    {
        if ($idFloor && $idCategory && $idCategory != '9' && $idCategory != '13' && $idCategory != '44' && $idCategory != '45') {
            $category = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Category')
                ->findByFloor($idFloor);
            
            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                    ->findAllSubcategoryPlatform($idCategory);
        }
        
        if ($idCategory == '9' || $idCategory == '44') {
            $idFloor = '4';
            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                    ->findAllBootsPaltform();
        }
        
        if ($idCategory == '13' || $idCategory == '45') {
            $idFloor = '3';
            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                    ->findAllAccessoriesPaltform();
        }
        
        return $this->render('PlatformProductsBundle:SeconderyContent:menu.html.twig', array(
            'floor' => $idFloor,
            'category' => isset($category) ? $category : '',
            'idCategory' => isset($idCategory) ? $idCategory : '',
            'subcategory' => isset($subcategory) ? $subcategory : '',
        ));
    }
}
?>
