<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Shop\InformationBundle\Form\Type\SearchShopType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction($shopname)
    {
        $form = $this->createForm(new SearchShopType(), new Product);
        $shop = $this->getDoctrine()->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["unique_name" => $shopname]);

        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
            ->findByProductShop($shopname);

        return $this->render('ShopInformationBundle:Main:index.html.twig', [
            'form' => $form->createView(),
            'shopname' => $shopname,
            'products' => $products,
            'shop' => $shop,
        ]);
    }
}
?>