<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Entity\Delivery;
use Shop\CreateBundle\Entity\Shops;

use Shop\CreateBundle\Form\Type\ShopsType;
use Shop\CreateBundle\Form\Type\DescriptionType;
use Shop\CreateBundle\Form\Type\UploadLogoType;
use Shop\CreateBundle\Form\Type\DeliveryType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PutController extends Controller
{
    /**
     * Page create shop
     *
     * @param Request $request
     *
     * @Route("/user/shop/create", name="create_shop")
     * @Method({"GET", "POST"})
     *
     * @return object
     */
    public function addAction(Request $request)
    {
        $user = $this->getUser();
        $shops = new Shops();
        $form = $this->createForm(ShopsType::class, $shops, [
            'action' => $this->generateUrl('create_shop'),
            'method' => 'POST',
        ]);
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $isName = $em->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(['uniqueName' => $shops->getUniqueName()]);

            if (!$isName) {
                $shops->setManager($user);

                $em->persist($shops);
                $em->flush();

                return $this->redirect($this->generateUrl('preview_shop', [
                    'shopname' => $shops->getUniqueName(),
                ]));
            }
        }
        
        return $this->render('ShopCreateBundle:Shop:form.html.twig', array(
            'form' => $form->createView(),
            'isCreate' => true,
            'errors' => true,
        ));
    }

    /**
     * Page create shop
     *
     * @param Request $request
     * @param string $shopname
     *
     * @Route("/user/shop/update/{shopname}", name="update_shop")
     * @Method({"GET", "POST"})
     *
     * @return object
     */
    public function updateAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shops = $em->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(['uniqueName' => $shopname]);

        $form = $this->createForm(ShopsType::class, $shops);
        $form->handleRequest($request);

        if ($form->isValid() && $shopname == $shops->getUniqueName()) {
            $isName = $em->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(['uniqueName' => $shops->getUniqueName()]);

            if ($isName) {
                $em->flush();

                return $this->redirect($this->generateUrl('preview_shop', [
                    'shopname' => $shops->getUniqueName(),
                ]));
            }
        }

        return $this->render('ShopCreateBundle:Shop:form.html.twig', array(
            'form' => $form->createView(),
            'shopname' => $shopname,
            'isCreate' => false,
            'errors' => true,
        ));
    }

    /**
     * Page create shop
     *
     * @param string $shopname
     *
     * @Route("/user/shop/preview/{shopname}", name="preview_shop")
     * @Method({"GET"})
     *
     * @return object
     */
    public function previewAction($shopname)
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(['uniqueName' => $shopname]);

        $upload = $this->createForm(UploadLogoType::class, $shop);
        $description = $this->createForm(DescriptionType::class, $shop);

        return $this->render('ShopCreateBundle:Preview:additional.html.twig', array(
            'upload' => $upload->createView(),
            'description' => $description->createView(),
            'image' => $shop->getPath(),
            'shopname' => $shopname,
        ));
    }

    /**
     * Page create shop
     *
     * @param string $shopname
     *
     * @Route("/user/shop/delivery/{shopname}", name="delivery")
     * @Method({"GET"})
     *
     * @return object
     */
    public function deliveryAction($shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(DeliveryType::class, $shop, [
            'attr' => ['class' => 'form-inline'],
        ]);

        $id = [];
        $shopsDelivery = [];
        $deliveries = $shop->getShopsDelivery();
        foreach ($deliveries as $delivery) {
            $id[] = $delivery->getDelivery()->getId();
            $shopsDelivery[] = $delivery->getDelivery();
        }

        if (count($id) > 0) {
            $deliveries = $em->getRepository("ShopCreateBundle:Delivery")
                ->findByNotShopsDelivery($id);
        } else {
            $deliveries = $em->getRepository("ShopCreateBundle:Delivery")
                ->findAll();
        }

        return $this->render('ShopCreateBundle:Delivery:all.html.twig', [
            'form' => $form->createView(),
            'deliveries' => $deliveries,
            'shopsDelivery' => $shopsDelivery,
            'shopname' => $shopname,
        ]);
    }
}