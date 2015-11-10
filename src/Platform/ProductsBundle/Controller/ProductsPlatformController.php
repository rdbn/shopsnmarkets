<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\ProductsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductsPlatformController extends Controller
{
    public function allAction() 
    {
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findAllProductPlatform();

        return $this->render('PlatformProductsBundle:All:products.html.twig', array(
            'products' => $products,
        ));
    }

    public function categoryAction($idFloor, $idCategory)
    {
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findAllProductCategoryPlatform($idCategory);
        
        return $this->render('PlatformProductsBundle:All:products.html.twig', array(
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'products' => $products,
        ));
    }
    
    public function subcategoryAction($idFloor, $idCategory, $idSubcategory)
    {
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findAllProductSubcategoryPlatform($idSubcategory);
        
        return $this->render('PlatformProductsBundle:All:products.html.twig', array(
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'products' => $products,
        ));
    }
    
    public function productAction($idFloor, $idCategory, $idSubcategory, $id)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findOneByProductPlatform($id);
        
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findByProductSubcategoryPlatform(array('id' => $idSubcategory, 'product' => $id));
        
        return $this->render('PlatformProductsBundle:Product:card.html.twig', array(
            'floor' => $idFloor,
            'idCategory' => $idCategory,
            'products' => $products,
            'product' => $product,
        ));
    }
}
?>
