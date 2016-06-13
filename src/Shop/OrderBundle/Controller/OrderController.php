<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use User\MessagesBundle\Entity\Messages;
use User\MessagesBundle\Form\Type\MessagesType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class OrderController extends Controller
{
    /**
     * Basket add order manager shop
     *
     * @Route("/order/users", name="user_order")
     * @Method({"GET"})
     *
     * @return mixed
     */
    public function usersAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository("ShopOrderBundle:Order")
            ->findByUsersOrder($user->getId());

        $form = $this->createForm(MessagesType::class, new Messages());
        
        return $this->render('ShopOrderBundle:Order:users.html.twig', [
            'form' => $form->createView(),
            'orders' => $orders,
            'isOrder' => true,
        ]);
    }

    /**
     * Basket add order manager shop
     *
     * @Route("/order/manager", name="manager_order")
     * @Method({"GET"})
     *
     * @return mixed
     */
    public function managerAction()
    {
        $user = $this->getUser();
        $orders = $this->getDoctrine()->getRepository("ShopOrderBundle:Order")
            ->findByManagerOrder($user->getId());

        $form = $this->createForm(MessagesType::class, new Messages());

        return $this->render('ShopOrderBundle:Order:manager.html.twig', [
            'form' => $form->createView(),
            'orders' => $orders,
            'isOrder' => true,
        ]);
    }
}
