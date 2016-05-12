<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use Shop\OrderBundle\Entity\Order;
use Shop\OrderBundle\Entity\Address;
use Shop\OrderBundle\Form\Type\AddressType;
use Shop\OrderBundle\Form\Type\UsersType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PageController extends Controller
{
    /**
     * Basket
     *
     * @Route("/basket", name="basket")
     * @Method({"GET"})
     *
     * @return mixed
     */
    public function basketAction()
    {
        $user = $this->getUser();
        if (!$user) {
            $response = new Response();
            if (!$response->headers->has("orders"))
                return $this->render('ShopOrderBundle:Page:product.html.twig');

            $orderItem = $this->getDoctrine()->getRepository("ShopOrderBundle:OrderItem")
                ->findByProductsBasket($user->getId());

            $sum = 0;
            foreach ($orderItem as $value) $sum += $value['product']['price'];
        } else {
            $orderItem = $this->getDoctrine()->getRepository("ShopOrderBundle:OrderItem")
                ->findByProductsUsersBasket($user->getId());

            if (count($orderItem) == 0)
                return $this->render('ShopOrderBundle:Page:product.html.twig');

            $sum = 0;
            foreach ($orderItem as $value) $sum += $value['product']['price'];
        }

        return $this->render('ShopOrderBundle:Page:product.html.twig', [
            'orderItems' => $orderItem,
            'count' => count($orderItem),
            'sum' => $sum,
        ]);
    }

    /**
     * Basket add order manager shop
     *
     * @param Request $request
     *
     * @Route("/basket/order", name="basket_order")
     * @Method({"GET", "POST"})
     *
     * @return mixed
     */
    public function orderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        if ($user) {
            $sum = $em->getRepository("ShopOrderBundle:OrderItem")
                ->getValueUsersBasket($user->getId());

            $form = $this->createForm(UsersType::class, $user, [
                'action' => $this->generateUrl('basket_order'),
                'method' => 'post',
            ]);
        } else {
            $address = new Address();

            $sum = $em->getRepository("ShopOrderBundle:OrderItem")
                ->getValueSumBasket($user->getId());

            $form = $this->createForm(AddressType::class, $address, [
                'action' => $this->generateUrl('basket_order'),
                'method' => 'post',
            ]);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("basket_order");
        }

        return $this->render('ShopOrderBundle:Page:delivery.html.twig', [
            'form' => $form->createView(),
            'count' => $sum[0]['count_product'],
            'sum' => $sum[0]['sum_price'],
        ]);
    }
}