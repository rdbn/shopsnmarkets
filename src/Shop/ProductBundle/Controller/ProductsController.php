<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductsController extends Controller
{ 
    public function allAction($shopname)
    {
        $products = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findAllProductShop($shopname);
        
        return $this->render('ShopProductBundle:All:products.html.twig', array(
            'shopname' => $shopname,
            'products' => $products,
        ));
    }
    
    public function allProductsCategoryAction($shopname, $idFloor, $idCategory)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $userID = $this->getUser();
            $manager = $this->get('shopname')->isManager($shopname, $userID);
        }
        
        $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findAllProductCategoryShop(array('name' => $shopname, 'category' => $idCategory));
        
        return $this->render('ShopProductBundle:Products:allProducts.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'shopname' => $shopname,
            'products' => $product,
        ));
    }
    
    public function allProductsSubcategoryAction($shopname, $idFloor, $idCategory, $idSubcategory)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $userID = $this->getUser();
            $manager = $this->get('shopname')->isManager($shopname, $userID);
        }
        
        $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findAllProductSubcategoryShop(array('name' => $shopname, 'subcategory' => $idSubcategory));
        
        return $this->render('ShopProductBundle:Products:allProducts.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'shopname' => $shopname,
            'products' => $product,
        ));
    }
    
    public function productAction($shopname, $idFloor, $idCategory, $idSubcategory, $idProduct)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $userID = $this->getUser();
            $manager = $this->get('shopname')->isManager($shopname, $userID);
        }
        
        $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findOneByProductShop($idProduct);
        
        $products = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findByProductSubcategoryShop(array('name' => $shopname, 'subcategory' => $idSubcategory, 'product' => $idProduct));
        
        return $this->render('ShopProductBundle:Products:product.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'shopname' => $shopname,
            'id' => $idProduct,
            'product' => $product,
            'products' => $products,
        ));
    }
}
?>
