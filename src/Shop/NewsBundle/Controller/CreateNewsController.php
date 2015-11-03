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
    public function formNewsAction($shopname)
    {
        $form = $this->createForm(new NewsType(), new News());
        
        return $this->render('ShopNewsBundle:Form:createForm.html.twig', array(
            'shopname' => $shopname,
            'form' => $form->createView(),
        ));
    }
    
    public function addNewsAction(Request $request, $shopname)
    {
        $news = $this->get('addNews');
        $form = $news->createForm(new NewsType(), new News());
        
        if ($news->addInformation($request, $shopname)) {
            return $this->redirect($this->generateUrl('_formNews', array('shopname' => $shopname)));
        }
        
        return $this->render('ShopNewsBundle:Form:createForm.html.twig', array(
            'shopname' => $shopname,
            'form' => $form->createView(),
        ));
    }
}
?>
