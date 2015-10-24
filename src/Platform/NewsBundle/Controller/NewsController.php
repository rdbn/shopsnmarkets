<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Platform\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NewsController extends Controller
{
    public function newsAction()
    {
        $name = 'Страница новостей';
        
        return $this->render('PlatformNewsBundle:News:news.html.twig', array(
            'name' => $name,
        ));
    }
}
?>
