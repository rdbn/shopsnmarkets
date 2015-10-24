<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace User\PropertyBundle\Controller;

use User\PropertyBundle\Form\Type\UploadImageType;
use User\PropertyBundle\Form\Type\PreviewUserType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PreviewUserController extends Controller 
{    
    public function formAction() 
    {
        $user = $this->getUser();
        
        $information = $this->get('formPreviewUser');
        $formPreview = $information->createForm(new PreviewUserType(), $user->getId());
        $formUpload = $this->createForm(new UploadImageType(), $user);
        
        return $this->render('UserPropertyBundle:Form:additionalInformationForm.html.twig',array(
            'formUpload' => $formUpload->createView(),
            'formPreview' => $formPreview->createView(),
            'image' => $user->getPath(),
        ));
    }
    
    public function saveAction() 
    {
        $request = $this->getRequest()->request->get('AdditionalInformarion');
        
        $userID = $this->getUser()->getId();
        
        $information = $this->get('formPreviewUser');
        $information->createForm(new PreviewUserType(), $userID);
        
        if ($information->add($request, $userID)) {
            return new Response('0');
        }
        
        return new Response('1');
    }
    
    public function uploadAction(Request $request) 
    {        
        $user = $this->getUser();
        
        $information = $this->get('formUploadAvatar');
        $information->createForm(new UploadImageType(), $user);
        
        if ($information->upload($request)) {
            return new Response($information->getPath());
        }
        
        return new JsonResponse($information->getErrors());
    }
}
?>
