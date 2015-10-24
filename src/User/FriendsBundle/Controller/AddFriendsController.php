<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\FriendsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AddFriendsController extends Controller {
    
    public function addFriendsAction() 
    {
        $user = $this->getUser();
        
        $id = $this->getRequest()->query->get('id');
        
        $resualt = $this->get('addFriends')->add($id, $user);
        
        if ($resualt) {
            return new Response('0');
        } else {
            return new Response('');
        }
    }
    
    public function checkFriendsAction() 
    {
        $userID = $this->getUser();
        
        $id = $this->getRequest()->query->get('id');
        
        $resualt = $this->get('checkFriends')->check($id, $userID);
        
        if ($resualt) {
            return new Response('0');
        } else {
            return new Response('');
        }
    }
    
    public function listTypeFriendsAction() 
    {        
        $arValue = array();
        $id = $this->getRequest()->query->get('id');
        
        $types = $this->getDoctrine()->getRepository('UserFriendsBundle:TypeFriends')
                ->findAll();
        
        foreach ($types as $key => $value) {
            $arValue[$key] = array('id_type' => $value->getId(), 'name' => $value->getName(), 'id_user' => $id);
        }
        
        return new JsonResponse($arValue);
    }
    
    public function deleteFriendsAction() 
    {
        $userID = $this->getUser()->getId();
        $id = $this->getRequest()->query->get('id');
        
        $delete = $this->get('deleteFriends')->deleteFriends($userID, $id);
        
        if ($delete) {
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
}
?>
