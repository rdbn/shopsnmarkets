<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Controller;

use Shop\OrderBundle\Entity\OrderItem;
use Shop\OrderBundle\Form\Type\OrderItemType;

use Shop\ProductBundle\Entity\Product;
use Platform\MainBundle\Form\Type\SearchType;
use Platform\MainBundle\Form\Type\SearchMainType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findByShops(0);

        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:AdvertisingPlatform')
            ->findByAdvertising(['date' => date("Y-m-d H:i:s"), 'id' => '1']);

        if (null == $advertising)
            $advertising['0']['path'] = '/public/images/slider.png';
        
        return $this->render('PlatformMainBundle:Page:index.html.twig', array(
            'shops' => $shops,
            'advertising' => $advertising,
        ));
    }

    public function shopsAction()
    {
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShops(0);

        return $this->render('PlatformMainBundle:Page:shops.html.twig', array(
            'shops' => $shops,
        ));
    }

    public function productsAction()
    {
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
            ->findByProductPlatform(0);

        return $this->render('PlatformMainBundle:Page:products.html.twig', array(
            'products' => $products,
        ));
    }

    public function productAction($id)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
            ->findOneByProductPlatform($id);

        $images = $this->getDoctrine()->getRepository('ShopProductBundle:ProductImage')
            ->findByProduct($id);

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

    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), new Product());

        return $this->render('PlatformMainBundle:Search:product.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function searchFormAction()
    {
        $form = $this->createForm(new SearchType(), new Product());

        return $this->render('PlatformMainBundle:Form:searchForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function searchTopAction()
    {
        $form = $this->createForm(new SearchMainType(), new Product());

        return $this->render('PlatformMainBundle:Form:searchFormTop.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function newsAction()
    {
        $name = 'Страница новостей';

        return $this->render('PlatformMainBundle:Page:news.html.twig', array(
            'name' => $name,
        ));
    }
}