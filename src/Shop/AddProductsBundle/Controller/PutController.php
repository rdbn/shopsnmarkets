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

class PutController extends Controller
{
    public function addAction(Request $request, $shopname)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType($shopname), $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $shop = $em->getRepository("ShopCreateBundle:Shops")
                ->findOneBy(["unique_name" => $shopname]);

            $product->setShops($shop);
            $product->upload();

            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('_mainShop', ['shopname' => $shopname]);
        }

        return $this->render('ShopAddProductsBundle:Form:form.html.twig', array(
            'form' => $form->createView(),
            'shopname' => $shopname,
        ));
    }

    public function updateAction(Request $request, $shopname, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("ShopAddProductsBundle:Product")
            ->findOneById($id);

        $form = $this->createForm(new ProductType(), $product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            //return $this->redirectToRoute('_mainShop', ['shopname' => $shopname]);
        }

        return $this->render('ShopAddProductsBundle:Form:form.html.twig', array(
            'form' => $form->createView(),
            'shopname' => $shopname,
        ));
    }
}
?>
