<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\MessagesBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxDialogController extends Controller
{    
    public function basketAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'integer')) {
            $this->get('dialog')->updateDialog($request, '2');
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
    
    public function deleteAction() {
        $request = $this->getRequest()->query->get('id');
        
        if (settype($request, 'integer')) {
            $this->get('dialog')->deleteDialog($request);
            
            return new Response('0');
        } else {
            return new Response('1');
        }
    }
}
?>