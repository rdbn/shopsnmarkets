<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\ProductBundle\Controller;

use Shop\ProductBundle\Entity\Product;
use Shop\ProductBundle\Entity\ProductImage;
use Shop\ProductBundle\Form\Type\ProductImageType;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Список тегов",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Route("/hashTags", name="hash_tags", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View(serializerGroups={"tags"})
    */
    public function hashTagsAction()
    {
        $tags = $this->getDoctrine()->getRepository("ShopProductBundle:HashTags")
            ->findAll();

        return $tags;
    }

    /**
     * @ApiDoc(
     *     description="Лайк товара",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/addLikeProduct/{id}", name="add_like_product", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     * @return mixed
     */
    public function likeAction($id)
    {
        $user = $this->getUser();
        if ($user == null) {
            $view = $this->view("Unique name is used.", 403);
            return $this->handleView($view);
        }

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('ShopProductBundle:Product')
            ->findOneByIsLike($id, $user->getId());
        
        if ($product) {
            $view = $this->view("This user is like.", 402);
            return $this->handleView($view);
        }

        $product = $em->getRepository('ShopProductBundle:Product')
            ->findOneBy(['id' => $id]);

        $em->persist($product->addLikeProduct($user));
        $em->flush();

        return $em->getRepository("ShopProductBundle:Product")
            ->findOneByCountLike($id);
    }

    /**
     * @ApiDoc(
     *     description="Добавляем картинки товара",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Route("/addImageProduct", name="add_image_product", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View(serializerGroups={"tags"})
     *
     * @return mixed
     */
    public function addImageAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductImageType::class, $product);
        $form->handleRequest($request);

        $redis = $this->get("snc_redis.default");
        $images = json_decode($redis->get("product_image_".$this->getUser()->getId()));
        if ($form->isValid()) {
            $product->upload();

            $result = array_map(function (ProductImage $data) {
                return $data->getPath();
            }, $product->getImage()->toArray());

            if (count($images) == 0) {
                $redis->set("product_image_" . $this->getUser()->getId(), json_encode($result));
            } else {
                $result = array_merge($images, $result);
                $redis->set("product_image_" . $this->getUser()->getId(), json_encode(array_splice($result, 0, 4)));
            }

            $avalancheService = $this->get('liip_imagine.cache.manager');
            $result = array_map(function (ProductImage $data) use ($avalancheService) {
                return $avalancheService->getBrowserPath($data->getPath(), 'upload_product_image');
            }, $product->getImage()->toArray());

            return [
                'images' => $result
            ];
        }

        return $form->getErrors();
    }

    /**
     * @ApiDoc(
     *     description="Удаляем картинку из базы или кеша",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Route("/removeProductImage", name="remove_product_image", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View()
     *
     * @return string
     */
    public function removeImageAction(Request $request)
    {
        $value = $request->request->get("image");

        if (is_numeric($value)) {
            $em = $this->getDoctrine()->getManager();
            $productImage = $em->getRepository("ShopProductBundle:ProductImage")
                ->findOneBy(['id' => $value]);

            $em->remove($productImage);
            $em->flush();
        } else {
            $redis = $this->get("snc_redis.default");
            $result = json_decode($redis->get("product_image_" . $this->getUser()->getId()), 1);

            $key = array_search($value, $result);
            if ($key !== false) {
                unlink($result[$key]);
                unset($result[$key]);
                $redis->set("product_image_" . $this->getUser()->getId(), json_encode($result));
            }
        }

        return "successful";
    }
}