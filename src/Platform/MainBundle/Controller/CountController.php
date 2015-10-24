<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CountController extends Controller {

    public function countAction() {
        $count = $this->get('countShopProductUser')->count();
        
        return $this->render('PlatformMainBundle:Main:count.html.twig', array(
            'count' => $count,
        ));
    }
}
?>
