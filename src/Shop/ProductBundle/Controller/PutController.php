<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Shop\ProductBundle\Entity\ProductImage;
use Shop\ProductBundle\Form\Type\ProductType;
use Shop\ProductBundle\Form\Type\ProductImageType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PutController extends Controller
{
    /**
     * Page add product
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Route("/{shopname}/addProducts", name="add_product")
     * @Method({"GET", "POST"})
     *
     * @return mixed
     */
    public function addAction(Request $request, $shopname)
    {
        $redis = $this->get("snc_redis.default");

        $product = new Product();
        $upload = $this->createForm(ProductImageType::class, $product);
        $form = $this->createForm(ProductType::class, $product, [
            'action' => $this->generateUrl('add_product', ['shopname' => $shopname]),
            'method' => 'post',
        ]);
        $form->handleRequest($request);

        $images = json_decode($redis->get("product_image_".$this->getUser()->getId()), 1);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $shop = $em->getRepository("ShopCreateBundle:Shops")
                ->findOneBy(["uniqueName" => $shopname]);

            $product->setShops($shop);

            foreach ($images as $image) {
                $productImage = new ProductImage();
                $productImage->setProduct($product);
                $productImage->setPath($image);

                $product->addImage($productImage);
            }

            $em->persist($product);
            $em->flush();

            $redis->del("product_image_".$this->getUser()->getId());

            return $this->redirectToRoute('main_shop', ['shopname' => $shopname]);
        }

        return $this->render('ShopProductBundle:Form:form.html.twig', [
            'upload' => $upload->createView(),
            'form' => $form->createView(),
            'shopname' => $shopname,
            'images' => $images,
        ]);
    }

    /**
     * Page update product
     *
     * @param Request $request
     * @param string $shopname
     * @param int $id
     *
     * @Route("/{shopname}/addProducts/{id}", name="update_product")
     * @Method({"GET", "POST"})
     *
     * @return mixed
     */
    public function updateAction(Request $request, $shopname, $id)
    {
        $redis = $this->get("snc_redis.default");
        $em = $this->getDoctrine()->getManager();
        /* @var Product $product */
        $product = $em->getRepository("ShopProductBundle:Product")
            ->findOneBy(["id" => $id]);

        $upload = $this->createForm(ProductImageType::class, $product);
        $form = $this->createForm(ProductType::class, $product, [
            'action' => $this->generateUrl('update_product', ['shopname' => $shopname, 'id' => $id]),
            'method' => 'post',
        ]);
        $form->handleRequest($request);

        $images = json_decode($redis->get("product_image_".$this->getUser()->getId()), 1);
        if ($form->isValid()) {
            if (count($images) > 0) {
                foreach ($images as $image) {
                    $productImage = new ProductImage();
                    $productImage->setProduct($product);
                    $productImage->setPath($image);

                    $product->addImage($productImage);
                }

                $redis->del("product_image_".$this->getUser()->getId());
            }

            $em->flush();

            return $this->redirectToRoute('product_platform', ['id' => $id]);
        }

        if (count($images) == 0) {
            $images = $product->getImage()->toArray();
        }

        return $this->render('ShopProductBundle:Form:form.html.twig', [
            'upload' => $upload->createView(),
            'form' => $form->createView(),
            'shopname' => $shopname,
            'images' => $images,
        ]);
    }
}