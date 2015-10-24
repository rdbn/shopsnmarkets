<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Form\Type\UploadLogoShopType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxCreateShopController extends Controller {
    
    public function uniqueNameAction() 
    {
        $name = $this->get('request')->request->get('name');
        
        $uniqueName = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $name));
        
        if ($uniqueName == NULL) {
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
    
    public function addLogoAction(Request $request, $nameShop) 
    {
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $nameShop));
        
        $addLogo = $this->get('formUploadLogoShop');
        $addLogo->createForm(new UploadLogoShopType(), $shop);
        
        if ($addLogo->upload($request, $nameShop)) {
            return $this->render('ShopCreateBundle:Upload:frameContent.html.twig', array(
                'logo' => $addLogo->getPath(),
            ));
        }
        
        return $this->render('ShopCreateBundle:Upload:frameContent.html.twig', array(
            'errors' => $addLogo->getErrors(),
        ));
    }
}
?>
