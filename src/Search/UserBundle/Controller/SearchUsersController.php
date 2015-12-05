<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Search\UserBundle\Controller;

use User\UserBundle\Entity\Users;
use Search\UserBundle\Form\Type\SearchUsersType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchUsersController extends Controller {
    
    public function searchUsersAction() 
    {
        $form = $this->createForm(new SearchUsersType(), new Users());
        
        return $this->render('SearchUserBundle:Form:searchUsers.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function resualtSearchAction() 
    {
        $userID = $this->getUser()->getId();
        $data = $this->get('request')->request->get('searchUsers');
        
        $search = $this->get('searchUsers');
        $search->createForm(new SearchUsersType(), new Users());
        
        if ($search->validSearch($data, $userID)) {
            $resualt = $search->resualtSearch();
            
            return new JsonResponse($resualt);
        }
        
        return new JsonResponse('');
    }
}
?>
