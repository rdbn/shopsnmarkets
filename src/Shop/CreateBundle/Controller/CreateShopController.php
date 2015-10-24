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

class CreateShopController extends Controller {
    
    public function createFormAction() 
    {        
        $form = $this->createForm(new ShopsType(), new Shops());
        
        return $this->render('ShopCreateBundle:Shop:formCreate.html.twig', array(
            'form' => $form->createView(),
            'errors' => true,
        ));
    }
    
    public function createShopAction(Request $request) 
    {
        $user = $this->getUser();
        
        $createShop = $this->get('formCreateShop');
        $form = $createShop->createForm(new ShopsType(), new Shops());
        
        if ($createShop->addShop($request, $user)) {
            $nameShop = $createShop->shopName();
            return $this->redirect($this->generateUrl('_previewShop', array('nameShop' => $nameShop)));
        }
        
        return $this->render('ShopCreateBundle:Shop:formCreate.html.twig', array(
            'form' => $form->createView(),
            'errors' => $createShop->isName(),
        ));
    }
}
?>
