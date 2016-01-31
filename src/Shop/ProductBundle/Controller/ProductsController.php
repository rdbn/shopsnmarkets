<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Shop\OrderBundle\Entity\OrderItem;
use Shop\OrderBundle\Form\Type\OrderItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductsController extends Controller
{
    public function tagsProductAction($shopname)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findByProductShop($shopname, 0);
        
        return $this->render('ShopProductBundle:Products:allProducts.html.twig', array(
            'manager' => isset($manager) ? $manager : false,
            'shopname' => $shopname,
            'products' => $product,
        ));
    }
    
    public function productAction($shopname, $id)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findOneByProductId($id);

        $images = $this->getDoctrine()->getRepository('ShopProductBundle:ProductImage')
            ->findByProduct($id);

        $tags = $this->getDoctrine()->getRepository('ShopProductBundle:HashTags')
            ->findByTags($id);

        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findOneByShop($shopname);

        $form = $this->createForm(new OrderItemType(), new OrderItem());
        
        return $this->render('ShopProductBundle:Products:product.html.twig', [
            'form' => $form->createView(),
            'shopname' => $shopname,
            'product' => $product,
            'images' => $images,
            'tags' => $tags,
            'shop' => $shop,
        ]);
    }
}