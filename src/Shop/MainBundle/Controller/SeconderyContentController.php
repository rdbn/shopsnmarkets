<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeconderyContentController extends Controller
{    
    public function shopAction($nameShop, $idFloor, $idCategory) {        
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneByShop($nameShop);
        
        if ($idFloor && $idCategory && $idCategory != '44' && $idCategory != '45' && $idCategory != '9' && $idCategory != '13') {
            $category = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Category')
                    ->findAllCategoryShopName(array('name' => $nameShop, 'floor' => $idFloor));

            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                    ->findAllSubcategoryShop(array('name' => $nameShop, 'category' => $idCategory));
        }
        
        if ($idCategory == '44' || $idCategory == '9' ) {
            $idFloor = '4';
            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                ->findAllBootsShop($nameShop);
        }
        
        if ($idCategory == '45' || $idCategory == '13') {
            $idFloor = '3';
            $subcategory = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Subcategory')
                ->findAllAccessoriesShop($nameShop);
        }
        
        $userID = $this->getUser();
        
        $isUser = $this->get('nameShop')->isUser($nameShop, $userID);
        
        return $this->render('ShopMainBundle:Main:seconderyContent.html.twig', array(
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'nameShop' => $nameShop,
            'category' => isset($category) ? $category : '',
            'subcategory' => isset($subcategory) ? $subcategory : '',
            'user' => $isUser,
            'shop' => $shop,
        ));
    }
}
?>
