<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\NewsBundle\Controller;

use Shop\NewsBundle\Entity\News;
use Shop\NewsBundle\Form\Type\NewsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreateNewsController extends Controller 
{
    public function formNewsAction($nameShop)
    {
        $form = $this->createForm(new NewsType(), new News());
        
        return $this->render('ShopNewsBundle:Form:createForm.html.twig', array(
            'nameShop' => $nameShop,
            'form' => $form->createView(),
        ));
    }
    
    public function addNewsAction(Request $request, $nameShop)
    {
        $news = $this->get('addNews');
        $form = $news->createForm(new NewsType(), new News());
        
        if ($news->addInformation($request, $nameShop)) {
            return $this->redirect($this->generateUrl('_formNews', array('nameShop' => $nameShop)));
        }
        
        return $this->render('ShopNewsBundle:Form:createForm.html.twig', array(
            'nameShop' => $nameShop,
            'form' => $form->createView(),
        ));
    }
}
?>
