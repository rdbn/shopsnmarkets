<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Entity\Delivery;
use Shop\CreateBundle\Entity\Shops;
use Shop\CreateBundle\Entity\ShopsDelivery;

use Shop\CreateBundle\Form\Type\ShopsType;
use Shop\CreateBundle\Form\Type\DescriptionType;
use Shop\CreateBundle\Form\Type\UploadLogoType;
use Shop\CreateBundle\Form\Type\DeliveryShopType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PutController extends Controller
{
    public function addAction(Request $request)
    {
        $user = $this->getUser();
        $shops = new Shops();
        $form = $this->createForm(new ShopsType(), $shops);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $isName = $em->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(['uniqueName' => $shops->getUniqueName()]);

            if (!$isName) {
                $shops->setManager($user);

                $em->persist($shops);
                $em->flush();

                return $this->redirect($this->generateUrl('_previewShop', [
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

    public function updateAction(Request $request, $shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shops = $em->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(['uniqueName' => $shopname]);

        $form = $this->createForm(new ShopsType(), $shops);
        $form->handleRequest($request);

        if ($form->isValid() && $shopname == $shops->getUniqueName()) {
            $isName = $em->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(['uniqueName' => $shops->getUniqueName()]);

            if ($isName) {
                $em->flush();

                return $this->redirect($this->generateUrl('_previewShop', [
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

    public function previewAction($shopname)
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
            ->findOneBy(['uniqueName' => $shopname]);

        $upload = $this->createForm(new UploadLogoType(), $shop);
        $description = $this->createForm(new DescriptionType($shopname), $shop);

        return $this->render('ShopCreateBundle:Preview:additional.html.twig', array(
            'upload' => $upload->createView(),
            'description' => $description->createView(),
            'image' => $shop->getPath(),
            'shopname' => $shopname,
        ));
    }

    public function deliveryAction($shopname)
    {
        $em = $this->getDoctrine()->getManager();
        $shop = $em->getRepository("ShopCreateBundle:Shops")
            ->findOneBy(["uniqueName" => $shopname]);

        $form = $this->createForm(new DeliveryShopType(), $shop);
        $delivery = $em->getRepository('ShopCreateBundle:Delivery')
            ->findAll();

        return $this->render('ShopCreateBundle:Delivery:all.html.twig', [
            'form' => $form->createView(),
            'delivery' => $delivery,
            'shopname' => $shopname,
        ]);
    }
}