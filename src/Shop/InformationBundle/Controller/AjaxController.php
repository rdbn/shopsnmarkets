<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Shop\InformationBundle\Entity\Comments;
use Shop\InformationBundle\Form\Type\CommentsType;

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
     *     description="Лайк магазина",
     *     statusCodes={
     *         200="Нормальный ответ",
     *         402="This user is like.",
     *         403="Not authorization user."
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/addLikeShop/{id}", name="add_like_shop", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     * @return mixed
     */
    public function addLikeAction($id)
    {
        $user = $this->getUser();
        if ($user == null) {
            $view = $this->view("Unique name is used.", 403);
            return $this->handleView($view);
        }

        $em = $this->getDoctrine()->getManager();
        $isLike = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneByIsLike($id, $user->getId());

        if ($isLike) {
            $view = $this->view("This user is like.", 402);
            return $this->handleView($view);
        }
        
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["id" => $id]);
        
        $shop->addLikeShop($user);
        $em->flush();
        
        return $em->getRepository("ShopCreateBundle:Shops")
            ->findOneByCountLike($id);
    }

    /**
     * @ApiDoc(
     *     description="Добавляем коментарий",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param string $shopname
     *
     * @Route("/{shopname}/information", name="shops_information", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View(serializerGroups={"shopInformation"})
     * @return mixed
     */
    public function shopAction($shopname)
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(["uniqueName" => $shopname]);

        $avalancheService = $this->get('liip_imagine.cache.manager');
        $cachedImage = $avalancheService->getBrowserPath($shop->getPath(), 'logo_shop');

        $shop->setPath($cachedImage);

        return $shop;
    }

    /**
     * @ApiDoc(
     *     description="Список последних 20 коментариев магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param string $shopname
     * @param int $count
     *
     * @Route("/{shopname}/showProducts/{count}", name="products_shops", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     * @return mixed
     */
    public function showProductsAction($shopname, $count)
    {
        $products = $this->getDoctrine()->getRepository("ShopProductBundle:Product")
            ->findByProductShop($shopname, $count);

        $avalancheService = $this->get('liip_imagine.cache.manager');
        $products = array_map(function ($data) use ($avalancheService) {
            $data['image'][0]['path'] = $avalancheService->getBrowserPath($data['image'][0]['path'], 'product_image');

            return $data;
        }, $products);

        return $products;
    }

    /**
     * @ApiDoc(
     *     description="Список последних 20 коментариев магазина",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     * @param int $count
     *
     * @Route("/shopComments/{id}/{count}", name="comments_shops", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View(serializerGroups={"comments"})
     * @return mixed
     */
    public function commentsAction($id, $count)
    {
        $comments = $this->getDoctrine()->getRepository("ShopInformationBundle:Comments")
            ->findBy(['shops' => $id], ['createdAt' => 'ASC'], 20, $count);

        $avalancheService = $this->get('liip_imagine.cache.manager');
        foreach ($comments as $comment) {
            $users = $comment->getUsers();
            $path = $users->getPath();
            $cachedImage = $avalancheService->getBrowserPath($path, 'mini_avatar');

            if (!preg_match("/(media\/cache)/i", $path)) $users->setPath($cachedImage);
        }

        return $comments;
    }

    /**
     * @ApiDoc(
     *     description="Добавляем коментарий",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Route("/{shopname}/addCommentsShop", name="add_comments_shops", defaults={"_format": "json"})
     * @Method({"POST"})
     *
     * @Rest\View(serializerGroups={"comments"})
     * @return mixed
     */
    public function addCommentsAction(Request $request, $shopname)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(['uniqueName' => $shopname]);

        $comments = new Comments();
        $comments->setUsers($user);
        $comments->setShops($shop);

        $form = $this->createForm(CommentsType::class, $comments);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($comments);
            $em->flush();

            $users = $comments->getUsers();
            $avalancheService = $this->get('liip_imagine.cache.manager');
            $cachedImage = $avalancheService->getBrowserPath($users->getPath(), 'mini_avatar');
            $users->setPath($cachedImage);
            
            return $comments;
        }

        return $form->getErrors();
    }
}