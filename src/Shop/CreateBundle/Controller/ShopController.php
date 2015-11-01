<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Entity\Shops;
use Shop\CreateBundle\Form\Type\ShopsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ShopController extends Controller
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
                ->findOneBy(array('unique_name' => $shops->getUniqueName()));

            if ($isName) {
                $shops->addManager($user);

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
            ->findOneBy(array('unique_name' => $shopname));

        $form = $this->createForm(new ShopsType(), $shops);
        $form->handleRequest($request);

        if ($form->isValid() && $shopname == $shops->getUniqueName()) {
            $isName = $em->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $shops->getUniqueName()));

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
}
?>