<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Shop\InformationBundle\Controller;

use Shop\InformationBundle\Entity\Comments;
use Shop\InformationBundle\Form\Type\CommentsType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopCommentsController extends Controller 
{    
    public function formCommentsAction($shopname)
    {
        $userID = $this->getUser();
        $comments = $this->get('shopComments');
        $formComments = '';
        if ($userID != NULL) {
            $form = $this->createForm(new CommentsType($shopname, $userID->getId()), new Comments());
            $formComments = $form->createView();
        }
        
        return $this->render('ShopInformationBundle:Shop:comments.html.twig', array(
            'comments' => $comments->comments($shopname),
            'form' => $formComments,
            'shopname' => $shopname,
        ));
    }
    
    public function addCommentsAction() 
    {
        $request = $this->getRequest()->request->get('Comments');
        
        $addComments = $this->get('shopComments');
        $addComments->createForm(new CommentsType($request['shopname'], $request['users']), new Comments());
        
        if ($addComments->addComment($request)) {
            return new JsonResponse($addComments->lastComments());
        }
        
        return new Response('');
    }
}
?>
