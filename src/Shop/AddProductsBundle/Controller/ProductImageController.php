<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Controller;

use Shop\AddProductsBundle\Entity\ProductImage;
use Shop\AddProductsBundle\Form\Type\ProductImageType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductImageController extends Controller
{
    public function formAction($nameShop)
    {
        $form = $this->createForm(new ProductImageType(), new ProductImage());

        return $this->render('ShopAddProductsBundle:Form:formUpload.html.twig', array(
            'form' => $form->createView(),
            'nameShop' => $nameShop,
        ));
    }
    
    public function uploadAction(Request $request, $nameShop)
    {
        $product = $this->get('productImage');
        $product->form(new ProductImageType(), new ProductImage());

        if ($product->upload($request, $nameShop)) {
            return new JsonResponse($product->getValue());
        }

        return new Response('1');
    }
    
    public function imagesAction() 
    {
        if ($this->getRequest()->getSession()->has('image_product')) {
            $image_product = $this->getRequest()->getSession()->get('image_product');
            
            return new JsonResponse($image_product);
        } else {
            return new Response('1');
        }
    }
    
    public function deleteAction() {
        $name = $this->getRequest()->request->get('name');
        
        $arImage = $this->getRequest()->getSession()->get('image_product');
        
        $key = array_search($name, $arImage);
        if ($key !== false) {
            unlink(__DIR__.'/../../../../web'.$arImage);
            unset($arImage[$key]);

            $this->getRequest()->getSession()->set('image_product', $arImage);

            return new Response('0');
        } else {
            return new Response('1');
        }
    }
}
?>
