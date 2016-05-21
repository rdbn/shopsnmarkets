<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use Shop\OrderBundle\Entity\Order;
use Shop\OrderBundle\Entity\OrderItem;
use Shop\ProductBundle\Entity\Product;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
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
     *     description="Доавить заказ в базу",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/addOrder/{id}", name="add_order", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     * @return mixed
     */
    public function addOrderAction($id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        /** @var Product $product */
        $product = $em->getRepository('ShopProductBundle:Product')
            ->findOneById($id);

        $order = $em->getRepository("ShopOrderBundle:Order")
            ->findOneBy(['users' => $user->getId(), 'shops' => $product->getShops()->getId(), 'checkPay' => false]);

        if ($order) {
            /** @var OrderItem $orderItem */
            $orderItem = $em->getRepository("ShopOrderBundle:OrderItem")
                ->findOneBy(['order' => $order->getId(), 'product' => $id]);

            if ($orderItem) {
                $orderItem->setNumber($orderItem->getNumber() + 1);
                $em->flush();

                return "successful";
            }
        } else {
            $order = new Order();
            $order->setUsers($user);
            $order->setShops($product->getShops());
        }

        $orderItem = new OrderItem();
        $orderItem->setNumber(1);
        $orderItem->setProduct($product);
        $orderItem->setOrder($order);

        $order->addOrderItem($orderItem);

        $em->persist($order);
        $em->flush();

        if (!$this->getUser()) {
            $orders = [];
            $id = $orderItem->getId();
            $response = new Response();
            if ($response->headers->has("orders")) {
                $orders = json_decode($response->headers->getCookies());
                if (!isset($orders[$id])) {
                    $orders[$id] = 0;
                } else {
                    $orders[$id] = $orders[$id] + 1;
                }
            } else {
                $orders[$id] = 0;
            }

            $response->headers->setCookie(new Cookie('orders', json_encode($orders), time() + 3600));
            $response->prepare($this->get("request"));
            $response->send();

            return $response->send();
        }

        return "successful";
    }

    /**
     * @ApiDoc(
     *     description="Удаляем заказ из базы",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     * @param int $isUp
     *
     * @Route("/updateNumberOrder/{id}/{isUp}", name="update_number_order", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     * @return mixed
     */
    public function updateNumberAction($id, $isUp)
    {
        $em = $this->getDoctrine()->getManager();
        $orderItem = $em->getRepository("ShopOrderBundle:OrderItem")
            ->findOneBy(['id' => $id]);

        $number = $orderItem->getNumber();
        if ($isUp) {
            $orderItem->setNumber($number + 1);
        } else if ($orderItem->getNumber() != 1) {
            $orderItem->setNumber($number - 1);
        }

        $em->flush();

        return [
            'number' => $orderItem->getNumber(),
        ];
    }

    /**
     * @ApiDoc(
     *     description="Удаляем заказ из базы",
     *     statusCodes={
     *         200="Нормальный ответ"
     *     }
     * )
     *
     * @param int $id
     *
     * @Route("/removeOrder/{id}", name="remove_order", defaults={"_format": "json"})
     * @Method({"GET"})
     *
     * @Rest\View()
     * @return mixed
     */
    public function removeOrderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $orderItem = $em->getRepository("ShopOrderBundle:OrderItem")
            ->findOneBy(['id' => $id]);

        $orderItems = $em->getRepository("ShopOrderBundle:OrderItem")
            ->findBy(['order' => $orderItem->getOrder()->getId()]);

        if (count($orderItems) == 1) {
            $em->remove($orderItems[0]->getOrder());
            $em->remove($orderItems[0]);
        } else {
            $em->remove($orderItem);
        }

        $em->flush();

        return "successful";
    }
}