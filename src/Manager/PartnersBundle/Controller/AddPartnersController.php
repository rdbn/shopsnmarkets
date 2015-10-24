<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Manager\PartnersBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AddPartnersController extends Controller {
    
    public function addPartnersAction() 
    {
        $data = $this->getRequest()->query->get('id');
        
        $resualt = $this->get('addPartners')->add($data);
        
        if ($resualt) {
            return new Response('0');
        } else {
            return new Response('');
        }
    }
    
    public function checkPartnersAction() 
    {
        $id = $this->getRequest()->query->get('id');
        
        $resualt = $this->get('checkPartners')->check($id);
        
        if ($resualt) {
            return new Response('0');
        } else {
            return new Response('');
        }
    }
    
    public function listMyShopsAction() 
    {
        $id = $this->getUser()->getId();
        
        $shops = $this->getDoctrine()->getRepository('ShopCreateBundle:Shops')
                ->findAllShopnameManager($id);
        
        return new JsonResponse($shops);
    }
    
    public function deleteAction() 
    {
        $id = $this->getRequest()->query->get('id');
        
        $delete = $this->get('deletePartners')->deletePartners($id);
        
        if ($delete) {
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
}
?>
