<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\AdvertisingBundle\Controller;

use Manager\AdvertisingBundle\Entity\Advertising;
use Manager\AdvertisingBundle\Entity\AdvertisingShop;
use Manager\AdvertisingBundle\Form\Type\AdvertisingType;
use Manager\AdvertisingBundle\Form\Type\AdvertisingShopType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CreateAdvertisingController extends Controller
{
    public function formAction()
    {
        $id = $this->getUser()->getId();
        
        $form = $this->createForm(new AdvertisingType($id), new Advertising());
        
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShopsManager($id);
        
        return $this->render('ManagerAdvertisingBundle:Form:formCreate.html.twig', array(
            'form' => $form->createView(),
            'shops' => $shops,
        ));
    }
    
    public function createPlatformAction(Request $requset)
    {        
        $id = $this->getUser()->getId();
        
        $create = $this->get('createPlatforn');
        $create->createForm(new AdvertisingType($id), new Advertising());
        
        if ($create->add($requset)) {
            return new JsonResponse($create->getInformation());
        }
        
        return new JsonResponse($create->getErrors());
    }
    
    public function createShopAction(Request $requset) 
    {
        $id = $this->getUser()->getId();
        
        $create = $this->get('createAdvertisingShop');
        $create->createForm(new AdvertisingShopType($id), new AdvertisingShop());
        
        if ($create->add($requset)) {
            return new JsonResponse($create->filename);
        }
        
        return new Response('1');
    }
}

?>
