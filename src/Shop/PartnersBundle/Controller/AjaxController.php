<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\PartnersBundle\Controller;

use Shop\CreateBundle\Entity\Shops;
use Shop\PartnersBundle\Entity\Partners;
use Shop\PartnersBundle\Form\Type\SearchType;

use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;

class AjaxController extends FOSRestController
{
    /**
     * @ApiDoc(
     *     description="Список магазинов менеджера",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @Rest\View(serializerGroups={"list"})
     */
    public function listAction()
    {
        $id = $this->getUser()->getId();
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findByManager($id);

        return $shops;
    }

    /**
     * @ApiDoc(
     *     description="Добавить в партнеры",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $shop
     * @param int $partner
     *
     * @Rest\View()
     */
    public function addAction($shop, $partner)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository('ShopCreateBundle:Shops')
            ->findOneById($shop);

        $partner = $em->getRepository('ShopCreateBundle:Shops')
            ->findOneById($partner);

        $partners = new Partners();
        $partners->setPartners($partner);
        $partners->setShops($shop);

        $em->persist($partners);
        $em->flush();
        
        return "successful";
    }

    /**
     * @ApiDoc(
     *     description="Подтвердить партнерство",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $shop
     * @param int $partner
     *
     * @Rest\View()
     */
    public function checkAction($shop, $partner)
    {
        $em = $this->getDoctrine()->getManager();
        $shopPartners = $em->getRepository("ShopPartnersBundle:Partners")
            ->findOneBy(["shops" => $shop, "partners" => $partner]);

        $shopPartners->setCheckPartners(true);

        $shop = $em->getRepository('ShopCreateBundle:Shops')
            ->findOneById($shop);

        $partner = $em->getRepository('ShopCreateBundle:Shops')
            ->findOneById($partner);

        $add = new Partners();
        $add->setShops($shop);
        $add->setPartners($partner);
        $add->setCheckPartners(true);

        $em->persist($add);
        $em->flush();

        return "successful";
    }

    /**
     * @ApiDoc(
     *     description="Удалить партнера",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $shop
     * @param int $partner
     *
     * @Rest\View()
     */
    public function removeAction($shop, $partner)
    {
        $em = $this->getDoctrine()->getManager();
        $partnerShop = $em->getRepository("ShopPartnersBundle:Partners")
            ->findOneBy(["partners" => $partner, "shops" => $shop]);

        $shopPartners = $em->getRepository("ShopPartnersBundle:Partners")
            ->findOneBy(["partners" => $shop, "shops" => $partner]);

        $em->remove($partnerShop);
        $em->remove($shopPartners);

        $em->flush();
        
        return "successful";
    }

    /**
     * @ApiDoc(
     *     description="Результаты поиска",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param Request $request
     *
     * @Rest\View()
     */
    public function resultAction(Request $request)
    {
        $userId = $this->getUser()->getId();

        $shop = new Shops();
        $form = $this->createForm(new SearchType(), $shop);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $search = $this->get("search.partners");
            $result = $search
                ->setKeywords($shop->getShopTags())
                ->setCityId($shop->getCity())
                ->setUserId($userId)
                ->getResult();

            return $result;
        }

        return $form->getErrors();
    }
}