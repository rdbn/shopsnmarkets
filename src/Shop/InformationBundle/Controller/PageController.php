<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Shop\InformationBundle\Form\Type\SearchShopType;

use Shop\InformationBundle\Entity\Comments;
use Shop\InformationBundle\Form\Type\CommentsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PageController extends Controller
{
    /**
     * Page create shop
     *
     * @param string $shopname
     *
     * @Route("/{shopname}", name="main_shop")
     * @Method({"GET"})
     *
     * @return mixed
     */
    public function indexAction($shopname)
    {
        $shop = $this->getDoctrine()->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $isShopManager = false;
        if ($shop->getManager()->getId() == $this->getUser()->getId()) {
            $isShopManager = true;
        }

        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
            ->findByProductShop($shopname, 0);

        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:AdvertisingShop')
            ->findByShops($shop->getId());

        $comments = new Comments();
        $comments->setShops($shop);
        $comments->setUsers($this->getUser());
        $comments = $this->createForm(CommentsType::class, $comments, [
            'method' => 'POST',
        ]);

        $search = $this->createForm(SearchShopType::class, new Product);

        return $this->render('ShopInformationBundle:Page:main.html.twig', [
            'comments' => $comments->createView(),
            'search' => $search->createView(),
            'isShopManager' => $isShopManager,
            'advertising' => $advertising,
            'shopname' => $shopname,
            'products' => $products,
            'shop' => $shop,
        ]);
    }
}