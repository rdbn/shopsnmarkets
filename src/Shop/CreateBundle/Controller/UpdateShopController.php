<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Form\Type\ShopsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UpdateShopController extends Controller {
    
    public function updateFormAction($nameShop) 
    {        
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $nameShop));
        
        $form = $this->createForm(new ShopsType(), $shop);
        
        return $this->render('ShopCreateBundle:Shop:formUpdate.html.twig', array(
            'form' => $form->createView(),
            'nameShop' => $nameShop,
            'errors' => true,
        ));
    }
    
    public function updateShopAction(Request $request, $nameShop) 
    {        
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $nameShop));
        
        $updateShop = $this->get('formUpdateShop');
        $form = $updateShop->createForm(new ShopsType(), $shop);
        
        if ($updateShop->update($request, $nameShop)) {
            return $this->redirect($this->generateUrl('_allShopsManager'));
        }
        
        return $this->render('ShopCreateBundle:Shop:formUpdate.html.twig', array(
            'form' => $form->createView(),
            'nameShop' => $nameShop,
            'errors' => $updateShop->isName(),
        ));
    }
}
?>
