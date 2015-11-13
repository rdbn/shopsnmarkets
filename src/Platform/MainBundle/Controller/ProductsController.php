<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Controller;

use Shop\OrderBundle\Form\Type\OrderItemType;
use Shop\OrderBundle\Entity\OrderItem;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductsController extends Controller
{
    public function allAction() 
    {
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findByProductPlatform();

        return $this->render('PlatformMainBundle:Page:products.html.twig', array(
            'products' => $products,
        ));
    }
    
    public function productAction($id)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
                ->findOneByProductPlatform($id);

        $images = $this->getDoctrine()->getRepository('ShopProductBundle:ProductImage')
            ->findOneByProduct($id);

        $tags = $this->getDoctrine()->getRepository('ShopProductBundle:HashTags')
            ->findByTags($id);

        $form = $this->createForm(new OrderItemType(), new OrderItem());
        
        return $this->render('PlatformMainBundle:Product:card.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'images' => $images,
            'tags' => $tags,
        ]);
    }
}