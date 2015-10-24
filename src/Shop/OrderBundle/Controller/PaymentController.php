<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\OrderBundle\Controller;

use Shop\OrderBundle\Entity\Order;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\Payment\CoreBundle\Entity\Payment;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /** @DI\Inject("payment.plugin_controller") */
    private $ppc;

    public function detailsAction(Request $request, $orderNumber)
    {
        $order = new Order('1200', $orderNumber);
        
        $form = $this->getFormFactory()->create('jms_choose_payment_method', null, array(
            'amount'   => $order->getAmount(),
            'currency' => 'RUB',
            'default_method' => 'payment_paypal', // Optional
            'predefined_data' => array(
                'paypal_express_checkout' => array(
                    'return_url' => $this->get('router')->generate('_payment_complete', array(
                        'orderNumber' => $order->getOrderNumber(),
                    ), true),
                    'cancel_url' => $this->get('router')->generate('_payment_cancel', array(
                        'orderNumber' => $order->getOrderNumber(),
                    ), true)
                ),
            ),
        ));

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->ppc->createPaymentInstruction($instruction = $form->getData());

                $order->setPaymentInstruction($instruction);
                $this->em->persist($order);
                $this->em->flush($order);

                return new RedirectResponse($this->get('router')->generate('_payment_complete', array(
                    'orderNumber' => $order->getOrderNumber(),
                )));
            }
        }

        return $this->render('ShopOrderBundle:Payment:details.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function completeAction(Order $order)
    {
        $instruction = $order->getPaymentInstruction();
        if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
            $payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
        } else {
            $payment = $pendingTransaction->getPayment();
        }

        $result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
        if (Result::STATUS_PENDING === $result->getStatus()) {
            $ex = $result->getPluginException();

            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();

                if ($action instanceof VisitUrl) {
                    return new RedirectResponse($action->getUrl());
                }

                throw $ex;
            }
        } else if (Result::STATUS_SUCCESS !== $result->getStatus()) {
            throw new \RuntimeException('Transaction was not successful: '.$result->getReasonCode());
        }

        // payment was successful, do something interesting with the order
    }

    /** @DI\LookupMethod("form.factory") */
    protected function getFormFactory() {
        return $this->get('form.factory');
    }
}