<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Platform\MainBundle\Controller;

use User\MessagesBundle\Entity\Messages;
use User\MessagesBundle\Form\Type\MessagesType;

use Shop\ProductBundle\Entity\Product;
use Platform\MainBundle\Form\Type\SearchType;

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
        
        return $this->render('PlatformMainBundle:Page:index.html.twig', [
            'shops' => $shops,
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

        $form = $this->createForm(SearchType::class, new Product());

        return $this->render('PlatformMainBundle:Page:products.html.twig', array(
            'form' => $form->createView(),
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
            ->findBy(["product" => $id]);

        $tags = $this->getDoctrine()->getRepository('ShopProductBundle:HashTags')
            ->findByTags($id);

        $isProductManager = false;
        if ($this->getUser()) {
            if ($product['shopManager'] == $this->getUser()->getId()) $isProductManager = true;
        }

        $form = $this->createForm(MessagesType::class, new Messages());

        return $this->render('PlatformMainBundle:Product:card.html.twig', [
            'isProductManager' => $isProductManager,
            'form' => $form->createView(),
            'product' => $product,
            'images' => $images,
            'tags' => $tags,
        ]);
    }
}