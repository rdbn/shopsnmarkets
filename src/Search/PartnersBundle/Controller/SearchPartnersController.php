<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\PartnersBundle\Controller;

use Shop\CreateBundle\Entity\Shops;
use Search\PartnersBundle\Form\Type\SearchPartnersType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchPartnersController extends Controller {
    
    public function searchPartnersAction() 
    {
        $form = $this->createForm(new SearchPartnersType(), new Shops());
        
        return $this->render('SearchPartnersBundle:Form:searchPartners.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function resualtSearchAction() 
    {
        $userID = $this->getUser()->getId();
        $data = $this->get('request')->request->get('SearchPartners');
        
        $search = $this->get('searchPartners');
        $search->createForm(new SearchPartnersType(), new Shops());
        
        if ($search->validSearch($data, $userID)) {            
            return new JsonResponse($search->resualtSearch());
        }
        
        return new JsonResponse('');
    }
}
?>
