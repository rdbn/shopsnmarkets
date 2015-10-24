<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\AdvertisingBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxAdvertisingController extends Controller
{
    public function paltformAction() 
    {
        $userID = $this->getUser()->getId();
        
        $advertising = $this->getDoctrine()->getRepository('ManagerAdvertisingBundle:Advertising')
                ->findByAdvertisingManager(array('date' => date("Y-m-d H:i:s"), 'user' => $userID));
        
        return new JsonResponse($advertising);
    }
    
    public function shopsAction() 
    {
        $userID = $this->getUser()->getId();
        
        $advertising = $this->get('advertisingManager')->advertising($userID);
        
        return new JsonResponse($advertising);
    }
    
    public function deleteAction() {
        $href = $this->getRequest()->query->get('href');
        
        $this->get('advertisingManager')->removeFile($href);
        
        return new Response('');
    }
}

?>
