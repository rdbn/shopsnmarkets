<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\CreateBundle\Controller;

use Shop\CreateBundle\Form\Type\UploadLogoShopType;
use Shop\CreateBundle\Form\Model\PreviewShop;
use Shop\CreateBundle\Form\Type\PreviewShopType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PreviewShopController extends Controller 
{        
    public function previewAction($nameShop) 
    {        
        $shop = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findOneBy(array('unique_name' => $nameShop));
        
        $form = $this->createForm(new UploadLogoShopType(), $shop);
        
        return $this->render('ShopCreateBundle:Preview:additionalShop.html.twig', array(
            'form' => $form->createView(),
            'image' => $shop->getPath(),
            'nameShop' => $nameShop,
        ));
    }
    
    public function formAction($nameShop) 
    {
        $form = $this->createForm(new PreviewShopType($nameShop), new PreviewShop());
        
        return $this->render('ShopCreateBundle:Preview:previewForm.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function saveAction() 
    {
        $request = $this->getRequest()->request->get('PreviewShop');
        
        $previewShop = $this->get('formPreviewShop');
        $previewShop->createForm(new PreviewShopType($request['shopname']), new PreviewShop());
        
        if ($previewShop->addInformation($request)) {
            return new Response('0');
        }
        
        return new Response('');
    }
}
?>
