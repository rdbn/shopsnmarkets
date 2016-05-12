<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Platform\MainBundle\Form\Type\SearchType;
use Platform\MainBundle\Form\Type\SearchMainType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PageController extends Controller
{
    /**
     * Main page
     *
     * @Route("/", name="main")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findByShops(0);

        $advertising = $this->getDoctrine()->getRepository('UserAdvertisingBundle:AdvertisingPlatform')
            ->findByAdvertising(['date' => date("Y-m-d H:i:s"), 'id' => '1']);

        if (null == $advertising)
            $advertising['0']['path'] = '/public/images/slider.png';
        
        return $this->render('PlatformMainBundle:Page:index.html.twig', [
            'shops' => $shops,
            'advertising' => $advertising,
        ]);
    }

    /**
     * Page shops
     *
     * @Route("/shops", name="shops")
     * @Method({"GET"})
     */
    public function shopsAction()
    {
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByShops(0);

        return $this->render('PlatformMainBundle:Page:shops.html.twig', array(
            'shops' => $shops,
        ));
    }

    /**
     * Page products
     *
     * @Route("/products", name="products")
     * @Method({"GET"})
     */
    public function productsAction()
    {
        $products = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
            ->findByProductPlatform(0);

        return $this->render('PlatformMainBundle:Page:products.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Page product
     *
     * @param int $id
     *
     * @Route("/products/{id}", name="product_platform", requirements={
     *     "id": "\d+"
     * })
     * @Method({"GET"})
     *
     * @return object
     */
    public function productAction($id)
    {
        $product = $this->getDoctrine()->getRepository('ShopProductBundle:Product')
            ->findOneByProductPlatform($id);

        $images = $this->getDoctrine()->getRepository('ShopProductBundle:ProductImage')
            ->findByProduct($id);

        $tags = $this->getDoctrine()->getRepository('ShopProductBundle:HashTags')
            ->findByTags($id);

        return $this->render('PlatformMainBundle:Product:card.html.twig', [
            'product' => $product,
            'images' => $images,
            'tags' => $tags,
        ]);
    }

    /**
     * Page search
     *
     * @Route("/search", name="search")
     * @Method({"GET"})
     */
    public function searchAction()
    {
        $form = $this->createForm(SearchType::class, new Product());

        return $this->render('PlatformMainBundle:Search:product.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Page news
     *
     * @Route("/news", name="news")
     * @Method({"GET"})
     */
    public function newsAction()
    {
        $name = 'Страница новостей';

        return $this->render('PlatformMainBundle:Page:news.html.twig', array(
            'name' => $name,
        ));
    }

    public function searchFormAction()
    {
        $form = $this->createForm(SearchType::class, new Product());

        return $this->render('PlatformMainBundle:Form:searchForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function searchTopAction()
    {
        $form = $this->createForm(SearchMainType::class, new Product());

        return $this->render('PlatformMainBundle:Form:searchFormTop.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}