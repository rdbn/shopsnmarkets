<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopNewsController extends Controller 
{
    public function previewNewsAction($shopname)
    {
        $news = '';
        
        return $this->render('ShopInformationBundle:News:previewNews.html.twig', array(
            'shopname' => $shopname,
            'news' => $news,
        ));
    }
}
?>
