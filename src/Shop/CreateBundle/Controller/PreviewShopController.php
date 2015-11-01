<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Form\Type\UploadLogoShopType;
use Shop\CreateBundle\Form\Type\PreviewShopType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PreviewShopController extends Controller 
{        
    public function previewAction($shopname)
    {        
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $shopname));
        
        $formUpload = $this->createForm(new UploadLogoShopType(), $shop);
        $formShop = $this->createForm(new PreviewShopType($shopname), $shop);
        
        return $this->render('ShopCreateBundle:Preview:additionalShop.html.twig', array(
            'formUpload' => $formUpload->createView(),
            'formShop' => $formShop->createView(),
            'image' => $shop->getPath(),
            'shopname' => $shopname,
        ));
    }
    
    public function saveAction() 
    {
        $request = $this->get("request")->request->get('PreviewShop');
        
        $previewShop = $this->get('formPreviewShop');
        $previewShop->createForm(new PreviewShopType($request['shopname']), new PreviewShop());
        
        if ($previewShop->addInformation($request)) {
            return new Response('0');
        }
        
        return new Response('');
    }
}
?>
