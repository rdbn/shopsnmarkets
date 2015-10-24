<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\AddProductsBundle\Controller;

use Shop\AddProductsBundle\Form\Type\ProductType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UpdateProductController extends Controller
{
    public function formAction($nameShop, $id)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $product = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                    ->findOneById($id);
            
            $form = $this->createForm(new ProductType($nameShop), $product);

            return $this->render('ShopAddProductsBundle:Form:formUpdate.html.twig', array(
                'id' => $id,
                'form' => $form->createView(),
                'nameShop' => $nameShop,
            ));
        } else {
            return $this->redirect($this->generateUrl('_mainShop', array('nameShop' => $nameShop)));
        }
    }
    
    public function updateProductAction(Request $request, $nameShop, $id)
    {
        if ($this->get('security.context')->isGranted('ROLE_MANAGER')) {
            $product_model = $this->getDoctrine()->getRepository('ShopAddProductsBundle:Product')
                    ->findOneById($id);
            
            $product = $this->get('updateProduct');
            $form = $product->form(new ProductType($nameShop), $product_model);
            
            if ($product->addProduct($request, $nameShop)) {
                return $this->redirect($this->generateUrl('_formUpdateProduct', array('nameShop' => $nameShop, 'id' => $id)));
            }

            return $this->render('ShopAddProductsBundle:Form:formUpdate.html.twig', array(
                'id' => $id,
                'form' => $form->createView(),
                'nameShop' => $nameShop,
            ));
        } else {
            return $this->redirect($this->generateUrl('_mainShop', array('nameShop' => $nameShop)));
        }
    }
}
?>
