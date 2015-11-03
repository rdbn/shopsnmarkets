<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopNewsController extends Controller 
{
    public function previewNewsAction($shopname)
    {
        $news = '';
        
        return $this->render('ShopNewsBundle:News:previewNews.html.twig', array(
            'shopname' => $shopname,
            'news' => $news,
        ));
    }
}
?>
