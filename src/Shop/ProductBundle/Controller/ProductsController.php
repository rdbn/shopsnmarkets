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
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findAllProductShop($shopname);
        
        return $this->render('ShopProductBundle:All:products.html.twig', array(
            'shopname' => $shopname,
            'products' => $products,
        ));
    }
    
    public function allProductsCategoryAction($shopname, $idFloor, $idCategory)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
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
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findAllProductSubcategoryShop(array('name' => $shopname, 'subcategory' => $idSubcategory));
        
        return $this->render('ShopProductBundle:Products:allProducts.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'shopname' => $shopname,
            'products' => $product,
        ));
    }
    
    public function productAction($shopname, $idProduct)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findOneByProductShop($idProduct);
        
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findByProductSubcategoryShop(array('name' => $shopname, 'product' => $idProduct));
        
        return $this->render('ShopProductBundle:Products:product.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'shopname' => $shopname,
            'id' => $idProduct,
            'product' => $product,
            'products' => $products,
        ));
    }
}
?>
