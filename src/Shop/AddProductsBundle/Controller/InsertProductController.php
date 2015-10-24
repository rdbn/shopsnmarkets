<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Controller;

use Shop\AddProductsBundle\Entity\Product;
use Shop\AddProductsBundle\Form\Type\ProductType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InsertProductController extends Controller
{
    public function formAction($nameShop)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            if ($this->getRequest()->getSession()->has('image_product')) {
                $image_product = $this->getRequest()->getSession()->get('image_product');
            }
            
            $form = $this->createForm(new ProductType($nameShop), new Product());
            
            return $this->render('ShopAddProductsBundle:Form:form.html.twig', array(
                'image_product' => isset($image_product) ? $image_product : '',
                'form' => $form->createView(),
                'nameShop' => $nameShop,
            ));
        } else {
            return $this->redirect($this->generateUrl('_mainShop', array('nameShop' => $nameShop)));
        }
    }
    
    public function insertProductAction(Request $request, $nameShop)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            if ($this->getRequest()->getSession()->has('image_product')) {
                $image_product = $this->getRequest()->getSession()->get('image_product');
            }
            
            $product = $this->get('addProduct');
            $form = $product->form(new ProductType($nameShop), new Product());
            
            if ($product->add($request)) {
                return $this->redirect($this->generateUrl('_formInsertProduct', array('nameShop' => $nameShop)));
            }

            return $this->render('ShopAddProductsBundle:Form:form.html.twig', array(
                'image_product' => $image_product,
                'form' => $form->createView(),
                'nameShop' => $nameShop,
            ));
        } else {
            return $this->redirect($this->generateUrl('_mainShop', array('nameShop' => $nameShop)));
        }
    }
}
?>
