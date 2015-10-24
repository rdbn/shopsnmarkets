<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductsController extends Controller
{ 
    public function allAction($nameShop) 
    {
        $products = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findAllProductShop($nameShop);
        
        return $this->render('ShopProductBundle:All:products.html.twig', array(
            'nameShop' => $nameShop,
            'products' => $products,
        ));
    }
    
    public function allProductsCategoryAction($nameShop, $idFloor, $idCategory)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $userID = $this->getUser();
            $manager = $this->get('nameShop')->isManager($nameShop, $userID);
        }
        
        $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findAllProductCategoryShop(array('name' => $nameShop, 'category' => $idCategory));
        
        return $this->render('ShopProductBundle:Products:allProducts.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'nameShop' => $nameShop,
            'products' => $product,
        ));
    }
    
    public function allProductsSubcategoryAction($nameShop, $idFloor, $idCategory, $idSubcategory)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $userID = $this->getUser();
            $manager = $this->get('nameShop')->isManager($nameShop, $userID);
        }
        
        $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findAllProductSubcategoryShop(array('name' => $nameShop, 'subcategory' => $idSubcategory));
        
        return $this->render('ShopProductBundle:Products:allProducts.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'nameShop' => $nameShop,
            'products' => $product,
        ));
    }
    
    public function productAction($nameShop, $idFloor, $idCategory, $idSubcategory, $idProduct)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $userID = $this->getUser();
            $manager = $this->get('nameShop')->isManager($nameShop, $userID);
        }
        
        $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findOneByProductShop($idProduct);
        
        $products = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                ->findByProductSubcategoryShop(array('name' => $nameShop, 'subcategory' => $idSubcategory, 'product' => $idProduct));
        
        return $this->render('ShopProductBundle:Products:product.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'nameShop' => $nameShop,
            'id' => $idProduct,
            'product' => $product,
            'products' => $products,
        ));
    }
}
?>
