<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\AddProductsBundle\Entity\Product;
use Search\ShopBundle\Form\Type\SearchShopType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction($shopname)
    {
        $form = $this->createForm(new SearchShopType(), new Product);
        $shop = $this->getDoctrine()->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["unique_name" => $shopname]);

        return $this->render('ShopCreateBundle:Main:index.html.twig', [
            'form' => $form->createView(),
            'shopname' => $shopname,
            'shop' => $shop,
        ]);
    }
}
?>