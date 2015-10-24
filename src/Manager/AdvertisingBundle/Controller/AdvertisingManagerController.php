<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Manager\AdvertisingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdvertisingManagerController extends Controller
{
    public function advertisingAction() 
    {
        $userID = $this->getUser()->getId();
        
        $advertising = $this->getDoctrine()->getRepository('ManagerAdvertisingBundle:Advertising')
                ->findByAdvertisingManager(array('date' => date("Y-m-d H:i:s"), 'user' => $userID));
        
        return $this->render('ManagerAdvertisingBundle:Advertising:advertising.html.twig', array(
            'advertising' => $advertising,
        ));
    }
}

?>
